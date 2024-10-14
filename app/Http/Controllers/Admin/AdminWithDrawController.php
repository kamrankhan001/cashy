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

    public function userDetails($withdrawRequest)
    {
        $withdrawRequest = WithdrawRequest::find($withdrawRequest);
        return view('admin.withDraw.user-details', compact('withdrawRequest'));
    }

    public function requestUpdate(Request $request, $withdrawRequest)
    {
        $request->validate([
            'request_status' => 'required|string|in:pending,verified'
        ]);

        $withdrawRequest = WithdrawRequest::find($withdrawRequest);

        $withdrawRequest->status = $request->request_status;

        $withdrawRequest->save();

        return redirect()->back()->with('success', 'Withdraw Request status updated successfully');
    }

}
