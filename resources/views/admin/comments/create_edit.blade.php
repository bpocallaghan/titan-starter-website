@extends('admin.admin')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span><i class="fa fa-edit"></i></span>
                <span>{{ isset($item)? 'Edit the ' . $item->name . ' entry': 'Create a new Comment' }}</span>
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
            <input type="hidden" name="commentable_id" value="{{ $item->commentable->id }}">
            <input type="hidden" name="commentable_type" value="{{ get_class($item->commentable) }}">
            <input type="hidden" name="commentable_type_name" value="{{ (new \ReflectionClass($item->commentable))->getShortName() }}">

            <div class="card-body">
                @include('admin.partials.card.info')

                <fieldset>

                    <div class="form-group">
                        <label for="content">Comment</label>
                        <textarea class="form-control {{ form_error_class('content', $errors) }}" id="content" name="content" rows="5">{{ ($errors && $errors->any()? old('content') : (isset($item)? $item->content : '')) }}</textarea>
                        {!! form_error_message('content', $errors) !!}
                    </div>

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
                                <label for="email">Email</label>
                                <input type="text" class="form-control {{ form_error_class('email', $errors) }}" id="email" name="email" placeholder="Enter Email" value="{{ ($errors && $errors->any()? old('email') : (isset($item)? $item->email : '')) }}">
                                {!! form_error_message('email', $errors) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-2">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="is_approved" class="custom-control-input" id="is_approved" {!! ($errors && $errors->any()? (old('is_approved') == 'on'? 'checked':'') : (isset($item)&& $item->is_approved == 1? 'checked' : '' )) !!}>
                                    <label class="custom-control-label" for="is_approved">Approve comment</label>
                                    {!! form_error_message('is_approved', $errors) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                </fieldset>
            </div>

            @include('admin.partials.form.form_footer')

        </form>
    </div>
@endsection
