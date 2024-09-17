@extends('layouts.app')


@section('content')
    <div class="container">



        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-start">

                <h4> Banners</h4>
                @can('banner-create')
                    <a class="btn btn-success" href="{{ url('banners/create') }}"> Create New Banner</a>
                @endcan


            </div>
            <table class="table table-striped">
                <tr>

                    <th width="3%">Icon</th>
                    <th>Name</th>
                    <th width="20%">Action</th>
                </tr>
                @foreach ($banners as $data)
                    <tr>
                        <td><img src="{{ $data->icon_url }}" class="img-fluid"> </td>
                        <td>{{ $data->name }}</td>

                        <td>
                            <form action="{{ url('banner/delete', $data->id) }}" method="POST">
                                <a class="btn btn-info btn-sm" href="{{ url('page', $data->slug) }}">View</a>
                                @can('banner-edit')
                                    <a class="btn btn-primary btn-sm" href="{{ url('banners/edit', $data->id) }}">Edit</a>
                                @endcan
                                @csrf
                                @method('DELETE')
                                @can('banner-delete')
                                    <button type="submit" data-confirm-delete="true"
                                        class="btn btn-danger btn-sm">Delete</button>
                                @endcan
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>

        </div>
    </div>
@endsection
