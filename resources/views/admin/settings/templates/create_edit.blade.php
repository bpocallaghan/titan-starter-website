@extends('admin.admin')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span><i class="fa fa-edit"></i></span>
                <span>{{ isset($item)? 'Edit the ' . $item->name . ' entry': 'Create a new Template' }}</span>
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <form method="POST" action="{{$selectedNavigation->url . (isset($item)? "/{$item->id}" : '')}}" accept-charset="UTF-8" enctype="multipart/form-data">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <input name="_method" type="hidden" value="{{isset($item)? 'PUT':'POST'}}">

            <div class="card-body">
                @include('admin.partials.card.info')

                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control {{ form_error_class('name', $errors) }}" id="name" name="name" placeholder="Enter Name" value="{{ ($errors && $errors->any()? old('name') : (isset($item)? $item->name : '')) }}">
                                {!! form_error_message('name', $errors) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="template">Template Name</label>
                                <input type="text" class="form-control {{ form_error_class('template', $errors) }}" id="template" name="template" placeholder="Enter Template Name" value="{{ ($errors && $errors->any()? old('template') : (isset($item)? $item->template : '')) }}">
                                {!! form_error_message('template', $errors) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="controller_action">Controller Action <span class="small">(optional, e.g AboutController@index)</span></label>
                                <input type="text" class="form-control {{ form_error_class('controller_action', $errors) }}" id="controller_action" name="controller_action" placeholder="Enter Controller Action" value="{{ ($errors && $errors->any()? old('controller_action') : (isset($item)? $item->controller_action : '')) }}">
                                {!! form_error_message('controller_action', $errors) !!}
                            </div>
                        </div>
                    </div>

                </fieldset>
            </div>

            @include('admin.partials.form.form_footer')

        </form>
    </div>
@endsection
