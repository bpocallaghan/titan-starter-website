@if($content->videos && $content->videos->count() > 0)
    <div class="gallery bg-black mt-3 mb-3 p-3">
        <div class="row">
            @foreach($content->videos->sortBy('list_order') as $item)

                <div class="col-sm-6">

                    @if(!isset($item->filename))
                        <figure>
                            <iframe width="315" height="177" src="@if($item->is_youtube) {{ 'https://www.youtube.com/embed/'.$item->link}} @else {{ $item->link }} @endif" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <figcaption>{!! $item->name !!}</figcaption>
                        </figure>
                    @else
                        <figure id="video-viewport">
                            <video id="video-{{$item->id}}" width="315px" height="177px" preload="auto" controls muted="" src="{{$item->url}}">
                                <source src="{{$item->url}}" type="video/mp4">
                            </video>
                            <figcaption>{!! $item->name !!}</figcaption>
                        </figure>
                    @endif

                </div>
            @endforeach
        </div>
    </div>
@endif
