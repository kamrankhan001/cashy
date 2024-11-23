<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreDepositRequest;
use App\Services\DepositService;
use Carbon\Carbon;
use App\Models\{User, WithdrawRequest, Setting, Work, Level, AssignWork, Reference, Wallet};

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function termAdnCondition()
    {
        return view('before-deposit');
    }

    public function initialDeposit()
    {
        $settings = Setting::first();
        return view('initial-deposit', compact('settings'));
    }

    public function storeDeposit(StoreDepositRequest $request, DepositService $depositService)
    {
        // Delegate the logic to the service class
        $depositService->storeDeposit($request);

        // Redirect to dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'Your deposit information has been submitted successfully.');
    }

    public function afterDeposit()
    {
        return view('after-deposit');
    }

    public function work(User $user)
    {
        // Get today's date
        $today = Carbon::today()->format('Y-m-d');

        // If the last viewed date is not today, reset the daily work count
        if ($user->last_viewed_date != $today) {

            $inviter = $user->invitedBy?->first();
            if ($inviter) {
                $settings = Setting::first();
                $inviterUser = User::find($inviter->inviter);
                $fivePercent = ($user->wallet->daily_earning * 5) / 100; // give 5% to the inviter
                $inviterUser->wallet->amount += $fivePercent;
                $inviterUser->wallet->pkr += ($fivePercent * $settings->per_coin_price);
                $inviterUser->wallet->save();

                $user->wallet->amount -= $fivePercent;
                $user->wallet->pkr -= ($fivePercent * $settings->per_coin_price);
                $user->wallet->save();
            }

            $initialRefsCount = Reference::where('inviter', $user->id)
                ->whereDate('created_at', $today)
                ->count();

            // Check if no referral was made today by comparing last referral date
            if ($initialRefsCount === 0 && $user->last_ref_date != $today) {
                // Reduce the work limit by 1 if no referral was made today
                $user->work_limit = max(0, $user->work_limit - 1); // Avoid negative work_limit
            } elseif ($initialRefsCount > 0) {
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
                // Reset the work limit if a referral was made today
                $user->work_limit = $levelLimits[$user->level]; // Set this to the initial work limit
                $user->last_ref_date = $today;
            }

            $take = $user->work_limit + 1;

            $getWorks = Work::select('id')->latest()->take($take)->get();

            // Prepare the data for bulk insert
            $assignWorkData = [];

            foreach ($getWorks as $getWork) {
                $assignWorkData[] = [
                    'user_id' => $user->id,
                    'work_id' => $getWork->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Perform bulk insert
            AssignWork::insert($assignWorkData);

            $user->last_viewed_date = $today;
            $user->save();
        }

        $works = $user->works()->wherePivot('isVisited', false)->get();

        return view('work', compact('user', 'works'));
    }

    public function trackAndRedirect(User $user, Work $work)
    {
        // Ensure the user is authorized to visit the work
        if (auth()->user()->id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403); // Unauthorized access
        }

        // Mark work as visited by the user
        $user->works()->updateExistingPivot($work->id, ['isVisited' => true]);

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

        // Add coins to user's wallet
        $coinPrWork = Level::pluck('task_income', 'level_number')->toArray();

        $perCoin = Setting::first()->per_coin_price;

        // Update or create the wallet
        if ($user->wallet) {
            $user->wallet->amount += ($coinPrWork[$user->level] / $perCoin) / $levelLimits[$user->level];
            $user->wallet->pkr += (($coinPrWork[$user->level] / $levelLimits[$user->level]));
            $user->wallet->save();
        } else {
            Wallet::create([
                'amount' => ($coinPrWork[$user->level] / $perCoin),
                'pkr' => (($coinPrWork[$user->level] / $levelLimits[$user->level]) / $perCoin),
                'user_id' => $user->id,
            ]);
        }

        // Get today's date
        $today = now()->format('Y-m-d');

        // Check if daily earning needs to be reset
        if ($user->wallet->last_earning_date !== $today) {
            $user->wallet->daily_earning = ($coinPrWork[$user->level] / $perCoin) / $levelLimits[$user->level]; // Set to current earning for today
            $user->wallet->last_earning_date = $today; // Update last earning date
        } else {
            $user->wallet->daily_earning += ($coinPrWork[$user->level] / $perCoin) / $levelLimits[$user->level]; // Increment daily earning
        }

        $user->wallet->save();

        // Return JSON with the redirect URL
        return response()->json(
            [
                'message' => 'Work tracked successfully',
                'redirect_url' => $work->url,
            ],
            200,
        );
    }

    public function profile(User $user)
    {
        return view('profile', compact('user'));
    }

    public function profileUpdate(Request $request, User $user, int $withdraw = 0)
    {
        // Validate the incoming request data
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
        ]);

        if ($user->account) {
            $user->account->bank_name = $request->bank_name;
            $user->account->account_name = $request->account_name;
            $user->account->account_number = $request->account_number;

            $user->account->save();
        } else {
            $user->account()->create([
                'bank_name' => $request->bank_name,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
            ]);
        }

        if ($withdraw) {
            return redirect()->back()->with('success', 'Your account information saved. you can withdraw now.');
        }

        return redirect()->back()->with('success', 'Account information updated successfully.');
    }

    public function wallet(User $user)
    {
        return view('wallet', compact('user'));
    }

    public function convertToPKR(User $user, int $isExtraCoins)
    {
        $settings = Setting::first();

        if ($isExtraCoins) {
            $user->wallet->convert_to_pkr += $settings->extra_coin_price * $user?->wallet?->extra_coins;
            $user->wallet->extra_coins = 0;
            if ($user->level < 10) {
                $user->last_level = $user->level;
                $user->save();
            }
        } else {
            $user->wallet->convert_to_pkr += $user->wallet->pkr;
            $user->wallet->pkr = 0;
            $user->wallet->amount = 0;
        }

        $user->wallet->save();

        return redirect()->back()->with('success', 'Convert into PKR successfully');
    }


    public function requestForWithdraw(User $user)
    {
        if ($user->wallet->convert_to_pkr < 200) {
            return redirect()->back()->with('warning', 'Your have insufficient balance');
        }

        if (!$user->account) {
            return redirect()->route('profile', ['user' => $user])->with('success', 'Please provide the bank information');
        }

        WithdrawRequest::create([
            'amount' => $user->wallet->convert_to_pkr,
            'user_id' => auth()->user()->id,
        ]);

        $user->wallet->convert_to_pkr = 0;
        $user->wallet->save();

        return redirect()->back()->with('success', 'your request submitted successfully');
    }

    public function team(User $user)
    {
        $invitees = $user->references()->get();

        // Get total member
        $totalMembers = $invitees->filter(function ($invitee) {
            $user = User::find($invitee->invitee);
            return $user && $user->verified_deposit == 'verified';
        })->count();

        return view('team', compact('user', 'totalMembers'));
    }
}
