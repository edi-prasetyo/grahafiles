@extends('layouts.front')
@section('content')
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-9">
                @include('frontends.top_banner')
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
                                                    {{ count($file->downloadCount) }} Download </div>
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
                                                <a href="{{ url('download/' . $file->uuid) }}" class="btn btn-primary"><i
                                                        class="bi bi-download"></i>
                                                    Download</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $posts->links() }}
            </div>
            <div class="col-md-3">
                @include('frontends.sidebar')
            </div>
        </div>
    </div>
@endsection
