<div class="jumbotron loading">
    <h2>Loading...</h2>
</div>
{{ Form::open(['method' => 'POST', 'route' => ['books.attach_authors', $book->id]]) }}
<?php
$book_authors = $book->authors->pluck('id')->toArray();
?>
{{ Form::hidden('exclude', implode(',', $authors->pluck('id')->toArray())) }}
<!-- Create checkbox for each gallery -->
<ul class="nav nav-stacked nav_authors">
@foreach($authors as $author)
<li><a href="#">
    {{ Form::checkbox('authors[]', $author->id, in_array($author->id, $book_authors), ['id' => $author->id]) }}
    {{ Form::label($author->id, $author->name) }}
    </a>
</li>
@endforeach
</ul>

<!-- pagination -->
{{ $authors->links('books.form_author_paginate') }}

{{ Form::close() }}
