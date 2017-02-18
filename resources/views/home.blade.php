@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="title m-b-md">
            Books
        </div>

        <div class="links">
            {{ link_to_route('books.index', 'Books') }}
            {{ link_to_route('books.create', 'Add book') }}
        </div>
    </div>
@endsection
