@section('styles')
    @parent
    <style>
        #form-modal-documents .select2.select2-container {
            display: block;
            width: 100% !important;
        }
    </style>
@endsection

<button type="button" data-toggle="modal" data-target="#modal-documents-attach" class="mt-3 btn btn-info">Attach an existing document</button>

<div class="modal fade" id="modal-documents-attach" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alert-info">
                <h4 class="modal-title">Attach Document</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="form-modal-documents-attach">
                    <input type="hidden" name="attach_documentable_id" value="{{ $documentable->id }}">
                    <input type="hidden" name="attach_documentable_type" value="{{ get_class($documentable) }}">
                    <input type="hidden" name="attach_documentable_type_name" value="{{ (new \ReflectionClass($documentable))->getShortName() }}">

                    <div class="form-group">
                        <label for="name">Custom Name</label>
                        <input type="text" class="form-control" name="attach_name" placeholder="Text to display" value="">
                    </div>
                    <div class="form-group">
                        <label for="document">Document</label>
                        @if(isset($documents))
                            {!! form_select('attach_document_id', ([0 => 'Please select a Document'] + $documentable->all_documents), null, ['class' => 'select2 form-control']) !!}
                        @endif
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel
                </button>
                <button id="modal-documents-attach-submit" type="button" class="btn btn-primary" data-dismiss="modal">
                    Add Document
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
            $('#modal-documents-attach-submit').on('click', function () {
                var name = $('#modal-documents-attach input[name=attach_name]');
                var id = $('#modal-documents-attach select[name=attach_document_id]').find(":selected").val();

                // basic validation
                if (id.length > 0) {

                    $.ajax({
                        type: 'POST',
                        url: "/admin/resources/documents/attach",
                        data: {
                            'id': id,
                            'name': name.val(),
                            'documentable_id': $('#modal-documents-attach input[name=attach_documentable_id]').val(),
                            'documentable_type': $('#modal-documents-attach input[name=attach_documentable_type]').val(),
                        },
                        dataType: "json",
                        success: function (data) {

                            if (data.error) {
                                notifyError(data.error.title, data.error.content);
                            } else {
                                notify('Successfully', 'The document attached.', null, null, 5000);
                            }

                            // update the title tag's input
                            var id = data.data.id;
                            var title = data.data.name;
                            var url = data.data.url;

                            // var active_from = data.data.active_from;
                            // var active_to = data.data.active_to;

                            if($('#documentGridSortable .dd-list .col-12').length > 0){
                                $('#documentGridSortable .dd-list .col-12').remove();
                            }

                            var html ='<div class="col-6 col-md-4 col-xl-3" data-id="'+id+'">'
                                        +'<div class="dd-item card dt-table">'
                                            +'<div class="card-header d-flex text-center">'
                                                +'<button class="dd-handle btn btn-outline-secondary btn-xs mr-2" data-toggle="tooltip" title="Order Document">'
                                                    +'<i class="fas fa-fw fa-list"></i>'
                                                +'</button>'
                                                +'<span class="flex-fill text-left">'
                                                    +'<a class="btn btn-info btn-xs" href="'+url+'" target="_blank" title="View Document" data-toggle="tooltip">'
                                                        +'<i class="fa fa-fw fa-eye"></i>'
                                                    +'</a>'
                                                +'</span>'
                                                +'<a id="document-row-clicker-'+id+'" class="flex-fill text-truncate dropzone-document-click" href="javascript:void(0)" data-id="'+id+'" data-toggle="tooltip" data-title="'+title+'">'
                                                    +'<span id="document-row-title-span-'+id+'" class="document-row-title-span">'+title+'</span>'
                                                +'</a>'
                                                +'<form id="form-delete-row'+id+'" method="POST" action="/admin/resources/documents/'+id+'" class="dt-titan text-right flex-fill" style="display: inline-block;">'
                                                    +'<input name="_method" type="hidden" value="DELETE">'
                                                    +'<input name="_token" type="hidden" value="{{ csrf_token() }}">'
                                                    +'<input name="_id" type="hidden" value="'+id+'">'
                                                    +'<a data-form="form-delete-row'+id+'" class="btn btn-danger btn-xs btn-delete-row text-light" data-toggle="tooltip" title="Delete document - '+title+'">'
                                                        +'<i class="fa fa-fw fa-times"></i>'
                                                    +'</a>'
                                                +'</form>'
                                            +'</div>'
                                        +'</div>'
                                    +'</div>';

                            $('#documentGridSortable .dd-list').append(html);


                        }
                    });
                }

                // reset
                name.val('');
            })
        })
    </script>
@endsection
