@extends('admin.admin')

@section('content')
    <div class="card  card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span><i class="fa fa-edit"></i></span>
                <span>{{ isset($item)? 'Edit the ' . $item->title . ' entry': 'Create a new Layout' }}</span>
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <form method="POST" action="{{$selectedNavigation->url . (isset($item)? "/{$item->id}" : '')}}" accept-charset="UTF-8">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <input name="_method" type="hidden" value="{{isset($item)? 'PUT':'POST'}}">

            <div class="card-body">
                @include('admin.partials.card.info')

                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control input-generate-slug {{ form_error_class('name', $errors) }}" id="name" name="name" placeholder="Enter Name" value="{{ ($errors && $errors->any()? old('name') : (isset($item)? $item->name : '')) }}">
                                {!! form_error_message('name', $errors) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
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
                                <label for="layout">Layout <span class="small">( e.g col-12, col-md-3 etc)</span></label>
                                <input type="text" class="form-control {{ form_error_class('layout', $errors) }}" id="layout" name="layout" placeholder="Enter Layout" value="{{ ($errors && $errors->any()? old('layout') : (isset($item)? $item->layout : '')) }}">
                                {!! form_error_message('layout', $errors) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="templates">Templates <span class="small">(which templates are allowed to use the layout)</span></label>
                                {!! form_select('templates[]', $templates, ($errors && $errors->any()? old('templates') : (isset($item)? $item->templates->pluck('id')->all() : '')), ['class' => 'select2 form-control ' . form_error_class('templates', $errors), 'multiple']) !!}
                                {!! form_error_message('templates', $errors) !!}
                            </div>
                        </div>

                    </div>
                </fieldset>
            </div>
            @include('admin.partials.form.form_footer')
        </form>
    </div>
@endsection
