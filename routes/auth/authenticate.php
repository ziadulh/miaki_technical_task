<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'],'/login', [ AuthController::class, 'login'])->name('login');
Route::get('logout', [ AuthController::class, 'logout'])->name('logout');