@extends('admin.admin')

@section('content')

            <div id="js-box-datatable" class="card card-primary">
                <div class="card-header">
                    @include('admin.partials.boxes.datatable_toolbar', [
                        'title' => 'Top Keywords for Product searches'
                    ])
                </div>

                <div class="card-body">
                    <table id="tbl-list" data-server="true" data-order-by="1|desc" class="dt-table table nowrap table-striped table-bordered table-sm" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Slug</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

@endsection

@include('admin.partials.datatables', [
    'action' => false,
    'displayLength' => 25,
    'options' => [
        ['data' => 'slug', 'name' => 'slug'],
        ['data' => 'total', 'name' => 'total'],
]])