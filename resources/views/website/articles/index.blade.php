@extends('website.website')

@section('content')
    <section class="container body">

        @include('website.partials.page_header')

        <div class="row pb-5">
            <div class="col-md-7 col-lg-8">

                @include('website.pages.page_components', ['item' => $page])

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
