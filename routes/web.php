<?php

use App\Livewire\Home\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');