<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreDepositRequest;
use App\Services\DepositService;
use Carbon\Carbon;
use App\Models\{User, Account, Payment, Wallet, WithdrawRequest, Setting, Work, Reference, AssignWork};

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
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


    public function work(User $user)
    {
        // Get today's date
        $today = Carbon::today()->format('Y-m-d');

        // If the last viewed date is not today, reset the daily work count
        if ($user->last_viewed_date != $today) {
            $take = $user->work_limit;

            $getWorks = Work::select('id')->where('visited', false)->latest()->take($take)->get();

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

        // Add coins to user's wallet
        // $coinPrWork = Setting::select('job_per_coin')->first()->job_per_coin;

        $coinPrWork = [
            1 => 25,
            2 => 35,
            3 => 45,
            4 => 60,
            5 => 80,
            6 => 120,
            7 => 200,
            8 => 300,
            9 => 400,
            10 => 500,
        ];

        // Update wallet amount
        $user->wallet->amount += $coinPrWork[$user->level];

        // Get today's date
        $today = now()->format('Y-m-d');

        // Check if daily earning needs to be reset
        if ($user->wallet->last_earning_date !== $today) {
            $user->wallet->daily_earning = $coinPrWork[$user->level]; // Set to current earning for today
            $user->wallet->last_earning_date = $today; // Update last earning date
        } else {
            $user->wallet->daily_earning += $coinPrWork[$user->level]; // Increment daily earning
        }

        // Save wallet updates
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

    public function profileUpdate(Request $request, User $user)
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

        return redirect()
            ->route('profile', ['user' => $user->id])
            ->with('success', 'Your account information updated successfully.');
    }

    public function wallet(User $user)
    {
        $amount = $this->getAmount($user);

        return view('wallet', compact('user', 'amount'));
    }

    public function requestForWithdraw(Request $request, User $user)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        WithdrawRequest::create([
            'amount' => $request->amount,
            'user_id' => auth()->user()->id,
        ]);

        $user->wallet->amount = $user->wallet->amount - $request->amount;
        $user->wallet->save();

        return redirect()->back()->with('success', 'your request submitted successfully');
    }

    public function team(User $user)
    {
        return view('team', compact('user'));
    }

    protected function getAmount($user)
    {
        $settings = Setting::first();

        $amount = $settings->per_coin_price * $user?->wallet?->amount;

        return $amount;
    }
}
