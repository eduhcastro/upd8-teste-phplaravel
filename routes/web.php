<?php

use App\Http\Controllers\Pages\Auth\Login;
use App\Http\Controllers\Pages\Client\Add;
use App\Http\Controllers\Pages\Client\Edit;
use App\Http\Controllers\Pages\Client\Show;
use App\Http\Controllers\Pages\Home;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [Home::class, 'homePage'])->name('homePage')->middleware('auth');

Route::prefix('auth')->group(function () {
  Route::get('login', [Login::class, 'loginPage'])->name('loginPage');
});

Route::prefix('clients')->middleware('auth')->group(function () {
  Route::get('/', [Show::class, 'showClientsPage'])->name('showClientsPage');

  /**
   * Cliente Routes Actions
   */
  Route::get('add', [Add::class, 'addClientsPage'])->name('addClientsPage');
  Route::get('edit/{id}', [Edit::class, 'editClientsPage'])->name('editClientsPage');
});
