<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\RenewalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Core Resource Management
Route::resource('licenses', LicenseController::class);
Route::resource('vendors', VendorController::class);
Route::resource('employees', EmployeeController::class);
Route::resource('assignments', AssignmentController::class);

// Reports & Data Export
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/export/{type}', [ReportController::class, 'export'])->name('reports.export');

// Contract Renewals & Expirations Hub
Route::get('/renewals', [RenewalController::class, 'index'])->name('renewals.index');
Route::post('/renewals/{license}/extend', [RenewalController::class, 'extend'])->name('renewals.extend');

// Audit Trail & Activity Log
Route::get('/activity', [ActivityLogController::class, 'index'])->name('activity.index');

// System Settings & Preferences
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
