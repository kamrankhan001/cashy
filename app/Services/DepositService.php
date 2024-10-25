<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Payment;
use App\Models\Reference;
use App\Models\{User,Level,Wallet};

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
            $referralBonus = Level::select('referral_bonus')->where('level_number', $inviter->level)->first();

            if ($inviter && $inviter->wallet) {
                // Add referral bonus to inviter's wallet
                $inviter->wallet->referral_bonus += $referralBonus->referral_bonus;
                $this->addExtraCoins($inviter);
                $inviter->wallet->save();

                // Update inviter's level and work limit based on total references
                $this->updateInviterLevel($inviter);
            }
        }
    }

    public function addExtraCoins($inviter)
    {
        $extraCoins = Level::pluck('extra_coins', 'level_number')->toArray();

        $inviter->wallet->extra_coins += $extraCoins[$inviter->level];
    }

    public function updateInviterLevel($inviter)
    {
        $totalReferences = Reference::where('inviter', $inviter->id)->count();

        $members = Level::pluck('members')->toArray();

        // Update inviter's level and work limit based on the number of invitees
        $levelLimits = [
            $members[1] => [2, 10],
            $members[2] => [3, 15],
            $members[3] => [4, 20],
            $members[4] => [5, 25],
            $members[5] => [6, 30],
            $members[6] => [7, 35],
            $members[7] => [8, 40],
            $members[8] => [9, 45],
            $members[9] => [10, 50],
        ];


        foreach ($levelLimits as $inviteCount => [$level, $workLimit]) {
            if ($totalReferences  >= $inviteCount) {
                $inviter->level = $level;
                $inviter->work_limit = $workLimit;
            }
        }

        $inviter->save();
    }
}
