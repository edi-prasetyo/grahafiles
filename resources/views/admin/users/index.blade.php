@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb mb-4">
                <div class="pull-left">
                    <h2>Users Management
                        <div class="float-end">

                        </div>
                    </h2>
                </div>
            </div>
        </div>


        @if ($message = Session::get('success'))
            <div class="alert alert-success my-2">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4> Users management</h4>
                {{-- <a class="btn btn-success" href="{{ url('users/create') }}"> Create New User</a> --}}
            </div>
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Status</th>
                    <th width="20%">Action</th>
                </tr>
                @foreach ($data as $key => $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if (!empty($user->getRoleNames()))
                                @foreach ($user->getRoleNames() as $v)
                                    <label class="badge badge-secondary text-dark">{{ $v }}</label>
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if ($user->status == 0)
                                <span class="badge rounded-pill text-bg-danger">Banned</span>
                            @else
                                <span class="badge rounded-pill text-bg-success">Active</span>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-info btn-sm" href="{{ url('users/show', $user->id) }}">Show</a>
                            <a class="btn btn-primary btn-sm" href="{{ url('users/edit', $user->id) }}">Edit</a>
                            @if ($user->status == 1)
                                <a class="btn btn-danger btn-sm" href="{{ url('users/banned', $user->id) }}"> Banned</a>
                            @else
                                <a class="btn btn-success btn-sm" href="{{ url('users/activated', $user->id) }}">
                                    Activated</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
