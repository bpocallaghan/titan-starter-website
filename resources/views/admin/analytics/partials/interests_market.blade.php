<div class="card card-outline card-primary" id="box-interests-market" style="min-height: 400px;">
    <div class="card-header">
        <h4 class="float-left m-0">
            <span><i class="fas fa-store"></i></span>
            <span>Top Interests In Market</span>
        </h4>

        @include('admin.partials.boxes.toolbar')
    </div>

    <div class="card-body">
        <div class="loading-widget text-primary">
            <i class="fa fa-fw fa-spinner fa-spin"></i>
        </div>

        <table id="tbl-interests-market" data-order-by="1|desc" class="table nowrap table-striped table-sm table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Category</th>
                <th>Sessions</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function ()
        {
            var datatable;

            initToolbarDateRange('#box-interests-market .daterange', updateInterestsMarket);

            function updateInterestsMarket(start, end)
            {
                $('#box-interests-market .loading-widget').show();

                if (datatable) {
                    datatable.destroy();
                    $('#box-interests-market table tbody').html('')
                }

                if (!start) {
                    start = moment().subtract(29, 'days').format('YYYY-MM-DD');
                    end = moment().format('YYYY-MM-DD');
                }

                doAjax('/api/analytics/interests-market', {
                    'start': start, 'end': end,
                }, renderTableInterestsMarket);
            }

            function renderTableInterestsMarket(data)
            {
                $('#box-interests-market .loading-widget').slideUp();

                for (var i = 0; i < data.length; i++) {
                    var html = '<tr><td>' + data[i][0] + '</td><td>' + data[i][1] + '</td></tr>';
                    $('#box-interests-market table tbody').append(html);
                }

                datatable = initDataTables('#tbl-interests-market');
            }

            setTimeout(function ()
            {
                updateInterestsMarket();
            }, 300);
        })
    </script>
@endsection