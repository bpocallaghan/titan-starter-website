@extends('admin.admin')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <span>List All Documents</span>
        </div>

        <div class="card-body">

            @include('admin.partials.card.info')

            <table id="tbl-list" data-server="false" data-page-length="25" class="dt-table table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Belongs To</th>
                    <th>Document</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->name }} {{ $item->is_cover? '(Cover)':'' }}</td>
                        <td>{!! (($item->documentable)? $item->documentable->name:'').' <small>('.(isset($item->documentable)? (new \ReflectionClass($item->documentable))->getShortName() : 'The item this belonged to was removed.').')</small>' !!}</td>
                        <td>
                            <a target="_blank" href="{{ $item->url }}">
                                <img style="height: 50px;" src="{{ $item->url }}" title="{{ $item->name }}">
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
