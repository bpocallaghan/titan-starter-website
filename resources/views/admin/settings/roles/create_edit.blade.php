@extends('admin.admin')

@section('content')
    <div class="card  card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span><i class="fa fa-edit"></i></span>
                <span>{{ isset($item)? 'Edit the ' . $item->title . ' entry': 'Create a new Role' }}</span>
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
                                <label for="icon">Icon</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">fa fa-</span>
                                    </div>
                                    <input type="text" class="form-control {{ form_error_class('icon', $errors) }}" id="icon" name="icon" placeholder="Enter Icon" value="{{ ($errors && $errors->any()? old('icon') : (isset($item)? $item->icon : '')) }}">
                                    {!! form_error_message('icon', $errors) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="keyword">Keyword</label>
                                <input type="text" class="form-control {{ form_error_class('keyword', $errors) }}" id="keyword" name="keyword" placeholder="Enter Keyword" value="{{ ($errors && $errors->any()? old('keyword') : (isset($item)? $item->keyword : '')) }}">
                                {!! form_error_message('keyword', $errors) !!}
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            @include('admin.partials.form.form_footer')
        </form>
    </div>
@endsection
