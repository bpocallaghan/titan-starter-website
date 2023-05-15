<div class="card card-outline card-primary" id="box-resolution" style="min-height: 400px;">
    <div class="card-header">
        <h4 class="float-left">
            <span><i class="fa fa-user-secret"></i></span>
            <span>Resolution</span>
        </h4>

        @include('admin.partials.boxes.toolbar')
    </div>

    <div class="card-body">
        <div class="loading-widget text-primary">
            <i class="fa fa-fw fa-spinner fa-spin"></i>
        </div>

        <canvas id="chart-resolution"></canvas>
    </div>
</div>

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function ()
        {
            var chart;

            initToolbarDateRange('#box-resolution .daterange', updateChart);

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

                $('#box-resolution .loading-widget').show();
                doAjax('/api/analytics/resolution', {
                    'start': start, 'end': end,
                }, createBarChart);
            }

            function createBarChart(data)
            {
                // total presolution views and visitors line chart
                var ctx = document.getElementById("chart-resolution").getContext("2d");

                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: data
                });

                $('#box-resolution .loading-widget').slideUp();
            }

            setTimeout(function ()
            {
                updateChart();
            }, 300);
        })
    </script>
@endsection