<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# php-laravel-blog

Приложение работает похожим образом с https://php-laravel-blog.hexlet.app/.
Это учебный проект, поэтому по сравнению в демо-проектом выше он оформлен более просто.
При создании упор был сделан на бэкенд части.
Ниже приведены основные этапы создания и тонкости организации кода.
Лучше сразу прочитать про Ресурсную маршрутизацию (см внизу страницы).
Она позволяет указать один метамаршрут (вместо 7) и упростить создание CRUD.

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
```php
$articles = Article::where('state', 'published')->orderBy('likes_count', 'desc')->get();
$articles = Article::where('name', 'ilike', "%{$q}%")->get() или Article::where('name', 'ilike', "%{$q}%")->paginate()
$articles = Article::all() или Article::paginate()
```

Ссылка:
```php
<a href="{{ route('article_categories.index') }}">Категории статей</a>
```

Как работает compact():
```php
$category = ...;
$articles = ...;
compact('category', 'articles'); // -> ['category' => $category, 'articles' => $articles]
```

Достаем то что ищется:
```php
$q = $request->input('q', '');
```

Поисковая форма (q - то что нужно найти в поисковике):
```php
{{  html()->form('GET', route('articles.index'))->open() }}
    {{  html()->input('text', 'q', $q) }}
    {{  html()->submit('Search') }}
{{ html()->form()->close() }}
```

Вот так в обработчике store делается валидация и сохранение:
```php
public function store(Request $request)
{
    // Проверка введенных данных
    // Если будут ошибки, то возникнет исключение
    // Иначе возвращаются данные формы
    $data = $request->validate([
        'name' => 'required|max:100',
        'description' => 'required|min:200',
        'state' => 'in:draft,published'
    ]);
    
    $category = new ArticleCategory();
    // Данные обновляются в объекте статьи с помощью метода fill 
    $category->fill($data);
    // При ошибках сохранения возникнет исключение
    $category->save();
    // Добавляем флеш сообщение, если нужно
    $request->session()->flash('success', 'The article was successfully added!');

    // Редирект на указанный маршрут
    return redirect()
        ->route('articles.index');
    }
```
либо
```php
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:article_categories|max:100',
        'description' => 'required|min:200',
        'state' => [
            Rule::in(['draft', 'published']),
        ]
    ]);

    $category = new ArticleCategory();
    // Данные обновляются в объекте статьи с помощью метода fill
    $category->fill($request->all());
    $category->save();

    return redirect()
        ->route('article_categories.index');
}
```

Валидации в store и update повторяются практически один в один.
Для того, чтобы избежать дублирования можно использовать [Form Request Validation](https://laravel.com/docs/11.x/validation#form-request-validation):
```bash
php artisan make:request StoreArticleRequest
```
```php
class StoreArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => "required|unique:articles,name,{$this->id}",
            'body' => 'required|min:100',
        ];
    }
}
```

### Избежать ручного создания формы удаления (как и реализовано в данном проекте) можно с помощью библиотеки jquery-ujs.
### Она опирается на data-атрибуты и сама превращает в форму все что ее попросят.
Для ее установки нужно установить Node.js.
Установка Node.js на Ubuntu через командную строку:
```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash - &&\
sudo apt-get install -y nodejs
```
Установка npm, установка зависимости jquery-ujs, установка остальных пакетов:
```bash
sudo apt install npm
npm install @rails/ujs
npm install
```
Затем добавьте в конец файла resources/js/app.js строчки:
```JavaScript
import ujs from '@rails/ujs';
ujs.start();
```
Затем нужно запустить сборку фронтенда:
```bash
npm run dev
```

## [Resource Controllers](https://laravel.com/docs/11.x/controllers#resource-controllers) - Ресурсная маршрутизация
Она упрощает создание типичных CRUD, за счет полной унификации всех маршрутов и способов их обработки.
Вместо описания 7 разных маршрутов, ресурсная маршрутизация позволяет указать один метамаршрут:
```php
<?php
Route::resource('articles', ArticleController::class);
```
Внутри себя он превращается в те самые семь маршрутов CRUD. Их можно увидеть с помощью команды artisan:
```bash
php artisan route:list

+-----------+-------------------------+------------------+---------+
| Method    | URI                     | Name             | Action  |
+-----------+-------------------------+------------------+---------+
| GET|HEAD  | /                       |                  | Closure |
| GET|HEAD  | articles                | articles.index   | index   |
| POST      | articles                | articles.store   | store   |
| GET|HEAD  | articles/create         | articles.create  | create  |
| GET|HEAD  | articles/{article}      | articles.show    | show    |
| PUT|PATCH | articles/{article}      | articles.update  | update  |
| DELETE    | articles/{article}      | articles.destroy | destroy |
| GET|HEAD  | articles/{article}/edit | articles.edit    | edit    |
+-----------+-------------------------+------------------+---------+
# Имя плейсхолдера article, а не id
```
Следующий шаг – упрощение контроллера. Первое - можно сразу сгенерировать контроллер, со всеми нужными обработчиками.
Второе - этот контроллер можно интегрировать с нужной моделью:
```bash
php artisan make:controller ArticleController --resource --model Article
```
При необходимости можно вот так сгенерировать вложенный ресурс автоматически:
```bash
php artisan make:controller ArticleCommentController --resource --model ArticleComment --parent Article
```
1. php artisan make:controller - команда для создания контроллера
2. ArticleCommentController - название контроллера, который будет создан
3. --resource - опция указывает, что контроллер будет ресурсным, что автоматически добавит методы для работы с ресурсами (CRUD операции)
4. --model ArticleComment - опция указывает, что контроллер будет связан с моделью ArticleComment
5. --parent Article - опция указывает, что модель ArticleComment будет иметь родительскую модель Article

Например, вот так выглядит ресурс комментарии к статьям:
```php
Route::resource('articles.comments', ArticleCommentController::class);
```
Для вложенного ресурса, в экшены, кроме самой сущности передается и родительская сущность:
```php
# /articles/{article}/comments/{comment}
# Обе сущности можно получить через параметры
public function edit(Article $article, ArticleComment $comment)
{
    return view('article_comment.edit', compact('article', 'comment'));
}
```
Если ресурс называется articles.comments, то параметр следует назвать $comment, а не $articleComment. 
Другими словами, имя параметра выбирается в единственном числе по имени ресурса.

Немного по-другому начинает работать хелпер route. Для построения ссылок, там где участвуют оба ресурса, нужно использовать массив для их передачи:
```php
route('articles.comments.edit', [$article, $comment]);
```
