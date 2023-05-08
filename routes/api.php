<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthUserController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/api/api_v1.php';

Route::get('/users/auth', AuthUserController::class)
    ->name('user.profile');

Route::post('/login', [AuthController::class, 'login'])
    ->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum')
    ->name('auth.logout');
