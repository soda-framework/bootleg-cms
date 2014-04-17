@extends('cms::layouts.scaffold')

@section('main')
<div class="col-md-2 fullheight">
@include('cms::contents.tree', array('content'=>@$content, 'tree'=>@$tree))
</div>
<div class="col-md-8 fullheight">
    @section('content')
            @include('cms::contents.form', array('content'=>@$content))
            @include('cms::contents.permission', array('content'=>@$content))

    @show
</div>
@stop