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
                                                    <img src="{{ $option->logo_url }}" class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                                <div class="text-center text-sm-left mb-2 mb-sm-0">
                                                    <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">{{ $option->site_name }}</h4>
                                                    <p class="mb-0">{{ $option->site_email }}</p>
                                                    <div class="mt-2">
                                                        <span
                                                            class="badge rounded-pill text-bg-success">{{ $option->site_url }}</span>
                                                    </div>
                                                </div>
                                                <div class="text-center text-sm-right">

                                                    Joined at
                                                    <div class="text-muted">
                                                        <small></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="related mt-5 mb-3"><span>Site Info</span></h4>

                                        <div class="tab-content pt-3">
                                            <div class="tab-pane active">

                                                <div class="row">
                                                    <div class="col">

                                                        <form action="{{ url('options/update') }}" method="POST"
                                                            enctype="multipart/form-data">

                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <img src="{{ $option->logo_url }}" class="img-fluid">
                                                                    <label class="form-label">Logo</label>
                                                                    <input type="file" name="logo"
                                                                        class="form-control">

                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <img src="{{ $option->second_logo_url }}"
                                                                        class="img-fluid">
                                                                    <label class="form-label">Second Logo</label>
                                                                    <input type="file" name="second_logo"
                                                                        class="form-control">

                                                                </div>

                                                                <div class="col-md-12 mb-3">
                                                                    <img src="{{ $option->favicon_url }}" class="img-fluid">
                                                                    <label class="form-label">Favicon</label>
                                                                    <input type="file" name="favicon"
                                                                        class="form-control">

                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Site Name</label>
                                                                        <input class="form-control" type="text"
                                                                            name="site_name" placeholder="Nama Situs"
                                                                            value="{{ $option->site_name }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Tagline</label>
                                                                        <input class="form-control" type="text"
                                                                            name="site_tagline" placeholder="Tagline"
                                                                            value="{{ $option->site_name }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Email</label>
                                                                        <input class="form-control" type="text"
                                                                            placeholder="user@example.com" name="site_email"
                                                                            value="{{ $option->site_email }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Url</label>
                                                                        <input class="form-control" type="text"
                                                                            placeholder="Url" name="site_url"
                                                                            value="{{ $option->site_url }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Phone</label>
                                                                        <input class="form-control" type="text"
                                                                            placeholder="Phone" name="phone_number"
                                                                            value="{{ $option->phone_number }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Whatsapp</label>
                                                                        <input class="form-control" type="text"
                                                                            placeholder="Whatsapp" name="whatsapp"
                                                                            value="{{ $option->whatsapp }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 mt-3">
                                                                    <label class="form-label">Site Description</label>
                                                                    <textarea class="form-control" name="site_description">{{ $option->site_description }}</textarea>
                                                                </div>
                                                                <div class="col-md-12 mt-3">
                                                                    <label class="form-label">Address</label>
                                                                    <textarea class="form-control" name="address">{{ $option->address }}</textarea>
                                                                </div>
                                                                <div class="col-md-12 mt-3">
                                                                    <label class="form-label">Google Maps Embed</label>
                                                                    <textarea class="form-control" name="maps">{{ $option->maps }}</textarea>
                                                                </div>


                                                            </div>

                                                            <h4 class="related mt-5 mb-3"><span>SEO</span></h4>
                                                            <div class="row">
                                                                <div class="col-md-6 mt-3">
                                                                    <label class="form-label">Google Webmaster
                                                                        <span data-bs-toggle="tooltip"
                                                                            data-bs-title="Copy Paste code Google Webmaster tools disini"><i
                                                                                class="ti ti-info-circle text-danger"></i>
                                                                        </span>

                                                                        <i class="ti ti-info"></i> </label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-text"><i
                                                                                class="ti ti-brand-google"></i> </div>
                                                                        <input type="text" name="google_webmaster"
                                                                            class="form-control"
                                                                            placeholder="Code google webmaster"
                                                                            value="{{ $option->google_webmaster }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 mt-3">
                                                                    <label class="form-label">Bing Webmaster
                                                                        <span data-bs-toggle="tooltip"
                                                                            data-bs-title="Copy Paste code Bing Webmaster tools disini"><i
                                                                                class="ti ti-info-circle text-danger"></i>
                                                                        </span>
                                                                    </label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-text"><i
                                                                                class="ti ti-brand-bing"></i> </div>
                                                                        <input type="text" name="bing_webmaster"
                                                                            class="form-control"
                                                                            placeholder="Code Bing Webmaster"
                                                                            value="{{ $option->bing_webmaster }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 mt-3">
                                                                    <label class="form-label">Keywords</label>
                                                                    <textarea class="form-control" name="keywords">{{ $option->keywords }}</textarea>
                                                                </div>
                                                            </div>

                                                            <h4 class="related mt-5 mb-3"><span>Social Media</span>
                                                            </h4>

                                                            <div class="row">

                                                                <div class="col-md-6 mt-3">
                                                                    <label class="form-label">Facebook</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-text"><i
                                                                                class="ti ti-brand-facebook"></i> </div>
                                                                        <input type="text" name="facebook"
                                                                            class="form-control"
                                                                            placeholder="Facebook Url"
                                                                            value="{{ $option->facebook }}">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 mt-3">
                                                                    <label class="form-label">Youtube</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-text"><i
                                                                                class="ti ti-brand-youtube"></i> </div>
                                                                        <input type="text" name="youtube"
                                                                            class="form-control" placeholder="Youtube Url"
                                                                            value="{{ $option->youtube }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mt-3">
                                                                    <label class="form-label">Twitter</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-text"><i
                                                                                class="ti ti-brand-twitter"></i> </div>
                                                                        <input type="text" name="twitter"
                                                                            class="form-control" placeholder="twitter Url"
                                                                            value="{{ $option->twitter }}">
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
                                                                            value="{{ $option->instagram }}">
                                                                    </div>
                                                                </div>

                                                                <div class="mt-3">
                                                                    <button class="btn btn-primary" type="submit">Upadate
                                                                        Site</button>
                                                                </div>


                                                            </div>

                                                        </form>

                                                    </div>
                                                </div>

                                                <h4 class="related mt-5 mb-3"><span>Security</span></h4>
                                                <div class="row">
                                                    <div class="col-12 col-sm-6 mb-3 mt-2">
                                                        <div class="mb-2"><b>Ganti Password</b></div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label class="form-label">Masukan Password
                                                                        Baru</label>
                                                                    <input class="form-control" type="password"
                                                                        placeholder="••••••">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-12 col-sm-5 offset-sm-1 mb-3">


                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <button class="btn btn-primary" type="submit">Simpan
                                                            Password</button>
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
                                        <a href="" type="button" class="btn btn-danger"><i
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

@section('scripts')
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
@endsection
