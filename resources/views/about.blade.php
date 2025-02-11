<!-- Шаблоны хранятся в resources/views/about.blade.php -->

@extends('layouts.app')

<!-- Секция, содержимое которой обычный текст. -->
@section('title', 'О блоге')

<!-- Это я добавил от себя в качестве эксперимента -->
@section('header', 'ЭТО HEADER')

<!-- Секция, содержащая HTML блок. Имеет открывающую и закрывающую часть. -->
@section('content')
    <h1>О блоге</h1>
    <p>Эксперименты с Laravel на Хекслете</p>
@endsection
