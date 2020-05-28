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
        <div class="mb-3">
            <a class="btn btn-labeled btn-primary video-click-create" href="#" data-modal-title="Create Video">
                <span class="btn-label"><i class="fa fa-fw fa-plus"></i></span>Create Video
            </a>
        </div>

        <div class="row d-flex dd-list video-collection" id="videoGridSortable">
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

                            <iframe class="card-img-top" width="315" height="177" src="@if($video->is_youtube) {{ 'https://www.youtube.com/embed/'.$video->link}} @else {{ $video->link }} @endif" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                            <div class="card-footer">
                                <a title="{{ $video->name }}" data-toggle="tooltip" href="javascript:void(0)" class="flex-fill text-truncate video-click video-name-{{$video->id}}" data-id="{{$video->id}}" data-modal-title="Update Video">{{ $video->name }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
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
                                    <label>Browse for an Image (800 x 452) <span class="small"> (Optional)</span></label>
                                    <div class="input-group input-group-sm">
                                        <input id="photo-label" type="text" class="form-control" readonly placeholder="Browse for an image">
                                        <input id="photo" style="display: none" accept="{{ get_file_extensions('image') }}" type="file" name="photo" onchange="document.getElementById('photo-label').value = this.value">

                                        <span class="input-group-append">
                                              <button type="button" class="btn btn-default" onclick="document.getElementById('photo').click();">Browse</button>
                                        </span>
                                    </div>
                                    <span class="text-muted small">In place of using the default image of the video, you can upload a custom image that you think reflects the video better. </span>
                                </section>

                                <div class="vid-image"></div>
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
            initActionDeleteClick();

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

            $('body').on('click', '.video-click-create', function (e) {
                e.preventDefault();

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

                        if (data['data']['is_youtube']) {
                            $('#modal-video-youtube').attr('checked', 'checked');
                        }
                        if (data['data']['image'] != null) {
                            $text = '<section>' +
                                '<img src="/uploads/images/' + data['data']['image'] + '" style="max-width: 100%; max-height: 300px;">' +
                                '<input type="hidden" name="image" value="' + data['data']['image'] + '">' +
                                '</section>';

                            $('#modal-video .vid-image').append($text);
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

                $vid_image = $('#image');
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

                            $text = '<div class="col-6 col-sm-4 col-md-3 mb-3"> <div class="card"> <div class="card-header d-flex text-center">\n' +
                                        '<button class="dd-handle btn btn-outline-secondary btn-xs mr-2" data-toggle="tooltip" title="Order Photo">\n' +
                                        '   <i class="fas fa-fw fa-list"></i>\n' +
                                        '</button>' +
                                        '<div class="form-check text-center m-0 pl-1 flex-fill">\n' +
                                        '   <div class="custom-control custom-radio">\n' +
                                        '       <input class="custom-control-input video-cover-radio" id="cover_photo' + data['data']['id'] + '" data-id="' + data['data']['id'] + '" type="radio" name="is_cover">\n' +
                                        '       <label for="cover_photo' + data['data']['id'] + '" class="custom-control-label">Cover</label>\n' +
                                        '   </div>\n' +
                                        '</div>'+

                                        '<form id="form-delete-row' + data['data']['id'] + '" method="POST" action="/admin/resources/videos/' + data['data']['id'] + '" class="flex-fill dt-titan">\n' +
                                            '<input name="_method" type="hidden" value="DELETE">\n' +
                                            '<input name="_token" type="hidden" value="{{ csrf_token() }}">\n' +
                                            '<input name="_id" type="hidden" value="' + data['data']['id'] + '">\n' +
                                            '<a data-form="form-delete-row' + data['data']['id'] + '" class="btn btn-danger btn-xs btn-delete-row text-light" data-toggle="tooltip" title="Delete video - ' + data['data']['name'] + '">\n' +
                                                '<i class="fa fa-fw fa-times"></i>\n' +
                                            '</a>\n' +
                                        '</form>\n' +
                                    '</div>\n' +
                                        '<iframe class="card-img-top" width="315" height="177" src="' + $link + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>\n' +
                                    '</div>' +
                                    '<div class="card-footer">' +
                                        '<a href="javascript:void(0)" title="' + data['data']['name'] + '" data-toggle="tooltip" class="flex-fill text-truncate video-click video-name-' + data['data']['id'] + '" data-id="' + data['data']['id'] + '" data-modal-title="Update Video">' + data['data']['name'] + '</a>\n' +
                                    '</div>'+
                                '</div>';

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

                $('#image').val('');
                $('#photo').val('');

                $('.vid-image').html('');
            });

            $('body').on('click', '#video-btn-form-save', function (e) {
                e.preventDefault();

                $vid_id = $('#modal-video-id');
                $vid_name = $('#modal-video-name');
                $vid_link = $('#modal-video-link');

                $vid_image = $('#image');
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

        });
    </script>
@endsection
