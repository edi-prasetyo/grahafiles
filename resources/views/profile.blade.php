@extends('layouts.app')

@section('content')
    <div class="container">
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
        <div class="col-md-10">
            <div class="row flex-lg-nowrap">
                <div class="col">
                    <div class="row">
                        <div class="col mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="e-profile">
                                        <div class="row">
                                            <div class="col-12 col-sm-auto mb-3">
                                                <div class="mx-auto" style="width: 140px;">
                                                    <div class="avatar-img-cover rounded-circle border">
                                                        <div class="avatar-img-frame">
                                                            @if ($user->avatar_url == null)
                                                                <div class="d-flex justify-content-center align-items-center rounded"
                                                                    style="height: 100px; background-color: rgb(233, 236, 239);">
                                                                    <span
                                                                        style="color: rgb(166, 168, 170); font: bold 8pt Arial;">Avatar</span>
                                                                </div>
                                                            @else
                                                                <img src="{{ $user->avatar_url }}" img-fluid>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                                <div class="text-center text-sm-left mb-2 mb-sm-0">
                                                    <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">{{ $user->name }}</h4>
                                                    <p class="mb-0">{{ $user->email }}</p>
                                                    <div class="mt-2">
                                                        <span
                                                            class="badge rounded-pill text-bg-success">{{ Auth::user()->roles->pluck('name')->implode(',') }}</span>
                                                    </div>
                                                </div>
                                                <div class="text-center text-sm-right">

                                                    Joined at
                                                    <div class="text-muted">
                                                        <small>{{ date('d-m-Y', strtotime($user->created_at)) }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item"><a href="" class="active nav-link">Settings</a></li>
                                        </ul>
                                        <div class="tab-content pt-3">
                                            <div class="tab-pane active">

                                                <div class="row">
                                                    <div class="col">

                                                        <form action="{{ url('update-profile') }}" method="POST"
                                                            enctype="multipart/form-data">

                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-md-12 mb-3">
                                                                    <label class="form-label">Avatar</label>
                                                                    <input type="file" name="avatar"
                                                                        class="form-control">

                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Full Name</label>
                                                                        <input class="form-control" type="text"
                                                                            name="name" placeholder="Nama Lengkap"
                                                                            value="{{ $user->name }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Email</label>
                                                                        <input class="form-control" type="text"
                                                                            placeholder="user@example.com"
                                                                            value="{{ $user->email }}" disabled readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">

                                                                <div class="col-md-12 mt-3">
                                                                    <label class="form-label">Bio</label>
                                                                    <textarea class="form-control" name="bio">{{ $user->bio }}</textarea>
                                                                </div>

                                                                <div class="col-md-6 mt-3">
                                                                    <label class="form-label">Facebook</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-text"><i
                                                                                class="ti ti-brand-facebook"></i> </div>
                                                                        <input type="text" name="facebook"
                                                                            class="form-control" placeholder="Facebook Url"
                                                                            value="{{ $user->youtube }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 mt-3">
                                                                    <label class="form-label">Youtube</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-text"><i
                                                                                class="ti ti-brand-youtube"></i> </div>
                                                                        <input type="text" name="youtube"
                                                                            class="form-control" placeholder="Youtube Url"
                                                                            value="{{ $user->youtube }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mt-3">
                                                                    <label class="form-label">Twitter</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-text"><i
                                                                                class="ti ti-brand-twitter"></i> </div>
                                                                        <input type="text" name="twitter"
                                                                            class="form-control" placeholder="twitter Url"
                                                                            value="{{ $user->twitter }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mt-3">
                                                                    <label class="form-label">Instagram</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-text"><i
                                                                                class="ti ti-brand-instagram"></i>
                                                                        </div>
                                                                        <input type="text" name="instagram"
                                                                            class="form-control"
                                                                            placeholder="instagram Url"
                                                                            value="{{ $user->instagram }}">
                                                                    </div>
                                                                </div>

                                                                <div class="mt-3">
                                                                    <button class="btn btn-primary" type="submit">Upadate
                                                                        Profile</button>
                                                                </div>


                                                            </div>

                                                        </form>

                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-3 mb-3">
                            <div class="card mb-3">
                                <div class="card-body">

                                    <div class="d-grid gap-2">
                                        <a href="{{ url('password/reset') }}" class="btn btn-warning">
                                            <i class="ti ti-lock"></i>
                                            <span>Ubah Password</span>
                                        </a>
                                        <button class="btn btn-secondary">
                                            <i class="ti ti-logout"></i>
                                            <span>Logout</span>
                                        </button>
                                    </div>

                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">Hapus Akun</div>
                                <div class="card-body">

                                    <p class="card-text">Menghapus akun anda maka semua postingan yang anda post akan ikut
                                        terhapus.</p>
                                    <div class="d-grid gap-2">
                                        <a href="{{ url('delete-profile') }}" type="button" class="btn btn-danger"><i
                                                class="ti ti-trash"></i> Hapus
                                            Akun</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection
