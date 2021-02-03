@extends('admin.admin')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span>List All Photos</span>
            </h3>
        </div>

        <div class="card-body">

            @include('admin.partials.card.info')

            <table id="tbl-list" data-server="false" class="dt-table table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Belongs To</th>
                    <th>Image</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->name }} {{ $item->is_cover? '(Cover)':'' }}</td>
                        <td>{!! (($item->photoable)? $item->photoable->name:'').' <small>('.(isset($item->photoable)? (new \ReflectionClass($item->photoable))->getShortName() : 'The item this belonged to was removed.').')</small>' !!}</td>
                        <td>
                            <a href="{{ $item->url }}" data-lightbox="{{ $item->name }}" data-title="{{ $item->name }}">
                                <img style="height: 50px;" src="{{ $item->urlForName($item->thumb) }}" title="{{ $item->name }}">
                            </a>
                        </td>
                        <td>{{ $item->created_at->format('d M Y') }}</td>
                        <td>{!! action_row($selectedNavigation->url, $item->id, $item->name, ['delete']) !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
