@extends('admin.admin')

@section('styles')
    <style>
        .cropper-box {
            margin: auto;
            min-height: 500px;
        }

        .preview {
            width: 100%;
            margin: auto;
            overflow: hidden;
            min-height: 100px;
            border: 1px solid lightgrey;
        }

        .cropper-container img {
            max-width: 100%; /* This rule is very important, please do not ignore this! */
            height:auto;
        }

    </style>
@endsection

@section('content')
    <div class="row ">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <span>Crop {{ $photoable->name }}</span>
                </div>

                <div class="card-body">

                    <div class="row cropper-container">
                        <div class="col-md-3">
                            <h4>Current Thumb</h4>
                            <img src="{{ $photoable->thumb_url }}" title="{{ $photoable->name }}" alt="{{ $photoable->name }}">
                        </div>

                        <div class="col-md-6">
                            <div class="cropper-box">
                                <h4>Crop</h4>
                                <img id="image-cropper" src="{{ $photoable->original_url }}" title="{{ $photoable->name }}" alt="{{ $photoable->name }}">
                            </div>

                            <div class="row docs-buttons mt-1 text-center">
                                <div class="col-12">

                                    <div class="btn-group mr-1">
                                        <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">
                                          <span class="fa fa-arrows-alt"></span>
                                        </span>
                                        </button>
                                        <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;setDragMode&quot;, &quot;crop&quot;)">
                                          <span class="fa fa-crop-alt"></span>
                                        </span>
                                        </button>
                                    </div>

                                    <div class="btn-group mr-1">
                                        <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;zoom&quot;, 0.1)">
                                          <span class="fa fa-search-plus"></span>
                                        </span>
                                        </button>
                                        <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;zoom&quot;, -0.1)">
                                          <span class="fa fa-search-minus"></span>
                                        </span>
                                        </button>
                                    </div>

                                    <div class="btn-group mr-1">
                                        <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;move&quot;, -10, 0)">
                                          <span class="fa fa-arrow-left"></span>
                                        </span>
                                        </button>
                                        <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;move&quot;, 10, 0)">
                                          <span class="fa fa-arrow-right"></span>
                                        </span>
                                        </button>
                                        <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;move&quot;, 0, -10)">
                                          <span class="fa fa-arrow-up"></span>
                                        </span>
                                        </button>
                                        <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;move&quot;, 0, 10)">
                                          <span class="fa fa-arrow-down"></span>
                                        </span>
                                        </button>
                                    </div>

                                    <div class="btn-group mr-1">
                                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;rotate&quot;, -45)">
                                          <span class="fa fa-undo-alt"></span>
                                        </span>
                                        </button>
                                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;rotate&quot;, 45)">
                                          <span class="fa fa-redo-alt"></span>
                                        </span>
                                        </button>
                                    </div>

                                    <div class="btn-group mr-1">
                                        <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;scaleX&quot;, -1)">
                                          <span class="fa fa-arrows-alt-h"></span>
                                        </span>
                                        </button>
                                        <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;scaleY&quot;, -1)">
                                          <span class="fa fa-arrows-alt-v"></span>
                                        </span>
                                        </button>
                                    </div>

                                    <div class="btn-group mr-1">
                                        <button type="button" class="btn btn-primary" data-method="crop" title="Crop">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;crop&quot;)">
                                          <span class="fa fa-check"></span>
                                        </span>
                                        </button>
                                        <button type="button" class="btn btn-primary" data-method="clear" title="Clear">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;clear&quot;)">
                                          <span class="fa fa-times"></span>
                                        </span>
                                        </button>
                                    </div>

                                    <div class="btn-group mr-1">
                                        <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
                                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="$().cropper(&quot;reset&quot;)">
                                          <span class="fa fa-sync-alt"></span>
                                        </span>
                                        </button>

                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="col-md-3">
                            <h4>Preview</h4>
                            <div class="preview"></div>
                        </div>
                    </div>


                </div>
                <div class="card-footer">
                    <a href="javascript:window.history.back();" class="btn btn-labeled btn-secondary float-left">
                        <span class="btn-label"><i class="fa fa-fw fa-chevron-left"></i></span>Back
                    </a>

                    <button id="btn-crop-photo" class="btn btn-labeled btn-primary btn-ajax-submit float-right">
                        <span class="btn-label"><i class="fa fa-fw fa-save"></i></span>
                        Update Photo
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function () {
            var cropperData = false;
            var $image = $('#image-cropper');

            var minWidth = 0;
            var minHeight = 0;

            var minCropWidth = 0;
            var minCropHeight = 0;
            var photoableMinWidth = '{{ isset($photoable::$THUMB_SIZE)? $photoable::$THUMB_SIZE[0]:'' }}';
            var photoableMinHeight = '{{ isset($photoable::$THUMB_SIZE)? $photoable::$THUMB_SIZE[1]:'' }}';

            if(photoableMinWidth != '' && photoableMinHeight != ''){
                minWidth = parseInt(photoableMinWidth);
                minHeight = parseInt(photoableMinHeight) + 25;
            }else {
                minWidth = $image.width();
                minHeight = $image.height() + 25;
            }


            $('.preview').css({
                width: '100%', //width,  sets the starting size to the same as orig image
                overflow: 'hidden',
                height:    minHeight,
                maxWidth:  minWidth,
                maxHeight: minHeight
            });

            var options = {
                aspectRatio: minWidth / minHeight,
                preview: '.preview',
                viewMode: 0
            };

            // Cropper
            $image.on({
                ready: function () {
                    cropperData = $(this).cropper('getData', true);

                    // add restrictions when natural image is bigger than minimum allowed
                    if (cropperData.width > minWidth && cropperData.height > minHeight) {
                        // get the original cropbox data
                        var originalBoxData = $image.cropper('getCropBoxData');
                        // set the crop area to minimum image size
                        $image.cropper('setData', {
                            width: minWidth,
                            height: minHeight
                        });
                        // set the minimum cropbox width and height
                        var cropBoxData = $image.cropper('getCropBoxData');
                        minCropWidth = cropBoxData.width;
                        minCropHeight = cropBoxData.height;
                        // reset the cropbox area to initialize
                        $image.cropper('setCropBoxData', {
                            width: originalBoxData.width,
                            height: originalBoxData.height,
                        });
                    } else {
                        notifyError("Image Size", "The image uploaded is smaller than the minimum required size.");
                    }
                },
                crop: function (e) {
                    // get crop data - round to integer
                    cropperData = $(this).cropper('getData', true);
                },
                cropmove: function (e) {
                    if (minCropWidth > 0) {
                        var imageData = $image.cropper('getData', true);

                        // if image width is less than minimum
                        if (imageData.width < minWidth) {
                            $image.cropper('setCropBoxData', {
                                width: minCropWidth
                            });
                        }

                        // if image height is less than minimum
                        if (imageData.height < minHeight) {
                            $image.cropper('setCropBoxData', {
                                height: minCropHeight
                            });
                        }
                    }
                }
            }).cropper(options);


            $('#btn-crop-photo').click(function (e) {
                e.preventDefault();

                cropperData['photoable_id'] = "{{ $photoable->id }}";
                cropperData['photoable_type'] = "{{ str_replace('\\','\\\\',get_class($photoable)) }}";
                cropperData['photoable_type_name'] = "{{ (new \ReflectionClass($photoable))->getShortName() }}";

                doAjax("/admin/resources/photos/crop-resource", cropperData, function (response) {

                    if (response.error) {
                        notifyError(response.error.title, response.error.content);
                    } else {
                        notify('Cropped', 'The photo was successfully cropped.', 'success', 'fa fa-smile-o bounce animated', 5000);
                    }
                });
            });

            // Buttons
            if (typeof document.createElement('cropper').style.transition === 'undefined') {
                $('button[data-method="rotate"]').prop('disabled', true);
                $('button[data-method="scale"]').prop('disabled', true);
            }

            // Methods
            $('.docs-buttons').on('click', '[data-method]', function () {
                var $this = $(this);
                var data = $this.data();
                var cropper = $image.data('cropper');
                var cropped;
                var $target;
                var result;

                if ($this.prop('disabled') || $this.hasClass('disabled')) {
                    return;
                }

                if (cropper && data.method) {
                    data = $.extend({}, data); // Clone a new one

                    if (typeof data.target !== 'undefined') {
                        $target = $(data.target);

                        if (typeof data.option === 'undefined') {
                            try {
                                data.option = JSON.parse($target.val());
                            } catch (e) {
                                console.log(e.message);
                            }
                        }
                    }

                    cropped = cropper.cropped;

                    switch (data.method) {
                        case 'rotate':
                            if (cropped && options.viewMode > 0) {
                                $image.cropper('clear');
                            }

                            break;

                        case 'getCroppedCanvas':
                            if (uploadedImageType === 'image/jpeg') {
                                if (!data.option) {
                                    data.option = {};
                                }

                                data.option.fillColor = '#fff';
                            }

                            break;
                    }

                    result = $image.cropper(data.method, data.option, data.secondOption);

                    switch (data.method) {
                        case 'rotate':
                            if (cropped && options.viewMode > 0) {
                                $image.cropper('crop');
                            }

                            break;

                        case 'scaleX':
                        case 'scaleY':
                            $(this).data('option', -data.option);
                            break;

                        case 'destroy':
                            if (uploadedImageURL) {
                                URL.revokeObjectURL(uploadedImageURL);
                                uploadedImageURL = '';
                                $image.attr('src', originalImageURL);
                            }

                            break;
                    }

                    if ($.isPlainObject(result) && $target) {
                        try {
                            $target.val(JSON.stringify(result));
                        } catch (e) {
                            console.log(e.message);
                        }
                    }
                }
            });

            // Keyboard
            $(document.body).on('keydown', function (e) {
                if (e.target !== this || !$image.data('cropper') || this.scrollTop > 300) {
                    return;
                }

                switch (e.which) {
                    case 37:
                        e.preventDefault();
                        $image.cropper('move', -1, 0);
                        break;

                    case 38:
                        e.preventDefault();
                        $image.cropper('move', 0, -1);
                        break;

                    case 39:
                        e.preventDefault();
                        $image.cropper('move', 1, 0);
                        break;

                    case 40:
                        e.preventDefault();
                        $image.cropper('move', 0, 1);
                        break;
                }
            });
        })
    </script>
@endsection
