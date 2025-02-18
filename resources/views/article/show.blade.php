@extends('layouts.app')

@section('content')
    <a href="{{ route('articles.index') }}">Список статей</a>
    <h1>{{$article->name}}</h1>
    <div>{{$article->body}}</div>
@endsection
