<h3 class="card-title">
    <span>{{ isset($title)? $title:'DataTable' }}
        ({{ $fromDate->format('l, d F') }} - {{ $toDate->format('l, d F') }})
    </span>
</h3>

<div class="float-right box-tools">
    <a href="{{ request()->url() }}/datatable/reset" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Reset Date Filter">
        <i class="fa fa-refresh"></i>
    </a>

    <button type="button" class="btn btn-primary btn-sm daterange" data-toggle="tooltip" title="Date range">
        <i class="fa fa-calendar"></i>
    </button>

    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fas fa-minus"></i>
    </button>
</div>

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function ()
        {
            initDateRangeLatest('#js-box-datatable .daterange', updateDatatables);

            function updateDatatables(start, end)
            {
                doAjax('{{ request()->url() }}/datatable/dates', {
                    'date_from': start, 'date_to': end,
                }, function ()
                {
                    location.reload();
                });
            }
        })
    </script>
@endsection