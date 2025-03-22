<?php

use App\Livewire\MyWords\MyWords;
use App\Livewire\Review\Review;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:user|admin'])->group(function () {
    Route::get('/mywords', MyWords::class)->name('mywords');
    Route::get('/review', Review::class)->name('review');
});
