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
use App\Http\Controllers\Admin\AREController;
use App\Http\Controllers\Admin\ICSRecordsController;
use App\Http\Controllers\Admin\ARERecordsController;
use App\Http\Controllers\Admin\OfficeRecordsController;
use App\Http\Controllers\Admin\IssuersController;
use App\Http\Controllers\Admin\ReceiversController;
use App\Http\Controllers\Admin\Forms\ICSFormController;
use App\Http\Controllers\Admin\ICSPrintController;
use App\Http\Controllers\Admin\Forms\AREFormController;
use App\Http\Controllers\Admin\AREPrintController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\AccountsCodeController;
use App\Http\Controllers\Admin\PersonnelController;
use App\Http\Controllers\Admin\RPCPPERecordsController;
use App\Http\Controllers\Admin\RPCPPEPrintController;
use App\Http\Controllers\Admin\Reports\RPCPPEReportController;
use App\Http\Controllers\Admin\UnitController as AdminUnitController;

use App\Http\Controllers\Office\DashboardController as OfficeDashboardController;
use App\Http\Controllers\Office\SearchController as OfficeSearchController;
use App\Http\Controllers\Office\ICSRecordsController as OfficeICSRecordsController;
use App\Http\Controllers\Office\ARERecordsController as OfficeARERecordsController;
use App\Http\Controllers\Office\Forms\ICSFormController as OfficeICSFormController;
use App\Http\Controllers\Office\ICSPrintController as OfficeICSPrintController;
use App\Http\Controllers\Office\Forms\AREFormController as OfficeAREFormController;
use App\Http\Controllers\Office\AREPrintController as OfficeAREPrintController;
use App\Http\Controllers\Office\RPCPPEPrintController as OfficeRPCPPEPrintController;
use App\Http\Controllers\Office\Reports\RPCPPEReportController as OfficeRPCPPEReportController;
use App\Http\Controllers\Office\RPCPPERecordsController as OfficeRPCPPERecordsController;

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
            Route::get('edit-ics/{encrypted_id}', [ICSController::class, 'editICS'])->name('admin.edit-ics');
            Route::post('create-ics', [ICSController::class, 'createICS'])->name('admin.create-ics');
            Route::patch('update-ics', [ICSController::class, 'updateICS'])->name('admin.update-ics');
            Route::delete('delete-ics', [ICSController::class, 'deleteICS'])->name('admin.delete-ics');

            Route::get('ppe', [AREController::class, 'index'])->name('admin.are');
            Route::get('edit-ppe/{encrypted_id}', [AREController::class, 'editARE'])->name('admin.edit-are');
            Route::post('create-are', [AREController::class, 'createARE'])->name('admin.create-are');
            Route::patch('update-are', [AREController::class, 'updateARE'])->name('admin.update-are');
            Route::delete('delete-are', [AREController::class, 'deleteARE'])->name('admin.delete-are');

            Route::get('ics-records', [ICSRecordsController::class, 'index'])->name('admin.ics-records');

            Route::get('ics-form/{encrypted_id}', [ICSFormController::class, 'index'])->name('admin.ics-form');
            Route::get('ics-print/{encrypted_id}', [ICSPrintController::class, 'index'])->name('admin.ics-print');
            Route::get('are-form/{encrypted_id}', [AREFormController::class, 'index'])->name('admin.are-form');
            Route::get('are-print/{encrypted_id}', [AREPrintController::class, 'index'])->name('admin.are-print');



            Route::get('are-records', [ARERecordsController::class, 'index'])->name('admin.are-records');

            Route::get('office-records', [OfficeRecordsController::class, 'index'])->name('admin.office-records');
            Route::get('office-records/{encrypted_id}', [OfficeRecordsController::class, 'officePropertyInventoryRecords'])->name('admin.office-property-inventory-records');
            Route::post('create-office', [OfficeRecordsController::class, 'createOffice'])->name('admin.create-office');
            Route::patch('update-office', [OfficeRecordsController::class, 'updateOffice'])->name('admin.update-office');
            Route::delete('delete-office', [OfficeRecordsController::class, 'deleteOffice'])->name('admin.delete-office');
            
            Route::get('issuers', [IssuersController::class, 'index'])->name('admin.issuers');
            Route::get('issuers/{encrypted_id}', [IssuersController::class, 'issuersPropertyInventoryRecords'])->name('admin.issuers-property-inventory-records');
            Route::post('create-issuer', [IssuersController::class, 'createIssuer'])->name('admin.create-issuer');
            Route::patch('update-issuer', [IssuersController::class, 'updateIssuer'])->name('admin.update-issuer');
            Route::delete('delete-issuer', [IssuersController::class, 'deleteIssuer'])->name('admin.delete-issuer');
            
            Route::get('receivers', [ReceiversController::class, 'index'])->name('admin.receivers');
            Route::get('receivers/{encrypted_id}', [ReceiversController::class, 'receiversPropertyInventoryRecords'])->name('admin.receivers-property-inventory-records');

            Route::post('search', [SearchController::class, 'search'])->name('admin.search');
            Route::post('search-clear', [SearchController::class, 'searchClear'])->name('admin.search-clear');
            Route::post('year', [SearchController::class, 'year'])->name('admin.year');
            Route::post('year-clear', [SearchController::class, 'yearClear'])->name('admin.year-clear');
            Route::post('search-receiver', [SearchController::class, 'searchReceiver'])->name('admin.search-receiver');
            Route::post('clear-receiver', [SearchController::class, 'clearReceiver'])->name('admin.search-receiver');
            Route::post('search-rpcppe', [SearchController::class, 'searchRPCPPE'])->name('admin.search-rpcppe');

            Route::get('accounts-code', [AccountsCodeController::class, 'index'])->name('admin.accounts-code');
            Route::get('accounts-code/{encrypted_id}', [AccountsCodeController::class, 'accountsCodePropertyInventoryRecords'])->name('admin.accounts-code-property-inventory-records');
            Route::post('create-accounts-code', [AccountsCodeController::class, 'createAccountsCode'])->name('admin.create-accounts-code');
            Route::patch('update-accounts-code', [AccountsCodeController::class, 'updateAccountsCode'])->name('admin.update-accounts-code');
            Route::delete('delete-accounts-code', [AccountsCodeController::class, 'deleteAccountsCode'])->name('admin.delete-accounts-code');

            Route::get('rpcppe-records', [RPCPPERecordsController::class, 'index'])->name('admin.rpcppe-records');

            Route::get('units', [AdminUnitController::class, 'index'])->name('admin.units');
            Route::post('create-unit', [AdminUnitController::class, 'createUnit'])->name('admin.create-unit');
            Route::patch('update-unit', [AdminUnitController::class, 'updateUnit'])->name('admin.update-unit');
            Route::delete('delete-unit', [AdminUnitController::class, 'deleteUnit'])->name('admin.delete-unit');

            Route::get('search-received-by', [PersonnelController::class, 'searchReceivedBy'])->name('admin.search-received-by');
        
            Route::get('rpcppe-print', [RPCPPEPrintController::class, 'index'])->name('admin.rpcppe-print');
            Route::get('rpcppe-report', [RPCPPEReportController::class, 'index'])->name('admin.rpcppe-report');
            
        });

    });

    Route::middleware(['office'])->group(function () {
        
        Route::prefix('office')->group(function () {
    
            Route::get('dashboard', [OfficeDashboardController::class, 'index'])->name('office.dashboard');
            
            Route::post('search', [OfficeSearchController::class, 'search'])->name('office.search');
            Route::post('search-clear', [OfficeSearchController::class, 'searchClear'])->name('office.search-clear');
            Route::post('year', [OfficeSearchController::class, 'year'])->name('office.year');
            Route::post('year-clear', [OfficeSearchController::class, 'yearClear'])->name('office.year-clear');
            Route::post('search-rpcppe', [OfficeSearchController::class, 'searchRPCPPE'])->name('office.search-rpcppe');

            Route::get('ics-records', [OfficeICSRecordsController::class, 'index'])->name('office.ics-records');
            Route::get('are-records', [OfficeARERecordsController::class, 'index'])->name('office.are-records');

            Route::get('ics-form/{encrypted_id}', [OfficeICSFormController::class, 'index'])->name('office.ics-form');
            Route::get('ics-print/{encrypted_id}', [OfficeICSPrintController::class, 'index'])->name('office.ics-print');
            Route::get('are-form/{encrypted_id}', [OfficeAREFormController::class, 'index'])->name('office.are-form');
            Route::get('are-print/{encrypted_id}', [OfficeAREPrintController::class, 'index'])->name('office.are-print');

            Route::get('rpcppe-records', [OfficeRPCPPERecordsController::class, 'index'])->name('office.rpcppe-records');

            Route::get('rpcppe-print', [OfficeRPCPPEPrintController::class, 'index'])->name('office.rpcppe-print');
            Route::get('rpcppe-report', [OfficeRPCPPEReportController::class, 'index'])->name('office.rpcppe-report');
        });

    });

});

require __DIR__.'/auth.php';
