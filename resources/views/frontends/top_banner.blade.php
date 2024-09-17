<div class="mb-3">
    @if ($top_banner == '')
        <small class=""> Sponsored Links</small>
        <div class="d-flex justify-content-center align-items-center rounded"
            style="height: 90px; background-color: rgb(233, 236, 239);">
            <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;">Google Ads</span>
        </div>
    @else
        @foreach ($top_banner as $top)
            @if ($top->script == null)
                <small class=""> Sponsored Links</small>
                <img class="w-100 img-fluid" src="{{ $top->image_url }}">
            @else
                <small class=""> Sponsored Links</small>
                {!! $top->script !!}
            @endif
        @endforeach
    @endif
</div>
