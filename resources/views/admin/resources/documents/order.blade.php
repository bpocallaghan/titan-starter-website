@extends('admin.admin')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <span>Update Documents List Order</span>
        </div>

        <div class="card-body">
            <div>
                <a href="javascript:window.history.back();" class="btn btn-secondary">
                    <span class="label"><i class="fa fa-fw fa-chevron-left"></i></span>Back
                </a>
            </div>

            <div id="documentGridSortable">
                <!-- Documents -->
                <div class="row d-flex dd-list mt-3">
                    @forelse($documentable->documents->sortBy('list_order') as $document)
                        <div class="col-6 col-md-4 col-xl-3" data-id="{{ $document->id }}">
                            <div class="dd-item card dt-table">
                                <div class="card-header d-flex text-center">
                                    <button class="dd-handle btn btn-outline-secondary btn-xs mr-2" data-toggle="tooltip" title="Order Document">
                                        <i class="fas fa-fw fa-list"></i>
                                    </button>

                                    <span class="flex-fill text-left">
                                        <a class="btn btn-info btn-xs" href="{{ $document->url }}" target="_blank" title="View Document" data-toggle="tooltip">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                    </span>

                                    <a id="document-row-clicker-{{ $document->id }}" class="flex-fill text-truncate dropzone-document-click" href="javascript:void(0)" data-id="{{ $document->id }}" data-toggle="tooltip" data-title="{{ $document->name }}">
                                        <span id="document-row-title-span-{{ $document->id }}" class="document-row-title-span">{{ $document->name }}</span>
                                    </a>

                                    <form id="form-delete-row{{ $document->id }}" method="POST" action="/admin/resources/documents/{{ $document->id }}" class="dt-titan text-right flex-fill" style="display: inline-block;">
                                        <input name="_method" type="hidden" value="DELETE">
                                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                        <input name="_id" type="hidden" value="{{ $document->id }}">

                                        <a data-form="form-delete-row{{ $document->id }}" class="btn btn-danger btn-xs btn-delete-row text-light" data-toggle="tooltip" title="Delete document - {{ $document->name }}">
                                            <i class="fa fa-fw fa-times"></i>
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted">No documents to order. Pleasse go back and click on the panel to upload
                                documents to {!! $documentable->name !!}.</p>
                        </div>
                    @endforelse
                </div>
                <!-- END Documents -->
            </div>

        </div>
    </div>

    <div class="modal fade" id="modal-document" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header alert-success">
                    <h4 class="modal-title">Update Document Name</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="modal-document-id"/>

                        <fieldset style="padding: 0">
                            <section class="form-group">
                                <label for="modal-document-name">Name of the Document</label>
                                <input type="text" class="form-control" id="modal-document-name" placeholder="Enter the name of the Document">
                            </section>
                        </fieldset>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancel
                    </button>
                    <button id="btn-form-save-document" type="button" class="btn btn-primary">
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
        $(function () {

            initSortableMenu("/admin/resources/documents/order", "documentGridSortable");

            // Dropzone.autoDiscover = false;
            activateDocumentClick();
            initActionDeleteClick($('.documents-container'));

            function activateDocumentClick()
            {
                $('.dropzone-document-click').off('click');
                $('.dropzone-document-click').on('click', function (e) {
                    e.preventDefault();

                    var id = $($(this).parent().find('.document-row-id')).val();
                    var title = $($(this).parent().find('.document-row-title')).val();

                    if ($(this).attr('data-id')) {
                        id = $(this).attr('data-id');
                        title = $(this).attr('data-title');
                    }

                    $('#modal-document-id').val(id);
                    $('#modal-document-name').val(title);
                    $('#modal-document').modal();

                    return false;
                });
            }

            $('#btn-form-save-document').click(function (e) {
                e.preventDefault();

                $('#modal-document').modal('hide');

                if ($('#modal-document-name').val().length < 3) {
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: "/admin/resources/documents/" + $('#modal-document-id').val() + '/edit/name',
                    data: {
                        'name': $('#modal-document-name').val()
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.error) {
                            notifyError(data.error.title, data.error.content);
                        } else {
                            notify('Successfully', 'The document name was updated.', null, null, 5000);
                        }

                        // update the title tag's input
                        var id = $('#modal-document-id').val();
                        var title = $('#modal-document-name').val();

                        $('#document-row-title-span-' + id).html(title);
                        $('#document-row-title-span-' + id).html(title);
                        $('#document-row-clicker-' + id).attr('data-title', title).attr('title', title).attr('data-original-title', title);

                        // reset
                        $('#modal-document-name').val('');
                        $('#modal-document-id').val('');
                    }
                });
            })
        })
    </script>
@endsection
