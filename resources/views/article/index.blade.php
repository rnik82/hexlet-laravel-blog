@extends('layouts.app')

@section('content')
    @if(session('success'))
        <ul class="alert alert-success">
            <li> {{ session('success') }} </li>
        </ul>
    @endif
    <small><a href="{{ route('articles.create') }}">Добавить новую статью</a></small>
    <h1>Список статей</h1>
    @foreach ($articles as $article)
        <h2>
            <a href="{{ route('articles.show', $article->id) }}">{{ $article->name }}</a>
            <a href="{{ route('articles.edit', $article->id) }}">Редактировать</a>
            {{-- <a href="{{ route('articles.destroy', $article) }}"
               data-confirm="Вы уверены?"
               data-method="delete" class="fa fa-remove"
               rel="nofollow">Удалить
            </a> --}}
            {{ html()->modelForm($article, 'DELETE', route('articles.destroy', $article))->open() }}
                {{ html()->submit('Delete')->class('btn btn-primary') }}
            {{ html()->closeModelForm() }}
        </h2>
        {{-- Str::limit – функция-хелпер, которая обрезает текст до указанной длины --}}
        {{-- Используется для очень длинных текстов, которые нужно сократить --}}
        <div>{{Str::limit($article->body, 200)}}</div>
    @endforeach
@endsection
