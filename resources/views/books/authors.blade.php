@extends('books.main')

@section('books.content')
    <h1>Authors</h1>
    @foreach ($authors as $author)
        <h3>{{ link_to_route('books.author', $author->name, $author->id) }}</h3>
    @endforeach

    <!-- pagination -->
    {{ $authors->render() }}
@endsection

@section('books.sidebar')

@endsection
