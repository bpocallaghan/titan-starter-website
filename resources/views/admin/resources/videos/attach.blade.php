@section('styles')
    @parent
    <style>
        #form-modal-videos .select2.select2-container {
            display: block;
            width: 100% !important;
        }
    </style>
@endsection

<button type="button" data-toggle="modal" data-target="#modal-videos-attach" class="mt-3 btn btn-info">Attach an existing video</button>

<div class="modal fade" id="modal-videos-attach" role="dialog">
    <div class="modal-dialog" role="video">
        <div class="modal-content">
            <div class="modal-header alert-info">
                <h4 class="modal-title">Attach video</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="form-modal-videos-attach">
                    <input type="hidden" name="attach_videoable_id" value="{{ $videoable->id }}">
                    <input type="hidden" name="attach_videoable_type" value="{{ get_class($videoable) }}">
                    <input type="hidden" name="attach_videoable_type_name" value="{{ (new \ReflectionClass($videoable))->getShortName() }}">

                    <div class="form-group">
                        <label for="name">Custom Name</label>
                        <input type="text" class="form-control" name="attach_name" placeholder="Text to display" value="">
                    </div>
                    <div class="form-group">
                        <label for="video">Video</label>
                        @if(isset($videos))
                            {!! form_select('attach_video_id', ([0 => 'Please select a video'] + $videoable->all_videos), null, ['class' => 'select2 form-control']) !!}
                        @endif
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel
                </button>
                <button id="modal-videos-attach-submit" type="button" class="btn btn-primary" data-dismiss="modal">
                    Add video
                </button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">

        $(function () {
            // on insert link
            $('#modal-videos-attach-submit').on('click', function () {
                var name = $('#modal-videos-attach input[name=attach_name]');
                var id = $('#modal-videos-attach select[name=attach_video_id]').find(":selected").val();

                // basic validation
                if (id.length > 0) {

                    $.ajax({
                        type: 'POST',
                        url: "/admin/resources/videos/attach",
                        data: {
                            'id': id,
                            'name': name.val(),
                            'videoable_id': $('#modal-videos-attach input[name=attach_videoable_id]').val(),
                            'videoable_type': $('#modal-videos-attach input[name=attach_videoable_type]').val(),
                        },
                        dataType: "json",
                        success: function (data) {

                            if (data.error) {
                                notifyError(data.error.title, data.error.content);
                            } else {
                                notify('Successfully', 'The video attached.', null, null, 5000);
                            }

                            // update the title tag's input
                            var id = data.data.id;
                            var title = data.data.name;

                            var html = '<div class="col-6 col-sm-4 col-md-3 mb-3" data-id="'+id+'">'
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

                                                html += '<iframe class="card-img-top" width="315" height="177" src="'+$link+'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                            }else {
                                                html += ' <div id="video-viewport" style="max-width: 330px; max-height: 185px;">'
                                                                +'<video id="video-'+id+'" width="330px" height="185px" preload="auto" controls muted="" src="/uploads/videos/'+data.data.filename+'">'
                                                                    +'<source src="/uploads/videos/'+data.data.filename+'" type="video/mp4">'
                                                                +'</video>'
                                                            +'</div>';
                                            }


                                            html += '<div class="card-footer">'
                                                +'<a title="'+title+'" data-toggle="tooltip" href="javascript:void(0)" class="flex-fill text-truncate video-click video-name-'+id+'" data-id="'+id+'" data-modal-title="Update Video">'+title+'</a>'
                                            +'</div>'
                                        +'</div>'
                                    +'</div>';

                            $('#videoGridSortable .dd-list').append(html);

                        }
                    });
                }

                // reset
                name.val('');
            })
        })
    </script>
@endsection
