<div class="card card-outline card-primary" id="box-gender" style="min-height: 400px;">
    <div class="card-header">
        <h4 class="float-left m-0">
            <span><i class="fa fa-female"></i></span>
            <span>Gender</span>
        </h4>

        @include('admin.partials.boxes.toolbar')
    </div>

    <div class="card-body">
        <div class="loading-widget text-primary">
            <i class="fa fa-fw fa-spinner fa-spin"></i>
        </div>

        {{--<div id="chart-gender-legend" class="chart-legend" style="margin-bottom: 5px;"></div>--}}
        <canvas id="chart-gender"></canvas>
    </div>
</div>

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function ()
        {
            var chart;

            initToolbarDateRange('#box-gender .daterange', updateChart);

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

                $('#box-gender .loading-widget').show();
                doAjax('/api/analytics/gender', {
                    'start': start, 'end': end,
                }, createPieChart);
            }

            function createPieChart(data)
            {
                // total page views and visitors line chart
                var ctx = document.getElementById("chart-gender").getContext("2d");

                var chart = new Chart(ctx, {
                    type: 'doughnut',
                    data: data
                });

                 $('#box-gender .loading-widget').slideUp();

            }

            setTimeout(function ()
            {
                updateChart();
            }, 300);
        })
    </script>
@endsection