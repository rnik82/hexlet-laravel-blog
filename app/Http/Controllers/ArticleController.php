<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Requests\StorePostRequest;

class ArticleController extends Controller
{
    public function index()
    {
        // Извлекаем статьи с учетом запрошенной страницы. Laravel автоматически определяет
        // наличие параметра page в запросе и выполняет правильное смещение в SQL.
        // Количество элементов, которые выводятся на странице равно пятнадцати.
        // Это число можно изменить, передав нужное значение в метод paginate($perPage)
        $articles = Article::paginate();

        // Статьи передаются в шаблон
        // compact('articles') => [ 'articles' => $articles ]
        return view('article.index', compact('articles'));
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('article.show', compact('article'));
    }

    // Вывод формы
    public function create()
    {
        // Передаем в шаблон вновь созданный объект. Он нужен для вывода формы
        $article = new Article();
        return view('article.create', compact('article'));
    }

    // Здесь нам понадобится объект запроса для извлечения данных
    public function store(StorePostRequest $request)
    {
        // Проверка введенных данных
        // Если будут ошибки, то возникнет исключение
        // Иначе возвращаются данные формы
//        $data = $request->validate([
//            'name' => 'required|unique:articles',
//            'body' => 'required|min:100',
//        ]);

        $article = new Article();
        // Заполнение статьи данными из формы
        $article->fill($request->all()); // fill($data)
        // При ошибках сохранения возникнет исключение
        $article->save();
        // Добавляем флеш сообщение
        $request->session()->flash('success', 'The article was successfully added!');

        // Редирект на указанный маршрут
        return redirect()
            ->route('articles.index');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('article.edit', compact('article'));
    }

    public function update(StorePostRequest $request, $id)
    {
        $article = Article::findOrFail($id);
        //$data = $request->validate([
            // У обновления немного измененная валидация
            // В проверку уникальности добавляется название поля и id текущего объекта
            // Если этого не сделать, Laravel будет ругаться, что имя уже существует
            //'name' => "required|unique:articles,name,{$article->id}",
            //'body' => 'required|min:100',
        //]);
        $article->fill($request->all());
        $article->save();
        $request->session()->flash('success', 'The article was successfully updated!');
        return redirect()
            ->route('articles.index');
    }
}
