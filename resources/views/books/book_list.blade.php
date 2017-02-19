@extends('books.main')

@section('books.content')
    <h1>Books</h1>
    <hr>
    @foreach ($books as $book)
        @include ('books.book_item', ['book' => $book])
        <hr>
    @endforeach
    <!-- pagination -->
    {{ $books->render() }}
@endsection

@section('books.sidebar')
    <h1>Rating</h1>
    <hr>
    <p>soon</p>
@endsection
