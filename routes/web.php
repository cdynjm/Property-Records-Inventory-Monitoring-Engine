<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RedirectIfAuthenticated;

use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\OfficeController;
use App\Http\Controllers\SuperAdmin\AdminAccountController;
use App\Http\Controllers\SuperAdmin\UnitController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ICSController;
use App\Http\Controllers\Admin\EditICSController;
use App\Http\Controllers\Admin\AREController;
use App\Http\Controllers\Admin\ICSRecordsController;
use App\Http\Controllers\Admin\ARERecordsController;
use App\Http\Controllers\Admin\OfficeRecordsController;
use App\Http\Controllers\Admin\IssuersController;
use App\Http\Controllers\Admin\ReceiversController;

use App\Http\Controllers\Office\DashboardController as OfficeDashboardController;

Route::get('/', [RedirectIfAuthenticated::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
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

            Route::get('ics', [ICSController::class, 'index'])->name('admin.ics');
            Route::post('create-ics', [ICSController::class, 'createICS'])->name('admin.create-ics');

            Route::get('edit-ics/{encrypted_id}', [EditICSController::class, 'index'])->name('admin.edit-ics');

            Route::get('are', [AREController::class, 'index'])->name('admin.are');

            Route::get('ics-records', [ICSRecordsController::class, 'index'])->name('admin.ics-records');

            Route::get('are-records', [ARERecordsController::class, 'index'])->name('admin.are-records');

            Route::get('office-records', [OfficeRecordsController::class, 'index'])->name('admin.office-records');
        
            Route::get('issuers', [IssuersController::class, 'index'])->name('admin.issuers');
            Route::post('create-issuer', [IssuersController::class, 'createIssuer'])->name('admin.create-issuer');
            Route::patch('update-issuer', [IssuersController::class, 'updateIssuer'])->name('admin.update-issuer');
            Route::delete('delete-issuer', [IssuersController::class, 'deleteIssuer'])->name('admin.delete-issuer');
            
            Route::get('receivers', [ReceiversController::class, 'index'])->name('admin.receivers');
        });

    });

    Route::middleware(['office'])->group(function () {
        
        Route::prefix('office')->group(function () {
    
            Route::get('dashboard', [OfficeDashboardController::class, 'index'])->name('office.dashboard');
            
        });

    });

});

require __DIR__.'/auth.php';
