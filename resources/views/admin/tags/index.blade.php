@extends('layouts.app')


@section('content')
    <div class="container">

        {{-- Default --}}
        <div class="row">
            <div class="col-lg-12 margin-tb mb-4">
                <div class="pull-left">
                    <h2>Tags
                    </h2>
                </div>
            </div>
        </div>

        {{-- @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif --}}

        @can('tag-create')
            <div class="card mb-3">
                <div class="card-body">
                    <form action="{{ url('tags/store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label"> Name </label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Nama Tag">
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

        <div class="card">
            <table class="table table-striped ">
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th width="15%">Action</th>
                </tr>
                @foreach ($tags as $key => $data)
                    <tr>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->slug }}</td>
                        <td>
                            <form action="{{ url('tags/delete', $data->id) }}" method="POST">
                                @can('tag-edit')
                                    <a class="btn btn-primary btn-sm" href="{{ url('tags/edit', $data->id) }}">Edit</a>
                                @endcan
                                @csrf
                                @method('DELETE')
                                @can('tag-delete')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                @endcan
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        {!! $tags->render() !!}

    </div>
@endsection
