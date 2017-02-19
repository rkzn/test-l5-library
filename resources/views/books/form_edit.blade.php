@extends('books.main')

@section('books.content')
    <h1>Edit book</h1>
    <hr>
    {!! Form::model($book, ['method' => 'PATCH', 'route' => ['books.update', $book->id], 'class' => 'form-horizontal']) !!}
    @include ('books.form', ['submitButtonText' => 'Save book'])
    {!! Form::close() !!}
@endsection

@section('books.sidebar')
    <h1>Control</h1>
    <hr>
    {{ Form::open(['method' => 'DELETE', 'route' => ['books.destroy', $book->id]]) }}
    <button type="submit" class="btn btn-danger btn-small">Remove</button>
    {{ Form::close() }}
@endsection
