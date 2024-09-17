@extends('layouts.front')

@section('content')
    <div class="container mb-5">
        @include('frontends.top_banner')
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
            aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"
                        class="text-body-emphasis text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Post</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    @foreach ($posts as $k => $item)
                        @if ($k && $k % 4 == 0)
                            <div class="col-md-4">
                                @include('frontends.list_banner')
                            </div>
                        @endif
                        <div class="col-md-4">
                            <div class="card mb-3 shadow-sm">
                                <div class="card-body">
                                    <div class="card-img-cover rounded border">
                                        <div class="card-img-frame">
                                            <img src="{{ $item->image_url }}" class="img-fluid rounded"
                                                alt="{{ $item->title }}">
                                        </div>
                                    </div>
                                    <h1 class="fs-6 mt-3 card-title">{{ Str::words($item->title, 4) }}</h1>
                                    <p class="card-text">
                                        @foreach ($item->files as $file)
                                            @php
                                                $bytes = $file->size;
                                                if ($bytes >= 1073741824) {
                                                    $bytes = number_format($bytes / 1073741824, 2) . ' GB';
                                                } elseif ($bytes >= 1048576) {
                                                    $bytes = number_format($bytes / 1048576, 2) . ' MB';
                                                } elseif ($bytes >= 1024) {
                                                    $bytes = number_format($bytes / 1024, 2) . ' KB';
                                                } elseif ($bytes > 1) {
                                                    $bytes = $bytes . ' bytes';
                                                } elseif ($bytes == 1) {
                                                    $bytes = $bytes . ' byte';
                                                } else {
                                                    $bytes = '0 bytes';
                                                }
                                            @endphp
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div> <i class="bi bi-hdd"></i> {{ $bytes }} </div>
                                                <div> <i class="bi bi-cloud-download"></i>
                                                    {{ $file->download_count }} Download </div>
                                            </div>
                                        @endforeach
                                    </p>
                                </div>
                                <div class="card-footer bg-body">
                                    <div class="d-grid gap-2">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{ url('file/' . $item->slug) }}" class="btn btn-info"><i
                                                    class="bi bi-box-arrow-up-right"></i>
                                                Detail</a>
                                            @foreach ($item->files as $file)
                                                <a href="{{ url('file/download/' . $file->uuid) }}"
                                                    class="btn btn-primary"><i class="bi bi-download"></i>
                                                    Download</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="paginate my-5">
                    {{ $posts->links() }}
                </div>
            </div>
            <div class="col-md-3">
                @include('frontends.sidebar')
            </div>
        </div>
    </div>
@endsection
