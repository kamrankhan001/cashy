<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, PasswordForget};
use Hash;

class AdminPasswordReset extends Controller
{
    public function index()
    {
        $resetRequests = PasswordForget::latest()->paginate(10);

        return view('admin.password-reset.index', compact('resetRequests'));
    }

    public function passwordChange(PasswordForget $reset, User $user)
    {
        return view('admin.password-reset.chnage', compact('reset','user'));
    }

    public function passwordChangeDone(Request $request, PasswordForget $reset, User $user)
    {
        // Validate request data
        $request->validate([
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
        ]);

        // Update the user's password
        $user->update([
            'password' => $request->password,
        ]);

        $reset->update([
            'password_reset' => 'yes',
        ]);

        // Redirect with success message
        return redirect()
            ->route('admin.password.reset') // Change this route as needed
            ->with('success', 'Password updated successfully!');
    }

}
