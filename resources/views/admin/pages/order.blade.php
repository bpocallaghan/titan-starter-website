@extends('admin.admin')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span><i class="fa fa-align-center"></i></span>
                <span>Update {{ ucfirst($resource) }} List Order</span>
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">

            @include('admin.partials.card.info')

            <div class="mb-3" role="group" aria-label="Page functionality" id="sortable-menu">
                <a href="javascript:window.history.back();" class="btn btn-secondary">
                    <span class="label"><i class="fa fa-fw fa-chevron-left"></i></span>Back
                </a>

                <button type="button" class="btn btn-light" data-action="expand-all">
                    <span class="label"><i class="fa fa-fw fa-plus-circle text-primary"></i></span>Expand
                    All
                </button>

                <button type="button" class="btn btn-light" data-action="collapse-all">
                    <span class="label"><i class="fa fa-fw fa-minus-circle text-red"></i></span>Collapse
                    All
                </button>
            </div>

            <div class="row">
                <div class="col col-12">
                    <div class="dd" id="pageOrderSortable" style="max-width: 100%">
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
        $(function () {
            initSortableMenu("{{ request()->url() }}", "pageOrderSortable");
        })
    </script>
@endsection
