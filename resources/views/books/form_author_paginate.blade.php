@if ($paginator->hasPages())
    <div class="btn-group btn-group-justified pagination" role="group" aria-label="...">

        {{-- Previous Page Link --}}
        <div class="btn-group" role="group">
        @if ($paginator->onFirstPage())
                <span class="btn btn-default disabled">&laquo;</span>
        @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="btn btn-default">&laquo;</a>
        @endif
        </div>


        <div class="btn-group" role="group">
            {{ Form::submit('Apply Authors', ['class' => 'btn btn-primary']) }}
        </div>

        <div class="btn-group" role="group">
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="btn btn-default">&raquo;</a>
        @else
                <span class="btn btn-default disabled">&raquo;</span>
        @endif
        </div>
    </div>
@endif
