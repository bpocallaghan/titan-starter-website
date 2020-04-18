@extends('admin.admin')

@section('content')
    <div class="card  card-primary">
        <div class="card-header">
            <h3 class="card-title">List All Website Activities</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <table id="tbl-list" data-page-length="25" data-order-by="0|desc" class="dt-table table table-sm table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Created</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $action)
                    <tr>
                        <td>{!! $action->id !!}</td>
                        <td>{!! $action->name !!}</td>
                        <td>{!! $action->description !!}</td>
                        <td>{{ $action->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
