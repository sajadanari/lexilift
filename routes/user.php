<?php

use App\Livewire\MyWords\MyWords;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:user|admin'])->group(function () {
    Route::get('/mywords', MyWords::class)->name('mywords');
});
