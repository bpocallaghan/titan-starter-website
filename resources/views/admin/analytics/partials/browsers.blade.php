<div class="card card-outline card-primary" id="box-browsers" style="min-height: 400px;">
    <div class="card-header">
        <h4 class="float-left m-0">
            <span><i class="fab fa-chrome"></i></span>
            <span>Top Browsers</span>
        </h4>

        @include('admin.partials.boxes.toolbar')
    </div>

    <div class="card-body">
        <div class="loading-widget text-primary">
            <i class="fa fa-fw fa-spinner fa-spin"></i>
        </div>

        <canvas id="chart-browsers"></canvas>
    </div>
</div>

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function ()
        {
            var chart;

            initToolbarDateRange('#box-browsers .daterange', updateChart);

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

                $('#box-browsers .loading-widget').show();
                doAjax('/api/analytics/browsers', {
                    'start': start, 'end': end,
                }, createPieChart);
            }

            function createPieChart(data)
            {

                console.log(data);
                // total page views and visitors line chart
                var ctx = document.getElementById("chart-browsers").getContext("2d");

                var chart = new Chart(ctx, {
                    type: 'doughnut',
                    data: data
                });

                 $('#box-browsers .loading-widget').slideUp();
            }

            setTimeout(function ()
            {
                updateChart();
            }, 300);
        })
    </script>
@endsection