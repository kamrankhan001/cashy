<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class AdminSettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('admin.setting', compact('setting'));
    }

    public function updateAccountInfo(Request $request, Setting $setting)
    {
        // Validate the input
        $request->validate([
            'jazzcash_title' => 'required|string|max:255',
            'jazzcash_number' => 'required|string|max:255',
            'easypaisa_title' => 'required|string|max:255',
            'easypaisa_number' => 'required|string|max:255',
        ]);

        // Update the settings in the database
        $setting->update(
            [
                'jazzcash_account_title' => $request->jazzcash_title,
                'jazzcash_account_number' => $request->jazzcash_number,
                'easy_asa_account_title' => $request->easypaisa_title,
                'easy_asa_account_number' => $request->easypaisa_number,
                'updated_at' => now(),
            ],
        );

        return redirect()->back()->with('success', 'Accounts settings updated successfully.');
    }

    public function updateCoinSettings(Request $request, Setting $setting)
    {
        // Validate the input
        $request->validate([
            'coin_price' => 'required|numeric|min:0',
            'coins_per_work' => 'required|integer|min:1',
        ]);

        // Update the settings in the database
        $setting->update([
                'per_coin_price' => $request->coin_price,
                'job_per_coin' => $request->coins_per_work,
                'updated_at' => now(),
            ],
        );

        return redirect()->back()->with('success', 'Coin settings updated successfully.');
    }
}
