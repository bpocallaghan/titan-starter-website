<div class="card card-outline card-light m-0">
    <div class="card-header">
        <span>Add a Video</span>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="card-body">


        <div class="callout callout-info callout-help">
            <h4 class="title">How it works?</h4>
            <p>
                Click on the button below to browse for videos<br/>
                Refresh the page when upload is complete<br/>
                Click on the video name to change it<br/>
                Click on the radio button to set the cover video<br/>
                <b>Note:</b> Batch upload limit of 5, refresh to add more videos, videos should be less than 5 MB.<br/>
                <b>Note:</b> Video's should rather be linked from a streaming website like YouTube or Vimeo etc.<br/>
                <b>Note:</b> When uploading your custom video, note that users will need to load it using their data.
            </p>
        </div>

        <form id="formVideoDropzone" class="dropzone" method="POST" action="/admin/resources/videos/upload" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="videoable_id" value="{{ $videoable->id }}">
            <input type="hidden" name="videoable_type" value="{{ get_class($videoable) }}">
            <input type="hidden" name="videoable_type_name" value="{{ (new \ReflectionClass($videoable))->getShortName() }}">

            <div class="dz-default dz-message">
                <span>Click here to browse for videos.</span>
            </div>
        </form>

        <!-- Upload pannel -->
        <div id="preview-template" style="display: none">
            <div class="dz-preview dz-file-preview">
                <a class="dropzone-video-click" href="#">
                    <div class="dz-video">
                        <img data-dz-thumbnail/>
                    </div>
                    <div class="dz-details">
                        <div class="dz-size"><span data-dz-size></span></div>
                        <!--<div class="dz-filename"><span data-dz-name></span></div>-->
                        <span class="video-row-title-span"></span>
                    </div>
                    <div class="dz-progress">
                        <span class="dz-upload" data-dz-uploadprogress></span></div>
                    <div class="dz-error-message"><span data-dz-errormessage></span>
                    </div>
                    <div class="dz-success-mark">
                        <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                            <title>Check</title>
                            <defs></defs>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                            </g>
                        </svg>
                    </div>
                    <div class="dz-error-mark">
                        <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                            <title>Error</title>n
                            <defs></defs>
                            n
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                n
                                <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                                    n
                                    <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
                                </g>
                            </g>
                        </svg>
                    </div>
                </a>
            </div>
        </div>

        <div id="videoGridSortable">
            <a class="btn btn-labeled btn-primary video-click-create mt-3" href="#" data-modal-title="Create Video">
                <span class="btn-label"><i class="fa fa-fw fa-plus"></i></span>Link Youtube Video
            </a>
            @include('admin.resources.videos.attach')

            <div class="row d-flex dd-list video-collection mt-3" id="videoGridSortable">
                @if(isset($videos))
                    @foreach($videos->sortBy('list_order') as $video)
                        <div class="col-6 col-sm-4 col-md-3 mb-3" data-id="{{ $video->id }}">
                            <div class="dd-item card dt-table">
                                <div class="card-header d-flex text-center">

                                    <button class="dd-handle btn btn-outline-secondary btn-xs mr-2" data-toggle="tooltip" title="Order Photo">
                                        <i class="fas fa-fw fa-list"></i>
                                    </button>

                                    <div class="form-check text-center m-0 pl-1 flex-fill">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input video-cover-radio" id="cover_photo{{ $video->id }}" data-id="{{ $video->id }}" type="radio" name="is_cover" {!! $video->is_cover == 1? 'checked' : '' !!}>
                                            <label for="cover_photo{{ $video->id }}" class="custom-control-label">Cover</label>
                                        </div>
                                    </div>

                                    <form id="form-delete-row{{ $video->id }}" method="POST" action="/admin/resources/videos/{{ $video->id }}" class="text-right dt-titan">
                                        <input name="_method" type="hidden" value="DELETE">
                                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                        <input name="_id" type="hidden" value="{{ $video->id }}">

                                        <a data-form="form-delete-row{{ $video->id }}" class="btn btn-danger btn-xs btn-delete-row text-light" data-toggle="tooltip" title="Delete video - {{ $video->name }}">
                                            <i class="fa fa-fw fa-times"></i>
                                        </a>
                                    </form>
                                </div>

                                @if(!isset($video->filename))
                                    <iframe class="card-img-top" width="315" height="177" src="@if($video->is_youtube) {{ 'https://www.youtube.com/embed/'.$video->link}} @else {{ $video->link }} @endif" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                @else
                                    <div id="video-viewport" style="max-width: 330px; max-height: 185px;" class="card-img-top">
                                        <video id="video-{{$video->id}}" width="330px" height="185px" preload="auto" controls muted="" src="{{$video->url}}">
                                            <source src="{{$video->url}}" type="video/mp4">
                                        </video>
                                    </div>
                                @endif

                                <div class="card-footer">
                                    <a title="{{ $video->name }}" data-toggle="tooltip" href="javascript:void(0)" class="flex-fill text-truncate video-click video-name-{{$video->id}}" data-id="{{$video->id}}" data-modal-title="Update Video">{{ $video->name }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    @php
        $resourceable_split = preg_split('/(?=[A-Z])/', (new \ReflectionClass($videoable))->getShortName(), -1, PREG_SPLIT_NO_EMPTY);
        $resourceable_join = join('-', $resourceable_split);
        $resourceable = strtolower($resourceable_join);
    @endphp

    @include('admin.partials.form.form_footer', ['submit' => false, 'order' => 'Videos', 'orderUrl' => '/admin/resources/videos/'. $resourceable  .'/'.$videoable->id .'/order'])
</div>

<div class="modal fade" id="modal-video" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="video-modal-form" method="POST" enctype="multipart/form-data">
                <div class="modal-header alert-success">
                    <h4 class="modal-title">Update Video</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="modal-video-id"/>
                    <fieldset>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="modal-video-name">Name</label>
                                    <input type="text" class="form-control" id="modal-video-name" name="name" placeholder="Name of the Video" value="">
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="modal-video-youtube">Is YouTube Video?</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="modal-video-youtube" name="is_youtube" checked>
                                        <i></i> YouTube Video
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="modal-video-link">Link</label>
                                    <input type="text" class="form-control" id="modal-video-link" name="link" placeholder="Link of the Video" value="">
                                    <span class="text-muted small">If this is a youtube video, please only add the code shown below in bold:
                                                <br>https://www.youtube.com/watch?v=<b class="text-red">XXxxXxX</b>
                                                <br>https://youtu.be/<b class="text-red">XXxxXxX</b></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="modal-video-desc">Description <span class="small"> (Optional)</span></label>
                                    <textarea class="form-control" id="modal-video-desc" name="content" placeholder="Description of the Video"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-12">
                                <section class="form-group">
                                    <label>Browse for a video (800 x 452) <span class="small"> (Optional)</span></label>
                                    <div class="input-group input-group-sm">
                                        <input id="photo-label" type="text" class="form-control" readonly placeholder="Browse for an video">
                                        <input id="photo" style="display: none" accept="{{ get_file_extensions('video') }}" type="file" name="photo" onchange="document.getElementById('photo-label').value = this.value">

                                        <span class="input-group-append">
                                              <button type="button" class="btn btn-default" onclick="document.getElementById('photo').click();">Browse</button>
                                        </span>
                                    </div>
                                    <span class="text-muted small">In place of using the default image of the video, you can upload a custom image that you think reflects the video better. </span>
                                </section>

                                <div class="vid-video"></div>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                    <button id="video-btn-form" type="submit" class="btn btn-primary video-save-create">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
    @parent

    <script type="text/javascript" charset="utf-8">
        $(function () {
            // Dropzone.autoDiscover = false;
            activateVideoClick();
            initActionDeleteClick();

            // autodiscover was turned off - update the settings
            var videoDropzone = new Dropzone("#formVideoDropzone");
            videoDropzone.options.maxFiles = "5";
            videoDropzone.options.maxFilesize = "5";
            videoDropzone.options.paramName = "file";
            videoDropzone.previewTemplate = $('#preview-template').html();
            videoDropzone.on("success", function (file, response) {
                if (response.data && response.success) {
                    var data = response.data;

                    file.hiddenInputs = Dropzone.createElement('<input class="video-row-title" type="hidden" value=""/>');
                    file.previewElement.appendChild(file.hiddenInputs);
                    file.hiddenInputs = Dropzone.createElement('<input class="video-row-id" type="hidden" id="video-row-' + data['id'] + '" value="' + data['id'] + '"/>');
                    file.previewElement.appendChild(file.hiddenInputs);

                    notify('Successfully', 'The video has been uploaded and saved in the database.', null, null, 5000);
                } else {
                    notifyError(response.error['title'], response.error['content']);
                    //notifyError('Oops!', 'Something went wrong (hover over video for more information', null, null, 5000);
                }
            });

            // when the radio button change for the photo cover
            $('.video-cover-radio').change(function () {
                var id = $(this).attr('data-id');

                $.ajax({
                    type: 'POST',
                    url: "/admin/resources/videos/" + id + '/cover',
                    data: {
                        videoable_id: "{{ $videoable->id }}",
                        videoable_type: "{{ str_replace('\\','\\\\',get_class($videoable)) }}",
                        videoable_type_name: "{{ (new \ReflectionClass($videoable))->getShortName() }}",
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.error) {
                            notifyError(data.error.title, data.error.content);
                        } else {
                            notify('Successfully', 'The cover video was updated.', null, null, 5000);
                        }
                    }
                });
            });

            function activateVideoClick()
            {
                $('body').off('click', '.dropzone-video-click');
                $('body').on('click', '.dropzone-video-click', function (e) {
                    e.preventDefault();

                    var id = $($(this).parent().find('.video-row-id')).val();
                    var title = $($(this).parent().find('.video-row-title')).val();

                    if ($(this).attr('data-id')) {
                        id = $(this).attr('data-id');
                        title = $(this).attr('data-title');
                    }

                    $('#modal-video-id').val(id);
                    $('#modal-video-name').val(title);
                    $('#modal-video').modal();

                    return false;
                });
            }

            $('body').on('click', '.video-click-create', function (e) {
                e.preventDefault();

                $('#modal-video-link').parents('.row').removeClass('d-none');
                $('#modal-video-youtube').parents('.form-group').removeClass('d-none');
                $('#modal-video-desc').val('');
                $('.video-save-create').attr('id', 'video-btn-form-create');
                $modal_title = $(this).attr('data-title');
                $('#modal-video .modal-title').html($modal_title);

                $('#modal-video').modal();
            });

            $('body').on('click', '.video-click', function (e) {
                e.preventDefault();

                $('.video-save-create').attr('id', 'video-btn-form-save');

                $modal_title = $(this).attr('data-title');
                $('#modal-video .modal-title').html($modal_title);

                var id = $(this).attr('data-id');

                $.post("/admin/resources/videos/" + id + "/getInfo").done(function (data) {

                    if (data['success']) {

                        $('#modal-video-id').val(id);
                        $('#modal-video-name').val(data['data']['name']);
                        $('#modal-video-link').val(data['data']['link']);
                        $('#modal-video-desc').val(data['data']['content']);

                        if(data['data']['filename'] != '' && data['data']['filename'] != null){
                            $('#modal-video-link').parents('.row').addClass('d-none');
                            $('#modal-video-youtube').parents('.form-group').addClass('d-none');
                        }else {
                            $('#modal-video-link').parents('.row').removeClass('d-none');
                            $('#modal-video-youtube').parents('.form-group').removeClass('d-none');

                            if (data['data']['is_youtube'] == 1) {
                                $('#modal-video-youtube').attr('checked', 'checked');
                            }else {
                                $('#modal-video-youtube').attr('checked', false);
                            }
                        }

                        if (data['data']['image'] != null) {
                            $text = '<section>' +
                                '<img src="/uploads/images/' + data['data']['image'] + '" style="max-width: 100%; max-height: 300px;">' +
                                '<input type="hidden" name="photo" value="' + data['data']['image'] + '">' +
                                '</section>';

                            $('#modal-video .vid-video').append($text);
                        }

                        $('#modal-video').modal();
                    }
                });

                return false;
            });

            $('body').on('click', '#video-btn-form-create', function (e) {
                e.preventDefault();

//                $vid_id = $('#modal-video-id');
                $vid_name = $('#modal-video-name');
                $vid_link = $('#modal-video-link');
                $vid_desc = $('#modal-video-desc');

                $vid_video = $('#video');
                $vid_photo = $('#photo');

                if ($vid_name.val().length < 3) {
                    return;
                }

                var form = document.getElementById('video-modal-form'); // You need to use standard javascript object here
                var formData = new FormData(form);

                formData.append('videoable_id', '{{ $videoable->id }}');
                formData.append('videoable_type', '{{ str_replace('\\','\\\\',get_class($videoable)) }}');
                formData.append('videoable_type_name', '{{ (new \ReflectionClass($videoable))->getShortName() }}');

                $.ajax({
                    type: 'POST',
                    url: "/admin/resources/videos/create",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data.error) {
                            notifyError(data.error.title, data.error.content);
                        } else {
                            notify('Successfully', 'A new video was created.', null, null, 5000);
                        }

                        if (data['success']) {

                            $link = '';

                            if (data['data']['is_youtube'] == 1) {
                                $link = 'https://www.youtube.com/embed/' + data['data']['link'];
                            } else {
                                $link = data['data']['link'];
                            }

                            // update the title tag's input
                            var id = data.data.id;
                            var title = data.data.name;

                            $text = '<div class="col-6 col-sm-4 col-md-3 mb-3" data-id="'+id+'">'
                                        +'<div class="dd-item card dt-table">'
                                            +'<div class="card-header d-flex text-center">'
                                                +'<button class="dd-handle btn btn-outline-secondary btn-xs mr-2" data-toggle="tooltip" title="Order Photo">'
                                                    +'<i class="fas fa-fw fa-list"></i>'
                                                +'</button>'
                                                +'<div class="form-check text-center m-0 pl-1 flex-fill">'
                                                    +'<div class="custom-control custom-radio">'
                                                        +'<input class="custom-control-input video-cover-radio" id="cover_photo'+id+'" data-id="'+id+'" type="radio" name="is_cover">'
                                                        +'<label for="cover_photo'+id+'" class="custom-control-label">Cover</label>'
                                                    +'</div>'
                                                +'</div>'
                                                +'<form id="form-delete-row'+id+'" method="POST" action="/admin/resources/videos/'+id+'" class="text-right dt-titan">'
                                                    +'<input name="_method" type="hidden" value="DELETE">'
                                                    +'<input name="_token" type="hidden" value="{{ csrf_token() }}">'
                                                    +'<input name="_id" type="hidden" value="'+id+'">'

                                                    +'<a data-form="form-delete-row'+id+'" class="btn btn-danger btn-xs btn-delete-row text-light" data-toggle="tooltip" title="Delete video - '+title+'">'
                                                        +'<i class="fa fa-fw fa-times"></i>'
                                                    +'</a>'
                                                +'</form>'
                                            +'</div>';

                                            if(data['data']['filename'] == '' || data['data']['filename'] == null){
                                                if(data['data']['is_youtube']){
                                                    $link = 'https://www.youtube.com/embed/' + data['data']['link'];
                                                }else {
                                                    $link = data['data']['link'];
                                                }

                                                $text += '<iframe class="card-img-top" width="315" height="177" src="'+$link+'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                            }else {
                                                $text += ' <div id="video-viewport" style="max-width: 330px; max-height: 185px;">'
                                                                +'<video id="video-'+id+'" width="330px" height="185px" preload="auto" controls muted="" src="/uploads/videos/'+data.data.filename+'">'
                                                                    +'<source src="/uploads/videos/'+data.data.filename+'" type="video/mp4">'
                                                                +'</video>'
                                                            +'</div>';
                                            }


                                            $text += '<div class="card-footer">'
                                                +'<a title="'+title+'" data-toggle="tooltip" href="javascript:void(0)" class="flex-fill text-truncate video-click video-name-'+id+'" data-id="'+id+'" data-modal-title="Update Video">'+title+'</a>'
                                            +'</div>'
                                        +'</div>'
                                    +'</div>';

                            $('.video-collection').append($text);
                        }
                        $('#modal-video').modal('hide');
                    }
                });
            });

            $('#modal-video').on('hidden.bs.modal', function (e) {
                $('#modal-video-id').val('');
                $('#modal-video-name').val('');
                $('#modal-video-link').val('');

                $('#video').val('');
                $('#photo').val('');

                $('.vid-video').html('');
            });

            $('body').on('click', '#video-btn-form-save', function (e) {
                e.preventDefault();

                $vid_id = $('#modal-video-id');
                $vid_name = $('#modal-video-name');
                $vid_link = $('#modal-video-link');

                $vid_video = $('#video');
                $vid_photo = $('#photo');

                if ($vid_name.val().length < 3) {
                    return;
                }

                var form = document.getElementById('video-modal-form'); // You need to use standard javascript object here
                var formData = new FormData(form);

                formData.append('videoable_id', '{{ $videoable->id }}');
                formData.append('videoable_type', '{{ str_replace('\\','\\\\',get_class($videoable)) }}');
                formData.append('videoable_type_name', '{{ (new \ReflectionClass($videoable))->getShortName() }}');

                $.ajax({
                    type: 'POST',
                    url: "/admin/resources/videos/" + $vid_id.val() + '/edit',
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data.error) {
                            notifyError(data.error.title, data.error.content);
                        } else {
                            notify('Successfully', 'The video name was updated.', null, null, 5000);
                        }
                        console.log(data['data']);

                        // update the title tag's input
                        var id = $vid_id.val();

                        $('.video-name-' + id).html($vid_name.val());

                        // reset
                        $('#modal-video').modal('hide');
                    }
                });
            });

            $('#btn-form-save-video').click(function (e) {
                e.preventDefault();

                $('#modal-video').modal('hide');

                if ($('#modal-video-name').val().length < 3) {
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: "/admin/resources/videos/" + $('#modal-video-id').val() + '/edit/name',
                    data: {
                        'name': $('#modal-video-name').val()
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.error) {
                            notifyError(data.error.title, data.error.content);
                        } else {
                            notify('Successfully', 'The video name was updated.', null, null, 5000);
                        }

                        // update the title tag's input
                        var id = $('#modal-video-id').val();
                        var title = $('#modal-video-name').val();
                        var idInput = $('#video-row-' + id);

                        idInput.parent().find('.video-row-title-span').html(title);
                        $('#video-row-title-span-' + id).html(title);
                        $('#video-row-clicker-' + id).attr('data-title', title);

                        // reset
                        $('#modal-video-name').val('');
                    }
                });
            });

        });
    </script>
@endsection
