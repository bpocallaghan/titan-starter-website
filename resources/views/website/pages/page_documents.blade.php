@if($content->documents && $content->documents->count() > 0)
    <div class="gallery bg-black mt-3 mb-3 p-3">
        @foreach($content->documents as $item)
            <a href="{{ $item->url }}" target="_blank" title="{{ $item->name }}" data-icon="uil uil-file-download-alt">
                {{$item->name}}
            </a>
            @if(!$loop->last)
                <span class="strong font-20 text-white mr-3 ml-3"> | </span>
            @endif
        @endforeach
    </div>
@endif
