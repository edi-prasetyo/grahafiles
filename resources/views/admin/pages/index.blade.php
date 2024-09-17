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

                <h4> Pages</h4>
                @can('post-create')
                    <a class="btn btn-success" href="{{ url('pages/create') }}"> Create New Page</a>
                @endcan


            </div>
            <table class="table table-striped">
                <tr>

                    <th>Title</th>
                    <th width="20%">Action</th>
                </tr>
                @foreach ($pages as $page)
                    <tr>
                        <td>{{ $page->title }}</td>

                        <td>
                            <form action="{{ url('pages/delete', $page->id) }}" method="POST">
                                <a class="btn btn-info btn-sm" href="{{ url('page', $page->slug) }}">View</a>
                                @can('page-edit')
                                    <a class="btn btn-primary btn-sm" href="{{ url('pages/edit', $page->id) }}">Edit</a>
                                @endcan
                                @csrf
                                @method('DELETE')
                                @can('page-delete')
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
