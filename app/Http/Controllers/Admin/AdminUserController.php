<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DepositService;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%')
                    ->orWhere('country', 'like', '%' . $search . '%');
            });
        }

        // Paginate results
        $users = $query->where('is_admin', false)->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function view(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function userAccountEdit(User $user)
    {
        return view('admin.users.edit-user', compact('user'));
    }

    public function updateDepositStatus(Request $request, User $user, DepositService $depositService)
    {
        $user->verified_deposit = $request->verified_deposit;
        $user->save();

        $depositService->handleReferralBonus($user);

        return redirect()->back()->with('success', 'Deposit status update successfully');
    }
}
