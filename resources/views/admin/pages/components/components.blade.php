
<div class="card card-primary">
    <div class="card-header">
        <span>{!! $page->name !!}</span>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        @if(($page->sections->count() <= 1))
            <div class="alert alert-info">
                <h4 class="title">How to create Page Content Sections</h4>
                <ul>
                    <li>Click on Create Content</li>
                    <li>To update the page content click on the blue edit icon on the right hand side of the heading. </li>
                    <li>Update the list order by dragging the elements up or down. </li>
                    <li>Remove the content section by clicking on the red trash icon, also on the right hand side of the heading.  </li>
                </ul>
            </div>
        @endif

        <div class="mb-3" id="nestable-menu">
            <a href="javascript:window.history.back();" class="btn btn-secondary ">
                <i class="fa fa-fw fa-chevron-left"></i> Back
            </a>
            <a class="btn btn-primary" href="{{ (isset($url)? $url : request()->url()).'/content/create' }}">
                <span class="label"><i class="fa fa-fw fa-plus"></i></span>
                Create Content
            </a>
        </div>

        <div class="row">
            <div class="col col-12">

                <div class="dd-list list-group" id="pageContent">
                    @foreach($page->sections as $item)
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
                                            <a href="{{ "/admin/pages/{$page->id}/sections/content/{$item->id}/edit" }}" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit {{ $item->heading }}">
                                                <i class="fa fa-fw fa-edit"></i>
                                            </a>
                                        </div>

                                        <div class="btn-group">
                                            <form id="form-delete-row{{ $item->id }}" method="POST" action="{{ "/admin/pages/{$page->id}/sections/{$item->id}" }}">
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
    </div>
</div>

@section('scripts')
    @parent
    @include('admin.partials.sortable')
    <script type="text/javascript" charset="utf-8">
        $(function () {
            initSortableMenu("{{ (isset($url)? $url : request()->url()) }}/order", 'pageContent');
        })
    </script>
@endsection
