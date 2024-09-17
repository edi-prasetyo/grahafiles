@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h2> Show Product</h2>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $post->title }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Details:</strong>

            </div>
        </div>
    </div>
@endsection
