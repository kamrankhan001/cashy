<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Payment;
use App\Models\Reference;
use App\Models\User;
use App\Models\Wallet;

class DepositService
{
    public function storeDeposit($request)
    {
        // Store the deposit picture
        $depositPicturePath = $request->file('deposit_picture')->store('deposits', 'public');

        // Create or update the account details
        Account::updateOrCreate(
            [
                'user_id' => auth()->id(),
            ],
            [
                'bank_name' => $request->bank_name,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
            ],
        );

        // Create the payment record
        Payment::create([
            'amount' => $request->amount,
            'deposit_picture' => $depositPicturePath,
            'type' => 'deposit',
            'user_id' => auth()->id(),
        ]);

        // Update the user's initial deposit status and mark email as verified
        $user = auth()->user();
        $user->initial_deposit = 'yes';
        $user->markEmailAsVerified();
        $user->save();

        // Add initial balance to the user's wallet
        Wallet::create([
            'amount' => '150',
            'user_id' => $user->id,
        ]);

        // Handle referral bonus
        $this->handleReferralBonus($user);
    }

    public function handleReferralBonus($user)
    {
        // Find the inviter from the Reference model
        $reference = Reference::where('invitee', $user->id)->first();

        if ($reference) {
            $inviter = User::find($reference->inviter);

            if ($inviter && $inviter->wallet) {
                // Add referral bonus to inviter's wallet
                $inviter->wallet->referral_bonus += 150;
                $this->addExtraCoins($inviter);
                $inviter->wallet->save();

                // Update inviter's level and work limit based on total references
                $this->updateInviterLevel($inviter);
            }
        }
    }

    public function addExtraCoins($inviter)
    {
        $extraCoins = [
            1 => 25,
            2 => 40,
            3 => 60,
            4 => 80,
            5 => 100,
            6 => 100,
            7 => 100,
            8 => 100,
            9 => 100,
            10 => 100,
        ];

        $inviter->wallet->extra_coins += $extraCoins[$inviter->level];
    }

    public function updateInviterLevel($inviter)
    {
        $totalReferences = Reference::where('invitee', $inviter->id)->count();

        // Update inviter's level and work limit based on the number of invitees
        $levelLimits = [
            4 => [2, 10],
            20 => [3, 15],
            40 => [4, 20],
            100 => [5, 25],
            180 => [6, 30],
            280 => [7, 35],
            400 => [8, 40],
            450 => [9, 45],
            500 => [10, 50],
        ];

        foreach ($levelLimits as $inviteCount => [$level, $workLimit]) {
            if ($totalReferences >= $inviteCount) {
                $inviter->level = $level;
                $inviter->work_limit = $workLimit;
            }
        }

        $inviter->save();
    }
}
