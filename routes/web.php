<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

/** php artisan serve */

Route::get('/', function () {
    return view('welcome');
});

Route::get('about', [PageController::class, 'about']);


