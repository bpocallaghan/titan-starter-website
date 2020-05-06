@extends('admin.admin')

@section('content')

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <span><i class="fa fa-bar-chart"></i></span>
                        <span>Summaries</span>
                    </h3>
                </div>

                <div class="card-body">

                    @include('admin.partials.card.info')

                    <table class="table table-striped table-bordered table-hover table-sm" width="100%">
                        <thead>
                        <tr>
                            <th data-class="expand">Description</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{!! $item[0] !!}</td>
                                <td>{!! $item[1] !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

@endsection
