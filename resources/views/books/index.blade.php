@extends('books.main')

@section('books.content')
    <h1>Books {{ link_to_route('books.create', 'Add book', [], ['class' => 'btn btn-primary pull-right']) }}</h1>
    @foreach ($books as $book)
        <article>
            <h3>{{ link_to_route('books.show', $book->title, $book->id) }}</h3>
            <div>
                {{ link_to_route('books.edit', 'Edit', $book->id) }}
                {{ Form::open(['method' => 'DELETE', 'route' => ['books.destroy', $book->id]]) }}
                <button type="submit">Remove</button>
                {{ Form::close() }}
            </div>
            {{ $book->subtitle }}
        </article>
        <hr>
    @endforeach

    <!-- pagination -->
    {{ $books->render() }}
@endsection

@section('books.sidebar')

@endsection
