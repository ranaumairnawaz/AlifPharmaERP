<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StockAuditController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\InventorySlipController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProjectManagerController;
use App\Http\Controllers\StockDiscardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\DamageReportController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\MaterialEntryController;
use App\Http\Controllers\AccountController;

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

// Authentication Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Corporate Hub
Route::middleware('auth')->group(function () {

    // Executive Dashboard (Unified Entry)
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // 1. Product Catalog Hub (RBAC Protected)
    Route::middleware('permission:products,read')->group(function () {
        Route::get('products/finished-goods', [ProductController::class, 'indexFinishedGoods'])->name('products.finished');
        Route::get('products/raw-materials', [ProductController::class, 'indexRawMaterials'])->name('products.raw');
        Route::get('products/packaging-materials', [ProductController::class, 'indexPackagingMaterials'])->name('products.packaging');

        Route::get('products/batch', [ProductController::class, 'batchIndex'])->name('products.batch');
        Route::post('products/batch', [ProductController::class, 'batchUpdate'])->name('products.batch.update');

        Route::get('products/catalogue/pdf', [ProductController::class, 'generateCataloguePDF'])->name('products.catalogue.pdf');
        Route::get('products/{product}/pdf', [ProductController::class, 'exportPdf'])->name('products.pdf');

        Route::resource('products', ProductController::class);
    });

    // 1.5 Batch Tracking & Production
    Route::middleware('permission:batches,read')->group(function () {
        Route::get('batches/expiring', [BatchController::class, 'expiring'])->name('batches.expiring');
        Route::get('batches', [BatchController::class, 'index'])->name('batches.index');
        Route::get('batches/create', [BatchController::class, 'create'])->name('batches.create');
        Route::post('batches', [BatchController::class, 'store'])->name('batches.store');
    });

    // 2. Logistics & Distribution (AP-Series)
    Route::middleware('permission:slips,read')->group(function () {
        Route::resource('inventory-slips', InventorySlipController::class)->names('slips')->parameters(['inventory-slips' => 'slip']);
        Route::get('inventory-slips/{slip}/pdf', [InventorySlipController::class, 'generatePDF'])->name('slips.pdf');
    });

    // 3. Finance & Accounts (Professional Invoicing)
    Route::middleware('permission:invoices,read')->group(function () {
        Route::resource('invoices', InvoiceController::class);
        Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'pdf'])->name('invoices.pdf');
        Route::patch('invoices/{invoice}/status', [InvoiceController::class, 'updateStatus'])->name('invoices.update-status');
        Route::post('invoices/{invoice}/warranty', [InvoiceController::class, 'generateWarranty'])->name('invoices.warranty');

        // Quick Personnel Registry (Direct Manifest Access)
        Route::post('project-managers', [ProjectManagerController::class, 'store'])->name('pms.store');
        Route::delete('project-managers/{pm}', [ProjectManagerController::class, 'destroy'])->name('pms.destroy');
    });

    // 4. Partner Ecosystem
    Route::middleware('permission:distributors,read')->group(function () {
        Route::get('distributors/{distributor}/pdf', [DistributorController::class, 'pdf'])->name('distributors.pdf');
        Route::resource('distributors', DistributorController::class);
    });

    // 5. Material Quality & Discards
    Route::middleware('permission:discards,read')->group(function () {
        Route::resource('stock-discards', StockDiscardController::class)->names('discards');
    });

    // 6. Master Data & Taxonomy (Individualized Permissions)
    Route::middleware('permission:groups,read')->group(function () {
        Route::resource('groups', GroupController::class);
    });
    Route::middleware('permission:brands,read')->group(function () {
        Route::resource('brands', BrandController::class);
    });
    Route::middleware('permission:categories,read')->group(function () {
        Route::resource('categories', CategoryController::class);
    });
    Route::middleware('permission:units,read')->group(function () {
        Route::resource('units', UnitController::class);
    });

    // 7. System Governance & Access Control (Modular)
    Route::middleware('permission:roles,read')->group(function () {
        Route::resource('roles', RolesController::class);
    });
    Route::middleware('permission:users,read')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });

    // 7.5 System Configuration (Granular)
    Route::middleware('permission:settings,read')->group(function () {
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
    });

    // 7.6 Activity Auditing (Granular)
    Route::middleware('permission:activities,read')->group(function () {
        Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    });

    // 7.7 Inventory Loss & Damages (Restricted)
    Route::middleware('permission:damages,read')->group(function () {
        Route::resource('damages', DamageReportController::class);
        Route::prefix('batches')->name('batches.')->group(function () {
            Route::post('{batch}/reject', [BatchController::class, 'reject'])->name('reject');
        });
    });

    // 7.8 Human Resources & Payroll (Sensitive)
    Route::middleware('permission:employees,read')->group(function () {
        Route::resource('employees', EmployeeController::class);
    });

    Route::middleware('permission:salaries,read')->group(function () {
        Route::prefix('salaries')->name('salaries.')->group(function () {
            Route::get('/', [SalaryController::class, 'index'])->name('index');
            Route::get('/process', [SalaryController::class, 'process'])->name('process');
            Route::post('/store', [SalaryController::class, 'store'])->name('store');
            Route::get('/slip/{payment}', [SalaryController::class, 'slip'])->name('slip');
        });
    });

    // 8. Intelligence & Reporting (BI Hub)
    Route::middleware('permission:reports,read')->group(function () {
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/financial/pdf', [ReportController::class, 'exportPdf'])->name('reports.financial.pdf');
        Route::get('stock-audit', [StockAuditController::class, 'index'])->name('reports.audit');
        Route::get('reports/audit/pdf', [StockAuditController::class, 'exportPdf'])->name('reports.audit.pdf');
    });

    // 9. Intelligence & Procurement (Materials)
    Route::middleware('permission:products,read')->group(function () {
        Route::get('materials', [MaterialEntryController::class, 'index'])->name('materials.index');
        Route::get('materials/create', [MaterialEntryController::class, 'create'])->name('materials.create');
        Route::post('materials', [MaterialEntryController::class, 'store'])->name('materials.store');
        Route::get('materials/{entry}', [MaterialEntryController::class, 'show'])->name('materials.show');
        Route::get('materials/{entry}/pdf', [MaterialEntryController::class, 'pdf'])->name('materials.pdf');
        Route::patch('materials/{entry}/status', [MaterialEntryController::class, 'updateStatus'])->name('materials.update-status');
    });

    // 11. Finance & Accounts Ledger
    Route::middleware('permission:accounts,read')->group(function () {
        Route::get('accounts', [AccountController::class, 'index'])->name('accounts.index');
        Route::get('accounts/income/create', [AccountController::class, 'createIncome'])->name('accounts.income.create');
        Route::post('accounts/income', [AccountController::class, 'storeIncome'])->name('accounts.income.store');
        Route::get('accounts/expense/create', [AccountController::class, 'createExpense'])->name('accounts.expense.create');
        Route::post('accounts/expense', [AccountController::class, 'storeExpense'])->name('accounts.expense.store');
        Route::delete('accounts/income/{income}', [AccountController::class, 'destroyIncome'])->name('accounts.income.destroy');
        Route::delete('accounts/expense/{expense}', [AccountController::class, 'destroyExpense'])->name('accounts.expense.destroy');
    });

    // 10. Utilities & Common Features
    Route::get('/api/search', [SearchController::class, 'index'])->name('search.api');
    Route::get('stock', [StockController::class, 'index'])->name('stock.index');
    Route::post('stock', [StockController::class, 'store'])->name('stock.store');
    Route::get('api/products/{id}/batches', [ProductController::class, 'getBatches'])->name('api.batches');
    Route::get('api/materials/search', [StockController::class, 'searchMaterials'])->name('api.materials.search');
    Route::get('api/materials/{productId}/lots', [StockController::class, 'getProductLots'])->name('api.materials.lots');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');

    // 10. Secondary Redundancy Hub (Cloud Backup)
    Route::prefix('backup')->name('backup.')->group(function () {
        Route::post('/run', [BackupController::class, 'run'])->name('run');
        Route::get('/info', [BackupController::class, 'getInfo'])->name('info');
    });
});
