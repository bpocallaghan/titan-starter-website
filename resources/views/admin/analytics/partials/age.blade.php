<div class="card card-outline card-primary" id="box-age" style="min-height: 400px;">
    <div class="card-header">
        <h4 class="float-left">
            <span><i class="fa fa-user-secret"></i></span>
            <span>Age</span>
        </h4>

        @include('admin.partials.boxes.toolbar')
    </div>

    <div class="card-body">
        <div class="loading-widget text-primary">
            <i class="fa fa-fw fa-spinner fa-spin"></i>
        </div>

        <canvas id="chart-age"></canvas>
    </div>
</div>

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function ()
        {
            var chart;

            initToolbarDateRange('#box-age .daterange', updateChart);

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

                $('#box-age .loading-widget').show();
                doAjax('/api/analytics/age', {
                    'start': start, 'end': end,
                }, createBarChart);
            }

            function createBarChart(data)
            {
                // total page views and visitors line chart
                var ctx = document.getElementById("chart-age").getContext("2d");

                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: data
                });

                $('#box-age .loading-widget').slideUp();
            }

            setTimeout(function ()
            {
                updateChart();
            }, 300);
        })
    </script>
@endsection