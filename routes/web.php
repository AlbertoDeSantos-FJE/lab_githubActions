<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication views and endpoints
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin panel grouping
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Admin: Gestió de llocs (Dashboard Maps placeholder)
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/places', [AdminController::class, 'getPlaces']);
    Route::post('/places', [AdminController::class, 'storePlace']);
    Route::delete('/places/{id}', [AdminController::class, 'destroyPlace']);
    
    // Admin: Categories
    Route::get('/categories', [AdminController::class, 'getCategories']); // API endpoint for map 
    Route::get('/manage-categories', function() {
        return view('admin.categories');
    })->name('admin.categories');
    
    // Admin: Gimcanes
    Route::get('/manage-gymkhanas', function() {
        return view('admin.gymkhanas');
    })->name('admin.gymkhanas');
});
