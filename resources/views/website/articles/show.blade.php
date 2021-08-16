@extends('website.website')

@section('content')
    <section class="container body">

            @include('website.partials.page_header')

            <div class="row pb-5">
                <div class="col-sm-7 col-lg-8">

                    @if($article->cover_photo)
                        <figure>
                            <a href="{{ $article->cover_photo->url }}" title="{{ $article->cover_photo->name }}" data-lightbox="cover" data-caption="{{ $article->cover_photo->name }}">
                                <img src="{{ $article->cover_photo->url }}" class="img-fluid">
                            </a>
                            <figcaption>{{ $article->cover_photo->name }}</figcaption>
                        </figure>
                    @endif


                    <p class="mt-3"><i class="fa fa-calendar mr-2"></i>{{ $article->posted_at }}</p>
                    <div class="mt-3">
                        {!! $article->content !!}
                    </div>

                    @if($article->photos && $article->photos->count() > 1)
                        <div class="gallery mt-3 mb-3 p-3">
                            <div class="row">
                                @foreach($article->photos->where('is_cover', 0)->sortBy('list_order') as $item)
                                    <div class="col-6 col-md-4">
                                        <figure>
                                            <a href="{{ $item->url }}" rel="group" title="{{ $item->name }}" data-lightbox="gallery" class="cover">
                                                <img class="img-fluid" src="{{ $item->thumbUrl }}">
                                            </a>
                                            <figcaption>{!! $item->name !!}</figcaption>
                                        </figure>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($article->videos && $article->videos->count() > 0)
                        <div class="gallery mt-3 mb-3 p-3">
                            <div class="row">
                                @foreach($article->videos->sortBy('list_order') as $item)

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

                    @if($article->documents && $article->documents->count() > 0)
                        <div class="gallery mt-3 mb-3 p-3">
                            @foreach($article->documents as $item)
                                <a href="{{ $item->url }}" target="_blank" title="{{ $item->name }}" data-icon="uil uil-file-download-alt">
                                    {{$item->name}}
                                </a>
                                @if(!$loop->last)
                                    <span class="strong font-20 text-white mr-3 ml-3"> | </span>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    @include('website.pages.page_components', ['item' => $article ])

                    @include('website.partials.comments', ['commentable' => $article])

                </div>

                @include('website.partials.page_side')
            </div>

    </section>
@endsection
