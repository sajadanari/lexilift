<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Home\Home;
use App\Livewire\MyWords\MyWords;
use Illuminate\Support\Facades\Route;

if(config('app.env') === 'local') {
    require_once('test.php');
}

require_once('admin.php');
require_once('user.php');

Route::get('/', Home::class)->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
});

// Auth routes
Route::get('login', Login::class)->name('login');
Route::get('register', Register::class)->name('register');
Route::post('/logout', [Login::class, 'logout'])->middleware('auth')->name('logout');
