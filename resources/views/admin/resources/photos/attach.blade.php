@section('styles')
    @parent
    <style>
        #form-modal-photos .select2.select2-container {
            display: block;
            width: 100% !important;
        }
    </style>
@endsection

<button type="button" data-toggle="modal" data-target="#modal-photos-attach" class="mt-3 btn btn-info">Attach an existing photo</button>

<div class="modal fade" id="modal-photos-attach" role="dialog">
    <div class="modal-dialog" role="photo">
        <div class="modal-content">
            <div class="modal-header alert-info">
                <h4 class="modal-title">Attach photo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="form-modal-photos-attach">
                    <input type="hidden" name="attach_photoable_id" value="{{ $photoable->id }}">
                    <input type="hidden" name="attach_photoable_type" value="{{ get_class($photoable) }}">
                    <input type="hidden" name="attach_photoable_type_name" value="{{ (new \ReflectionClass($photoable))->getShortName() }}">

                    <div class="form-group">
                        <label for="name">Custom Name</label>
                        <input type="text" class="form-control" name="attach_name" placeholder="Text to display" value="">
                    </div>
                    <div class="form-group">
                        <label for="photo">photo</label>
                        @if(isset($photos))
                            {!! form_select('attach_photo_id', ([0 => 'Please select a photo'] + $photoable->all_photos), null, ['class' => 'select2 form-control']) !!}
                        @endif
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel
                </button>
                <button id="modal-photos-attach-submit" type="button" class="btn btn-primary" data-dismiss="modal">
                    Add photo
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
            $('#modal-photos-attach-submit').on('click', function () {
                var name = $('#modal-photos-attach input[name=attach_name]');
                var id = $('#modal-photos-attach select[name=attach_photo_id]').find(":selected").val();

                // basic validation
                if (id.length > 0) {

                    $.ajax({
                        type: 'POST',
                        url: "/admin/resources/photos/attach",
                        data: {
                            'id': id,
                            'name': name.val(),
                            'photoable_id': $('#modal-photos-attach input[name=attach_photoable_id]').val(),
                            'photoable_type': $('#modal-photos-attach input[name=attach_photoable_type]').val(),
                        },
                        dataType: "json",
                        success: function (data) {

                            if (data.error) {
                                notifyError(data.error.title, data.error.content);
                            } else {
                                notify('Successfully', 'The photo attached.', null, null, 5000);
                            }

                            // update the title tag's input
                            var id = data.data.id;
                            var title = data.data.name;
                            var url = data.data.url;
                            var thumbUrl = data.data.url;

                            if($('#photoGridSortable .dd-list .col-12').length > 0){
                                $('#photoGridSortable .dd-list .col-12').remove();
                            }

                            var html ='<div class="col-6 col-md-4 col-lg-3 col-xl-2" data-id="'+id+'">'
                                        +'<div class="dd-item card dt-table">'
                                            +'<div class="card-header d-flex text-center p-2 align-items-center">'
                                                +'<button class="dd-handle btn btn-outline-secondary btn-xs mr-2" data-toggle="tooltip" title="Order Photo">'
                                                    +'<i class="fas fa-fw fa-list"></i>'
                                                +'</button>'
                                                +'<div class="form-check text-center m-0 pl-1 flex-fill">'
                                                    +'<div class="custom-control custom-radio">'
                                                        +'<input class="custom-control-input photo-cover-radio" id="cover_photo'+id+'" data-id="'+id+'" type="radio" name="is_cover">'
                                                        +'<label for="cover_photo'+id+'" class="custom-control-label">Cover</label>'
                                                    +'</div>'
                                                +'</div>'
                                                +'<div class=" text-right">'
                                                    +'<a href="/admin/resources/photos/crop/'+id+'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Crop '+title+'">'
                                                        +'<i class="fa fa-fw fa-crop"></i>'
                                                    +'</a>'
                                                    +'<form id="form-delete-row'+id+'" method="POST" action="/admin/resources/photos/'+id+'" class="dt-titan d-inline-block">'
                                                        +'<input name="_method" type="hidden" value="DELETE">'
                                                        +'<input name="_token" type="hidden" value="{{ csrf_token() }}">'
                                                        +'<input name="_id" type="hidden" value="'+id+'">'

                                                        +'<a data-form="form-delete-row'+id+'" class="btn btn-danger btn-xs btn-delete-row text-light" data-toggle="tooltip" title="Delete photo - '+title+'">'
                                                            +'<i class="fa fa-fw fa-times"></i>'
                                                        +'</a>'
                                                    +'</form>'
                                                +'</div>'
                                            +'</div>'
                                            +'<a class="card-img-top" href="'+url+'" data-lightbox="Photo gallery" data-title="'+title+'">'
                                                +'<img src="'+thumbUrl+'" title="'+title+'" class="img-fluid">'
                                            +'</a>'
                                            +'<div class="card-footer">'
                                                +'<a id="image-row-clicker-'+id+'" class="text-truncate dropzone-image-click" href="javascript:void(0)" data-id="'+id+'" data-toggle="tooltip" data-title="'+title+'">'
                                                    +'<div id="image-row-title-span-'+id+'" class="image-row-title-span text-truncate">'+title+'</div>'
                                                +'</a>'
                                            +'</div>'
                                        +'</div>'
                                    +'</div>';

                            $('#photoGridSortable .dd-list').append(html);

                        }
                    });
                }

                // reset
                name.val('');
            })
        })
    </script>
@endsection
