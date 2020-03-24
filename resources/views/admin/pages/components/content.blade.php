@extends('admin.admin')

@section('content')
    <!--card-outline-->
    <form class="card card-secondary" method="POST" action="/admin/pages/{{ $page->id . '/sections/content' . (isset($item)? "/{$item->id}" : '')}}" accept-charset="UTF-8" enctype="multipart/form-data">
        {!! csrf_field() !!}
        {!! method_field(isset($item)? 'put':'post') !!}
        <input name="page_id" type="hidden" value="{{ $page->id }}">

        <div class="card-header">
            <span>{{ isset($item)? 'Edit the "' . $item->heading . '" entry': 'Create a new Page Content Section' }}</span>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="callout callout-info callout-help">
                <h4 class="title">How it works?</h4>
                <ul>
                    <li>Enter heading & choose heading size (optional)</li>
                    <li>Browse for a featured photo, choose the alignment for the image & enter caption (optional)</li>
                    <li>Enter content (optional)</li>
                    <li>Click on submit to save changes, you will be redirected back in order to upload videos, photos & documents</li>
                    <li>Scroll below to upload videos to the page content section (optional)</li>
                    <li>Scroll below to upload photos to the page content section (optional)</li>
                    <li>Scroll below to upload documents to the page content section (optional)</li>
                </ul>
            </div>

            <fieldset>
                @include('admin.pages.components.form_heading')

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group {{ form_error_class('media', $errors) }}">
                            <label>Upload your Photo - Maximum 2MB <span class="small">(Optional)</span> </label>
                            <div class="input-group">
                                <input id="media-label" type="text" class="form-control" readonly placeholder="Browse for a photo">
                                <input id="media" style="display: none" accept="{{ get_file_extensions('image') }}" type="file" name="media" onchange="document.getElementById('media-label').value = this.value">

                                <div class="input-group-append">
                                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('media').click();">Browse</button>
                                </div>
                            </div>
                            {!! form_error_message('media', $errors) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group {{ form_error_class('media_align', $errors) }}">
                            <label for="media_align">Media Alignment</label>
                            {!! form_select('media_align', ['left'  => 'Left', 'right' => 'Right', 'top'   => 'Top / Center'], ($errors && $errors->any()? old('media_align') : (isset($item)? $item->media_align : 'left')), ['class' => 'select2 form-control']) !!}
                            {!! form_error_message('media_align', $errors) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="caption">Media Caption <span class="small">(Optional)</span></label>
                            <input type="text" class="form-control {{ form_error_class('caption', $errors) }}" id="caption" name="caption" placeholder="Enter Caption" value="{{ ($errors && $errors->any()? old('caption') : (isset($item)? $item->caption : '')) }}">
                            {!! form_error_message('caption', $errors) !!}
                        </div>
                    </div>
                </div>

                @include('admin.pages.components.form_content')

                @if(isset($item) && $item->media)
                    <div id="media-box">
                        <a style="display:inline-block;" target="_blank" href="{{ $item->imageUrl }}">
                            <img class="img-fluid" src="{{ $item->thumb_url }}" style="height:100px;"/>
                            <button title="Remove media" class="btn btn-danger btn-xs btn-delete-row pull-right" id="form-delete-row{{ $item->id }}" data-id="{{ $item->id }}" data-page-id="{{ $item->page_id }}">
                                <i class="fa fa-times"></i></button>
                        </a>

                    </div>
                @endif
            </fieldset>

        </div>
        @include('admin.partials.form.form_footer')
    </form>

    @if(isset($item))
        <div class="card card-secondary card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="resources" role="tablist">
                    <li class="nav-item">
                        <a class="toggle-sortable nav-link active" id="resources-photos-tab" data-url="/admin/photos/order" data-type="photoGridSortable" data-toggle="pill" href="#resources-photos" role="tab" aria-controls="resources-photos" aria-selected="true"><i class="fas fa-images"></i> Photos</a>
                    </li>
                    <li class="nav-item">
                        <a class="toggle-sortable nav-link" id="resources-videos-tab" data-url="/admin/photos/videos/order" data-type="videoGridSortable" data-toggle="pill" href="#resources-videos" role="tab" aria-controls="resources-videos" aria-selected="false"><i class="fa fa-film"></i> Videos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="resources-documents-tab" data-toggle="pill" href="#resources-documents" role="tab" aria-controls="resources-documents" aria-selected="false"><i class="fas fa-file-pdf"></i> Documents</a>
                    </li>
                </ul>
            </div>

            <div class="card-body p-0">
                <div class="tab-content" id="resources-tabContent">
                    <div class="tab-pane fade show active" data-url="/admin/photos/order" data-type="photoGridSortable" id="resources-photos" role="tabpanel" aria-labelledby="resources-photos-tab">
                        @include('admin.photos.photoable', ['photoable' => $item, 'photos' => $item->photos])
                    </div>

                    <div class="tab-pane fade" data-url="/admin/photos/videos/order" data-type="videoGridSortable" id="resources-videos" role="tabpanel" aria-labelledby="resources-videos-tab">
                        @include('admin.photos.videos.videoable', ['videoable' => $item, 'videos' => $item->videos])
                    </div>

                    <div class="tab-pane fade" id="resources-documents" role="tabpanel" aria-labelledby="resources-documents-tab">
                        @include('admin.documents.documentable', ['documentable' => $item, 'documents' => $item->documents])
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@include('admin.partials.sortable')

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function () {

            initSortableMenu("/admin/photos/order", "photoGridSortable");

            $('.toggle-sortable').on('shown.bs.tab', function (e) {
                $newTab = e.target; // newly activated tab
                $oldTab = e.relatedTarget; // previous active tab

                sort.destroy();

                $type = $newTab.getAttribute('data-type');
                $url = $newTab.getAttribute('data-url');

                initSortableMenu($url, $type);
            });

            $('.btn-delete-row').on('click', function (e) {
                e.preventDefault();

                $id = $(this).attr('data-id');
                $page_id = $(this).attr('data-page-id');

                $.ajax({
                    type: 'POST',
                    url: "/admin/pages/" + $page_id + "/sections/content/" + $id + "/removeMedia",
                    dataType: "json",
                    success: function (data) {
                        if (data.error) {
                            notifyError(data.error.title, data.error.content);
                        } else {
                            notify('Successfully', 'The media was successfully removed.', null, null, 5000);
                        }

                        $('body').find('#media-box').html('');
                    }
                });
            });
        });
    </script>
@endsection
