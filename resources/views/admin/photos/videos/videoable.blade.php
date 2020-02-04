<div class="card card-outline card-secondary">
    <div class="card-header">
        <h3 class="card-title">{!! $videoable->name !!} Videos</h3>

        <div class="card-tools">
            <a class="btn btn-warning btn-sm" href="/admin/photos/show/{{ $videoable->id }}/videos/order">
                <span><i class="fa fa-sort" aria-hidden="true"></i></span></a>
        </div>
    </div>

    <div class="card-body">
        <div class="well well-sm well-toolbar">
            <a class="btn btn-labeled btn-primary video-click-create" href="#" data-modal-title="Create Video">
                <span class="btn-label"><i class="fa fa-fw fa-plus"></i></span>Create Video
            </a>
        </div>

        <div class="row dt-table video-collection">

            @if(isset($videos))
                @foreach($videos->sortBy('list_order') as $item)
                    <div class="col-sm-3" style="margin-bottom: 15px;">

                        <div class="text-center">
                            <label class="radio" style="margin-top: -10px;;">
                                <input class="video-cover-radio" data-id="{{$item->id}}" type="radio" name="is_cover" @if($item->is_cover) checked @endif><i></i>
                            </label>

                            <form id="form-delete-row{{ $item->id }}" method="POST" action="/admin/photos/videos/{{ $item->id }}" class="dt-titan">
                                <input name="_method" type="hidden" value="DELETE">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                <input name="_id" type="hidden" value="{{ $item->id }}">

                                <a data-form="form-delete-row{{ $item->id }}" class="btn btn-danger btn-xs btn-delete-row pull-right" data-toggle="tooltip" title="Delete video - {{ $item->name }}"
                                   style="float:right; padding: 0px 6px;">
                                    <i class="fa fa-times"></i>
                                </a>
                            </form>

                            <br>
                            <a href="#" class="video-click video-name-{{$item->id}}" data-id="{{$item->id}}" data-modal-title="Update Video">{{ $item->name }}</a>
                        </div>
                        <figure>
                            <iframe width="315" height="177" src="@if($item->is_youtube) {{ 'https://www.youtube.com/embed/'.$item->link}} @else {{ $item->link }} @endif" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </figure>
                    </div>
                @endforeach
            @endif

        </div>

    </div>
</div>

<div class="modal fade" id="modal-video" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="video-modal-form" method="POST" enctype="multipart/form-data">
                <div class="modal-header alert-success">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title">Update Video</h4>
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
                                <label for="modal-video-youtube">YouTube Video?</label>
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
                                    <label for="modal-video-desc">Description</label>
                                    <textarea class="form-control" id="modal-video-desc" name="content" placeholder="Description of the Video"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="modal-video-link">Link</label>
                                    <input type="text" class="form-control" id="modal-video-link" name="link" placeholder="Link of the Video" value="">
                                    <span class="text-muted small">If this is a youtube video, please only add the code shown below in bold:
                                                <br>https://www.youtube.com/watch?v=<b>XXxxXxX</b>
                                                <br>https://youtu.be/<b>XXxxXxX</b></span>
                                </div>
                            </div>
                            <div class="col col-12">
                                <section class="form-group">
                                    <label>Browse for an Image (1600 x 500)</label>
                                    <div class="input-group input-group-sm">
                                        <input id="photo-label" type="text" class="form-control" readonly placeholder="Browse for an image">
                                        <span class="input-group-btn">
                                              <button type="button" class="btn btn-default" onclick="document.getElementById('photo').click();">Browse</button>
                                            </span>
                                        <input id="photo" style="display: none" accept="{{ get_file_extensions('image') }}" type="file" name="photo" onchange="document.getElementById('photo-label').value = this.value">
                                    </div>
                                </section>

                                <div class="vid-image"></div>
                            </div>
                        </div>

                    </fieldset>

                    {{--<button id="video-btn-form" type="submit" class="btn btn-primary create pull-right">--}}
                    {{--Submit--}}
                    {{--</button>--}}

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancel
                    </button>
                    <button id="video-btn-form" type="submit" class="btn btn-primary video-save-create pull-right">
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
                    url: "/admin/photos/videos/" + id + '/cover',
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

                $.post("/admin/photos/videos/" + id + "/getInfo").done(function (data) {

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
                    url: "/admin/photos/videos/create",
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

                            $text = '<div class="col-sm-3">\n' +
                                '<div class="text-center">\n' +
                                '<label class="radio" style="margin-top: -10px;;">\n' +
                                '<input class="video-cover-radio" data-id="' + data['data']['id'] + '" type="radio" name="is_cover"><i></i>\n' +
                                '</label>\n' +
                                '<form id="form-delete-row' + data['data']['id'] + '" method="POST" action="/admin/photos/videos/' + data['data']['id'] + '" class="dt-titan">\n' +
                                '<input name="_method" type="hidden" value="DELETE">\n' +
                                '<input name="_token" type="hidden" value="{{ csrf_token() }}">\n' +
                                '<input name="_id" type="hidden" value="' + data['data']['id'] + '">\n' +
                                '<a data-form="form-delete-row' + data['data']['id'] + '" class="btn btn-danger btn-xs btn-delete-row pull-right" data-toggle="tooltip" title="Delete video - ' + data['data']['name'] + '"\n' +
                                'style="float:right; padding: 0px 6px;">\n' +
                                '<i class="fa fa-times"></i>\n' +
                                '</a>\n' +
                                '</form>\n' +
                                '<br>\n' +
                                '<a href="#" class="video-click video-name-' + data['data']['id'] + '" data-id="' + data['data']['id'] + '" data-modal-title="Update Video">' + data['data']['name'] + '</a>\n' +
                                '</div>\n' +
                                '<iframe width="315" height="177" src="' + $link + '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>\n' +
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
                    url: "/admin/photos/videos/" + $vid_id.val() + '/edit',
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data.error) {
                            notifyError(data.error.title, data.error.content);
                        } else {
                            notify('Successfully', 'The photo name was updated.', null, null, 5000);
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
