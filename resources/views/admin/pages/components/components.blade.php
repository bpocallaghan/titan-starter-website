<!--card-outline-->
<div class="card card-secondary">
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
                    <li>Update the list order by dragging the headings up or down.</li>
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
                <div class="dd" id="dd-navigation" style="max-width: 100%">
                    <ol class="dd-list">
                        @foreach($page->sections as $item)
                            <li class="dd-item" data-id="{{ $item->id }}">
                                <div class="dt-table float-right mt-3 mr-3" data-server="true">
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
                                <div class="dd-handle">
                                    <div>
                                        <span class="text-bold text-lg">
                                            {{ $item->heading }}
                                            <span class="text-muted">
                                                ({{ $item->heading_element }})
                                            </span>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="media">
                                            @if($item->media)
                                                <a href="{{ $item->url }}" data-lightbox="Featured Image"><img class=img-fluid" src="{{ $item->thumbUrl }}" style="height: 30px;"></a>
                                            @endif
                                            <div class="media-body ml-1">
                                                {!! $item->summary !!}
                                            </div>
                                        </div>

                                        @foreach($item->documents as $document)
                                            <a href="{{ $document->url }}" target="_blank">{{ $document->name }}</a>{{ $loop->last?'':' | ' }}
                                        @endforeach

                                        @foreach($item->photos as $photo)
                                            <a href="{{ $item->url }}" data-lightbox="Content Gallery"><img class=img-fluid" data-lightbox="Featured Image" src="{{ $photo->thumb_url }}" style="height: 30px;"></a>
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @parent
    @include('admin.partials.nestable')
    <script type="text/javascript" charset="utf-8">
        $(function () {
            initNestableMenu(1, "{{ (isset($url)? $url : request()->url()) }}/order");
        })
    </script>
@endsection
