<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Account, Payment, Wallet, WithdrawRequest, Setting, Work, Reference};

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

    public function storeDeposit(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'deposit_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Limit to 2MB
        ]);

        // Store the deposit picture in the 'public/deposits' directory
        $depositPicturePath = $request->file('deposit_picture')->store('deposits', 'public');

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

        Payment::create([
            'amount' => $request->amount,
            'deposit_picture' => $depositPicturePath,
            'type' => 'deposit',
            'user_id' => auth()->id(),
        ]);

        $user = auth()->user();
        $user->initial_deposit = 'yes';
        $user->markEmailAsVerified();
        $user->save();

        Wallet::create([
            'amount' => '500',
            'user_id' => $user->id,
        ]);

        $reference = Reference::where('invitee', $user->id)->first();

        if ($reference) {
            $inviter = User::find($reference->inviter);

            if ($inviter && $inviter->wallet) {
                $amount = $inviter->wallet->amount;
                $inviter->wallet->amount = (float) $amount + 100;
                $inviter->wallet->save();
            }

            $totalReferences = Reference::where('invitee', $user->id)->count();

            switch ($totalReferences) {
                case 20:
                    $inviter->level = 2;
                    break;
                case 40:
                    $inviter->level = 3;
                    break;
                case 70:
                    $inviter->level = 4;
                    break;
                case 100:
                    $inviter->level = 5;
                    break;
            }
        }

        // Redirect to the dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'Your deposit information has been submitted successfully.');
    }

    public function work(User $user)
    {
        $level = $user->level;

        $worksLimit = [
            1 => 5,
            2 => 10,
            3 => 20,
            4 => 30,
            5 => 45,
        ];

        $take = $worksLimit[$level];

        $works = Work::where('visited', false)->latest()->take($take)->get();

        return view('work', compact('user', 'works'));
    }

    public function trackAndRedirect(User $user, Work $work)
    {
        // Ensure the user is authorized to visit the work
        if (auth()->user()->id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403); // Unauthorized access
        }

        // Mark work as visited by the user
        $work->user_id = $user->id;
        $work->visited = true;
        $work->save();

        // Add coins to user's wallet
        $coinPrWork = Setting::select('job_per_coin')->first()->job_per_coin;

        // Update wallet amount
        $user->wallet->amount += (float) $coinPrWork;

        // Get today's date
        $today = now()->format('Y-m-d');

        // Check if daily earning needs to be reset
        if ($user->wallet->last_earning_date !== $today) {
            $user->wallet->daily_earning = (float) $coinPrWork; // Set to current earning for today
            $user->wallet->last_earning_date = $today; // Update last earning date
        } else {
            $user->wallet->daily_earning += (float) $coinPrWork; // Increment daily earning
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
        // $members = Reference::where('inviter', $user->id)->latest()->first();
        // dd($members->inviterUser->name);
        $link = route('register', ['user' => $user->id]);
        return view('team', compact('user', 'link'));
    }

    protected function getAmount($user)
    {
        $settings = Setting::first();

        $amount = $settings->per_coin_price * $user?->wallet?->amount;

        return $amount;
    }
}
