<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Mail\RegisterConfirmMail;
use Illuminate\Support\Facades\Mail;
use App\Models\{User, Reference};

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function check(Request $request)
    {
        // Validate the input data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt to log the user in
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // If login is successful, regenerate the session and redirect
            $request->session()->regenerate();

            if ($request->user()->is_admin) {
                // Redirect to intended page or dashboard
                return redirect()->route('admin.dashboard');
            }

            // Redirect to intended page or dashboard
            return redirect()->intended('dashboard');
        }

        // If login fails, redirect back with error message
        return back()
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])
            ->onlyInput('email');
    }

    public function register($user = null)
    {
        return view('auth.register', compact('user'));
    }

    public function store(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15|regex:/^\+?[0-9-]{7,15}$/', // Validates international phone numbers
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user in the database
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'country' => $validatedData['country'],
            'city' => $validatedData['city'],
            'address' => $validatedData['address'],
            'phone' => $validatedData['phone'],
            'password' => Hash::make($validatedData['password']), // Hash the password before storing
        ]);

        if($request->inviter){
            Reference::create([
                'inviter' => $request->inviter,
                'invitee' => $user->id,
            ]);
        }

        // Log the user in after successful registration
        Auth::login($user);

        //defer(fn() => Mail::to($validatedData['email'])->send(new RegisterConfirmMail()));

        // Redirect to a desired page, such as the dashboard
        return redirect()->route('initial.deposit');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Log the user out

        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return redirect()->route('login'); // Redirect to the login page
    }

    public function confirmRegistration()
    {
        return view('post-register');
    }

    public function settings()
    {
        return view('setting');
    }

    public function passwordUpdate(Request $request)
    {
        // Validate the input
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        // Check if current password is correct
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        // Update the user's password
        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Optionally redirect with a success message
        return redirect()->route('settings')->with('success', 'Password successfully updated.');
    }
}
