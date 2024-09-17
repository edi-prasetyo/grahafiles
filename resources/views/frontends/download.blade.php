@extends('layouts.front')
@section('content')
    <div class="container mb-5">
        <div class="col-md-10 mx-auto">
            <div class="align-items-center vh-50 text-center">
                <h1 class="mt-5 mb-5">{{ $post->title }}</h1>
                <div id="countdown">You have to wait 15 seconds.</div>
                <b class="mb-3">Generating Download Link...</b><br />
                @if ($files->file_url == null)
                @else
                    <button class="btn btn-success downloadButton px-5 mt-3" id="download_link" onclick="unduh(this)"
                        style="display: none;">
                        <i class="bi bi-cloud-arrow-down"></i> Download File
                    </button>
                @endif
                <h3 id="countdown"></h3>
                @php
                    $files->file_url;
                    $download_url = url('file/download-file/' . $files->uuid);
                @endphp

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
            </div>
        </div>
    </div>

    <script>
        const downloadButton = document.getElementById("download_link");
        const countdown = document.getElementById("countdown");
        const downloadLink = {!! json_encode($download_url) !!};

        let timer;
        let countdownValue = 20;

        downloadButton.addEventListener("click", function() {
            countdown.style.display = "block";

            timer = setInterval(function() {

                if (countdownValue <= 0) {
                    clearInterval(timer);
                    countdown.innerHTML = "Downloading...";
                    setTimeout(function() {
                        const a = document.createElement("a");
                        a.style.display = "none";
                        a.href = downloadLink;
                        a.setAttribute("download", "");
                        document.body.appendChild(a);
                        a.click();
                    }, 1000);
                } else {
                    countdown.innerHTML =
                        `Starting download in ${countdownValue} seconds...`;
                }
                countdownValue--;
            }, 1000);
        });

        (function() {
            var message = "%d seconds before download link appears";
            var count = 15;
            var countdown_element = document.getElementById("countdown");
            var download_link = document.getElementById("download_link");
            var timer = setInterval(function() {
                if (count) {
                    countdown_element.innerHTML = "You have to wait %d seconds.".replace("%d", count);
                    count--;
                } else {
                    clearInterval(timer);
                    countdown_element.style.display = "none";
                    download_link.style.display = "";
                }
            }, 1000);
        })();
        const unduh = (element) => {
            element.hidden = true;
        }
    </script>

@endsection
