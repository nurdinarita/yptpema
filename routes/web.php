<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BlogController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('admin/dashboard', [DashboardController::class, 'index']);

Route::resource('admin/blog', BlogController::class)->middleware('auth');
