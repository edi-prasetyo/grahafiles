@extends('layouts.app')


@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Edit Role
                        <div class="float-end">
                            <a class="btn btn-primary" href="{{ url('roles/index') }}"> Back</a>
                        </div>
                    </h2>
                </div>
            </div>
        </div>


        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('roles/update', $role->id) }}" method="POST">
            @csrf



            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" name="name" value="{{ $role->name }}" class="form-control"
                            placeholder="Name" readonly>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Permission:</strong>
                        <div class="row mt-3">

                            @foreach ($permissions as $key => $group)
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-header"><b>{{ ucfirst($key) }}</b></div>
                                        <div class="card-body">
                                            @forelse($group as $permission)
                                                <label style="width: 30%" class="">
                                                    <input
                                                        {{ $role->permissions->contains('id', $permission->id) ? 'checked' : '' }}
                                                        name="permissions[]" class="permissioncheckbox"
                                                        class="rounded-md border" type="checkbox"
                                                        value="{{ $permission->name }}">
                                                    {{ $permission->name }} &nbsp;&nbsp;
                                                </label>

                                            @empty
                                                {{ __('No permission in this group !') }}
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>




























            {{-- <div class="row">
                <div class="col-xs-12 mb-3">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" value="{{ $role->name }}" name="name" class="form-control"
                            placeholder="Name">
                    </div>
                </div>
                <div class="col-xs-12 mb-3">
                    <div class="form-group">
                        <strong>Permission:</strong>
                        <br />
                        @foreach ($permission as $value)
                            <label>
                                <input type="checkbox" @if (in_array($value->id, $rolePermissions)) checked @endif name="permission[]"
                                    value="{{ $value->name }}" class="name">
                                {{ $value->name }}</label> {{ $value->id }}
                            <br />
                        @endforeach
                    </div>
                </div>
                <div class="col-xs-12 mb-3 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div> --}}
        </form>
    </div>

@endsection
