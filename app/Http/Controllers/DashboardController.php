<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Account, Payment, Wallet, WithdrawRequest, Setting};

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


        Account::create([
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'user_id' => auth()->id(),
        ]);

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

        // Redirect to the dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'Your deposit information has been submitted successfully.');
    }

    public function work(User $user)
    {
        return view('work', compact('user'));
    }

    public function pofile(User $user)
    {
        return view('profile', compact('user'));
    }

    public function wallet(User $user)
    {
        return view('wallet', compact('user'));
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
}
