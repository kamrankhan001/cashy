<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', false)->count();

        return view('admin.dashboard', compact('users'));
    }
}
