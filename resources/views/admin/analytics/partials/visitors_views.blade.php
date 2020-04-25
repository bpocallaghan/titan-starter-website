<div class="card card-outline card-primary" id="box-total-views">
    <div class="card-header">
        <h4 class="float-left m-0">
            <span><i class="fa fa-users"></i></span>
            <span>Total Page Views</span>
        </h4>

        @include('admin.partials.boxes.toolbar')
    </div>

    <div class="card-body">
        <div class="loading-widget text-primary">
            <i class="fa fa-fw fa-spinner fa-spin"></i>
        </div>

        <canvas id="chart-page-views" style="height: 400px;"></canvas>
    </div>
</div>

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function ()
        {
            var chart;

            initToolbarDateRange('#box-total-views .daterange', updateChart);

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

                $('#box-total-views .loading-widget').show();
                doAjax('/api/analytics/visitors-views', {
                    'start': start, 'end': end,
                }, createLineChart);
            }

            function createLineChart(data)
            {

                // total page views and visitors line chart
                var ctx = document.getElementById("chart-page-views").getContext("2d");

                var chart = new Chart(ctx, {
                    type: 'line',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        tooltips: {
                            mode: 'label',
                            enabled: true,
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ' - ' + tooltipItem.yLabel ;
                                }
                            }
                        }
                    }
                });

                 $('#box-total-views .loading-widget').slideUp();
            }

            setTimeout(function ()
            {
                updateChart();
            }, 300);
        })
    </script>
@endsection