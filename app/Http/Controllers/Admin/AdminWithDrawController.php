<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, WithdrawRequest};

class AdminWithDrawController extends Controller
{
    public function index()
    {
        $withDrawRequests = WithdrawRequest::latest()->paginate(10);
        return view('admin.withDraw.index', compact('withDrawRequests'));
    }

    public function userDetails(User $user)
    {
        return view('admin.withDraw.user-details', compact('user'));
    }
}
