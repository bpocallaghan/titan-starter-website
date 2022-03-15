@extends('admin.admin')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                List All Pages
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            @include('admin.partials.card.info')

            <div class="mb-3" role="group" aria-label="Page functionality">
                <a href="{{ request()->url().'/create' }}"  class="btn btn-primary">
                    <i class="fa fa-fw fa-plus"></i> Create {{ ucfirst($resource) }}
                </a>

                <a href="{{ request()->url().'/order' }}" class="btn btn-light">
                    <i class="fa fa-fw fa-align-center"></i> General Order
                </a>
                <a href="{{ request()->url().'/order/featured' }}"class="btn btn-light">
                    <i class="fa fa-fw fa-align-center"></i> Featured Order
                </a>
                <a href="{{ request()->url().'/order/header' }}" class="btn btn-light">
                    <i class="fa fa-fw fa-align-center"></i> Header Order
                </a>
                <a href="{{ request()->url().'/order/footer' }}" class="btn btn-light">
                    <i class="fa fa-fw fa-align-center"></i> Footer Order
                </a>
            </div>

            {{--<div class="card">--}}
                {{--<div class="card-body">--}}
                    {{--<a class="btn btn-labeled btn-primary mb-3" href="{{ request()->url().'/create' }}">--}}
                        {{--<span class="btn-label"><i class="fa fa-fw fa-plus"></i></span>Create {{ ucfirst($resource) }}--}}
                    {{--</a>--}}

                    {{--<a class="btn btn-labeled btn-default text-black mb-3" href="{{ request()->url().'/order' }}">--}}
                        {{--<span class="btn-label"><i class="fa fa-fw fa-align-center"></i></span>General--}}
                        {{--Order--}}
                    {{--</a>--}}

                    {{--<a class="btn btn-labeled btn-default text-black mb-3" href="{{ Request::url().'/order/featured' }}">--}}
                        {{--<span class="btn-label"><i class="fa fa-fw fa-align-center"></i></span>--}}
                        {{--Featured Order--}}
                    {{--</a>--}}

                    {{--<a class="btn btn-labeled btn-default text-black mb-3" href="{{ request()->url().'/order/header' }}">--}}
                        {{--<span class="btn-label"><i class="fa fa-fw fa-align-center"></i></span>--}}
                        {{--Header Order--}}
                    {{--</a>--}}

                    {{--<a class="btn btn-labeled btn-default text-black mb-3" href="{{ request()->url().'/order/footer' }}">--}}
                        {{--<span class="btn-label"><i class="fa fa-fw fa-align-center"></i></span>--}}
                        {{--Footer Order--}}
                    {{--</a>--}}
                {{--</div>--}}
            {{--</div>--}}

            <table id="tbl-list" data-page-length="25" class="dt-table table table-sm table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>Page</th>
                    <th>Description</th>
                    <th>Url</th>
                    <th>Parent</th>
                    <th>Page Views</th>
                    <th style="min-width: 115px;">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{!! $item->description !!}</td>
                        <td>{!! $item->url !!}</td>
                        <td>{{ ($item->parent)? $item->parent->title : '-' }}</td>
                        <td>{{ $item->views }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="/admin/pages/{{ $item->id }}/sections" class="btn btn-info btn-xs" data-toggle="tooltip" title="Manage Page Content">
                                    <i class="far fa-fw fa-file-alt"></i>
                                </a>
                            </div>
                            {!! action_row($selectedNavigation->url, $item->id, $item->name, ['edit', 'delete'], false) !!}
                            <a target="_blank" href="{{ $item->url }}" class="btn btn-light btn-xs" data-toggle="tooltip" title="View Page">
                                <i class="far fa-fw fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
