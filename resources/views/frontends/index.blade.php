@section('robots', 'index, follow')
@section('meta_title', $option->site_name)
@section('meta_description', $option->site_description)
@section('og_url', url('/'))
@section('canonical', url('/'))
@section('img_url', $option->logo_url)
@section('short_description', $option->site_tagline)
@section('keywords', 'free download logo, download logo vector, unduh logo vector, logo format cdr, logo format ai, logo
    format eps')

    @extends('layouts.front')
@section('content')
    <section class="hero bg-dark-subtle py-5">
        <div class="container">
            <h1>Need Vector Images?</h1>
            <p> Find Vector graphics, What You Want please Start Search here</p>
            <form action="{{ url('search') }}" method="GET">
                @csrf
                <div class="input-box bg-body">
                    <i class="bi bi-search"></i>
                    <input type="text" name="keyword" value="{{ old('keyword') }}" placeholder="Search here..." />
                    <button class="button">Search</button>
                </div>
            </form>
        </div>

    </section>
    <div class="container mb-5">
        <div class="d-flex justify-content-between align-items-start mt-5">
            <h4>Popular Vector</h4>
            <a href="">view All</a>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('frontends.top_banner')
                <div class="row">
                    @foreach ($popular as $k => $item)
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

        </div>
    </div>

    <div class="container mb-5">
        <div class="d-flex justify-content-between align-items-start mt-5">
            <h4>Recent Vector</h4>
            <a href="{{ url('files') }}">view All</a>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('frontends.top_banner')
                <div class="row">
                    @foreach ($recent as $k => $item)
                        {{-- @if ($k && $k % 4 == 0)
                            <div class="col-md-2">
                                @include('frontends.list_banner')
                            </div>
                        @endif --}}
                        <div class="col-md-2 col-6">
                            <a class="text-body-emphasis text-decoration-none" href="{{ url('detail/' . $item->slug) }}">
                                <div class="card mb-3 shadow-sm border-0 ">
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

        </div>
    </div>
@endsection
