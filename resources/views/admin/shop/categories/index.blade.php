@extends('admin.admin')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span>List All Product Categories</span>
            </h3>
        </div>

        <div class="card-body">

            @include('admin.partials.card.info')

            @include('admin.partials.card.buttons', ['order' => true])

            <table id="tbl-list" data-server="false" class="dt-table table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Product Category</th>
                    <th>Url</th>
                    <th>Parent</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{!! $item->url !!}</td>
                        <td>{{ ($item->parent)? $item->parent->name : '-' }}</td>
                        <td>{!! image_row_link($item->name, $item->image_thumb, $item->image) !!}</td>
                        <td>{!! action_row($selectedNavigation->url, $item->id, $item->name, ['edit', 'delete']) !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
