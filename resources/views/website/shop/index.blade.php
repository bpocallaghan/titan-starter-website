@extends('website.website')

@section('content')
    <section class="container body">

        @include('website.partials.page_header')

        <div class="row pb-5">
            <div class="col-sm-7 col-lg-8 content">

                <button data-target="#filters" class="btn btn-info btn-block" data-toggle="collapse" data-icon="fa-search">Filter
                    / Sort Results</button>

                <div class="collapse show mb-3" id="filters">
                    <div class="filter bg-light p-3" id="js-shop-filters">
                        <form id="js-form-filters">
                            {!! csrf_field() !!}

                            <div class="form-group">
                                <label for="filter_name" class="sr-only">Product Name</label>
                                <input type="text" class="form-control" id="filter_name" placeholder="Product Name" name="name">
                            </div>

                            <div class="form-row form-group mb-4">
                                <div class="col">
                                    <label for="category_id" class="sr-only">Category</label>
                                    {!! form_select('category_id', ([0 => '- Category -'] + $filterCategories), ($errors && $errors->any()? old('category_id') : 0), ['class' => 'form-control']) !!}
                                </div>
                                <div class="col">
                                    <label for="size_id" class="sr-only">Features</label>
                                    {!! form_select('feature_id', ([0 => '- Feature -'] + $filterFeatures), ($errors && $errors->any()? old('feature_id') : 0), ['class' => 'form-control']) !!}
                                </div>
                                <div class="col">
                                    <button id="js-btn-filters" role="button" class="btn btn-primary btn-block btn-filters"><span>Search</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @include('website.pages.page_components', ['item' => $page])

                @include('website.partials.social_share')

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
            var pagination = new PaginationClass({
                onComplete: function () {
                    $('html, body').animate({
                        scrollTop: ($("#js-shop-filters").offset().top - 50)
                    }, 300);
                }
            });

            $('#js-btn-filters').on('click', function (e) {
                e.preventDefault();

                $filtersBTN = $(this);

                var search = $('#filter_name').val();
                var category = $('#category_id').find(":selected").val();
                var features = $('#feature_id').find(":selected").val();

                // if search
                if (search.length >= 2 || category > 0 || features > 0) {

                    // ajax to set the session values
                    BTN.loading($filtersBTN);
                    doAjax('/products/filter', {
                        search: search,
                        category: category,
                        features: features
                    }, function (response) {
                        // reset pagination results
                        pagination.showPage(1, true);

                        // slight delay before we reset
                        setTimeout(function () {
                            BTN.reset($filtersBTN);
                        }, 300);
                    });
                }
                return false;
            });
        })
    </script>
@endsection
