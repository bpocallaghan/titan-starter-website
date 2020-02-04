@extends('admin.admin')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <span><i class="fa fa-table"></i></span>
                        <span>List All Videos</span>
                    </h3>
                </div>

                <div class="box-body">

                    @include('admin.partials.info')

                    <table id="tbl-list" data-server="false" class="dt-table table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Video</th>
                            <th>Link</th>
                            <th>Custom Image</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->name }} {{ $item->is_cover? '(Cover)':'' }}</td>
                                <td>{{ (isset($item->photoable) && $item->photoable->name)? $item->photoable->name:(new \ReflectionClass($item->photoable))->getShortName() }}</td>
                                <td>
                                    <figure>
                                        <iframe width="315" height="177" src="@if($item->is_youtube) {{ 'https://www.youtube.com/embed/'.$item->link}} @else {{ $item->link }} @endif" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </figure>
                                </td>
                                <td>
                                    <a target="_blank" href="@if($item->is_youtube) {{ 'https://www.youtube.com/embed/'.$item->link}} @else {{ $item->link }} @endif">@if($item->is_youtube) {{ 'https://www.youtube.com/embed/'.$item->link}} @else {{ $item->link }} @endif</a>
                                </td>
                                <td>
                                    @if(isset($item->image))
                                        <a target="_blank" href="{{ $item->imageUrl }}">
                                            <img style="height: 50px;" src="{{ $item->thumbUrl }}" title="{{ $item->name }}">
                                        </a>
                                    @endif
                                </td>
                                <td>{{ $item->created_at->format('d M Y') }}</td>
                                <td>{!! action_row($selectedNavigation->url, $item->id, $item->name, ['delete']) !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
