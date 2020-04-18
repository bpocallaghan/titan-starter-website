@extends('admin.admin')

@section('content')

    <div class="card card-primary">
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
                    <th>User</th>
                    <th>Action</th>
                    <th>After</th>
                    <th>Before</th>
                    <th>Created</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $activity)
                    <tr>
                        <td>{{ $activity->id }}</td>
                        <td>{{ isset($activity->user)? $activity->user->fullname:'System' }}</td>
                        <td>{!! $activity->name !!}</td>
                        <td><p>{!! activity_after($activity) !!}</p></td>
                        <td><p>{!! activity_before($activity) !!}</p></td>
                        {{--<td>{{ isset($activity->subject)? isset($activity->subject->title)? $activity->subject->title:'':'' }}</td>--}}
                        <td>{{ $activity->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
