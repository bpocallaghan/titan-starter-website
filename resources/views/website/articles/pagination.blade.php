<div class="pagination-box">
    <div class="row pb-3">
        @foreach($paginator as $item)
            <div class="col-12 col-lg-6">
                <div class="card h-100">
                    <img class="card-img-top" src="{{ $item->cover_photo->thumbUrl }}" alt="{{ $item->name }}">
                    <div class="card-body">
                        <h3 class="card-title">{!! $item->name !!}</h3>
                        <p class="card-text">{!! $item->summary !!}</p>

                    </div>
                    <div class="card-footer bg-white d-flex justify-content-between align-items-center border-top">
                        <div class="flex-grow-1" data-icon="far fa-calendar">
                            {!! $item->active_from->format('\<\s\t\r\o\n\g\>d\</\s\t\r\o\n\g\> M Y') !!}
                        </div>
                        <div class="text-right">
                            <a href="/articles/{{ $item->category->slug }}/{{ $item->slug }}" class="btn btn-secondary">Read article</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @include('website.partials.paginator_footer')
</div>
