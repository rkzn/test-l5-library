@extends('books.main')

@section('books.content')
    <article>
        <h1>{{ $book->title }}</h1>
        <div>ISBN: {!! $book->ISBN !!}</div>
        <div>SUB: {!! $book->subtitle !!}</div>
    </article>

@endsection

@section('books.sidebar')
    <p>{{ link_to_route('books.index', 'All books') }}</p>
@endsection
