<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\UserController;
use App\Livewire\Register\Register;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
     return view('home');
})->name('home');

Route::get('/register', Register::class)->name('register');

Route::prefix('dashboard')->group(function () {
    Route::view('/', 'dashboard.index')->name('dashboard');
    Route::view('/category', 'dashboard.category')->name('dashboard.category');
    Route::view('/country', 'dashboard.country')->name('dashboard.country');
    Route::view('/user', 'dashboard.user')->name('dashboard.user');
});

Route::get('/categories/export', [CategoryController::class, 'export'])->name('categories.export');
Route::post('/categories/import', [CategoryController::class, 'import'])->name('categories.import');

Route::get('/countries/export', [CountryController::class, 'export'])->name('countries.export');
Route::post('/countries/import', [CountryController::class, 'import'])->name('countries.import');

Route::get('/users/export', [UserController::class, 'export'])->name('users.export');
Route::post('/users/import', [UserController::class, 'import'])->name('users.import');
