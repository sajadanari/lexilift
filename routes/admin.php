<?php

use App\Livewire\Users\Users;
use App\Livewire\Words\Words;
use Illuminate\Support\Facades\Route;

Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/words', Words::class)->name('words');
    Route::get('/users', Users::class)->name('users');
});
