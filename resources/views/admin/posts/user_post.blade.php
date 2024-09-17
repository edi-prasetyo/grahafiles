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

                <h4> Post</h4>
                @can('post-create')
                    <a class="btn btn-success" href="{{ url('posts/create') }}"> Create New Post</a>
                @endcan


            </div>
            <table class="table table-striped">
                <tr>

                    <th>Title</th>

                    <th>Tags</th>
                    <th width="20%">Action</th>
                </tr>
                @foreach ($user_posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>
                            @foreach ($post->tag as $singleTag)
                                <span class="badge rounded-pill text-bg-info">{{ $singleTag->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <form action="{{ url('posts/delete', $post->id) }}" method="POST">
                                <a class="btn btn-info btn-sm" href="{{ url('detail', $post->slug) }}">View</a>
                                @can('post-edit')
                                    <a class="btn btn-primary btn-sm" href="{{ url('posts/edit', $post->id) }}">Edit</a>
                                @endcan
                                @csrf
                                @method('DELETE')
                                @can('post-delete')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                @endcan
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="card-footer">
                {{ $user_posts->links() }}
            </div>
        </div>
    </div>
@endsection
