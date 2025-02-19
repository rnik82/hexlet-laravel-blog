<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Передаем в шаблон вновь созданный объект. Он нужен для вывода формы
        $article = new Article();
        return view('article.create', compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article = Article::findOrFail($article->id);
        return view('article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $article = Article::findOrFail($article->id);
        return view('article.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, Article $article)
    {
        $article = Article::findOrFail($article->id);
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        // DELETE — идемпотентный метод, поэтому результат операции всегда один и тот же
        $article = Article::find($article->id);
        if ($article) {
            $article->delete();
        }
        //$request->session()->flash('success', 'The article was successfully deleted!');
        return redirect()->route('articles.index')
            ->with('success', 'The article was successfully deleted!');
    }
}
