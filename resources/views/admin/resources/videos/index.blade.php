@extends('admin.admin')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span>List All Videos</span>
            </h3>
        </div>

        <div class="card-body">

            @include('admin.partials.card.info')

            <table id="tbl-list" data-server="false" class="dt-table table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Belongs To</th>
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
                        <td>{!! (($item->videoable)? $item->videoable->name:'').' <small>('.(isset($item->videoable)? (new \ReflectionClass($item->videoable))->getShortName() : 'The item thiss belonged to was removed.').')</small>' !!}</td>
                        <td>
                            @if(!isset($item->filename))
                                <figure>
                                    <iframe width="315" height="177" src="@if($item->is_youtube) {{ 'https://www.youtube.com/embed/'.$item->link}} @else {{ $item->link }} @endif" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </figure>
                            @else
                                <figure id="video-viewport" style="max-width: 315px; max-height: 177px;">
                                    <video id="video-{{$item->id}}" width="315px" height="177px" preload="auto" controls muted="" src="{{$item->url}}">
                                        <source src="{{$item->url}}" type="video/mp4">
                                    </video>
                                </figure>
                            @endif
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
@endsection
