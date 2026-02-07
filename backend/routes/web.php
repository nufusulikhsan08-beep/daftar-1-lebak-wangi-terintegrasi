<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LandAssetController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\FurnitureController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\MonthlyReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/password/reset', [AuthController::class, 'showResetForm'])->name('password.request');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Schools Routes
    Route::resource('schools', SchoolController::class);
    
    // Principal Routes
    Route::prefix('schools/{schoolId}/principal')->name('schools.principal.')->group(function () {
        Route::get('/', [PrincipalController::class, 'show'])->name('show');
        Route::get('/edit', [PrincipalController::class, 'edit'])->name('edit');
        Route::put('/', [PrincipalController::class, 'update'])->name('update');
    });
    
    // Teachers Routes
    Route::prefix('schools/{schoolId}/teachers')->name('schools.teachers.')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('index');
        Route::get('/create', [TeacherController::class, 'create'])->name('create');
        Route::post('/', [TeacherController::class, 'store'])->name('store');
        Route::get('/{teacherId}', [TeacherController::class, 'show'])->name('show');
        Route::get('/{teacherId}/edit', [TeacherController::class, 'edit'])->name('edit');
        Route::put('/{teacherId}', [TeacherController::class, 'update'])->name('update');
        Route::delete('/{teacherId}', [TeacherController::class, 'destroy'])->name('destroy');
        Route::get('/import/form', [TeacherController::class, 'showImportForm'])->name('import.form');
        Route::post('/import', [TeacherController::class, 'import'])->name('import');
        Route::get('/export', [TeacherController::class, 'export'])->name('export');
        Route::get('/export/form', [TeacherController::class, 'showExportForm'])->name('export.form');
    });
    
    // Students Routes
    Route::prefix('schools/{schoolId}/students')->name('schools.students.')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('/create', [StudentController::class, 'create'])->name('create');
        Route::post('/', [StudentController::class, 'store'])->name('store');
        Route::get('/{studentId}', [StudentController::class, 'show'])->name('show');
        Route::get('/{studentId}/edit', [StudentController::class, 'edit'])->name('edit');
        Route::put('/{studentId}', [StudentController::class, 'update'])->name('update');
        Route::delete('/{studentId}', [StudentController::class, 'destroy'])->name('destroy');
        Route::get('/statistics', [StudentController::class, 'statistics'])->name('statistics');
        Route::post('/mutasi', [StudentController::class, 'mutasi'])->name('mutasi');
        Route::get('/import/form', [StudentController::class, 'showImportForm'])->name('import.form');
        Route::post('/import', [StudentController::class, 'import'])->name('import');
        Route::get('/export', [StudentController::class, 'export'])->name('export');
        Route::get('/export/form', [StudentController::class, 'showExportForm'])->name('export.form');
    });
    
    // Inventaris - Land Asset Routes
    Route::prefix('schools/{schoolId}/inventaris/land')->name('schools.inventaris.land.')->group(function () {
        Route::get('/', [LandAssetController::class, 'show'])->name('show');
        Route::get('/edit', [LandAssetController::class, 'edit'])->name('edit');
        Route::put('/', [LandAssetController::class, 'update'])->name('update');
    });
    
    // Inventaris - Buildings Routes
    Route::prefix('schools/{schoolId}/inventaris/buildings')->name('schools.inventaris.buildings.')->group(function () {
        Route::get('/', [BuildingController::class, 'index'])->name('index');
        Route::get('/{buildingId}/edit', [BuildingController::class, 'edit'])->name('edit');
        Route::put('/{buildingId}', [BuildingController::class, 'update'])->name('update');
        Route::put('/bulk', [BuildingController::class, 'updateBulk'])->name('updateBulk');
    });
    
    // Inventaris - Furniture Routes
    Route::prefix('schools/{schoolId}/inventaris/furniture')->name('schools.inventaris.furniture.')->group(function () {
        Route::get('/', [FurnitureController::class, 'index'])->name('index');
        Route::get('/{furnitureId}/edit', [FurnitureController::class, 'edit'])->name('edit');
        Route::put('/{furnitureId}', [FurnitureController::class, 'update'])->name('update');
        Route::put('/bulk', [FurnitureController::class, 'updateBulk'])->name('updateBulk');
    });
    
    // Inventaris - Facilities Routes
    Route::prefix('schools/{schoolId}/inventaris/facilities')->name('schools.inventaris.facilities.')->group(function () {
        Route::get('/', [FacilityController::class, 'show'])->name('show');
        Route::get('/edit', [FacilityController::class, 'edit'])->name('edit');
        Route::put('/', [FacilityController::class, 'update'])->name('update');
    });
    
    // Monthly Reports Routes
    Route::prefix('schools/{schoolId}/reports/monthly')->name('schools.reports.monthly.')->group(function () {
        Route::get('/', [MonthlyReportController::class, 'index'])->name('index');
        Route::get('/create', [MonthlyReportController::class, 'create'])->name('create');
        Route::post('/', [MonthlyReportController::class, 'store'])->name('store');
        Route::get('/{reportId}', [MonthlyReportController::class, 'show'])->name('show');
        Route::get('/{reportId}/edit', [MonthlyReportController::class, 'edit'])->name('edit');
        Route::put('/{reportId}', [MonthlyReportController::class, 'update'])->name('update');
        Route::post('/{reportId}/submit', [MonthlyReportController::class, 'submit'])->name('submit');
        Route::get('/{reportId}/pdf', [MonthlyReportController::class, 'generatePDF'])->name('pdf');
    });

    // Admin Routes (Dinas Pendidikan)
    Route::prefix('admin')->name('admin.')->middleware(['role:admin_dinas'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

        // Reports Monitoring
        Route::prefix('reports/monthly')->name('reports.monthly.')->group(function () {
            Route::get('/', [MonthlyReportController::class, 'adminIndex'])->name('index');
            Route::post('/{reportId}/approve', [MonthlyReportController::class, 'approve'])->name('approve');
        });

        // Consolidated Report
        Route::get('/reports/consolidated', [MonthlyReportController::class, 'adminConsolidatedReport'])
              ->name('reports.consolidated');

        // Send All Reminders
        Route::post('/reports/send-all-reminders', [DashboardController::class, 'sendAllReminders'])
              ->name('reports.send.all.reminders');
    });

    // Reminder Route
    Route::post('/schools/{schoolId}/reminder', [MonthlyReportController::class, 'sendReminder'])->name('schools.reminder');

// API Routes for dropdowns and autocomplete
Route::middleware(['auth'])->prefix('api')->name('api.')->group(function () {
    Route::get('/schools/dropdown', [SchoolController::class, 'getSchoolsDropdown'])->name('schools.dropdown');
});