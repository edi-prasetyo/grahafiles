<div class="my-3">
    @if ($list_banner == null)
        <small class=""> Sponsored Links</small>
        <div class="d-flex justify-content-center align-items-center rounded w-100"
            style="height: 320px; width:100%; background-color: rgb(233, 236, 239);">
            <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;"> Ads</span>
        </div>
    @else
        @foreach ($list_banner as $list)
            @if ($list->script == null)
                <small class=""> Sponsored Links</small>
                <img class="w-100" src="{{ $list->image_url }}">
            @else
                <small class=""> Sponsored Links</small>
                {!! $list->script !!}
            @endif
        @endforeach
    @endif



</div>
