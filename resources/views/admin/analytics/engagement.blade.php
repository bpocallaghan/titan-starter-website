@extends('admin.admin')

@section('content')
    {{-- engagement --}}
    <style>
        .small-box h3, .small-box p {
            z-index: 9999999999;
        }

        .small-charts {
            width: 90px !important;
            height: 60px;
        }

        .small-box .icon-chart {
            position: absolute;
            top: 15px;
            right: 5px;
            z-index: 0;
        }
    </style>

    <div class="row">
        <div class="col-lg col-6">
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3 id="engagement-time-user">&nbsp;</h3>
                    <p>Average Engagement Time </p>

                    <div class="icon-chart">
                        <canvas class="small-charts" id="chart-engagement-time-user" width="80px" height="50px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg col-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3 id="engaged-sessions-user">&nbsp;</h3>
                    <p>Average Engaged sessions per User</p>

                    <div class="icon-chart">
                        <canvas class="small-charts" id="chart-engaged-sessions-user" width=80px" height="50px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg col-6">
            <div class="small-box bg-purple">
                <div class="inner">
                    <h3 id="event-count">&nbsp;</h3>
                    <p>Total Event Count</p>

                    <div class="icon">
                        <i class="fas fa-plus"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg col-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3 id="sessions-engaged">&nbsp;</h3>
                    <p>Sessions Engaged</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tachometer-alt"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-8">
            @include('admin.analytics.partials.engagement_views')
        </div>

        <div class="col-md-4">
            @include('admin.analytics.partials.event_count_name')
        </div>
    </div>
@endsection


@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function () {
            function getMonthlySummary()
            {
                doAjax('/api/analytics/engagement-time-user', null, function (response) {
                   $('#engagement-time-user').html(parseFloat(response.data['datasets'][0]['data'][0]).toFixed(2));
                    doughnutChart('chart-engagement-time-user', response.data);
                });

                doAjax('/api/analytics/engaged-sessions-user', null, function (response) {
                    $('#engaged-sessions-user').html(parseFloat(response.data['datasets'][0]['data'][0]).toFixed(2));
                    doughnutChart('chart-engaged-sessions-user', response.data);
                });

                doAjax('/api/analytics/event-count', null, function (response) {
                    $('#event-count').html((parseFloat(response.data)));
                });

                doAjax('/api/analytics/sessions-engaged', null, function (response) {
                    $('#sessions-engaged').html((parseFloat(response.data) * 100).toFixed(2) + '<sup>%</sup>');
                });

            }

            function doughnutChart(id, data)
            {
                // total page views and engagement-time-user line chart
                var ctx = document.getElementById(id).getContext("2d");

                var chart = new Chart(ctx, {
                    type: 'doughnut',
                    data: data,
                    options: {
                        legend: {
                            display: false
                        }
                    }
                });

            }

            getMonthlySummary();
        })
    </script>
@endsection