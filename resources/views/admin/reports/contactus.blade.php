@extends('admin.admin')

@section('content')

            <div class="card card-primary" id="box-main-chart">
                <div class="card-header">
                    <h3 class="card-title">
                        <span><i class="fa fa-comment-o"></i></span>
                        <span>Contact Us</span>
                    </h3>

                    @include('admin.partials.boxes.toolbar')
                </div>

                <div class="card-body">

                    <div class="loading-widget text-primary">
                        <i class="fa fa-fw fa-spinner fa-spin"></i>
                    </div>

                    <canvas id="line-chart"></canvas>

                    <hr/>

                    <table data-order-by="4|desc" id="main-datatable" class="table table-striped table-bordered table-sm" width="100%">
                        <thead>
                        <tr>
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Content</th>
                            <th>Belongs To</th>
                            <th>Created On</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

@endsection

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        function onUpdate(start, end)
        {
            if ( $.fn.DataTable.isDataTable('#main-datatable') ) {
                $('#main-datatable').DataTable().destroy();
            }

            datatable = initDatatablesAjax('#main-datatable', "{{ request()->url() }}" + "/datatable?date_from=" + start + '&date_to=' + end, [

                {data: 'fullname', name: 'fullname'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'content', name: 'content'},
                {data: 'type', name: 'type'},
                {data: 'date', name: 'date'},
            ]);
        }


        var chart;

        initToolbarDateRange('#box-main-chart .daterange', updateChart);

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

            $('.loading-widget').show();
            doAjax("{{ isset($url)? $url : request()->url() . '/chart' }}", {
                'start': start, 'end': end,
            }, createLineChart);

            if (typeof onUpdate != 'undefined' && isFunction(onUpdate)) {
                onUpdate(start, end);
            }

        }

        function createLineChart(data)
        {

            // total page views and visitors line chart
            var ctx = document.getElementById("line-chart").getContext("2d");

            var chart = new Chart(ctx, {
                type: 'line',
                data: data,
                options: {
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

            $('.loading-widget').slideUp();
        }

        setTimeout(function ()
        {
            updateChart();
        }, 300);


    </script>
@endsection
