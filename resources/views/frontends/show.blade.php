@extends('layouts.front')

@section('content')
    <div class="container mb-5">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
            aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"
                        class="text-body-emphasis text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{!! Str::words($post->title, 4) !!}</li>
            </ol>
        </nav>
        <h1 class="mb-5">{{ $post->title }}</h1>
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        @if ($post->image_url == null)
                            <div class="d-flex justify-content-center align-items-center rounded-circle"
                                style="height:150px; background-color: rgb(233, 236, 239);">
                                <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;">Photo</span>
                            </div>
                        @else
                            <img class="img-fluid rounded w-100 img-thumbnail" src="{{ $post->image_url }}">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                File Download
                            </div>
                            <ul class="list-group list-group-flush">
                                @foreach ($files as $file)
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
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        Size
                                        <span>{{ $bytes }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        File Format
                                        <span>{{ $file->ext }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">Total
                                        Download
                                        <span>{{ $file->download_count }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="d-grid gap-2">
                                            <a href="{{ url('file/download/' . $file->uuid) }}" rel="dofollow"
                                                target="blank" class="btn btn-success"><i
                                                    class="bi bi-cloud-arrow-down"></i>
                                                Download</a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="card-body">
                                <div class="share-social-media">
                                    <i class="bi bi-share me-3"></i>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('file', $post->slug) }}"
                                        target="_blank"
                                        class="btn btn-sm btn-primary rounded-3 btnShare text-decoration-none">
                                        <i class="bi bi-facebook"></i> <span class="txt-share">Facebook</span>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?text={!! Str::words($post->content, 20) !!}&url={{ url('file', $post->slug) }}"
                                        target="_blank" class="btn btn-sm btn-dark rounded-3 btnShare">
                                        <i class="bi bi-twitter"></i> <span class="txt-share"> Twitter</span>
                                    </a>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url('file', $post->slug) }}&title={!! Str::words($post->title, 20) !!}"
                                        class="btn btn-sm btn-info rounded-3 btnShare">
                                        <i class="bi bi-linkedin"></i> <span class="txt-share">Linkedin</span>
                                    </a>
                                    <a href="https://wa.me/?text={!! $post->content !!}%20{{ url('file', $post->slug) }}"
                                        target="_blank" class="btn btn-sm btn-success rounded-3 btnShare">
                                        <i class="bi bi-whatsapp"></i> <span class="txt-share">Whatsapp</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div class="content-details">
                        {!! $post->content !!}</div>
                </div>
                <div class="mb-3"> Category : <a href="{{ url('category/' . $post->category_slug) }}">
                        {{ $post->category_name }}</a> </div>
                Tags : @foreach ($tags as $tag)
                    <a href="{{ url('tag', $tag->tag_slug) }}"> <span
                            class="btn btn-outline-secondary btn-sm">{{ $tag->tag_name }}</span></a>
                @endforeach
                <div class="d-grid gap-2 mt-3">
                    <div class="row">
                        @if ($download_banner == '')
                            <small class=""> Sponsored Links</small>
                            <div class="d-flex justify-content-center align-items-center rounded w-100"
                                style="height: 320px; width:100%; background-color: rgb(233, 236, 239);">
                                <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;">Google Ads</span>
                            </div>
                        @else
                            @foreach ($download_banner as $download)
                                <div class="col-md-5">
                                    @if ($download->script == null)
                                        <small class=""> Sponsored Links</small>
                                        <img class="w-100" src="{{ $download->image_url }}">
                                    @else
                                        <small class=""> Sponsored Links</small>
                                        {!! $download->script !!}
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <h4 class="related mt-2 mb-3"><span>Related Posts</span></h4>
                    <div class="row">
                        @foreach ($related as $related)
                            <div class="col-md-4">
                                <div class="card mb-3 shadow-sm">

                                    <div class="card-body">
                                        <div class="card-img-cover rounded border">
                                            <div class="card-img-frame">
                                                <img src="{{ $related->image_url }}" class="img-fluid rounded"
                                                    alt="{{ $related->title }}">
                                            </div>
                                        </div>
                                        <h5 class="card-title fs-6 mt-2">{{ Str::words($related->title, 3) }}</h5>
                                        <p class="card-text">
                                            @foreach ($related->files as $file)
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
                                                <a href="{{ url('file/' . $related->slug) }}" class="btn btn-info"><i
                                                        class="bi bi-box-arrow-up-right"></i>
                                                    Detail</a>
                                                @foreach ($post->files as $file)
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
                </div>
            </div>
            <div class="col-md-3">
                @include('frontends.sidebar')
            </div>
        </div>
    </div>
@endsection
