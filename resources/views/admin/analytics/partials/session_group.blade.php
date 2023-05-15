<div class="card card-outline card-primary" id="box-group" style="min-height: 400px;">
    <div class="card-header">
        <h4 class="float-left m-0">
            <span><i class="far fa-file-alt"></i></span>
            <span>Top Source</span>
        </h4>

        @include('admin.partials.boxes.toolbar')
    </div>

    <div class="card-body">
        <div class="loading-widget text-primary">
            <i class="fa fa-fw fa-spinner fa-spin"></i>
        </div>

        <table id="tbl-group" data-order-by="1|desc" class="table nowrap table-striped table-sm table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Source</th>
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

            initToolbarDateRange('#box-group .daterange', updateKeywords);

            function updateKeywords(start, end)
            {
                $('#box-group .loading-widget').show();

                if (datatable) {
                    datatable.destroy();
                    $('#box-group table tbody').html('')
                }

                if (!start) {
                    start = moment().subtract(29, 'days').format('YYYY-MM-DD');
                    end = moment().format('YYYY-MM-DD');
                }

                doAjax('/api/analytics/session-group', {
                    'start': start, 'end': end,
                }, renderTableKeywords);
            }

            function renderTableKeywords(data)
            {
                $('#box-group .loading-widget').slideUp();

                for (var i = 0; i < data.length; i++) {
                    var html = '<tr><td>' + data[i]['sessionDefaultChannelGroup'] + '</td><td>' + data[i]['sessions'] + '</td></tr>';
                    $('#box-group table tbody').append(html);
                }

                datatable = initDataTables('#tbl-group');
            }

            setTimeout(function ()
            {
                updateKeywords();
            }, 300);
        })
    </script>
@endsection