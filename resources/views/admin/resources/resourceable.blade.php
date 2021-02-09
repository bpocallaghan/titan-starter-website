@if(isset($resource))
    <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="resources" role="tablist">
                @if(isset($resource->photos))
                    <li class="nav-item">
                        <a class="toggle-sortable nav-link active" id="resources-photos-tab" data-url="/admin/resources/photos/order" data-type="photoGridSortable" data-toggle="pill" href="#resources-photos" role="tab" aria-controls="resources-photos" aria-selected="true"><i class="fas fa-fw fa-images"></i> Photos</a>
                    </li>
                @endif
                @if(isset($resource->videos))
                    <li class="nav-item">
                        <a class="toggle-sortable nav-link" id="resources-videos-tab" data-url="/admin/resources/videos/order" data-type="videoGridSortable" data-toggle="pill" href="#resources-videos" role="tab" aria-controls="resources-videos" aria-selected="false"><i class="fa fa-fw fa-film"></i> Videos</a>
                    </li>
                @endif
                @if(isset($resource->documents))
                    <li class="nav-item">
                        <a class="toggle-sortable nav-link" id="resources-documents-tab" data-url="/admin/resources/documents/order" data-type="documentGridSortable" data-toggle="pill" href="#resources-documents" role="tab" aria-controls="resources-documents" aria-selected="false"><i class="fas fa-fw fa-file-pdf"></i> Documents</a>
                    </li>
                @endif
            </ul>
        </div>

        <div class="card-body p-0">
            <div class="tab-content" id="resources-tabContent">
                @if(isset($resource->photos))
                    <div class="tab-pane fade show active" data-url="/admin/resources/photos/order" data-type="photoGridSortable" id="resources-photos" role="tabpanel" aria-labelledby="resources-photos-tab">
                        @include('admin.resources.photos.photoable', ['photoable'=> $resource, 'photos' => $resource->photos])
                    </div>
                @endif
                @if(isset($resource->videos))
                    <div class="tab-pane fade" data-url="/admin/resources/videos/order" data-type="videoGridSortable" id="resources-videos" role="tabpanel" aria-labelledby="resources-videos-tab">
                        @include('admin.resources.videos.videoable', ['videoable' => $resource, 'videos' => $resource->videos])
                    </div>
                @endif
                @if(isset($resource->documents))
                <div class="tab-pane fade" data-url="/admin/resources/documents/order" data-type="documentGridSortable" id="resources-documents" role="tabpanel" aria-labelledby="resources-documents-tab">
                    @include('admin.resources.documents.documentable', ['documentable' => $resource, 'documents' => $resource->documents])
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif
@include('admin.partials.sortable')

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function () {

            initSortableMenu("/admin/resources/photos/order", "photoGridSortable");

            $('.toggle-sortable').on('shown.bs.tab', function (e) {
                $newTab = e.target; // newly activated tab
                $oldTab = e.relatedTarget; // previous active tab

                sort.destroy();

                $type = $newTab.getAttribute('data-type');
                $url = $newTab.getAttribute('data-url');

                initSortableMenu($url, $type);
            });

             // Javascript to enable link to tab
             var url = document.location.toString();
            if (url.match('#')) {
                $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
            }

            // Change hash for page-reload
            $('.nav-tabs a').on('shown.bs.tab', function (e) {
                window.location.hash = e.target.hash;
            });

        });
    </script>
@endsection
