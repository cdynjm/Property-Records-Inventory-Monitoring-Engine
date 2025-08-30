<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\OfficeController;
use App\Http\Controllers\SuperAdmin\AdminAccountController;
use App\Http\Controllers\SuperAdmin\UnitController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

use App\Http\Controllers\Office\DashboardController as OfficeDashboardController;

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

            Route::get('dashboard', [SuperAdminDashboardController::class, 'index'])->name('superadmin.dashboard');

            Route::get('offices', [OfficeController::class, 'index'])->name('superadmin.offices');
            Route::post('create-office', [OfficeController::class, 'createOffice'])->name('superadmin.create-office');
            Route::patch('update-office', [OfficeController::class, 'updateOffice'])->name('superadmin.update-office');
            Route::delete('delete-office', [OfficeController::class, 'deleteOffice'])->name('superadmin.delete-office');
            
            Route::get('admin-accounts', [AdminAccountController::class, 'index'])->name('superadmin.admin');
            Route::post('create-admin', [AdminAccountController::class, 'createAdmin'])->name('superadmin.create-admin');
            Route::patch('update-admin', [AdminAccountController::class, 'updateAdmin'])->name('superadmin.update-admin');
            Route::delete('delete-admin', [AdminAccountController::class, 'deleteAdmin'])->name('superadmin.delete-admin');

            Route::get('units', [UnitController::class, 'index'])->name('superadmin.units');
            Route::post('create-unit', [UnitController::class, 'createUnit'])->name('superadmin.create-unit');
            Route::patch('update-unit', [UnitController::class, 'updateUnit'])->name('superadmin.update-unit');
            Route::delete('delete-unit', [UnitController::class, 'deleteUnit'])->name('superadmin.delete-unit');

        });

    });

    Route::middleware(['admin'])->group(function () {
        
        Route::prefix('admin')->group(function () {
            
            Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        });

    });

    Route::middleware(['office'])->group(function () {
        
        Route::prefix('office')->group(function () {
    
            Route::get('dashboard', [OfficeDashboardController::class, 'index'])->name('office.dashboard');
            
        });

    });

});

require __DIR__.'/auth.php';
