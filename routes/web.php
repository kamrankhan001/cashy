<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{AuthController, DashboardController};
use App\Http\Controllers\Admin\{AdminDashboardController, AdminUserController, AdminWorkController, AdminSettingController, AdminWithDrawController};


Route::get('clear-all', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return 'Application cache, config, view, and route caches cleared successfully';
});

Route::get('create-link-storage', function(){
    Artisan::call('storage:link');
    return 'storage linked successfully';
});

Route::redirect('/', '/login');

Route::get('/register/{user?}', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('store.register');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'check'])->name('check.login');

Route::middleware('auth')->group(function () {
    Route::get('/confirm-registration', [AuthController::class, 'confirmRegistration'])->name('confirm.registration');

    Route::get('/initial-deposit', [DashboardController::class, 'initialDeposit'])->name('initial.deposit');

    Route::post('/initial-deposit', [DashboardController::class, 'storeDeposit'])->name('store.deposit');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Work
    Route::get('/work/{user}', [DashboardController::class, 'work'])->name('work');
    Route::put('/work/{user}/track/{work}', [DashboardController::class, 'trackAndRedirect'])->name('work.track');

    // Team
    Route::get('/team/{user}', [DashboardController::class, 'team'])->name('team');

    // Settings
    Route::get('/settings', [AuthController::class, 'settings'])->name('settings');

    // Password Update
    Route::post('/update/password', [AuthController::class, 'passwordUpdate'])->name('password.update');

    // Profile
    Route::get('/pofile/{user}', [DashboardController::class, 'pofile'])->name('profile');

    // Wallet
    Route::get('/wallet/{user}', [DashboardController::class, 'wallet'])->name('wallet');
    Route::post('/request/for/withdraw/{user}', [DashboardController::class, 'requestForWithdraw'])->name('request.withdraw');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Users
        Route::get('/users', [AdminUserController::class, 'index'])->name('users');
        Route::get('/users/{user}/view', [AdminUserController::class, 'view'])->name('users.view');
        Route::put('/users/{user}/update/deposit/status', [AdminUserController::class, 'updateDepositStatus'])->name('users.updateDepositStatus');

        // Add Work
        Route::get('/add/work', [AdminWorkController::class, 'index'])->name('works');
        Route::post('/works', [AdminWorkController::class, 'store'])->name('works.store');
        Route::put('/works/{work}', [AdminWorkController::class, 'update'])->name('works.update');
        Route::delete('/works/{work}', [AdminWorkController::class, 'destroy'])->name('works.destroy');

        // WithDraw Requests
        Route::get('/withdraw/request', [AdminWithDrawController::class, 'index'])->name('withdraw');
        Route::get('/withdraw/request/{withDrawRequest}', [AdminWithDrawController::class, 'userDetails'])->name('withdraw.user');
        Route::put('/withdraw/request/{withDrawRequest}', [AdminWithDrawController::class, 'requestUpdate'])->name('withdraw.request.update');


        // Setting
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings');
        Route::post('settings/update-accounts', [AdminSettingController::class, 'updateAccountInfo'])->name('update-accounts');
        Route::post('settings/update-coins', [AdminSettingController::class, 'updateCoinSettings'])->name('update-coins');
    });
