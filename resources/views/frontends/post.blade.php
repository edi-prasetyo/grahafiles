@extends('layouts.front')

@section('content')
    @include('layouts.inc.searchbar')
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
            @foreach ($posts as $k => $item)
                <div class="col-md-2 col-6">
                    <a class="text-body-emphasis text-decoration-none" href="{{ url('detail/' . $item->slug) }}">
                        <div class="card mb-3 shadow-sm border-0">
                            <div class="card-body">
                                <div class="card-img-cover rounded relative">

                                    <div class="card-img-frame">
                                        <img src="{{ $item->image_url }}" class="img-fluid rounded"
                                            alt="{{ $item->title }}">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-body">
                                <h1 class="fs-6 card-title fw-light">
                                    @php
                                        $first_title = mb_substr($item->title, 0, 1);
                                    @endphp

                                    {{ Str::words($item->title, 4) }}
                                </h1>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="paginate my-5">
            {{ $posts->links() }}
        </div>
    </div>
    {{-- <div class="col-md-3">
                @include('frontends.sidebar')
            </div> --}}
@endsection
