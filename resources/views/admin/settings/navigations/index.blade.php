@extends('admin.admin')

@section('content')


    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                List All Navigation's
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            @include('admin.partials.card.info')

            @include('admin.partials.card.buttons', ['order' => true])

            <table id="tbl-list" data-page-length="25" class="dt-table table table-sm table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th class="desktop">Description</th>
                    <th>Slug</th>
                    <th>Url</th>
                    <th>Parent</th>
                    <th>Roles</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{!! $item->description !!}</td>
                        <td>{{ $item->slug }}</td>
                        <td>{{ $item->url }}</td>
                        <td>{{ ($item->parent)? $item->parent->title : '-' }}</td>
                        <td>{{ $item->rolesString }}</td>
                        <td>
                            {!! action_row($selectedNavigation->url, $item->id, $item->title, ['edit', 'delete']) !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
