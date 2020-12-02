@extends('admin.admin')

@section('content')
    <div class="card <!--card-outline--> card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span><i class="fa fa-edit"></i></span>
                <span>{{ isset($item)? 'Edit the ' . $item->name . ' entry': 'Create a new Faq' }}</span>
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
                        <div class="col-12 col-md-8">
                            <div class="form-group">
                                <label for="question">Question</label>
                                <input type="text" class="form-control {{ form_error_class('question', $errors) }}" id="question" name="question" placeholder="Enter Question" value="{{ ($errors && $errors->any()? old('question') : (isset($item)? $item->question : '')) }}">
                                {!! form_error_message('question', $errors) !!}
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                {!! form_select('category_id', ([0 => 'Please select a Category'] + $categories), ($errors && $errors->any()? old('category_id') : (isset($item)? $item->category_id : '')), ['class' => 'select2 form-control ' . form_error_class('category_id', $errors)]) !!}
                                {!! form_error_message('category_id', $errors) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="answer">Answer</label>
                        <textarea class="form-control summernote  {{ form_error_class('answer', $errors) }}" id="answer" name="answer" rows="10">{{ ($errors && $errors->any()? old('answer') : (isset($item)? $item->answer : '')) }}</textarea>
                        {!! form_error_message('answer', $errors) !!}
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
        })
    </script>
@endsection
