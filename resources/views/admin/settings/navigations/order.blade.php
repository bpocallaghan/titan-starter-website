@extends('admin.admin')

@section('content')
    <div class="card <!--card-outline--> card-secondary">
        <div class="card-header">
            <h3 class="card-title">
                Update {{ ucfirst($resource) }} List Order
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">

            @include('admin.partials.info')

            <div class="card" id="nestable-menu">
                <div class="card-body">
                    <a href="javascript:window.history.back();" class="btn btn-labeled btn-default">
                        <span class="btn-label"><i class="fa fa-fw fa-chevron-left"></i></span>Back
                    </a>

                    <button type="button" class="btn btn-labeled btn-default text-primary" data-action="expand-all">
                        <span class="btn-label"><i class="fa fa-fw fa-plus-circle"></i></span>Expand
                        All
                    </button>

                    <button type="button" class="btn btn-labeled btn-default text-primary" data-action="collapse-all">
                        <span class="btn-label"><i class="fa fa-fw fa-minus-circle text-red"></i></span>Collapse
                        All
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="dd" id="dd-navigation" style="max-width: 100%">
                        {!! $itemsHtml !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.nestable')
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function () {
            initNestableMenu(4, "{{ request()->url() }}");
        })
    </script>
@endsection
