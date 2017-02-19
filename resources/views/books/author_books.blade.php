@extends('books.main')

@section('books.content')
    <h1>{{ $author->name }}'s books</h1>
    <hr>
    @foreach ($books as $book)
        @include ('books.book_item', ['book' => $book])
        <hr>
    @endforeach
    <!-- pagination -->
    {{ $books->render() }}
@endsection

@section('books.sidebar')

@endsection
