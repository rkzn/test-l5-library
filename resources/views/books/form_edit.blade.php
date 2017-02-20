@extends('books.main')

@section('books.content')
    <h1>Edit book</h1>
    <hr>
    {!! Form::model($book, ['method' => 'PATCH', 'route' => ['books.update', $book->id], 'class' => 'form-horizontal']) !!}
    @include ('books.form', ['submitButtonText' => 'Save book'])
    {!! Form::close() !!}
@endsection

@section('books.sidebar')
    <h1>Authors</h1>
    <hr>
    <div class="wrap_book_authors">
    @include ('books.form_authors', ['book' => $book, 'authors' => $authors])
    </div>
@endsection
