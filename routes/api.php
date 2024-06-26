<?php

use App\Http\Controllers\v1\PostController;
use App\Http\Controllers\v1\SubscriberController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::post('posts', [PostController::class, 'store']);
    Route::post('subscribers', [SubscriberController::class, 'store']);
});
