<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Setting, Level};

class AdminSettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        $levels = Level::all();

        return view('admin.setting', compact('setting', 'levels'));
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
        $setting->update([
            'jazzcash_account_title' => $request->jazzcash_title,
            'jazzcash_account_number' => $request->jazzcash_number,
            'easy_asa_account_title' => $request->easypaisa_title,
            'easy_asa_account_number' => $request->easypaisa_number,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Accounts settings updated successfully.');
    }

    public function updateCoinSettings(Request $request, Setting $setting)
    {
        // Validate the input
        $request->validate([
            'coin_price' => 'required|numeric|min:0',
            'extra_coin_price' => 'required|numeric|min:0',
        ]);

        // Update the settings in the database
        $setting->update([
            'per_coin_price' => $request->coin_price,
            'extra_coin_price' => $request->extra_coin_price,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Coin settings updated successfully.');
    }

    public function levelsUpdate(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'levels.*.id' => 'required|exists:levels,id',
            'levels.*.members' => 'required|integer',
            'levels.*.task_income' => 'required|numeric',
            'levels.*.referral_bonus' => 'required|numeric',
            'levels.*.extra_coins' => 'required|integer',
        ]);

        // Update each level
        foreach ($request->levels as $levelData) {
            $level = Level::find($levelData['id']);
            $level->update($levelData);
        }

        return redirect()->back()->with('success', 'Levels updated successfully!');
    }
}
