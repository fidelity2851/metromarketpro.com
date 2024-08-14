<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\DepositMethodController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\KYCController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TwoFaController;
use App\Http\Controllers\UserController;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'ensure_email_verified', '2fa'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/deposit', [DepositController::class, 'index'])->name('deposit');

    Route::controller(KYCController::class)->group(function () {
        Route::get('/kyc', 'index')->name('kyc');
        Route::get('/kyc/{kyc}', 'show')->name('edit-kyc');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('users');
        Route::get('/user/{user}', 'show')->name('show-user');
        Route::get('/user/{user}/edit', 'edit')->name('edit-user');
    });

    Route::controller(TeamController::class)->group(function () {
        Route::get('/teams', 'index')->name('teams');
        Route::get('/team/{team}/edit', 'edit')->name('edit-team');
    });

    Route::controller(InvestmentController::class)->group(function () {
        Route::get('/invest', 'index')->name('invest');
    });

    Route::controller(PlanController::class)->group(function () {
        Route::get('/plans', 'index')->name('plans');
        Route::get('/plan/{plan}/edit', 'edit')->name('edit-plan');
    });

    Route::controller(SupportTicketController::class)->group(function () {
        Route::get('/support', 'index')->name('tickets');
        Route::get('/support/{ticket}/view', 'view')->name('view-ticket');
        Route::get('/support/{ticket}/edit', 'edit')->name('edit-ticket');
    });

    Route::controller(DepositMethodController::class)->group(function () {
        Route::get('/deposit/methods', 'index')->name('deposit-methods');
        Route::get('/deposit/methods/{method}/edit', 'edit')->name('edit-deposit-method');
    });

    Route::controller(SettingController::class)->group(function () {
        Route::get('/settings', 'index')->name('settings');
    });

    Route::controller(TwoFaController::class)->group(function () {
        Route::get('/2fa', 'index')->name('2fa');
        Route::get('/google2fa/activate', 'index');
        Route::get('google2fa/enable', 'enable2fa')->name('google2fa.enable');
        Route::get('google2fa/disable', 'disable2fa')->name('google2fa.disable');
        Route::get('google2fa/delete', 'delete2fa')->name('google2fa.delete');

        Route::post('google2fa/authenticate', 'verify2fa')->name('google2fa.verify');
        Route::post('google2fa/activate', 'activate2fa')->name('google2fa.activate');
    });


    Route::view('/withdrawal', 'withdrawal')->name('withdrawal');
    Route::view('/transfer', 'transfer_funds')->name('transfer-funds');
    Route::view('/payout', 'payout')->name('payout');
    Route::view('/referral', 'referral')->name('referrals');
    Route::view('/notification', 'notification')->name('notifications');
    Route::view('/profile', 'profile_setting')->name('profile');
});

// Guest
Route::controller(InvestmentController::class)->group(function () {
    Route::get('/invest/pay', 'PayInvestmentIntrest')->name('pay-invest');
});


// Route::get('/linkstorage', function () {
//     Artisan::call('storage:link');
// });


// Livewire::setScriptRoute(function ($handle) {
//     return Route::get('/user/livewire/livewire.js', $handle);
// });
// Livewire::setUpdateRoute(function ($handle) {
//     return Route::post('/user/livewire/update', $handle);
// });


require __DIR__ . '/auth.php';
