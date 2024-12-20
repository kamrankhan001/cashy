<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Payment;
use App\Models\Reference;
use App\Models\{User,Level,Wallet, Setting, FirstDeposit};

class DepositService
{
    public function storeDeposit($request)
    {
        // Create or update the account details
        FirstDeposit::create([
                'trx_id' => $request->bank_name,
                'sender_name' => $request->account_name,
                'sender_account' => $request->account_number,
                'user_id' => auth()->user()->id,
            ],
        );

        // Create the payment record
        Payment::create([
            'amount' => 700,
            'type' => 'deposit',
            'user_id' => auth()->id(),
        ]);

        // Update the user's initial deposit status and mark email as verified
        $user = auth()->user();
        $user->initial_deposit = 'yes';
        $user->markEmailAsVerified();
        $user->save();
    }

    public function handleReferralBonus($user)
    {
        $perCoins = Setting::first()->per_coin_price;

        if($user->inviter_got_coins == 0){

            // Find the inviter from the Reference model
            $reference = Reference::where('invitee', $user->id)->first();

            if ($reference) {
                $inviter = User::find($reference->inviter);
                $referralBonus = Level::select('referral_bonus')->where('level_number', $inviter->level)->first();

                if ($inviter && $inviter->wallet) {
                    // Add referral bonus to inviter's wallet
                    // $inviter->wallet->referral_bonus += $referralBonus->referral_bonus;
                    $inviter->wallet->amount += ($referralBonus->referral_bonus/$perCoins);
                    $inviter->wallet->pkr += $referralBonus->referral_bonus;
                    $this->addExtraCoins($inviter,$perCoins);
                    $inviter->wallet->save();

                    // Update inviter's level and work limit based on total references
                    $this->updateInviterLevel($inviter);
                }
            }

            $user->inviter_got_coins = 1;
            $user->save();
        }

    }

    public function addExtraCoins($inviter, $perCoins)
    {
        $levelLimits = [
            1 => 5,
            2 => 10,
            3 => 15,
            4 => 20,
            5 => 25,
            6 => 30,
            7 => 35,
            8 => 40,
            9 => 45,
            10 => 50,
        ];

        $extraCoins = Level::pluck('extra_coins', 'level_number')->toArray();
        $extraCoin = Setting::first()->extra_coin_price;

        $inviter->wallet->extra_coins += ($extraCoins[$inviter->level]/$extraCoin);
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
