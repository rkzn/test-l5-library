@extends('books.main')

@section('books.content')
    {!! Form::model($book, ['method' => 'PATCH', 'route' => ['books.update', $book->id], 'class' => 'form-horizontal']) !!}
    @include ('books.form', ['submitButtonText' => 'Save book'])
    {!! Form::close() !!}
@endsection
