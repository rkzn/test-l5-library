@extends('books.main')

@section('books.content')
    <h1>Add book</h1>
    <hr>
    {!! Form::open(['route' => 'books.store', 'class' => 'form-horizontal']) !!}
    @include ('books.form', ['submitButtonText' => 'Add book'])
    {!! Form::close() !!}
@endsection
