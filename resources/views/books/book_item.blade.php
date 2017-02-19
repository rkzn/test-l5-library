<div class="media">
    <div class="media-left">
        <a href="{{ route('books.show', $book->id) }}">
            <img alt="64x64" class="media-object" data-src="{{ $book->image_url_small }}" style="width: 64px; height: 64px;" src="{{ $book->image_url_small }}" data-holder-rendered="true">
        </a>
    </div>
    <div class="media-body">
        <h4 class="media-heading">{{ link_to_route('books.show', $book->title, $book->id) }}</h4>
        ISBN: <strong>{{ $book->isbn }}</strong>, Publisher: <strong>{{ $book->publisher }}</strong>
    </div>
</div>
