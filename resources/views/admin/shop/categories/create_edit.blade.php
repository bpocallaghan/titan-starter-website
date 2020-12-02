@extends('admin.admin')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span><i class="fa fa-edit"></i></span>
                <span>{{ isset($item)? 'Edit the ' . $item->name . ' entry': 'Create a new Product Category' }}</span>
            </h3>
        </div>

        <form method="POST" action="{{$selectedNavigation->url . (isset($item)? "/{$item->id}" : '')}}" accept-charset="UTF-8" enctype="multipart/form-data">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <input name="_method" type="hidden" value="{{isset($item)? 'PUT':'POST'}}">

            <div class="card-body no-padding">

                @include('admin.partials.card.info')


                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control {{ form_error_class('name', $errors) }}" id="name" name="name" placeholder="Please insert the Name" value="{{ ($errors && $errors->any()? old('name') : (isset($item)? $item->name : '')) }}">
                                {!! form_error_message('name', $errors) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parent">Parent</label>
                                {!! form_select('parent_id', ([0 => 'Please select a Parent'] + $parents), ($errors && $errors->any()? old('parent_id') : (isset($item)? $item->parent_id : '')), ['class' => 'select2 form-control '.form_error_class('parent_id', $errors) ]) !!}
                                {!! form_error_message('parent_id', $errors) !!}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Browse for an Image (255 x 255)</label>
                                <div class="input-group">
                                    <input id="photo-label" type="text" class="form-control {{ form_error_class('photo', $errors) }}" readonly placeholder="Browse for an image">
                                    <span class="input-group-append">
                                  <button type="button" class="btn btn-default" onclick="document.getElementById('photo').click();">Browse</button>
                                </span>
                                    <input id="photo" style="display: none" accept="{{ get_file_extensions('image') }}" type="file" name="photo" onchange="document.getElementById('photo-label').value = this.value">
                                    {!! form_error_message('photo', $errors) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            @if(isset($item) && $item && $item->image)
                                <section>
                                    <img src="{{ uploaded_images_url($item->image) }}" style="max-width: 100%; max-height: 300px;">
                                    <input type="hidden" name="image" value="{{ $item->image }}">
                                </section>
                            @endif
                        </div>

                    </div>
                </fieldset>
            </div>

            @include('admin.partials.form.form_footer')
        </form>
    </div>

@endsection
