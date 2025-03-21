<?php

use App\Livewire\Users\Users;
use Illuminate\Support\Facades\Route;

Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', Users::class)->name('users');
});
