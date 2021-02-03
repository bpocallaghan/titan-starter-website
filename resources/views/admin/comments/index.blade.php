@extends('admin.admin')

@section('content')
	<div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">List All Comments</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            @include('admin.partials.card.info')

            {{-- @include('admin.partials.card.buttons') --}}

            <table id="tbl-list" data-page-length="25" class="dt-table table table-sm table-bordered table-striped table-hover">
                <thead>
				<tr>
					<th>Comment</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Belongs To</th>
					<th>Created</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
                @foreach ($items as $item)
					<tr>
                        <td>{!! $item->content !!}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{!! (($item->commentable)? $item->commentable->name:'').' <small>('.(new \ReflectionClass($item->commentable))->getShortName().')</small>' !!}</td>
						<td>{{ $item->created_at->format('d M Y') }}</td>
                        <td>
                            {!! action_row($selectedNavigation->url, $item->id, $item->name, ['show', 'edit', 'delete']) !!}
                            @if($item->is_approved == 1) <span class="badge badge-success">Approved</span> @else <span class="badge badge-warning">Not Approved</span> @endif
                        </td>
					</tr>
				@endforeach
				</tbody>
            </table>
        </div>
    </div>
@endsection
