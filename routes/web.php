<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->name('auth');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware('auth')->group(function(){
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::prefix('admin')->name('admin.')->group(function(){
        Route::resource('/user', UserController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
    });
});
