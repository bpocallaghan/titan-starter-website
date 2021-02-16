@extends('website.website')

@section('content')
    <section class="container body">

            @include('website.partials.page_header')

            <div class="row pb-5">
                <div class="col-sm-7 col-lg-8">

                    @if($news->cover_photo)
                        <figure>
                            <a href="{{ $news->cover_photo->url }}" title="{{ $news->cover_photo->name }}" data-lightbox="cover" data-caption="{{ $news->cover_photo->name }}">
                                <img src="{{ $news->cover_photo->url }}" class="img-fluid">
                            </a>
                            <figcaption>{{ $news->cover_photo->name }}</figcaption>
                        </figure>
                    @endif


                        <p class="mt-3"><i class="fa fa-calendar mr-2"></i>{{ $news->posted_at }}</p>
                        <div class="mt-3">
                            {!! $news->content !!}
                        </div>

                        @if($news->photos && $news->photos->count() > 1)
                            <div class="gallery mt-3 mb-3 p-3">
                                <div class="row">
                                    @foreach($news->photos->where('is_cover', 0)->sortBy('list_order') as $item)
                                        <div class="col-6 col-sm-4 col-lg-3">
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

                        @if($news->videos && $news->videos->count() > 0)
                            <div class="gallery mt-3 mb-3 p-3">
                                <div class="row">
                                    @foreach($news->videos->sortBy('list_order') as $item)

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

                        @if($news->documents && $news->documents->count() > 0)
                            <div class="gallery mt-3 mb-3 p-3">
                                @foreach($news->documents as $item)
                                    <a href="{{ $item->url }}" target="_blank" title="{{ $item->name }}" data-icon="uil uil-file-download-alt">
                                        {{$item->name}}
                                    </a>
                                    @if(!$loop->last)
                                        <span class="strong font-20 text-white mr-3 ml-3"> | </span>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        @include('website.partials.comments', ['commentable' => $item])
                </div>

                @include('website.partials.page_side')
            </div>

    </section>
@endsection
