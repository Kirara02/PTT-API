<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\ServerController;
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
        //User
        Route::resource('user', UserController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
        Route::put('user/{id}/reset', [UserController::class, 'reset'])->name('user.reset');
        //Server
        Route::resource('server', ServerController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
        //Company
        Route::resource('company', CompanyController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
    });
});
