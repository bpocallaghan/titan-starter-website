
@if(($section->components->count() >= 1))
    <div class="row">
        <div class="col col-12" id="content-{{$section->id}}">

            <div class="dd-list list-group">
                @foreach($section->components->sortBy('list_order') as $item)
                    <div class="dd-item list-group-item card mb-2" data-id="{{ $item->id }}">

                        <div class="d-flex">
                            <button type="button" class="dd-handle btn btn-outline-secondary float-left mr-3" href="#"> <i class="fa fa-list"></i> </button>

                            <div class="float-left flex-fill">

                                <h5 class="mb-1">{{ $item->heading }}
                                    <span class="text-muted">
                                        ({{ $item->heading_element }})
                                    </span>
                                </h5>

                                @if($item->media)
                                    <a href="{{ $item->imageUrl }}" data-lightbox="Featured Image" title="{{ $item->caption }}"><img class="img-fluid mr-2 float-left" src="{{ $item->thumbUrl }}" alt="{{ $item->caption }}" style="height: 25px;"></a>
                                @endif
                                <p class="mb-1">{!! $item->summary !!}</p>

                                <div class="resources">

                                    @foreach($item->documents as $document)
                                        <a href="{{ $document->url }}" title="{{ $document->name }}" target="_blank" class="btn btn-xs btn-outline-secondary">{{ $document->name }}</a>
                                    @endforeach

                                    @foreach($item->photos->sortBy('list_order') as $photo)
                                        <a href="{{ $photo->url }}" title="{{ $photo->name }}" data-lightbox="Content Gallery"><img class="img-fluid" src="{{ $photo->thumb_url }}" alt="{{ $photo->name }}" style="height: 30px;"></a>
                                    @endforeach

                                </div>

                            </div>

                            <div class="float-right">
                                <div class="dt-table text-right mb-1" data-server="true">
                                    <div class="btn-group">
                                        <a href="{{ "/admin/{$resource}/{$resourceable->id}/sections/{$section->id}/content/{$item->id}/edit" }}" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit {{ $item->heading }}">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>
                                    </div>

                                    <div class="btn-group">
                                        <form id="form-delete-row{{ $item->id }}" method="POST" action="{{ "/admin/{$resource}/{$resourceable->id}/sections/{$section->id}/content/{$item->id}" }}/remove">
                                            <input name="_method" type="hidden" value="POST">
                                            <input name="_id" type="hidden" value="{{ $item->id }}">
                                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                            <a data-form="form-delete-row{{ $item->id }}" class="btn btn-warning text-light btn-xs btn-delete-row" data-toggle="tooltip" title="Remove {{ $item->heading }}">
                                                <i class="far fa-fw fa-times"></i>
                                            </a>
                                        </form>
                                    </div>

                                    <div class="btn-group">
                                        <form id="form-delete-row{{ $item->id }}" method="POST" action="{{ "/admin/{$resource}/{$resourceable->id}/sections/{$section->id}/content/{$item->id}" }}">
                                            <input name="_method" type="hidden" value="DELETE">
                                            <input name="_id" type="hidden" value="{{ $item->id }}">
                                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                            <a data-form="form-delete-row{{ $item->id }}" class="btn btn-danger text-light btn-xs btn-delete-row" data-toggle="tooltip" title="Delete {{ $item->heading }}">
                                                <i class="far fa-fw fa-trash-alt"></i>
                                            </a>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function () {
            initSortableMenu("{{ (isset($url)? $url.'/'.$section->id.'/content' : request()->url().'/'.$section->id.'/content') }}/order", 'content-{{$section->id}}', false);
        })
    </script>
@endsection
