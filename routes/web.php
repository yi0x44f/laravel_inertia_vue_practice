<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::inertia('/about','About',['user'=>'Yi'])->name('about');

Route::middleware('guest')->group( function(){
    Route::inertia('/register','Auth/Register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::inertia('/login', 'Auth/Login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});






Route::middleware('auth')->group( function(){
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');
});
