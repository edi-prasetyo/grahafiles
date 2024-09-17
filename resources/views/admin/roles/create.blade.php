@extends('layouts.app')


@section('content')
    <div class="container">

        {{-- <div class="ml-4 mt-16">
            <form action="{{ url('roles/store') }}" method="POST">
                @csrf

                <h1 class="text-3xl mt-4 mb-8"> Create Role </h1>

                <div class="mb-6">
                    <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role
                        Name</label>
                    <input type="text" value="{{ old('name') }}" name="name" id="email"
                        class="bg-gray-50 w-80 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 "
                        placeholder="User, Editor, Author ... ">

                    @foreach ($errors->get('name') as $error)
                        <p class="text-red-600">{{ $error }}</p>
                    @endforeach
                </div>

                <table class="permissionTable border rounded-md bg-white overflow-hidden shadow-lg my-4 p-4">
                    <th class="px-4 py-4">
                        {{ __('Section') }}
                    </th>

                    <th class="px-4 py-4">
                        <label>
                            <input class="grand_selectall" type="checkbox">
                            {{ __('Select All') }}
                        </label>
                    </th>

                    <th class="px-4 py-4">
                        {{ __('Available permissions') }}
                    </th>



                    <tbody>
                        @foreach ($permissions as $key => $group)
                            <tr class="py-8">
                                <td class="p-6">
                                    <b>{{ ucfirst($key) }}</b>
                                </td>
                                <td class="p-6" width="30%">
                                    <label>
                                        <input class="selectall" type="checkbox">
                                        {{ __('Select All') }}
                                    </label>
                                </td>
                                <td class="p-6">

                                    @forelse($group as $permission)
                                        <label style="width: 30%" class="">
                                            <input name="permissions[]" class="permissioncheckbox" class="rounded-md border"
                                                type="checkbox" value="{{ $permission->id }}">
                                            {{ $permission->name }} &nbsp;&nbsp;
                                        </label>

                                    @empty
                                        {{ __('No permission in this group !') }}
                                    @endforelse

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>


                <button type="submit"
                    class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 ">
                    Create Role
                </button>

            </form>
        </div> --}}















        <div class="row">
            <div class="col-lg-12 margin-tb mb-4">
                <div class="pull-left">
                    <h2>Create New Role
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

        <form action="{{ url('roles/store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" name="name" class="form-control" placeholder="Name">
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
                                                    <input name="permission[]" class="permissioncheckbox"
                                                        class="rounded-md border" type="checkbox"
                                                        value="{{ $permission->name }}">
                                                    {{ $permission->name }}
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
        </form>
    </div>
@endsection
