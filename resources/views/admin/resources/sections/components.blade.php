<div class="alert alert-info collapse helpSections scroll-collapse">
    <h5 class="title"><i class="far fa-fw fa-question-circle"></i> <a class="text-decoration-none" data-toggle="collapse" href=".helpSections" aria-expanded="false" aria-controls=".helpSections">How to create Sections</a></h5>
    <ul>
        <li>Click on <label class="badge badge-light"><i class="fa fa-fw fa-plus"></i> Create Section</label> found at the bottom of the page.</li>
        <li>To update the sections you can either click on the title or on the <label class="badge badge-light"><i class="fa fa-fw fa-edit"></i> Edit</label> button found on the right of the section block header. </li>
        <li>Update the list order by dragging the elements by the <label class="badge badge-light"><i class="fa fa-fw fa-list"></i> Order</label> button up or down, found on the right of the section block header. </li>
        <li>Remove the section by clicking on the <label class="badge badge-light"><i class="fa fa-fw fa-trash"></i> Delete</label> button, found on the right of the section block header.  </li>
        <li>Sections can have a name / title, content and resources (Images, Videos, Documents).</li>
        <li>Each section can have multiple content components within.</li>
    </ul>
</div>


@if(($resourceable->sections->count() > 0))
    <div id="sectionsOrderSortable">
        <div class="dd-list list-group">
            @foreach($resourceable->sections->sortBy('list_order') as $section)
                <div class="card card-primary" data-id="{{ $section->id }}">
                    <div class="card-header">
                        <a data-toggle="collapse" href="#section-collapse{{ $section->id }}" aria-expanded="false" aria-controls="section-collapse{{ $section->id }}"><span>{!! $resourceable->name !!} - @if($section->name != '') {{ $section->name }}  @else Section Name (Optional) {{ (isset($section->summary) && $section->summary != '' ? ' - '.$section->summary: 'Section Description (Optional)') }}  @endif </span></a>

                        <div class="card-tools">

                            <span class="float-left" data-toggle="tooltip" title="Help" data-original-title="Help">
                                <button class="btn btn-tool" data-toggle="collapse" data-target=".helpSections" aria-expanded="false" aria-controls=".helpSections"> <span><i class="fa fa-fw fa-question-circle" aria-hidden="true"></i> Help </span></button>
                            </span>

                            <span class="float-left" data-toggle="tooltip" title="Order Section" data-original-title="Order Section">
                                <button type="button" class="dd-handle btn btn-tool" href="#"> <i class="fa fa-fw fa-list"></i> Order </button>
                            </span>

                            <span class="float-left" data-toggle="tooltip" title="Edit Section" data-original-title="Edit Section">
                                <a class="btn btn-tool" data-toggle="collapse" href="#section-collapse{{ $section->id }}" aria-expanded="false" aria-controls="section-collapse{{ $section->id }}"> <span><i class="fa fa-fw fa-edit" aria-hidden="true"></i> Edit </span></a>
                            </span>

                            <span class="float-left dt-titan" data-toggle="tooltip" title="Delete Section" data-original-title="Delete Section">
                                <form id="form-delete-row{{ $resourceable->id }}-{{ $section->id }}" method="POST" action="/admin/{{ $resource }}/{{ $resourceable->id }}/sections/{{ $section->id }}">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input name="_id" type="hidden" value="{{ $section->id }}">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                    <button type="submit" data-form="form-delete-row{{ $resourceable->id }}-{{ $section->id }}" class="btn btn-tool btn-delete-row" data-original-title="Delete section - {{ $section->name }}">
                                        <i class="fa fa-fw fa-trash"></i> Delete
                                    </button>
                                </form>
                            </span>

                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="card collapse" id="section-collapse{{ $section->id }}">
                            @include('admin.resources.sections.collapse')
                        </div>

                        <div class="alert alert-info collapse helpContent{{ $section->id }}">
                            <h5 class="title"><i class="far fa-fw fa-question-circle"></i> <a class="text-decoration-none" data-toggle="collapse" href=".helpContent{{ $section->id }}" aria-expanded="false" aria-controls=".helpContent{{ $section->id }}">How to create Content</a></h5>
                            <ul>
                                <li>Click on <label class="badge badge-light"><i class="fa fa-fw fa-plus"></i> Create Content</label> button.</li>
                                <li>Content from other items can also be attached for the same content on two different items. This is also a quick way to share the same images on two different items.</li>
                                <li>To update the content click on the edit icon <label class="badge badge-light"><i class="fa fa-fw fa-edit"></i></label>, found on the right of the heading. </li>
                                <li>Update the order by dragging the elements by the list icon <label class="badge badge-light"><i class="fa fa-fw fa-list"></i></label> up or down, found on the left of the heading. </li>
                                <li>Delete the content by clicking on the red trash icon <label class="badge badge-light"><i class="fa fa-fw fa-trash-alt"></i></label>, found on the right of the heading. </li>
                                <li>Remove the content by clicking on the yellow times icon <label class="badge badge-light"><i class="fa fa-fw fa-times"></i></label>, found on the right of the heading. </li>
                            </ul>
                        </div>

                        <div class="mb-3" id="nestable-menu">

                            <a class="btn btn-primary" href="{{ (isset($url)? $url : request()->url()).'/'.$section->id.'/content/create' }}">
                                <span class="label"><i class="fa fa-fw fa-plus"></i></span>
                                Create Content
                            </a>

                            <a class="btn btn-light" href="/admin/{{$resource}}/sections/{{$section->id}}/resources#resources-photos">
                                <span class="label"><i class="fa fa-fw fa-images"></i></span>
                                Gallery
                                @if(isset($section->photos) && $section->photos->count() > 0)<span class="badge badge-light">({{ $section->photos->count() }})</span> @endif
                            </a>

                            <a class="btn btn-light" href="/admin/{{$resource}}/sections/{{$section->id}}/resources#resources-videos">
                                <span class="label"><i class="fa fa-fw fa-film"></i></span>
                                Video Gallery
                                @if(isset($section->videos) && $section->videos->count() > 0)<span class="badge badge-light">({{ $section->videos->count() }})</span> @endif
                            </a>

                            <a class="btn btn-light" href="/admin/{{$resource}}/sections/{{$section->id}}/resources#resources-documents">
                                <span class="label"><i class="fa fa-fw fa-file-pdf"></i></span>
                                Documents Gallery
                                @if(isset($section->documents) && $section->documents->count() > 0)<span class="badge badge-light">({{ $section->documents->count() }})</span> @endif
                            </a>

                            <a class="btn btn-light float-right" data-toggle="collapse" href=".helpContent{{ $section->id }}" aria-expanded="false" aria-controls=".helpContent{{ $section->id }}">
                                <span class="label"><i class="far fa-fw fa-question-circle"></i></span>
                                Help
                            </a>

                        </div>

                        <div class="mb-3" id="nestable-menu">
                            <form method="POST" action="/admin/{{$resource}}/{{ $resourceable->id . '/sections/'.$section->id.'/content/attach'}}" accept-charset="UTF-8" enctype="multipart/form-data">
                                {!! csrf_field() !!}
                                {!! method_field('post') !!}
                                <input name="section_id" type="hidden" value="{{ $section->id }}">
                                <input name="attatch" type="hidden" value="true">

                                <div class="form-row d-flex align-items-end">
                                    <div class="p-3 flex-grow-1">
                                        <label for="category">Attach a Content Component</label>
                                        {!! form_select('content_id', ([0 => 'Please select a Content Components'] + $resourceable->other_content), ($errors && $errors->any()? old('content_id') : (isset($item)? $item->content_id : '')), ['id' => 'content-id-'.$section->id, 'class' => 'select2 form-control '.form_error_class('content_id', $errors)]) !!}
                                        {!! form_error_message('content_id', $errors) !!}
                                    </div>
                                    <div class="p-3 ">
                                        <button class="btn btn-info btn-submit float-right">
                                            <i class="fa fa-fw fa-plus"></i> Attach
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>

                        @include('admin.resources.sections.components.components', ['section' => $section, 'resource' => $resource])
                    </div>
                </div>
            @endforeach
        </div>
    </div>


@endif
<div class="row">
    <div class="col-12 text-right">
        <a href="{{ isset($back)? "/admin/{$back}/" : (isset($resource)? "/admin/{$resource}/" : "javascript:window.history.back();") }}" class="btn btn-secondary ">
            <i class="fa fa-fw fa-chevron-left"></i> Back
        </a>
        <a href="{{ "/admin/{$resource}/{$resourceable->id}/sections/create" }}" class="btn btn-labeled btn-primary">
            <span class="btn-label"><i class="fa fa-fw fa-plus"></i></span>
            Create Section
        </a>
    </div>
</div>

@section('scripts')
    @parent
    @include('admin.partials.sortable')
    <script type="text/javascript" charset="utf-8">
        $(function () {
            initSortableMenu("{{ (isset($url)? $url : request()->url()) }}/order", 'sectionsOrderSortable', false);
        })
    </script>
@endsection
