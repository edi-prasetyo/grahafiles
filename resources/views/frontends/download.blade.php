@extends('layouts.front')
@section('content')
    <div class="container mb-5">
        <div class="col-md-10 mx-auto">
            <div class="align-items-center vh-50 text-center">
                <h1 class="mt-5 mb-5">{{ $post->title }}</h1>

                {{-- <div id="countdown">You have to wait 15 seconds.</div>
                <b class="mb-3">Generating Download Link...</b><br />
                @if ($files->file_url == null)
                @else
                    <button class="btn btn-success downloadButton px-5 mt-3" id="download_link" onclick="unduh(this)"
                        style="display: none;">
                        <i class="bi bi-cloud-arrow-down"></i> Download File
                    </button>
                @endif --}}




                {{-- <button class="btn btn-success px-5 mt-3" id="downloadButton">
                    <i class="bi bi-cloud-arrow-down"></i> Download File
                </button>

                <h3 id="countdown"></h3> --}}





                @php
                    $files->file_url;
                    $download_url = url('download-file/' . $files->uuid);
                    // $file_path = url('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9/' . $files->file);
                @endphp


                <a class="button like" onClick="this.style='display: none';" href="{{ $download_url }}" id="download">Click To
                    Download</a>
                <button class="btn btn-success" id="btn"> <i class="bi bi-cloud-arrow-down"></i> Open Link
                    Download</button>




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

                {{-- {{ $files->file_url }} --}}

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

    {{-- <script>
        const downloadButton = document.getElementById("downloadButton");
        const countdown = document.getElementById("countdown");
        const downloadLink = {!! json_encode($download_url) !!};

        let timer;
        let countdownValue = 25;

        downloadButton.addEventListener("click", function() {
            countdown.style.display = "block";

            timer = setInterval(function() {

                if (!focusOut) {
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
                }
            }, 1000);



        });

        window.addEventListener('blur', function() {
            focusOut = true;
        })

        window.addEventListener('focus', function() {
            focusOut = false;
        });



        // const downloadButton = document.getElementById("download_link");
        // const countdown = document.getElementById("countdown");
        // const downloadLink = {!! json_encode($download_url) !!};

        // let timer;
        // let countdownValue = 20;
        // let focusOut = false;

        // downloadButton.addEventListener("click", function() {
        //     countdown.style.display = "block";

        //     timer = setInterval(function() {

        //         if (!focusOut) {
        //             if (countdownValue <= 0) {
        //                 clearInterval(timer);
        //                 countdown.innerHTML = "Downloading...";
        //                 setTimeout(function() {
        //                     const a = document.createElement("a");
        //                     a.style.display = "none";
        //                     a.href = downloadLink;
        //                     a.setAttribute("download", "");
        //                     document.body.appendChild(a);
        //                     a.click();
        //                 }, 1000);
        //             } else {
        //                 countdown.innerHTML =
        //                     `Starting download in ${countdownValue} seconds...`;
        //             }
        //             countdownValue--;
        //         }
        //     }, 1000);


        // });


        // (function() {
        //     var message = "%d seconds before download link appears";
        //     var count = 15;
        //     var countdown_element = document.getElementById("countdown");
        //     var download_link = document.getElementById("download_link");
        //     var timer = setInterval(function() {

        //         if (!focusOut) {
        //             if (count) {
        //                 countdown_element.innerHTML = "You have to wait %d seconds.".replace("%d", count);
        //                 count--;
        //             } else {
        //                 clearInterval(timer);
        //                 countdown_element.style.display = "none";
        //                 download_link.style.display = "";
        //             }
        //         }
        //     }, 1000);

        // })();
        // const unduh = (element) => {
        //     element.hidden = true;
        // }



        // window.addEventListener('blur', function() {
        //     focusOut = true;
        // })

        // window.addEventListener('focus', function() {
        //     focusOut = false;
        // });
    </script> --}}

    <script>
        var downloadButton = document.getElementById("download");
        var counter = 45;
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
                        newElement.innerHTML = "<h3>" + counter.toString() + " second. Please Wait</h3>";
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
