@extends('admin.admin')

@section('content')

		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">
					<span>List All Product Features</span>
				</h3>
			</div>

			<div class="card-body">

				@include('admin.partials.card.info')

				@include('admin.partials.card.buttons')

				<table id="tbl-list" data-server="false" class="dt-table table table-striped table-bordered table-sm" cellspacing="0" width="100%">
					<thead>
					<tr>
						<th>Feature</th>
                         <th>Created</th>
						<th>Action</th>
					</tr>
					</thead>
					<tbody>
					@foreach ($items as $item)
						<tr>
							<td>{{ $item->name }}</td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
							<td>{!! action_row($selectedNavigation->url, $item->id, $item->name, ['edit', 'delete']) !!}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>

@endsection
