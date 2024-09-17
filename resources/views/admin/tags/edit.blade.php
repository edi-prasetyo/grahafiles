@extends('layouts.app')


@section('content')
    <div class="container">

        @can('category-create')
            <div class="card mb-3">
                <div class="card-body">
                    <form action="{{ url('tags/update', $tag->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label"> Name </label>
                            <input type="text" name="name" value="{{ $tag->name }}"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Nama Category">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary my-3">Submit</button>
                    </form>
                </div>
            </div>
        @endcan

    </div>
@endsection
