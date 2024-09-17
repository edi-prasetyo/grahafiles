<div class="card shadow-sm">
    <div class="card-header bg-body">
        Recent Posts
    </div>
    <div class="card-body">
        @foreach ($recent as $k => $recent)
            <div class="row mb-3">
                <div class="col-5">
                    <div class="sidebar-img-cover rounded">
                        <div class="sidebar-img-frame">
                            <img src="{{ $recent->image_url }}" class="img-fluid rounded border">
                        </div>
                    </div>
                </div>
                <div class="col-7">
                    <h6 class="card-title"><a href="{{ url('file', $recent->slug) }}"
                            class="text-decoration-none text-body-emphasis">
                            {!! Str::words($recent->title, 4) !!}</a></h6>
                    <small><i class="bi bi-clock"></i> @php

                        $diffInDays = $recent->created_at->diffInDays();
                        $showDiff = $recent->created_at->locale('id')->diffForHumans();
                    @endphp
                        {{ $showDiff }}</small>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="mx-auto my-2">
    @if ($sidebar_banner == '')
        <small class=""> Sponsored Links</small>
        <div class="d-flex justify-content-center align-items-center rounded"
            style="height: 250px;width:100%; background-color: rgb(233, 236, 239);">
            <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;">Ads</span>
        </div>
    @else
        @foreach ($sidebar_banner as $sidebar)
            @if ($sidebar->script == null)
                <small class=""> Sponsored Links</small>
                <img class="w-100 img-fluid" src="{{ $sidebar->image_url }}">
            @else
                <small class=""> Sponsored Links</small>
                {!! $sidebar->script !!}
            @endif
        @endforeach
    @endif
</div>
<div class="card mt-3 shadow-sm">
    <div class="card-header bg-body">
        Popular Posts
    </div>
    <div class="card-body">
        @foreach ($popular as $popular)
            <div class="row mb-3">
                <div class="col-5">
                    <div class="sidebar-img-cover rounded">
                        <div class="sidebar-img-frame">
                            <img src="{{ $popular->image_url }}" class="img-fluid rounded border">
                        </div>
                    </div>
                </div>
                <div class="col-7">
                    <h6><a href="{{ url('file', $popular->slug) }}" class="text-decoration-none text-body-emphasis">
                            {!! Str::words($popular->title, 4) !!}</a></h6>
                    <small><i class="ti ti-eye"></i> {{ $popular->views }} View</small>
                </div>
            </div>
        @endforeach
    </div>
</div>
