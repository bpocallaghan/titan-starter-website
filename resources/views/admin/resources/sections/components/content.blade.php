@extends('admin.admin')

@section('content')

    <form class="card card-primary" method="POST" action="/admin/{{$resource}}/{{ $resourceable->id . '/sections/'.$section->id.'/content' . (isset($item)? "/{$item->id}" : '')}}" accept-charset="UTF-8" enctype="multipart/form-data">
        {!! csrf_field() !!}
        {!! method_field(isset($item)? 'put':'post') !!}
        <input name="section_id" type="hidden" value="{{ $section->id }}">

        <div class="card-header">
            <span>{{ isset($item)? 'Edit the "' . (isset($item->heading)? $item->heading : (isset($section->name)? $section->name.' (Section)' : $section->sectionable->name.' ('.(new \ReflectionClass($section->sectionable))->getShortName().')' )) . '" content entry': 'Create a new Content' }}</span>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="callout callout-info callout-help">
                <h4 class="title">How it works?</h4>
                <ul>
                    <li>Enter heading & choose heading size (optional)</li>
                    <li>Browse for a featured photo, choose the alignment for the image & enter caption (optional)</li>
                    <li>Enter content (optional)</li>
                    <li>Click on submit to save changes, you will be redirected back in order to upload videos, photos & documents</li>
                    <li>Scroll below to upload videos to the page content section (optional)</li>
                    <li>Scroll below to upload photos to the page content section (optional)</li>
                    <li>Scroll below to upload documents to the page content section (optional)</li>
                </ul>
            </div>

            <fieldset>
                @include('admin.resources.sections.components.form_heading')

                <div class="row">
                    <div class="@if(isset($item) && $item->media) col-md-6 @else col-md-8 @endif">
                        <div class="form-group">
                            <label>Upload your Photo - Maximum 2MB <span class="small">(Optional)</span> </label>
                            <div class="input-group">
                                <input id="media-label" type="text" class="form-control {{ form_error_class('media', $errors) }}" readonly placeholder="Browse for a photo">
                                <input id="media" style="display: none" accept="{{ get_file_extensions('image') }}" type="file" name="media" onchange="document.getElementById('media-label').value = this.value">
                                {!! form_error_message('media', $errors) !!}

                                <div class="input-group-append">
                                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('media').click();">Browse</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="media_align">Media Alignment</label>
                            {!! form_select('media_align', ['left'  => 'Left', 'right' => 'Right', 'top'   => 'Top / Center'], ($errors && $errors->any()? old('media_align') : (isset($item)? $item->media_align : 'left')), ['class' => 'select2 form-control '.form_error_class('media_align', $errors) ]) !!}
                            {!! form_error_message('media_align', $errors) !!}
                        </div>
                    </div>

                    @if(isset($item) && $item->media)
                        <div class="col-md-2 text-center" id="media-box">
                            <a data-lightbox="Feature Image" href="{{ $item->imageUrl }}">
                                <img class="img-fluid mt-2" src="{{ $item->thumb_url }}" style="height:75px;"/>
                            </a>
                            <button title="Remove media" class="btn btn-danger btn-xs btn-delete-row pull-right btn-delete-media" id="form-delete-row{{ $item->id }}" data-id="{{ $item->id }}" data-resource-id="{{ $item->id }}">
                                <i class="fa fa-fw fa-times"></i></button>
                                <a href="/admin/resources/content/{{ $item->id }}/crop-resource" title="Crop media" class="btn btn-info btn-xs pull-right">
                                    <i class="fa fa-fw fa-crop-alt"></i>
                                </a>
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="caption">Media Caption <span class="small">(Optional, good for SEO)</span></label>
                            <input type="text" class="form-control {{ form_error_class('caption', $errors) }}" id="caption" name="caption" placeholder="Enter Caption" value="{{ ($errors && $errors->any()? old('caption') : (isset($item)? $item->caption : '')) }}">
                            {!! form_error_message('caption', $errors) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="action_name">Action Name <span class="small">(Optional)</span></label>
                            <input type="text" class="form-control {{ form_error_class('action_name', $errors) }}" id="action_name" name="action_name" placeholder="Enter Action Name" value="{{ ($errors && $errors->any()? old('action_name') : (isset($item)? $item->action_name : '')) }}">
                            {!! form_error_message('action_name', $errors) !!}
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="action_url">Action Url <span class="small">(Optional)</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control {{ form_error_class('action_url', $errors) }}" id="action_url" name="action_url" placeholder="Enter Action Url" value="{{ ($errors && $errors->any()? old('action_url') : (isset($item)? $item->action_url : '')) }}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-link"></i></span>
                                </div>
                                {!! form_error_message('action_url', $errors) !!}
                            </div>
                        </div>
                    </div>
                </div>

                @include('admin.resources.sections.components.form_content')

            </fieldset>

        </div>
        @include('admin.partials.form.form_footer')
    </form>

    @if(isset($item))
        @include('admin.resources.resourceable', ['resource' => $item])
    @endif
@endsection


@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function () {

            $('.btn-delete-media').on('click', function (e) {
                e.preventDefault();

                $id = $(this).attr('data-id');
                $resourceable_id = $(this).attr('data-resource-id');

                $.ajax({
                    type: 'POST',
                    url: "/admin/{{$resource}}/" + $resourceable_id + "/sections/{{$section->id}}/content/" + $id + "/removeMedia",
                    dataType: "json",
                    success: function (data) {
                        if (data.error) {
                            notifyError(data.error.title, data.error.content);
                        } else {
                            notify('Successfully', 'The media was successfully removed.', null, null, 5000);
                        }

                        $('body').find('#media-box').html('');
                    }
                });
            });
        });
    </script>
@endsection
