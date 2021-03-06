<div class="form-group{{ $errors->has('isbn') ? ' has-error' : '' }}">
    {!! Form::label('isbn', 'ISBN:', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
    {!! Form::text('isbn', null, ['class' => 'form-control']) !!}
        <span class="help-block">
        @if ($errors->has('isbn'))
            <strong>{{ $errors->first('isbn') }}</strong>
            @else
            <small>ex. {{ \Illuminate\Support\Str::random(13) }}</small>
        @endif
         </span>
    </div>
</div>
<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
    {!! Form::label('title', 'Title:', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
        @if ($errors->has('title'))
            <span class="help-block">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class="form-group{{ $errors->has('publisher') ? ' has-error' : '' }}">
    {!! Form::label('publisher', 'Publisher:', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
    {!! Form::text('publisher', null, ['class' => 'form-control']) !!}
        @if ($errors->has('publisher'))
            <span class="help-block">
                <strong>{{ $errors->first('publisher') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class="form-group{{ $errors->has('pub_year') ? ' has-error' : '' }}">
    {!! Form::label('pub_year', 'Year of Publication:', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
    {!! Form::selectRange('pub_year', 1900, date('Y'), null, ['class' => 'form-control']) !!}
        @if ($errors->has('pub_year'))
            <span class="help-block">
                <strong>{{ $errors->first('pub_year') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('image_url_small') ? ' has-error' : '' }}">
    {!! Form::label('image_url_small', 'Image URL (small):', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
    {!! Form::text('image_url_small', null, ['class' => 'form-control']) !!}
        <span class="help-block">
               <small>ex. http://lorempixel.com/60/80/nature/</small>
        </span>
    </div>
</div>

<div class="form-group{{ $errors->has('image_url_medium') ? ' has-error' : '' }}">
    {!! Form::label('image_url_medium', 'Image URL (medium):', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
    {!! Form::text('image_url_medium', null, ['class' => 'form-control']) !!}
        <span class="help-block">
               <small>ex. http://lorempixel.com/240/320/nature/</small>
        </span>
    </div>
</div>

<div class="form-group{{ $errors->has('image_url_large') ? ' has-error' : '' }}">
    {!! Form::label('image_url_large', 'Image URL (large):', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
    {!! Form::text('image_url_large', null, ['class' => 'form-control']) !!}
        <span class="help-block">
               <small>ex. http://lorempixel.com/480/640/nature/</small>
        </span>
    </div>

</div>
<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
