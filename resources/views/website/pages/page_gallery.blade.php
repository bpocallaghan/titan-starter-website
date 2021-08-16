@if($content->photos && $content->photos->count() > 0)
    <div class="gallery bg-black mt-3 mb-3 p-3">
        <div class="row">
            @foreach($content->photos->where('is_cover', 0)->sortBy('list_order') as $item)
                <div class="col-6 col-md-4">
                    <figure>
                        <a href="{{ $item->url }}" rel="group" title="{{ $item->name }}" data-lightbox="gallery" class="cover" style="background-image:url('{{ $item->thumbUrl }}')">
                            <img src="{{ $item->thumbUrl }}">
                        </a>
                        <figcaption>{!! $item->name !!}</figcaption>
                    </figure>
                </div>
            @endforeach
        </div>
    </div>
@endif
