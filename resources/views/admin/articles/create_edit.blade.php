@extends('admin.admin')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span><i class="fa fa-edit"></i></span>
                <span>{{ isset($item)? 'Edit the ' . $item->title . ' entry': 'Create a new Article' }}</span>
            </h3>
        </div>

        @include('admin.partials.card.info')

        <form method="POST" action="{{$selectedNavigation->url . (isset($item)? "/{$item->id}" : '')}}" accept-charset="UTF-8" enctype="multipart/form-data">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <input name="_method" type="hidden" value="{{isset($item)? 'PUT':'POST'}}">

            <div class="card-body">

                <fieldset>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="id-name">Name</label>
                                <input type="text" class="form-control  {{ form_error_class('name', $errors) }}" id="id-name" name="name" placeholder="Please insert the Name" value="{{ ($errors && $errors->any()? old('name') : (isset($item)? $item->name : '')) }}">
                                {!! form_error_message('name', $errors) !!}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="category">Category</label>
                                {!! form_select('category_id', ([0 => 'Please select a Category'] + $categories), ($errors && $errors->any()? old('category_id') : (isset($item)? $item->category_id : '')), ['class' => 'select2 form-control '.form_error_class('category_id', $errors)]) !!}
                                {!! form_error_message('category_id', $errors) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-10">
                            <div class="form-group">
                                <label for="summary">Summary <span class="small">(optional)</span></label>
                                <input type="text" class="form-control {{ form_error_class('summary', $errors) }}" id="summary" name="summary" placeholder="Please insert the Summary" value="{{ ($errors && $errors->any()? old('summary') : (isset($item)? $item->summary : '')) }}">
                                {!! form_error_message('summary', $errors) !!}
                            </div>
                        </div>
                        <div class="col col-2">
                            <div class="form-group">
                                <label for="summary">Accept comments? <span class="small">(optional)</span></label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="allow_comments" class="custom-control-input" id="allow_comments" {!! ($errors && $errors->any()? (old('allow_comments') == 'on'? 'checked':'') : (isset($item)&& $item->allow_comments == 1? 'checked' : '' )) !!}>
                                    <label class="custom-control-label" for="allow_comments">Allow Comments</label>
                                    {!! form_error_message('allow_comments', $errors) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="active_from">Active From <span class="small">(optional, current timestamp will be used)</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control {{ form_error_class('active_from', $errors) }}" id="active_from" data-date-format="YYYY-MM-DD HH:mm:ss" name="active_from" placeholder="Please insert the Active From" value="{{ ($errors && $errors->any()? old('active_from') : (isset($item)? $item->active_from : '')) }}">
                                    <span class="input-group-append"><span class="input-group-text"><i class="fa fa-calendar"></i></span></span>
                                    {!! form_error_message('active_from', $errors) !!}
                                </div>

                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="active_to">Active To <span class="small">(optional, article will not show on website after this date)</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control {{ form_error_class('active_to', $errors) }}" id="active_to" data-date-format="YYYY-MM-DD HH:mm:ss" name="active_to" placeholder="Please insert the Active To" value="{{ ($errors && $errors->any()? old('active_to') : (isset($item)? $item->active_to : '')) }}">
                                    <div class="input-group-append"><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
                                    {!! form_error_message('active_to', $errors) !!}
                                </div>
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

                    <div class="form-group">
                        <label for="article-content">Content</label>
                        <textarea class="form-control summernote {{ form_error_class('content', $errors) }}" id="article-content" name="content" rows="18">{{ ($errors && $errors->any()? old('content') : (isset($item)? $item->content : '')) }}</textarea>
                        {!! form_error_message('content', $errors) !!}
                    </div>
                </fieldset>



            </div>

            @include('admin.partials.form.form_footer')
        </form>
    </div>

    @if(isset($item))
        @include('admin.resources.sections.components', ['resourceable' => $item, 'url' => "/admin/articles/{$item->id}/sections", 'resource' => 'articles', 'back' => 'articles'])
    @endif

@endsection

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function ()
        {
            setDateTimePickerRange('#active_from', '#active_to');

            initSummerNote('.summernote');
        })
    </script>
@endsection
