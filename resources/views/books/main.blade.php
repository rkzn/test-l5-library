@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                        {{ Session::get('flash_message') }}
                    </div>
                @endif
                @yield('books.content')
            </div>
            <div class="col-md-4">
                @yield('books.sidebar')
            </div>
        </div>
    </div>
@endsection
