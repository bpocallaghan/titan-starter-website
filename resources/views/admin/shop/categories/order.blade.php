@extends('admin.admin')

@section('content')

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <span><i class="fa fa-align-center"></i></span>
                        <span>Update {{ ucfirst($resource) }} List Order</span>
                    </h3>
                </div>

                <div class="card-body">

                    @include('admin.partials.card.info')

                    <div id="nestable-menu">
                        <a href="javascript:window.history.back();" class="btn btn-labeled btn-secondary">
                            <span class="btn-label"><i class="fa fa-fw fa-chevron-left"></i></span>Back
                        </a>

                        <button type="button" class="btn btn-labeled btn-default text-primary" data-action="expand-all">
                            <span class="btn-label"><i class="fa fa-fw fa-plus-circle"></i></span>Expand All
                        </button>

                        <button type="button" class="btn btn-labeled btn-default text-primary" data-action="collapse-all">
                            <span class="btn-label"><i class="fa fa-fw fa-minus-circle text-red"></i></span>Collapse All
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="dd" id="listOrderSortable">
                                {!! $itemsHtml !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    @include('admin.partials.sortable')
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function ()
        {
            initSortableMenu("{{ Request::url() }}", "listOrderSortable");
        })
    </script>
@endsection
