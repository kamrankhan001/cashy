<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{AuthController, DashboardController};
use App\Http\Controllers\Admin\{AdminDashboardController, AdminUserController};



Route::redirect('/', '/login');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('store.register');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'check'])->name('check.login');

Route::middleware('auth')->group(function() {
    Route::get('/confirm-registration', [AuthController::class, 'confirmRegistration'])->name('confirm.registration');

    Route::get('/initial-deposit', [DashboardController::class, 'initialDeposit'])->name('initial.deposit');

    Route::post('/initial-deposit', [DashboardController::class, 'storeDeposit'])->name('store.deposit');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function() {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::get('/users/{user}/view', [AdminUserController::class, 'view'])->name('users.view');
    Route::put('/users/{user}/update/deposit/status', [AdminUserController::class, 'updateDepositStatus'])->name('users.updateDepositStatus');


});
