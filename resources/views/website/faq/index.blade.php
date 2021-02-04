@extends('website.website')

@section('content')
    <section class="container body contact">

        <div class="row mb-5">
            <div class="col-12">
                <h2 class="page-header text-center">{!! isset($pageTitle) ? $pageTitle : $page->name !!}</h2>
            </div>
        </div>

        @include('website.pages.page_components', ['item' => $page])

    </section>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function () {

            $('.btn-toggle-question').on('click', function (e) {

                if ($(this).hasClass('collapsed')) {
                    $.post('/faq/question/' + $(this).attr('data-id') + '/total_read');
                }
            });

            $('.btn-helpful').on('click', function (e) {
                e.preventDefault();

                // show spinner
                var $footer = $('#faq-footer-' + $(this).attr('data-id'));
                $footer.html("<i class=\"fa fa-spinner fa-spin text-primary text-sm\"></i>");

                // post and show response
                $.post('/faq/question/' + $(this).attr('data-id') + '/' + $(this).attr('data-type'), function () {
                    $footer.html("<div><small><span class=\"text-muted\">Thank you for your feedback.</span></small></div>");
                });
                return false;
            });
        })
    </script>
@endsection
