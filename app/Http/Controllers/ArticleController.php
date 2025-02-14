<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

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
}
