<?php

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    // Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/send-message', [App\Http\Controllers\HomeController::class, 'sendMessage'])->name('send-message');

    Route::get('profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile.index');
    Route::put('profile/{id}', [App\Http\Controllers\HomeController::class, 'profileUpdate'])->name('profile.update');

    Route::resource('document', 'App\Http\Controllers\DokumenController');
    Route::post('document/delete', 'App\Http\Controllers\DokumenController@delete')->name('document.delete');

    Route::resource('users', 'App\Http\Controllers\UsersController');
    Route::post('users/delete', 'App\Http\Controllers\UsersController@delete')->name('users.delete');

    Route::get('/chat/history/{tanggal}', [App\Http\Controllers\HomeController::class, 'getChatByDate'])->name('chat.history');

});