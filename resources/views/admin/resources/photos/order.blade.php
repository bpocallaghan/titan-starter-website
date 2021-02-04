@extends('admin.admin')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <span>Update Photos List Order</span>
        </div>

        <div class="card-body">
            <div>
                <a href="javascript:window.history.back();" class="btn btn-secondary">
                    <span class="label"><i class="fa fa-fw fa-chevron-left"></i></span>Back
                </a>
            </div>

            <div id="photoGridSortable">
                <div class="row d-flex dd-list mt-3">
                    @forelse($photoable->photos->sortBy('list_order') as $photo)
                        <div class="col-2" data-id="{{ $photo->id }}">
                            <div class="dd-item card dt-table">
                                <div class="card-header d-flex text-center p-2 align-items-center">

                                    <button class="dd-handle btn btn-outline-secondary btn-xs mr-2" data-toggle="tooltip" title="Order Photo">
                                        <i class="fas fa-fw fa-list"></i>
                                    </button>

                                    <div class="form-check text-center m-0 pl-1 flex-fill">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input photo-cover-radio" id="cover_photo{{ $photo->id }}" data-id="{{ $photo->id }}" type="radio" name="is_cover" {!! $photo->is_cover == 1? 'checked' : '' !!}>
                                            <label for="cover_photo{{ $photo->id }}" class="custom-control-label">Cover</label>
                                        </div>
                                    </div>

                                    <div class=" text-right">
                                        <a href="/admin/resources/photos/crop/{{ $photo->id }}" class="btn btn-info btn-xs" data-toggle="tooltip" title="Crop {{ $photo->name }}">
                                            <i class="fa fa-fw fa-crop"></i>
                                        </a>
                                        <form id="form-delete-row{{ $photo->id }}" method="POST" action="/admin/resources/photos/{{ $photo->id }}" class="dt-titan d-inline-block">
                                            <input name="_method" type="hidden" value="DELETE">
                                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                            <input name="_id" type="hidden" value="{{ $photo->id }}">

                                            <a data-form="form-delete-row{{ $photo->id }}" class="btn btn-danger btn-xs btn-delete-row text-light" data-toggle="tooltip" title="Delete photo - {{ $photo->name }}">
                                                <i class="fa fa-fw fa-times"></i>
                                            </a>
                                        </form>
                                    </div>
                                </div>

                                <a class="card-img-top" href="{{ $photo->url }}" data-lightbox="Photo gallery" data-title="{{ $photo->name }}">
                                    <img src="{{ $photo->thumb_url }}" title="{{ $photo->name }}" class="img-fluid">
                                </a>

                                <div class="card-footer">
                                    <a id="image-row-clicker-{{ $photo->id }}" class="text-truncate dropzone-image-click" href="javascript:void(0)" data-id="{{ $photo->id }}" data-toggle="tooltip" data-title="{{ $photo->name }}">
                                        <div id="image-row-title-span-{{ $photo->id }}" class="image-row-title-span text-truncate">{{ $photo->name }}</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">

                            <p class="text-muted">No photos to order, please go back and click on the panel to upload photos
                                to {!! $photoable->name !!}.
                            </p>

                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modal-photo" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header alert-success">
                    <h4 class="modal-title">Update Photo Name</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="modal-photo-id"/>

                        <fieldset style="padding: 0">
                            <section class="form-group">
                                <label for="modal-photo-name">Name of the Photo</label>
                                <input type="text" class="form-control" id="modal-photo-name" placeholder="Enter the name of the Photo">
                            </section>
                        </fieldset>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancel
                    </button>
                    <button id="btn-form-save" type="button" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.sortable')
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function ()
        {
            initSortableMenu("/admin/resources/photos/order", "photoGridSortable");

            activateImageClick();

// when the radio button change for the photo cover
            $('.photo-cover-radio').change(function () {
                var id = $(this).attr('data-id');

                $.ajax({
                    type: 'POST',
                    url: "/admin/resources/photos/" + id + '/cover',
                    data: {
                        photoable_id: "{{ $photoable->id }}",
                        photoable_type: "{{ str_replace('\\','\\\\',get_class($photoable)) }}",
                        photoable_type_name: "{{ (new \ReflectionClass($photoable))->getShortName() }}",
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.error) {
                            notifyError(data.error.title, data.error.content);
                        } else {
                            notify('Successfully', 'The cover photo was updated.', null, null, 5000);
                        }
                    }
                });
            })

            function activateImageClick()
            {
                $('.dropzone-image-click').off('click');
                $('.dropzone-image-click').on('click', function (e) {
                    e.preventDefault();

                    var id = $($(this).parent().find('.image-row-id')).val();
                    var title = $($(this).parent().find('.image-row-title')).val();

                    if ($(this).attr('data-id')) {
                        id = $(this).attr('data-id');
                        title = $(this).attr('data-title');
                    }

                    $('#modal-photo-id').val(id);
                    $('#modal-photo-name').val(title);
                    $('#modal-photo').modal();

                    return false;
                });
            }

            $('#btn-form-save').click(function (e) {
                e.preventDefault();

                $('#modal-photo').modal('hide');

                if ($('#modal-photo-name').val().length < 3) {
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: "/admin/resources/photos/" + $('#modal-photo-id').val() + '/edit/name',
                    data: {
                        'name': $('#modal-photo-name').val()
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.error) {
                            notifyError(data.error.title, data.error.content);
                        } else {
                            notify('Successfully', 'The photo name was updated.', null, null, 5000);
                        }

                        // update the title tag's input
                        var id = $('#modal-photo-id').val();
                        var title = $('#modal-photo-name').val();
                        var idInput = $('#image-row-' + id);

                        idInput.parent().find('.image-row-title-span').html(title);
                        $('#image-row-title-span-' + id).html(title);
                        $('#image-row-clicker-' + id).attr('data-title', title);

                        // reset
                        $('#modal-photo-name').val('');
                    }
                });
            })
        })
    </script>
@endsection
