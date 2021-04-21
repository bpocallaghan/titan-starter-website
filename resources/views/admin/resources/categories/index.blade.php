@extends('admin.admin')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span>List All Resource Categories</span>
            </h3>
        </div>

        <div class="card-body">
            @include('admin.partials.card.info')

            @include('admin.partials.card.buttons')

            <table id="tbl-list" data-server="false" class="dt-table table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Total Resources</th>
                    <th>Photos</th>
                    <th>Videos</th>
                    <th>Documents</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>
                            @if(isset($item->photos)) {!! 'Photos: '.$item->photos->count() !!} @endif
                            @if(isset($item->videos)) {!! '<br> Videos: '.$item->videos->count() !!} @endif
                            @if(isset($item->documents)) {!! '<br> Documents: '.$item->documents->count() !!} @endif
                        </td>
                        <td>
                            @if(isset($item->photos))
                                @foreach($item->photos as $photo)
                                    <a href="{{ $photo->url }}" data-lightbox="{{ $photo->name }}"><i class="fa fa-fw fa-image"></i> {{ $photo->name }}</a> {{ $loop->last?'':' | ' }}
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if(isset($item->videos))
                                @foreach($item->videos as $video)
                                    <a target="_blank" href="@if($video->is_youtube) {{ 'https://www.youtube.com/watch?v='.$video->link}} @else {{ $video->link }} @endif"><i class="fa fa-fw fa-video"></i>  {{ $video->name }}</a> {{ $loop->last?'':' | ' }}
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if(isset($item->documents))
                                @foreach($item->documents as $document)
                                    <a target="_blank" href="{{ $document->url }}"><i class="fa fa-fw fa-file-pdf"></i> {{ $document->name }}</a>{{ $loop->last?'':' | ' }}
                                @endforeach
                            @endif
                        </td>
                        <td>{{ $item->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="/admin/resources/resource-category/{{ $item->id }}/resources" class="btn btn-info btn-xs" data-toggle="tooltip" title="Add Resources">
                                    <i class="fas fa-fw fa-photo-video"></i>
                                </a>
                            </div>
                            {!! action_row($selectedNavigation->url, $item->id, $item->name, ['edit', 'delete'], false) !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
