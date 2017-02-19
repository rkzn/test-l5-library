@extends('books.main')

@section('books.content')
    <h1>ISBN - {{ $book->isbn }}</h1>
    <hr>
    <div class="row">

        <div class="col-md-7">

            <h4>{{ $book->title }}</h4>

            <dl class="dl-horizontal">
                <dt>ISBN</dt>
                <dd>{!! $book->isbn !!}</dd>

                <dt>Year</dt>
                <dd>{!! $book->pub_year !!}</dd>

                <dt>Publisher</dt>
                <dd>{!! $book->publisher !!}</dd>

                <dt>Authors</dt>
                <dd>
                    <ul class="list-inline">
                        @foreach ($book->authors as $author)
                            <li>
                                {{ link_to_route('books.author', $author->name, $author->id) }}
                                <span class="label label-default">{{ $author->books->count() }}</span>
                            </li>
                        @endforeach
                    </ul>

                </dd>

            </dl>

        </div>
        <div class="col-md-5">
            <img src="{!! $book->image_url_large !!}" class="thumbnail pull-right" width="100%">
        </div>
    </div>


@endsection

@section('books.sidebar')
    <h1>Control</h1>
    <hr>
    {{ Form::open(['method' => 'DELETE', 'route' => ['books.destroy', $book->id]]) }}
    {{ link_to_route('books.edit', 'Edit', $book->id, ['class' => 'btn btn-primary btn-small']) }}
    <button type="submit" class="btn btn-danger btn-small">Remove</button>
    {{ Form::close() }}
@endsection
