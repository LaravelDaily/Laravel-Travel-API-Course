<?php

use App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\TourController;
use App\Http\Controllers\Api\V1\TravelController;
use Illuminate\Http\Request;
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

Route::get('travels', [TravelController::class, 'index']);
Route::get('travels/{travel:slug}/tours', [TourController::class, 'index']);

Route::prefix('admin')->middleware(['auth:sanctum'])->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::post('travels', [Admin\TravelController::class, 'store']);
        Route::post('travels/{travel}/tours', [Admin\TourController::class, 'store']);
    });

    Route::put('travels/{travel}', [\App\Http\Controllers\Api\V1\Admin\TravelController::class, 'update']);
});

Route::post('login', LoginController::class);
