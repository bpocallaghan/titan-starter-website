@if($content->videos && $content->videos->count() > 0)
    <div class="gallery bg-black mt-3 mb-3 p-3">
        <div class="row">
            @foreach($content->videos->sortBy('list_order') as $item)

                <div class="col-6 col-sm-4 col-lg-3">

                    <figure>
                        <iframe class="card-img-top" width="315" height="177" src="@if($item->is_youtube) {{ 'https://www.youtube.com/embed/'.$item->link}} @else {{ $item->link }} @endif" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <figcaption>{!! $item->name !!}</figcaption>
                    </figure>

                </div>
            @endforeach
        </div>
    </div>
@endif
