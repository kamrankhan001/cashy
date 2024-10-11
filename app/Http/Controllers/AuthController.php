<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\RegisterConfirmMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

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

            if($request->user()->is_admin){
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

    public function register()
    {
        return view('auth.register');
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

        // Log the user in after successful registration
        Auth::login($user);

        defer(fn () =>  Mail::to($validatedData['email'])->send(new RegisterConfirmMail()));

        // Redirect to a desired page, such as the dashboard
        return redirect()->route('confirm.registration');
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

}
