<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\StokManagementController;

Route::pattern('id', '[0-9]+');

// Authentication Routes
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('/register', [AuthController::class, 'register'])->name('register.form');
Route::post('/register', [AuthController::class, 'store_user'])->name('register.store');

// Profile Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('profile/update', [AuthController::class, 'update']);
});

// Protected Routes (Require Authentication)
Route::middleware('auth')->group(function () {
   
    // Dashboard
    Route::get('/', [WelcomeController::class, 'index']);
    
    // User Management (Admin Only)
    Route::middleware(['authorize:ADM'])->prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/list', [UserController::class, 'list']);
        Route::get('/create_ajax', [UserController::class, 'create_ajax']);
        Route::post('/ajax', [UserController::class, 'store_ajax']);
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
        Route::get('/import', [UserController::class, 'import']);
        Route::post('/import_ajax', [UserController::class, 'import_ajax']);
        Route::get('/export_excel', [UserController::class, 'export_excel']);
        Route::get('/export_pdf', [UserController::class, 'export_pdf']);
    });
    
    // Level Management (Admin Only)
    Route::middleware(['authorize:ADM'])->prefix('level')->group(function () {
        Route::get('/', [LevelController::class, 'index']);
        Route::post('/list', [LevelController::class, 'list']);
        Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
        Route::post('/ajax', [LevelController::class, 'store_ajax']);
        Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
        Route::get('/import', [LevelController::class, 'import']);
        Route::post('/import_ajax', [LevelController::class, 'import_ajax']);
        Route::get('/export_excel', [LevelController::class, 'export_excel']);
        Route::get('/export_pdf', [LevelController::class, 'export_pdf']);
    });
    
    // Kategori Management (Admin Only)
    Route::middleware(['authorize:ADM'])->prefix('kategori')->group(function () {
        Route::get('/', [KategoriController::class, 'index']);
        Route::post('/list', [KategoriController::class, 'list']);
        Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
        Route::post('/ajax', [KategoriController::class, 'store_ajax']);
        Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
        Route::get('/import', [KategoriController::class, 'import']);
        Route::post('/import_ajax', [KategoriController::class, 'import_ajax']);
        Route::get('/export_excel', [KategoriController::class, 'export_excel']);
        Route::get('/export_pdf', [KategoriController::class, 'export_pdf']);
    });
    
        Route::middleware(['authorize:ADM, MNG'])->prefix('barang')->group(function (){
        Route::get('/', [BarangController::class, 'index']);
        Route::post('/list', [BarangController::class, 'list']);
        Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
        Route::post('/ajax', [BarangController::class, 'store_ajax']);
        Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']);
        Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);
        Route::get('/{id}/confirm_ajax', [BarangController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
        Route::get('/import', [BarangController::class, 'import']);
        Route::post('/import_ajax', [BarangController::class, 'import_ajax']);
        Route::get('/export_excel', [BarangController::class, 'export_excel']);
        Route::get('/export_pdf', [BarangController::class, 'export_pdf']);

    });
        Route::middleware(['authorize:ADM,MNG,STF'])->prefix('stok')->group(function () {
        Route::get('/', [StokManagementController::class, 'index'])->name('stok.index');
        Route::get('/list', [StokManagementController::class, 'list'])->name('stok.list');
        Route::get('/{id}/history', [StokManagementController::class, 'history'])->name('stok.history');
        Route::get('/report', [StokManagementController::class, 'report'])->name('stok.report');
        Route::get('/export-pdf', [StokManagementController::class, 'exportPdf'])->name('stok.export-pdf');
        Route::get('/import', [StokManagementController::class, 'import'])->name('stok.import');
        Route::post('/add', [StokManagementController::class, 'addStock'])->name('stok.add');
        Route::post('/reduce', [StokManagementController::class, 'reduceStock'])->name('stok.reduce');
        Route::post('/adjust', [StokManagementController::class, 'adjustStock'])->name('stok.adjust');
        Route::post('/import-ajax', [StokManagementController::class, 'importAjax'])->name('stok.import-ajax');
});
    
});
