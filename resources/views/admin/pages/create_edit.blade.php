@extends('admin.admin')

@section('content')

    <form method="POST" class="card card-primary" action="{{$selectedNavigation->url . (isset($item)? "/{$item->id}" : '')}}" accept-charset="UTF-8">
        {!! csrf_field() !!}
        {!! method_field(isset($item)? 'put':'post') !!}

        <div class="card-header">
            <h3 class="card-title">
                <span><i class="fa fa-edit"></i></span>
                <span>{{ isset($item)? 'Edit the ' . $item->name . ' entry': 'Create a new Page' }}</span>
            </h3>


            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            @include('admin.partials.card.info')

            <fieldset>
                <div class="row">
                    <div class="col col-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control input-generate-slug {{ form_error_class('name', $errors) }}" id="name" name="name" placeholder="Enter Name" value="{{ ($errors && $errors->any()? old('name') : (isset($item)? $item->name : '')) }}">
                            {!! form_error_message('name', $errors) !!}
                        </div>
                    </div>

                    <div class="col col-3">
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <div class="input-group">
                                <input type="text" class="form-control {{ form_error_class('slug', $errors) }}" id="slug" name="slug" placeholder="Enter Slug" value="{{ ($errors && $errors->any()? old('slug') : (isset($item)? $item->slug : '')) }}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-link"></i></span>
                                </div>
                                {!! form_error_message('slug', $errors) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col col-3">
                        <div class="form-group">
                            <label for="icon">Icon</label>
                            <input type="text" class="form-control {{ form_error_class('icon', $errors) }}" id="icon" name="icon" placeholder="Enter icon" value="{{ ($errors && $errors->any()? old('icon') : (isset($item)? $item->icon : '')) }}">
                            {!! form_error_message('icon', $errors) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-md-12">
                        <div class="form-group">
                            <label for="title">Meta Title <span class="small">(Browser tab title)</span></label>
                            <input type="text" class="form-control {{ form_error_class('title', $errors) }}" id="title" name="title" placeholder="Enter HTML Meta Title" value="{{ ($errors && $errors->any()? old('title') : (isset($item)? $item->title : '')) }}">
                            <p class="text-muted small"><i class="fa fa-info-circle"></i> SEO Tip: Less than 70 characters long, should be unique for every page.</p>
                            {!! form_error_message('title', $errors) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Meta Description <span class="small">(when you share page)</span></label>
                            <input type="text" class="form-control {{ form_error_class('description', $errors) }}" id="description" name="description" placeholder="Enter Description" value="{{ ($errors && $errors->any()? old('description') : (isset($item)? $item->description : '')) }}">
                            <p class="text-muted small"><i class="fa fa-info-circle"></i> SEO Tip: Between 150 - 160 characters long, should be unique for every page. Should include keywords relevant to the content of the page they describe.</p>
                            {!! form_error_message('description', $errors) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-6">
                        <div class="form-group">
                            <label for="id-parent_id">Parent <span class="small">(navigation parent, under which navigation it will display)</span></label>
                            {!! form_select('parent_id', ([0 => 'Please select a Parent'] + $parents), isset($item)? ($errors && $errors->any()? old('parent_id') : $item->parent_id) : old('parent_id'), ['class' => 'select2 form-control ' . form_error_class('parent_id', $errors)]) !!}
                            {!! form_error_message('parent_id', $errors) !!}
                        </div>
                    </div>

                    <div class="col col-6">
                        <div class="form-group">
                            <label for="id-url_parent_id">Url Parent <span class="small">(parent to generate the url)</span></label>
                            {!! form_select('url_parent_id', ([0 => 'Please select an Url Parent'] + $parents), ($errors && $errors->any()? old('url_parent_id') : (isset($item)? $item->url_parent_id : '')), ['class' => 'select2 form-control ' . form_error_class('url_parent_id', $errors)]) !!}
                            {!! form_error_message('url_parent_id', $errors) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {{ form_error_class('banners', $errors) }}">
                            <label for="banners">Banners <span class="small">(leave empty to use the default banners)</span></label>
                            {!! form_select('banners[]', $banners, ($errors && $errors->any()? old('banners') : (isset($item)? $item->banners->pluck('id')->all() : '')), ['class' => 'select2 form-control', 'multiple']) !!}
                            {!! form_error_message('banners', $errors) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="is_header" class="custom-control-input" id="is_header" {!! ($errors && $errors->any()? (old('is_header') == 'on'? 'checked':'') : (isset($item)? $item->is_header == 1? 'checked' : '' : 'checked')) !!}>
                            <label class="custom-control-label" for="is_header">Is Header</label>
                        </div>
                        {!! form_error_message('is_header', $errors) !!}
                    </div>

                    <div class="col col-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="is_footer" class="custom-control-input" id="is_footer" {!! ($errors && $errors->any()? (old('is_footer') == 'on'? 'checked':'') : (isset($item)&& $item->is_footer == 1? 'checked' : '' )) !!}>
                            <label class="custom-control-label" for="is_footer">Is Footer</label>
                        </div>
                        {!! form_error_message('is_footer', $errors) !!}
                    </div>

                    <div class="col col-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="is_hidden" class="custom-control-input" id="is_hidden" {!! ($errors && $errors->any()? (old('is_hidden') == 'on'? 'checked':'') : (isset($item)&& $item->is_hidden == 1? 'checked' : '' )) !!}>
                            <label class="custom-control-label" for="is_hidden">Is Hidden</label>
                        </div>
                        {!! form_error_message('is_hidden', $errors) !!}
                    </div>

                    <div class="col col-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="is_featured" class="custom-control-input" id="is_featured" {!! ($errors && $errors->any()? (old('is_featured') == 'on'? 'checked':'') : (isset($item)&& $item->is_featured == 1? 'checked' : '' )) !!}>
                            <label class="custom-control-label" for="is_featured">Is Featured</label>
                        </div>
                        {!! form_error_message('is_featured', $errors) !!}

                    </div>
                </div>
            </fieldset>
        </div>

        @include('admin.partials.form.form_footer')
    </form>

    @if(isset($item))
        @include('admin.pages.components.components', ['page' => $item, 'url' => "/admin/pages/{$item->id}/sections"])
    @endif
@endsection
