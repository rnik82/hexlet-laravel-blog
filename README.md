<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.


## Создание проекта на Laravel из командной строки
Проекты на Laravel создаются из командной строки. Проще всего создать новый проект с помощью команды composer create-project.
Для этого нужно перейти в домашнюю директорию и выполните команду
```bash
composer create-project --prefer-dist laravel/laravel <dir_name> // напр. - hexlet-laravel-blog
```
Создастся приложение в директории hexlet-laravel-blog и установятся все зависимости, необходимые для работы Laravel

## Как запустить сайт в режиме разработки:
```bash
$ php artisan serve
Laravel development server started: <http://127.0.0.1:8000>
```
Эта команда запускает встроенный в PHP веб-сервер и настраивает его для работы с Laravel по указанному адресу

## Как создать Модель через утилиту artisan:
```bash
$ php artisan make:model <Model_name> --migration // Model_name - напр. Article

Model created successfully.
Created Migration: 2020_03_21_220908_create_articles_table
```
Этот вызов создаст два файла:
- миграцию в директории database/migrations
- класс (модель) с именем Article в директории app/Models

Затем нужно накатить миграции:
```bash
$ php artisan migrate
```
Если нужно откатить (отменить последнюю миграцию):
```bash
$ php artisan migrate:rollback
```

## Контроллеры, так же как и модели, можно генерировать через artisan:
```bash
$ php artisan make:controller PageController // или любое нужное имя

Controller created successfully.
```

## Как посмотреть поля таблицы через tinker (командную строку):
```bash
$ php artisan tinker
Psy Shell v0.12.7 (PHP 8.3.11 — cli) by Justin Hileman
>>> DB::getSchemaBuilder()->getColumnListing('имя таблицы')  // напр. article_categories
= [
"id",
"name",
"description",
"state",
"created_at",
"updated_at",
:
```

## Или вот так:
Зайти в REPL, извлечь первую сущность нужной модели и распечатать ее
```bash
$ php artisan tinker
>>> $u = \App\Models\User::first() // вместо User — ArticleCategory в нашем случае
>>> $u->toArray()

string(29) "select * from "users" limit 1"
=> [
"id" => 1,
"email" => "streich.viva@example.net",
"first_name" => "Tatum",
"last_name" => "Hudson",
"password" => "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi",
"created_at" => "2020-03-21 19:31:38",
"updated_at" => "2020-03-21 19:31:38",
]
```


### Заметки

Выборка из БД:
$articles = Article::where('state', 'published')->orderBy('likes_count', 'desc')->get();
$articles = Article::where('name', 'ilike', "%{$q}%")->get() или Article::where('name', 'ilike', "%{$q}%")->paginate()
$articles = Article::all() или Article::paginate()

Ссылка:
<a href="{{ route('article_categories.index') }}">Категории статей</a>

Как работает compact():
$category = ...;
$articles = ...;
compact('category', 'articles'); // -> ['category' => $category, 'articles' => $articles]

Достаем то что ищется:
$q = $request->input('q', '');

Поисковая форма (q - то что нужно найти в поисковике):
{{  html()->form('GET', route('articles.index'))->open() }}
    {{  html()->input('text', 'q', $q) }}
    {{  html()->submit('Search') }}
{{ html()->form()->close() }}
