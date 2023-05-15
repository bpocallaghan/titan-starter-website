<div class="card card-outline card-primary" id="box-referrers" style="min-height: 400px;">
    <div class="card-header">
        <h4 class="float-left m-0">
            <span><i class="far fa-link"></i></span>
            <span>Top Referrals</span>
        </h4>

        @include('admin.partials.boxes.toolbar')
    </div>

    <div class="card-body">
        <div class="loading-widget text-primary">
            <i class="fa fa-fw fa-spinner fa-spin"></i>
        </div>

        <table id="tbl-referrers" data-order-by="1|desc" class="table nowrap table-striped table-sm table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>URL</th>
                <th>Page Views</th>
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

            initToolbarDateRange('#box-referrers .daterange', updateReferrers);

            function updateReferrers(start, end)
            {
                $('#box-referrers .loading-widget').show();

                if (datatable) {
                    datatable.destroy();
                    $('#box-referrers table tbody').html('')
                }

                if (!start) {
                    start = moment().subtract(29, 'days').format('YYYY-MM-DD');
                    end = moment().format('YYYY-MM-DD');
                }

                doAjax('/api/analytics/referrers', {
                    'start': start, 'end': end,
                }, renderTableReferrers);
            }

            function renderTableReferrers(data)
            {
                $('#box-referrers .loading-widget').slideUp();

                for (var i = 0; i < data.length; i++) {
                    var html = '<tr><td>' + data[i]['pageReferrer'] + '</td><td>' + data[i]['screenPageViews'] + '</td></tr>';
                    $('#box-referrers table tbody').append(html);
                }

                datatable = initDataTables('#tbl-referrers');
            }

            setTimeout(function ()
            {
                updateReferrers();
            }, 300);
        })
    </script>
@endsection