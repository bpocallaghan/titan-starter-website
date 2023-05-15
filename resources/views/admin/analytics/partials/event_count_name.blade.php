<div class="card card-outline card-primary" id="box-event-count-name" style="min-height: 400px;">
    <div class="card-header">
        <h4 class="float-left m-0">
            <span><i class="fa fa-hand-pointer"></i></span>
            <span>Event count by Event name</span>
        </h4>

        @include('admin.partials.boxes.toolbar')
    </div>

    <div class="card-body">
        <div class="loading-widget text-primary">
            <i class="fa fa-fw fa-spinner fa-spin"></i>
        </div>

        <table id="tbl-event-count-name" data-order-by="1|desc" class="table nowrap table-striped table-sm table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Event Name</th>
                <th>Event Count</th>
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

            initToolbarDateRange('#box-event-count-name .daterange', updateInterestsAffinity);

            function updateInterestsAffinity(start, end)
            {
                $('#box-event-count-name .loading-widget').show();

                if (datatable) {
                    datatable.destroy();
                    $('#box-event-count-name table tbody').html('')
                }

                if (!start) {
                    start = moment().subtract(29, 'days').format('YYYY-MM-DD');
                    end = moment().format('YYYY-MM-DD');
                }

                doAjax('/api/analytics/event-count-name', {
                    'start': start, 'end': end,
                }, renderTableInterestsAffinity);
            }

            function renderTableInterestsAffinity(data)
            {
                $('#box-event-count-name .loading-widget').slideUp();

                for (var i = 0; i < data.length; i++) {
                    var html = '<tr><td>' + data[i]['eventName'] + '</td><td>' + data[i]['eventCount'] + '</td></tr>';
                    $('#box-event-count-name table tbody').append(html);
                }

                datatable = initDataTables('#tbl-event-count-name');
            }

            setTimeout(function ()
            {
                updateInterestsAffinity();
            }, 300);
        })
    </script>
@endsection