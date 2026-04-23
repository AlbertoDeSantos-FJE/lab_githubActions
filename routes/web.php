<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocaleController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication views and endpoints
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin panel grouping with role protection
Route::middleware(['auth'])->group(function () {
    // Regular user routes (Main page)
    Route::view('/main', 'main')->name('main');

    // Admin only routes
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

        // Moved Profile Routes to be Admin only
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('/places', [AdminController::class, 'getPlaces']);
        Route::post('/places', [AdminController::class, 'storePlace']);
        Route::put('/places/{id}', [AdminController::class, 'updatePlace']);
        Route::delete('/places/{id}', [AdminController::class, 'destroyPlace']);
        
        Route::get('/categories', [AdminController::class, 'getCategories']);
        Route::get('/manage-categories', [AdminController::class, 'manageCategories'])->name('admin.categories');
        Route::post('/categories', [AdminController::class, 'storeCategory']);
        Route::put('/categories/{id}', [AdminController::class, 'updateCategory']);
        Route::delete('/categories/{id}', [AdminController::class, 'destroyCategory']);
        Route::post('/categories/{id}/toggle', [AdminController::class, 'toggleCategoryStatus']);
        
        Route::get('/manage-gymkhanas', [AdminController::class, 'manageGymkhanas'])->name('admin.gymkhanas');
        Route::get('/gym-create', [AdminController::class, 'createGymkhana'])->name('admin.gymkhanas.create');
        Route::post('/gymkhanas', [AdminController::class, 'storeGymkhana'])->name('admin.gymkhanas.store');
        Route::get('/gymkhanas/{id}/edit', [AdminController::class, 'editGymkhana'])->name('admin.gymkhanas.edit');
        Route::put('/gymkhanas/{id}', [AdminController::class, 'updateGymkhana'])->name('admin.gymkhanas.update');
        Route::delete('/gymkhanas/{id}', [AdminController::class, 'destroyGymkhana'])->name('admin.gymkhanas.destroy');
        Route::post('/gymkhanas/{id}/toggle', [AdminController::class, 'toggleGymkhanaStatus']);
        Route::get('/manage-users', [AdminController::class, 'manageUsers'])->name('admin.users');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
        Route::get('/stats/active-groups', [AdminController::class, 'getActiveGroups'])->name('admin.stats.active-groups');
        Route::get('/stats/active-gymkhanas', [AdminController::class, 'getActiveGymkhanas'])->name('admin.stats.active-gymkhanas');
    });
});
Route::get('lang/{locale}', [LocaleController::class, 'switch'])->name('lang.switch');
