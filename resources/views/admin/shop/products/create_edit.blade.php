@extends('admin.admin')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span><i class="fa fa-edit"></i></span>
                <span>{{ isset($item)? 'Edit the ' . $item->name . ' entry': 'Create a new Product' }}</span>
            </h3>
        </div>

        <form method="POST" action="{{$selectedNavigation->url . (isset($item)? "/{$item->id}" : '')}}" accept-charset="UTF-8">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <input name="_method" type="hidden" value="{{isset($item)? 'PUT':'POST'}}">
            <div class="card-body">

                @include('admin.partials.card.info')



                <fieldset>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control {{ form_error_class('name', $errors) }}" id="name" name="name" placeholder="Please insert the Name" value="{{ ($errors && $errors->any()? old('name') : (isset($item)? $item->name : '')) }}">
                                {!! form_error_message('name', $errors) !!}
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label>Stock </label>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input {{ form_error_class('in_stock', $errors) }}" type="checkbox" name="in_stock" id="in_stock" {{ ($errors && $errors->any()? (old('in_stock')? 'checked="checked"':'') :  (isset($item) && $item->in_stock? 'checked="checked"':'checked="checked"')) }}>
                                <label for="in_stock" class="custom-control-label">In Stock</label>
                                {!! form_error_message('in_stock', $errors) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="reference">Reference (Code)</label>
                                <input type="text" class="form-control {{ form_error_class('reference', $errors) }}" id="reference" name="reference" placeholder="Please insert the Reference" value="{{ ($errors && $errors->any()? old('reference') : (isset($item)? $item->reference : '')) }}">
                                {!! form_error_message('reference', $errors) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">N$</span></div>
                                    <input type="text" class="form-control {{ form_error_class('amount', $errors) }}" id="amount" name="amount" placeholder="Please insert the Amount" value="{{ ($errors && $errors->any()? old('amount') : (isset($item)? $item->amount : '')) }}">
                                    {!! form_error_message('amount', $errors) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category">Category</label>
                                {!! form_select('category_id', ([0 => 'Please select a Category'] + $categories), ($errors && $errors->any()? old('category_id') : (isset($item)? $item->category_id : '')), ['class' => 'select2 form-control ' . form_error_class('category_id', $errors) ]) !!}
                                {!! form_error_message('category_id', $errors) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="size">Features</label>
                                {!! form_select('features[]', $features, ($errors && $errors->any()? old('features') : (isset($item)? $item->features->pluck('id')->all() : '')), ['class' => 'select2 form-control ' . form_error_class('features', $errors), 'multiple']) !!}
                                {!! form_error_message('features', $errors) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="special_amount">Special Amount</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">N$</span></div>
                                    <input type="text" class="form-control {{ form_error_class('special_amount', $errors) }}" id="special_amount" name="special_amount" placeholder="Please insert the Amount" value="{{ ($errors && $errors->any()? old('special_amount') : (isset($item)? $item->special_amount : '')) }}">
                                    {!! form_error_message('special_amount', $errors) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="special_from">Special From <span class="small">(optional)</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control {{ form_error_class('special_from', $errors) }}" id="special_from" data-date-format="YYYY-MM-DD HH:mm:ss" name="special_from" placeholder="Please insert the Special From" value="{{ ($errors && $errors->any()? old('special_from') : (isset($item)? $item->special_from : '')) }}">
                                    <span class="input-group-append"><span class="input-group-text"><i class="fa fa-calendar"></i></span></span>
                                    {!! form_error_message('special_from', $errors) !!}
                                </div>

                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="special_to">Special To <span class="small">(optional)</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control {{ form_error_class('special_to', $errors) }}" id="special_to" data-date-format="YYYY-MM-DD HH:mm:ss" name="special_to" placeholder="Please insert the Special To" value="{{ ($errors && $errors->any()? old('special_to') : (isset($item)? $item->special_to : '')) }}">
                                    <div class="input-group-append"><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
                                    {!! form_error_message('special_to', $errors) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="content-content">Content</label>
                        <textarea class="form-control summernote {{ form_error_class('content', $errors) }}" id="content-content" name="content" rows="18" placeholder="Please insert the Content">{{ ($errors && $errors->any()? old('content') : (isset($item)? $item->content : '')) }}</textarea>
                        {!! form_error_message('content', $errors) !!}
                    </div>
                </fieldset>
            </div>

            @include('admin.partials.form.form_footer')
        </form>
    </div>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function () {
            initSummerNote('.summernote');

            setDateTimePickerRange('#special_from', '#special_to');
        })
    </script>
@endsection
