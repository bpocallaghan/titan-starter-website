<div class="card card-outline card-primary" id="box-device-category" style="min-height: 400px;">
    <div class="card-header">
        <h4 class="float-left m-0">
            <span><i class="fa fa-tv"></i></span>
            <span>Device Category</span>
        </h4>

        @include('admin.partials.boxes.toolbar')
    </div>

    <div class="card-body">
        <div class="loading-widget text-primary">
            <i class="fa fa-fw fa-spinner fa-spin"></i>
        </div>

        <canvas id="chart-device-category"></canvas>
    </div>
</div>

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function ()
        {
            var chart;

            initToolbarDateRange('#box-device-category .daterange', updateChart);

            /**
             * Get the chart's data
             * @param view
             */
            function updateChart(start, end)
            {
                if (chart) {
                    chart.destroy();
                }

                if (!start) {
                    start = moment().subtract(29, 'days').format('YYYY-MM-DD');
                    end = moment().format('YYYY-MM-DD');
                }

                $('#box-device-category .loading-widget').show();
                doAjax('/api/analytics/device-category', {
                    'start': start, 'end': end,
                }, createPieChart);
            }

            function createPieChart(data)
            {
                // total page views and visitors line chart
                var ctx = document.getElementById("chart-device-category").getContext("2d");

                var chart = new Chart(ctx, {
                    type: 'doughnut',
                    data: data
                });

                 $('#box-device-category .loading-widget').slideUp();

            }

            setTimeout(function ()
            {
                updateChart();
            }, 300);
        })
    </script>
@endsection