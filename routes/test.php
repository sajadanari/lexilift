<?php

use Illuminate\Support\Facades\Route;

Route::get('/templogin/{role}', function() {
    if (request()->role == 'admin') {
        auth()->loginUsingId(1);
    } else {
        auth()->loginUsingId(2);
    }
    return redirect()->route('home');
})->name('templogin');