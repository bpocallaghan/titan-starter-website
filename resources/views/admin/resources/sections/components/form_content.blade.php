<div class="row">
    <div class="col col-md-12">
        <section class="form-group">
            <label for="content-content">Content</label>
            <textarea class="form-control summernote content-content {{ form_error_class('content', $errors) }}" id="content-content" name="content" rows="30" placeholder="Please insert the Content">{{ ($errors && $errors->any()? old('content') : (isset($item)? $item->content : '')) }}</textarea>
            {!! form_error_message('content', $errors) !!}
        </section>
    </div>
</div>

@include('admin.partials.summernote.document', ['summernote' => '.content-content'])

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function () {
            pageSummerNote('.content-content', {{ $height ?? '300' }});

            function pageSummerNote(selector, height)
            {
                $(selector).summernote({
                    height: height ? height : 120,
                    focus: false,
                    tabsize: 2,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'strikethrough','superscript', 'subscript', 'clear']],
                        ['color', ['color']],
                        ['layout', ['ul', 'ol', 'paragraph']],
                        ['insert', ['table', 'link', 'document', /*, 'picture', 'video',*/ 'hr']],
                        ['misc', ['fullscreen', 'codeview', 'undo']]
                    ],
                    buttons: {
                        document: DocumentButton
                    },
                });
            }
        })
    </script>
@endsection
