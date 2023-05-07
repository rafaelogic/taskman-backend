<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/api/api_v1.php';

Route::post('/login', [AuthController::class, 'login'])
    ->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum')
    ->name('auth.logout');
