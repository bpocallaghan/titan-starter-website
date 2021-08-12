@extends('website.website')

@section('content')
    <section class="container body">

        @include('website.partials.page_header')

        <div class="row pb-5">
            <div class="col-sm-7 col-lg-8">

                @include('website.pages.page_components', ['item' => $activePage ])

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

                @include('website.partials.comments', ['commentable' => $activePage])

                @include('website.partials.social_share')
            </div>

            @include('website.partials.page_side')
        </div>

    </section>
@endsection
