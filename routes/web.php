<?php

use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Home\Home;
use App\Livewire\MyWords\MyWords;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');

Route::get('/dashboard', Dashboard::class)->name('dashboard');

Route::get('/mywords', MyWords::class)->name('mywords');