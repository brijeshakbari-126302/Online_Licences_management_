<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\RenewalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

// Public Website Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.store');

// Authentication & Session Management
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Executive Dashboard
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
