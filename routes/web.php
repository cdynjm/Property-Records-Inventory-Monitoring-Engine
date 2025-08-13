<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SuperAdmin\DashboardController;

Route::get('/', function () {
    return view('pages.welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::middleware(['auth'])->group(function () {

    Route::middleware(['superadmin'])->group(function () {

        Route::prefix('superadmin')->group(function () {

            Route::get('dashboard', [DashboardController::class, 'index'])->name('superadmin.dashboard');

        });

    });

    Route::middleware(['admin'])->group(function () {
        
        Route::prefix('admin')->group(function () {
    
        });

    });

    Route::middleware(['office'])->group(function () {
        
        Route::prefix('office')->group(function () {
    
        });

    });

});

require __DIR__.'/auth.php';
