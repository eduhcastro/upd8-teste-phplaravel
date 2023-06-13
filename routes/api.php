<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pages\Auth\Login;
use App\Http\Controllers\Pages\Client\Add;
use App\Http\Controllers\Pages\Client\Edit;
use App\Http\Controllers\Pages\Client\Show;
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
Route::prefix('auth')->middleware('web')->group(function () {
    Route::post('process/login', [Login::class, 'loginProcess'])->name('loginProcess');
    Route::get('process/logout', [Login::class, 'logoutProcess'])->name('logoutProcess');
});

Route::prefix('clients')->middleware('web')->group(function () {
    Route::post('process/add', [Add::class, 'addClientsProcess'])->name('addClientsProcess');
    Route::post('process/edit', [Edit::class, 'editClientsProcess'])->name('editClientsProcess');
    Route::delete('process/delete/{id}', [Show::class, 'deleteClientProcess'])->name('deleteClientProcess');
    Route::post('process/list', [Show::class, 'showClientsPageApi'])->name('showClientsPageApi');
});
