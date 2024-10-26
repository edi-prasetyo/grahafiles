@section('robots', 'index, follow')
@section('meta_title', $post->meta_title)
@section('meta_description', $post->meta_description)
@section('og_url', url('download', $files->uuid))
@section('canonical', url('download', $files->uuid))
@section('img_url', $post->image_url)
@section('short_description', $post->short_description)
@section('keywords', 'logo, download logo, logo vector, logo cdr, logo ai, logo eps')

@extends('layouts.front')
@section('content')
    @include('layouts.inc.searchbar')
    <div class="container mb-5">
        <div class="col-md-10 mx-auto mt-5">
            <div class="col-md-9 mx-auto mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <img class="img-fluid rounded" src="{{ $post->image_url }}">
                    </div>
                    <div class="col-md-6">
                        <h1 class="">{{ $post->title }} Format {{ $files->ext }}</h1>
                    </div>
                </div>
            </div>

            <div class="align-items-center vh-50 text-center">
                @php
                    $files->file_url;
                    $download_url = url('download-file/' . $files->uuid);
                    // $file_path = url('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9/' . $files->file);
                @endphp


                <a class="button like" onClick="this.style='display: none';" href="{{ $download_url }}" id="download">Click
                    To
                    Download</a>
                <button class="btn btn-success" id="btn"> <i class="bi bi-cloud-arrow-down"></i> Open Link
                    Download</button>

                <div class="col-md-8 mx-auto mt-3">
                    <div class="row">

                        @if ($download_banner == '')
                            <small class=""> Sponsored Links</small>
                            <div class="d-flex justify-content-center align-items-center rounded w-100"
                                style="height: 320px; width:100%; background-color: rgb(233, 236, 239);">
                                <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;">Google Ads</span>
                            </div>
                        @else
                            @foreach ($download_banner as $download)
                                <div class="col-md-6">
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
                </div>


                @php
                    $bytes = $files->size;
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

                <p>Download {{ $post->title }} Untuk kebutuhan Advertising, Silahkan download file ini dan gunakan sesuai
                    kebutuhan. File {{ $post->title }} dengan format {{ $files->ext }} dengan ukuran file
                    {{ $bytes }} .

                    kami tidak memberikan jaminan apa pun tentang kelengkapan, keandalan, dan keakuratan informasi ini.
                    Untuk informasi selengkapnya harap baca disclaimer yang ada di situs ini dengan mengklik halaman <a
                        href={{ url('page/disclaimer') }}>ini</a>
                </p>






            </div>
        </div>

        <h3 class="text-center my-5">Random Files</h3>
        <div class="row">
            {{-- Random Posts --}}
            @foreach ($randoms as $k => $item)
                {{-- @if ($k && $k % 4 == 0)
            <div class="col-md-2">
                @include('frontends.list_banner')
            </div>
        @endif --}}
                <div class="col-md-2 col-6">
                    <a class="text-body-emphasis text-decoration-none" href="{{ url('detail/' . $item->slug) }}">
                        <div class="card mb-3 shadow-sm border-0">
                            <div class="card-body">
                                <div class="card-img-cover rounded relative">

                                    {{-- <div class="badge rounded-pill text-bg-primary absolute"> {{ $item->category_name }}
                        </div> --}}


                                    <div class="card-img-frame">
                                        <img src="{{ $item->image_url }}" class="img-fluid rounded"
                                            alt="{{ $item->title }}">
                                    </div>
                                </div>


                            </div>
                            <div class="card-footer bg-body">
                                <h1 class="fs-6 card-title fw-light">

                                    {{ Str::words($item->title, 4) }}
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>


    <script>
        var downloadButton = document.getElementById("download");
        var counter = 15;
        var newElement = document.createElement("p");
        newElement.innerHTML = "Click Button to Open Link Download";
        var id;
        let focusOut = false;
        downloadButton.parentNode.replaceChild(newElement, downloadButton)

        function startDownload() {
            this.style.display = 'none';
            id = setInterval(function() {
                if (!focusOut) {
                    counter--;
                    if (counter < 0) {
                        newElement.parentNode.replaceChild(downloadButton, newElement);
                        clearInterval(id);
                    } else {
                        newElement.innerHTML = "Silahkan tunggu " + counter.toString() +
                            " Detik. Untuk menampilkan Link Download";
                    }
                }
            }, 1000);
        };

        var clickbtn = document.getElementById("btn");
        clickbtn.onclick = startDownload

        window.addEventListener('blur', function() {
            focusOut = true;
        })

        window.addEventListener('focus', function() {
            focusOut = false;
        });
    </script>

@endsection
