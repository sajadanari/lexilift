<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Home\Home;
use App\Livewire\MyWords\MyWords;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');

Route::get('/dashboard', Dashboard::class)->name('dashboard');

Route::get('/mywords', MyWords::class)->name('mywords');

// Auth routes
Route::name('auth.')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
});