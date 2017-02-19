@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="title m-b-md">
            Library
        </div>

        <div class="links">
            {{ link_to_route('books.index', 'Books') }}
            {{ link_to_route('books.authors', 'Authors') }}
        </div>
    </div>
@endsection
