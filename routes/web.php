<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SystemSettingsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ParentsController;
use App\Http\Controllers\Admin\GuardianController;
use App\Http\Controllers\Admin\ChildrenController;
use App\Http\Controllers\Admin\PickupController;
use App\Http\Controllers\Admin\ScannerController;

use App\Http\Controllers\Parent\AccountController;
use App\Http\Controllers\Parent\HomeController;
use App\Http\Controllers\Parent\ProfileController;
use App\Http\Controllers\Parent\SecurityController;
use App\Http\Controllers\Parent\PickUpLogsController;
use App\Http\Controllers\Parent\ChildController;
use App\Http\Controllers\Parent\GuardiansController;


// Admin
Route::get('admin', [AuthController::class, 'index'])->name('admin.login.form');
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('settings', [SystemSettingsController::class, 'index'])->name('settings');
    Route::post('settings/update', [SystemSettingsController::class, 'update'])->name('settings.update');

    Route::get('users', [UsersController::class, 'index'])->name('users');
    Route::post('users/save', [UsersController::class, 'storeOrUpdate'])->name('users.save');

    Route::get('parents', [ParentsController::class, 'index'])->name('parents');
    Route::get('parents/{id}/show', [ParentsController::class, 'show'])->name('parents.edit');
    Route::post('parents/store', [ParentsController::class, 'store'])->name('parents.store');
    Route::get('parents/generate-qr/{id}', [ParentsController::class, 'generateQrCode']);
    Route::post('parents/send-activation-email', [ParentsController::class, 'sendActivationEmail'])->name('parents.send.activation.email');

    Route::get('guardians', [GuardianController::class, 'index'])->name('guardians');
    Route::get('guardians/generate-qr/{id}', [GuardianController::class, 'generateQrCode']);
    
    Route::get('children', [ChildrenController::class, 'index'])->name('children');
    Route::get('pickups', [PickupController::class, 'index'])->name('pickups');
    Route::get('scanner', [ScannerController::class, 'index'])->name('scanner');
    Route::post('scanner/scan', [ScannerController::class, 'scan'])->name('scanner.scan');
    Route::post('scanner/face', [ScannerController::class, 'face'])->name('scanner.face');
});

//Parents / Guardians route
Route::get('/', [AccountController::class, 'index'])->name('parent.login.form');
Route::post('login', [AccountController::class, 'login'])->name('parent.login');
Route::get('register', [AccountController::class, 'form'])->name('parent.register.form');
Route::get('logout', [AccountController::class, 'logout'])->name('parent.logout');
Route::post('register', [AccountController::class, 'register'])->name('parent.register');
Route::get('verify-email/{token}', [AccountController::class, 'verifyEmail'])
    ->middleware('signed')
    ->name('parent.verify.email');

Route::prefix('parent')->name('parent.')->group(function () {
    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');

    Route::get('security', [SecurityController::class, 'index'])->name('security');
    Route::post('security/update-email', [SecurityController::class, 'updateEmail'])->name('security.update-email');
    Route::post('security/update-password', [SecurityController::class, 'updatePassword'])->name('security.update-password');
    // Route::post('security/delete-account', [SecurityController::class, 'deleteAccount'])->name('security.delete-account');
    Route::post('security/register-face', [SecurityController::class, 'registerFace'])->name('security.face-register');

    Route::get('pickup/logs', [PickUpLogsController::class, 'index'])->name('pickup.logs');
    Route::get('child', [ChildController::class, 'index'])->name('child');
    Route::post('child/save', [ChildController::class, 'submit'])->name('child.save');
    Route::get('child/{id}/edit', [ChildController::class, 'show']);

    Route::get('generate-qr/{id}', [ParentsController::class, 'generateQrCode']);
    
    Route::get('guardians', [GuardiansController::class, 'index'])->name('guardians');
    Route::get('guardians/generate-qr/{id}', [GuardiansController::class, 'generateQrCode']);
    
    Route::post('guardians/save', [GuardiansController::class, 'submit'])->name('guardians.save');
    Route::get('guardians/{id}/edit', [GuardiansController::class, 'show']);
});