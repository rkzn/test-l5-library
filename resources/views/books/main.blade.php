@extends('layouts.app')

@section('content')
    @if (count($errors) > 0)
        <div class="container">
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        </div>
    @endif
    @if(Session::has('flash_message'))
        <div class="container">
        <div class="alert alert-success">
            {{ Session::get('flash_message') }}
        </div>
        </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @yield('books.content')
            </div>
            <div class="col-md-4">
                @yield('books.sidebar')
            </div>
        </div>
    </div>
@endsection
