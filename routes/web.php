<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ArticleController;

/** php artisan serve */

Route::get('/', function () {
    return view('welcome');
    //return 'hello, world!';
});

Route::get('about', [PageController::class, 'about'])
    ->name('about'); ;

// Название сущности в URL во множественном числе, контроллер в единственном
Route::get('articles', [ArticleController::class, 'index'])
    ->name('articles.index'); // имя маршрута, нужно для того, чтобы не создавать ссылки руками

// Маршрут для отображения формы. Важно добавить этот маршрут до маршрута articles/{id}.
//// Иначе последний перехватит обращение к articles/create, так как он соответствует шаблону.
Route::get('articles/create', [ArticleController::class, 'create'])
    ->name('articles.create');

Route::get('articles/{id}', [ArticleController::class, 'show'])
    ->name('articles.show');

// Маршрут для обработки и сохранения формы.
Route::post('articles', [ArticleController::class, 'store'])
    ->name('articles.store');

// Маршрут для отображения формы редактирования
Route::get('articles/{id}/edit', [ArticleController::class, 'edit'])
    ->name('articles.edit');

// Маршрут для сохранения изменений после редактирования
Route::patch('articles/{id}', [ArticleController::class, 'update'])
    ->name('articles.update');

// Маршрут для удаления статьи
Route::delete('articles/{id}', [ArticleController::class, 'destroy'])
    ->name('articles.destroy');
