@if(isset($articles) && $articles->count() >= 1)
    <aside class="card mt-3">
        <div class="card-body">
            <h3 class="side-heading">Latest News</h3>

            <div id="articles-carousel" class="carousel slide side-articles" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    @foreach($articles as $k => $item)
                        <div class="carousel-item {{ $k == 0? 'active':'' }}">
                            <div class="card">
                                <img class="card-img-top" src="{{ $item->cover_photo->thumbUrl }}" alt="{{ $item->name }}">
                                <div class="card-body">
                                    <h4 class="card-title">{!! $item->name !!}</h4>
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
                <a class="carousel-control-prev" href="#articles-carousel" role="button" data-slide="prev">
                    <span class="fa fa-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#articles-carousel" role="button" data-slide="next">
                    <span class="fa fa-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </aside>
@endif
