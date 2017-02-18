@extends('books.main')

@section('books.content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::open(['route' => 'books.store', 'class' => 'form-horizontal']) !!}
    @include ('books.form', ['submitButtonText' => 'Add book'])
    {!! Form::close() !!}
@endsection
