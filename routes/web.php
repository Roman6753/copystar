<?php

use App\Livewire\Register\Register;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $users = User::all();
    return view('home', compact('users'));
})->name('home');

Route::get('/register', Register::class)->name('register');
