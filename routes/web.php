<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\StaticController;
// use \App\Http\Controllers\StaticController as StaticC;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('/static', [StaticController::class, 'index'])
    ->name('static');

Route::resource('/articles', ArticleController::class);

Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::group(['middleware' => ['role:admin|staff|client']], function () {
        Route::get('/client', [ClientController::class, 'index'])
            ->name('client');
    });

    Route::group(['middleware' => ['role:admin|staff']], function () {
        Route::get('/admin', [AdminController::class, 'index'])
            ->name('admin');
    });
});

require __DIR__.'/settings.php';
