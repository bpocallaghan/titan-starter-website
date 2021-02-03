@extends('website.website')

@section('content')
    <section class="container body">

        @include('website.partials.page_header')

        <div class="row pb-5">
            <div class="col-sm-7 col-lg-8">

                @foreach($activePage->sections as $section)

                    @if(isset($section->name))
                        <h2>{!! $section->name !!}</h2>
                    @endif

                    {!! $section->content !!}

                    @include('website.pages.page_gallery' , ['content' => $section])
                    @include('website.pages.page_videos' , ['content' => $section])
                    @include('website.pages.page_documents' , ['content' => $section])

                    @if(isset($section->components) && $section->components->count() > 0)
                        <div class="row mb-3 mb-xl-5">

                            @foreach($section->components as $content)
                                <section class="{{ isset($section->layout) && strpos($section->layout, 'col') !== false? $section->layout: 'col-12' }} mb-4 mb-md-3">
                                    @include('website.pages.page_heading')
                                    @include('website.pages.page_content')

                                    @include('website.pages.page_gallery')
                                    @include('website.pages.page_videos')
                                    @include('website.pages.page_documents')
                                </section>
                            @endforeach
                        </div>
                    @endif

                @endforeach

                @include('website.partials.comments', ['commentable' => $page])


                @if($childrenPages && $childrenPages->count() > 0)
                    <div class="row pb-5">
                        @foreach($childrenPages as $item)
                            <div class="col-sm-6">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h3 data-icon="fa fa-fw {{ $item->icon }}">{{ $item->name }} </h3>
                                    </div>
                                    <div class="card-body">
                                        <p>{{ $item->description }}</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ $item->url }}">read more
                                            <i data-icon="fa-angle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @include('website.partials.social_share')
            </div>

            @include('website.partials.page_side')
        </div>

    </section>
@endsection
