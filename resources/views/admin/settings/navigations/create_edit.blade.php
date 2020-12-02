@extends('admin.admin')

@section('content')
    <div class="card  card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span><i class="fa fa-edit"></i></span>
                <span>{{ isset($item)? 'Edit the ' . $item->title . ' entry': 'Add a new ' . ucfirst($resource) }}</span>
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <form id="form-edit" method="post" action="{{ $selectedNavigation->url . (isset($item)? '/' . $item->id : '') }}">
            <div class="card-body">
                @include('admin.partials.card.info')

                {!! csrf_field() !!}
                {!! method_field(isset($item)? 'put':'post') !!}

                <fieldset>
                    <div class="row">
                        <div class="col col-3">
                            <div class="form-group">
                                <label for="icon">Icon</label>
                                <input type="text" class="form-control {{ form_error_class('icon', $errors) }}" id="icon" name="icon" placeholder="Enter icon" value="{{ ($errors && $errors->any()? old('icon') : (isset($item)? $item->icon : '')) }}">
                                {!! form_error_message('icon', $errors) !!}
                            </div>
                        </div>

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
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" class="form-control {{ form_error_class('description', $errors) }}" id="description" name="description" placeholder="Enter Description" value="{{ ($errors && $errors->any()? old('description') : (isset($item)? $item->description : '')) }}">
                                {!! form_error_message('description', $errors) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="roles">Roles <span class="small">(which user roles have access to navigation)</span></label>
                                {!! form_select('roles[]', $roles, ($errors && $errors->any()? old('roles') : (isset($item)? $item->roles->pluck('id')->all() : '')), ['class' => 'select2 form-control ' . form_error_class('roles', $errors), 'multiple']) !!}
                                {!! form_error_message('roles', $errors) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-2">
                            <div class="form-group clearfix">
                                <label for="id-is_hidden">Set Visibility</label>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="is_hidden" name="is_hidden" {!! ($errors && $errors->any()? (old('is_hidden') == 'on'? 'checked':'') : (isset($item)? $item->is_hidden == 1? 'checked' : '' : '')) !!}>
                                    <label for="is_hidden" class="custom-control-label">Is Hidden</label>
                                </div>
                            </div>
                        </div>

                        <div class="col col-5">
                            <div class="form-group">
                                <label for="id-parent_id">Parent <span class="small">(navigation parent, under which navigation it will display)</span></label>
                                {!! form_select('parent_id', ([0 => 'Please select a Parent'] + $parents), isset($item)? ($errors && $errors->any()? old('parent_id') : $item->parent_id) : old('parent_id'), ['class' => 'select2 form-control ' . form_error_class('parent_id', $errors)]) !!}
                                {!! form_error_message('parent_id', $errors) !!}
                            </div>
                        </div>

                        <div class="col col-5">
                            <div class="form-group">
                                <label for="id-url_parent_id">Url Parent <span class="small">(parent to generate the url, same as parent if empty)</span></label>
                                {!! form_select('url_parent_id', ([0 => 'Please select an Url Parent'] + $parents), ($errors && $errors->any()? old('url_parent_id') : (isset($item)? $item->url_parent_id : '')), ['class' => 'select2 form-control '.form_error_class('url_parent_id', $errors)]) !!}
                                {!! form_error_message('url_parent_id', $errors) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-3">
                            <div class="form-group">
                                <label for="help_index_title">Help Index Title</label>
                                <input type="text" class="form-control {{ form_error_class('help_index_title', $errors) }}" id="help_index_title" name="help_index_title" placeholder="Enter Help Index Title" value="{{ ($errors && $errors->any()? old('help_index_title') : (isset($item)? $item->help_index_title : '')) }}">
                                {!! form_error_message('help_index_title', $errors) !!}
                            </div>
                        </div>

                        <div class="col col-9">
                            <div class="form-group">
                                <label for="help_index_content">Help Index Content</label>
                                <input type="text" class="form-control {{ form_error_class('help_index_content', $errors) }}" id="help_index_content" name="help_index_content" placeholder="Enter Help Index Content" value="{{ ($errors && $errors->any()? old('help_index_content') : (isset($item)? $item->help_index_content : '')) }}">
                                {!! form_error_message('help_index_content', $errors) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-3">
                            <div class="form-group">
                                <label for="help_create_title">Help Create Title</label>
                                <input type="text" class="form-control {{ form_error_class('help_create_title', $errors) }}" id="help_create_title" name="help_create_title" placeholder="Enter Help Create Title" value="{{ ($errors && $errors->any()? old('help_create_title') : (isset($item)? $item->help_create_title : '')) }}">
                                {!! form_error_message('help_create_title', $errors) !!}
                            </div>
                        </div>

                        <div class="col col-9">
                            <div class="form-group">
                                <label for="help_create_content">Help Create Content</label>
                                <input type="text" class="form-control {{ form_error_class('help_create_content', $errors) }}" id="help_create_content" name="help_create_content" placeholder="Enter Help Create Content" value="{{ ($errors && $errors->any()? old('help_create_content') : (isset($item)? $item->help_create_content : '')) }}">
                                {!! form_error_message('help_create_content', $errors) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-3">
                            <div class="form-group">
                                <label for="help_edit_title">Help Edit Title</label>
                                <input type="text" class="form-control {{ form_error_class('help_edit_title', $errors) }}" id="help_edit_title" name="help_edit_title" placeholder="Enter Help Edit Title" value="{{ ($errors && $errors->any()? old('help_edit_title') : (isset($item)? $item->help_edit_title : '')) }}">
                                {!! form_error_message('help_edit_title', $errors) !!}
                            </div>
                        </div>

                        <div class="col col-9">
                            <div class="form-group">
                                <label for="help_edit_content">Help Edit Content</label>
                                <input type="text" class="form-control {{ form_error_class('help_edit_content', $errors) }}" id="help_edit_content" name="help_edit_content" placeholder="Enter Help Edit Content" value="{{ ($errors && $errors->any()? old('help_edit_content') : (isset($item)? $item->help_edit_content : '')) }}">
                                {!! form_error_message('help_edit_content', $errors) !!}
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            @include('admin.partials.form.form_footer')

        </form>
    </div>
@endsection
