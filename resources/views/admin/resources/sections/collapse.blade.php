<form method="POST" action="{{"/admin/{$resource}/{$resourceable->id}/sections" . (isset($section)? "/{$section->id}" : '')}}" accept-charset="UTF-8">
    <input name="_token" type="hidden" value="{{ csrf_token() }}">
    <input name="_method" type="hidden" value="{{isset($section)? 'PUT':'POST'}}">
    <input name="page_id" type="hidden" value="{{isset($resourceable)? $resourceable->id: ''}}">
    <input type="hidden" name="sectionable_id" value="{{ $resourceable->id }}">
    <input type="hidden" name="sectionable_type" value="{{ get_class($resourceable) }}">
    <input type="hidden" name="sectionable_type_name" value="{{ (new \ReflectionClass($resourceable))->getShortName() }}">

    <fieldset>
        <div class="row">
            <div class="col-md-12">
                <div class="callout callout-info callout-help">
                    <h4 class="title">Section Info</h4>
                    <p>This section will belong to the {{$resource}}: <strong>{{ $resourceable->name }}</strong></p>
                    <p><i class="fa fa-exclamation-circle"></i> No name, nor description is required, however you have to submit in order for the section to be created.</p>
                </div>
            </div>
        </div>
        <div class="row card-body">
            <div class="col-md-8">
                <div class="form-group {{ form_error_class('name', $errors) }}">
                    <label for="name">Section Name (Optional)</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Please insert the Section Name" value="{{ ($errors && $errors->any()? old('name') : (isset($section)? $section->name : '')) }}">
                    {!! form_error_message('name', $errors) !!}
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group {{ form_error_class('layout', $errors) }}">
                    <label for="layout">Content layout</label>
                    {!! form_select('layout',  $resourceable->layouts, ($errors && $errors->any()? old('layout') : (isset($section)? $section->layout : 'section')), ['class' => 'select2 form-control', 'id' => 'layout-'.(isset($section)? $section->id: '') ]) !!}
                    {!! form_error_message('layout', $errors) !!}
                </div>
            </div>
        </div>

        <div class="px-3">
            @include('admin.resources.sections.components.form_content', ['item'=> isset($section)? $section :  null])
        </div>
    </fieldset>
    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @include('admin.partials.form.form_footer')
</form>
