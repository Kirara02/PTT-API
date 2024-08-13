<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CertificateController;
use App\Http\Controllers\API\PositionController;
use App\Http\Controllers\API\ServerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('auth')->group(function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
});

Route::middleware('auth:sanctum')->group(function () {

    //Server
    Route::get('/servers', [ServerController::class, 'index']);
    Route::get('/servers/{id}', [ServerController::class, 'show']);
    Route::post('/servers', [ServerController::class, 'store']);
    Route::put('/servers/{id}', [ServerController::class, 'update']);
    Route::delete('/servers/{id}', [ServerController::class, 'destroy']);

    //Certificates
    Route::post('/certificates',[CertificateController::class, 'store']);

    //Positions
    Route::get('/positions', [PositionController::class, 'getData']);
    Route::get('/position', [PositionController::class, 'getLastPositionUser']);
    Route::post('/position', [PositionController::class, 'store']);
});
