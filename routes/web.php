<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServerChannelController;
use App\Http\Controllers\ServerCategoryController;

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

Route::get('/', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

Route::post('/servers', [ServerController::class, 'store'])
    ->name('servers.store')
    ->middleware('auth');

Route::get('/servers/{server}', [ServerController::class, 'show'])
    ->name('servers.show')
    ->middleware('auth');

Route::put('/servers/{server}', [ServerController::class, 'update'])
    ->name('servers.update')
    ->middleware('auth');

Route::delete('/servers/{server}', [ServerController::class, 'destroy'])
    ->name('servers.destroy')
    ->middleware('auth');

Route::post('/servers/{server}/categories', [ServerCategoryController::class, 'store'])
    ->name('servers.categories.store')
    ->middleware('auth');

Route::put('/servers/{server}/categories/{category}', [ServerCategoryController::class, 'update'])
    ->name('servers.categories.update')
    ->middleware('auth');

Route::delete('/servers/{server}/categories/{category}', [ServerCategoryController::class, 'destroy'])
    ->name('servers.categories.destroy')
    ->middleware('auth');

Route::post('/servers/{server}/channels', [ServerChannelController::class, 'store'])
    ->name('servers.channels.store')
    ->middleware('auth');

Route::put('/servers/{server}/channels/{channel}', [ServerChannelController::class, 'update'])
    ->name('servers.channels.update')
    ->middleware('auth');

Route::delete('/servers/{server}/channels/{channel}', [ServerChannelController::class, 'destroy'])
    ->name('servers.channels.destroy')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
