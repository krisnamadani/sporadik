<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataController;

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

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::controller(LoginController::class)->group(function ()
{
    Route::get('login', 'login')->name('login');
    Route::post('login', 'login_post')->name('login.post');

    Route::get('logout', 'logout')->name('logout');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function ()
{
    Route::get('/', function () {
        return redirect()->route('admin.dashboard.index');
    });

    Route::controller(DashboardController::class)->prefix('dashboard')->name('dashboard.')->group(function ()
    {
        Route::get('/', 'index')->name('index');
    });

    Route::controller(DataController::class)->prefix('data')->name('data.')->group(function ()
    {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/update', 'update')->name('update');
        Route::delete('/delete', 'delete')->name('delete');
    });

    Route::controller(UserController::class)->prefix('user')->name('user.')->group(function ()
    {
        Route::get('/', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/update', 'update')->name('update');
        Route::delete('/delete', 'delete')->name('delete');
    });
});
