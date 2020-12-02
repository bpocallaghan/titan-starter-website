@extends('website.website')

@section('content')
    <section class="container body">

        @include('website.partials.page_header')

        <div class="row pb-5">
            <div class="col-md-7 col-lg-8">

                @foreach($page->components as $content)
                    <div class="mb-5">
                        @include('website.pages.page_heading')
                        @include('website.pages.page_content')

                        @include('website.pages.page_gallery')
                        @include('website.pages.page_videos')
                        @include('website.pages.page_documents')
                    </div>
                @endforeach

                <div class="mb-5">
                    @include('website.news.pagination')
                </div>

            </div>

            @include('website.partials.page_side')
        </div>

    </section>

@endsection

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function () {
            // paginator
            new PaginationClass();
        })
    </script>
@endsection
