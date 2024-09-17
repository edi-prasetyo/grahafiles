@extends('layouts.front')

@section('content')
    <div class="container mb-5">
        <div class="col-md-10 mx-auto">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"
                            class="text-body-emphasis text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{!! Str::words($page->title, 4) !!}</li>
                </ol>
            </nav>
            <h1 class="mb-5">{{ $page->title }}</h1>
            <div class="row">
                <div class="col-md-8">
                    @if ($page->image_url == null)
                    @else
                        <img class="img-fluid rounded w-100" src="{{ $page->image_url }}">
                    @endif
                    <div class="content-details">
                        {!! $page->content !!}
                    </div>

                    @include('frontends.top_banner')

                </div>
            </div>
        </div>
    </div>
@endsection
