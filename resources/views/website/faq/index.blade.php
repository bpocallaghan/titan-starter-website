@extends('website.website')

@section('content')
    <section class="container body contact">

        <div class="row mb-5">
            <div class="col-12">
                <h2 class="page-header text-center">{!! isset($pageTitle) ? $pageTitle : $page->name !!}</h2>
            </div>
        </div>

        @foreach($items as $category)
            <div id="acc-category{{ $category->id }}">
                <div class="card card-success">
                    <div class="card-header">
                        <h4 class="card-title">
                            <a data-toggle="collapse" data-parent="#acc-category{{ $category->id }}" href="#body-category{{ $category->id }}" class="collapsed" aria-expanded="false">
                                {{ $category->name }}
                            </a>
                        </h4>
                    </div>
                    <div id="body-category{{ $category->id }}" class="panel-collapse in collapse">
                        <div class="card-body">
                            @foreach($category->faqs as $faq)
                                <div id="acc-faq{{ $faq->id }}" class="mb-2">
                                    <div class="card card-outline card-info">
                                        <div class="card-header">
                                            <h4 class="card-title">
                                                <a class="collapsed btn-toggle-question" data-id="{{ $faq->id }}" data-toggle="collapse" data-parent="#acc-faq{{ $faq->id }}" href="#body-faq{{ $faq->id }}">
                                                    {!! $faq->question !!}
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="body-faq{{ $faq->id }}" class="collapse collapse" data-id="{{ $faq->id }}">
                                            <div class="card-body">
                                                {!! $faq->answer !!}
                                            </div>

                                            <div id="faq-footer-{{ $faq->id }}" class="card-footer" style="border-top: 1px solid #ddd;">
                                                <div class="btn-group btn-group-sm">
                                                    <span class="btn" style="padding-left: 0px;">Was this question helpful?</span>
                                                    <a class="btn btn-success btn-helpful" href="#" data-id="{{ $faq->id }}" data-type="helpful_yes">
                                                        <i class="fa fa-thumbs-up"></i> Yes
                                                    </a>
                                                    <a class="btn btn-danger btn-helpful" href="#" data-id="{{ $faq->id }}" data-type="helpful_no">
                                                        <i class="fa fa-thumbs-down"></i> No
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
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
