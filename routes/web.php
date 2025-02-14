<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ArticleController;

/** php artisan serve */

Route::get('/', function () {
    return view('welcome');
    //return 'hello, world!';
});

Route::get('about', [PageController::class, 'about']);

// Название сущности в URL во множественном числе, контроллер в единственном
Route::get('articles', [ArticleController::class, 'index'])
    ->name('articles.index'); // имя маршрута, нужно для того, чтобы не создавать ссылки руками

Route::get('articles/{id}', [ArticleController::class, 'show'])
    ->name('articles.show');


