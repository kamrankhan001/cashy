<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function initialDeposit()
    {
        return view('initial-deposit');
    }

    public function storeDeposit(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'deposit_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Limit to 2MB
        ]);

        // Store the deposit picture in the 'public/deposits' directory
        $depositPicturePath = $request->file('deposit_picture')->store('deposits', 'public');

        // Create a new deposit record
        Payment::create([
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'deposit_picture' => $depositPicturePath,
            'isVerified' => false,
            'user_id' => auth()->id(),
        ]);

        $user = auth()->user();
        $user->markEmailAsVerified();

        // Redirect to the dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'Your deposit information has been submitted successfully.');
    }
}
