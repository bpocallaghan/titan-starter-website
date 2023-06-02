@extends('admin.admin')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span><i class="fa fa-edit"></i></span>
                <span>{{ isset($item)? 'Edit the ' . $item->name . ' entry': 'Create a new Setting' }}</span>
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <form method="POST" action="{{$selectedNavigation->url . (isset($item)? "/{$item->id}" : '')}}" accept-charset="UTF-8">
            <div class="card-body">

                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <input name="_method" type="hidden" value="{{isset($item)? 'PUT':'POST'}}">

                <input name="zoom_level" type="hidden" value="{{ isset($item)? $item->zoom_level : old('zoom_level') }}" readonly/>
                <input name="latitude" type="hidden" value="{{ isset($item)? $item->latitude : old('latitude') }}" readonly/>
                <input name="longitude" type="hidden" value="{{ isset($item)? $item->longitude : old('longitude') }}" readonly/>

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
                                <label for="slogan">Slogan</label>
                                <input type="text" class="form-control {{ form_error_class('slogan', $errors) }}" id="slogan" name="slogan" placeholder="Enter Slogan" value="{{ ($errors && $errors->any()? old('slogan') : (isset($item)? $item->slogan : '')) }}">
                                {!! form_error_message('slogan', $errors) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="2" class="form-control {{ form_error_class('description', $errors) }}">{{ ($errors && $errors->any()? old('description') : (isset($item)? $item->description : '')) }}</textarea>
                        {!! form_error_message('description', $errors) !!}
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="author">Author</label>
                                <input type="text" class="form-control {{ form_error_class('author', $errors) }}" id="author" name="author" placeholder="Enter Author" value="{{ ($errors && $errors->any()? old('author') : (isset($item)? $item->author : '')) }}">
                                {!! form_error_message('author', $errors) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="keywords">Keywords</label>
                                <input type="text" class="form-control {{ form_error_class('keywords', $errors) }}" id="keywords" name="keywords" placeholder="Enter Keywords" value="{{ ($errors && $errors->any()? old('keywords') : (isset($item)? $item->keywords : '')) }}">
                                {!! form_error_message('keywords', $errors) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <div class="input-group">
                                    <input type="text" class="form-control {{ form_error_class('email', $errors) }}" id="email" name="email" placeholder="Enter Email" value="{{ ($errors && $errors->any()? old('email') : (isset($item)? $item->email : '')) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="far fa-envelope"></i></span>
                                    </div>
                                    {!! form_error_message('email', $errors) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telephone">Telephone</label>
                                <div class="input-group">
                                    <input type="text" class="form-control {{ form_error_class('telephone', $errors) }}" id="telephone" name="telephone" placeholder="Enter Telephone" value="{{ ($errors && $errors->any()? old('telephone') : (isset($item)? $item->telephone : '')) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    {!! form_error_message('telephone', $errors) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fax">Fax</label>
                                <div class="input-group">
                                    <input type="text" class="form-control {{ form_error_class('fax', $errors) }}" id="fax" name="fax" placeholder="Enter Fax" value="{{ ($errors && $errors->any()? old('fax') : (isset($item)? $item->fax : '')) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    {!! form_error_message('fax', $errors) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="whatsapp">WhatsApp</label>
                                <div class="input-group">
                                    <input type="text" class="form-control {{ form_error_class('whatsapp', $errors) }}" id="whatsapp" name="whatsapp" placeholder="Enter WhatsApp" value="{{ ($errors && $errors->any()? old('whatsapp') : (isset($item)? $item->whatsapp : '')) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                    </div>
                                    {!! form_error_message('whatsapp', $errors) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cellphone">Cellphone</label>
                                <div class="input-group">
                                    <input type="text" class="form-control {{ form_error_class('cellphone', $errors) }}" id="cellphone" name="cellphone" placeholder="Enter Cellphone" value="{{ ($errors && $errors->any()? old('cellphone') : (isset($item)? $item->cellphone : '')) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                    </div>
                                    {!! form_error_message('cellphone', $errors) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="weekdays">Weekdays</label>
                                <input type="text" class="form-control {{ form_error_class('weekdays', $errors) }}" id="weekdays" name="weekdays" placeholder="Enter Opening Hours for weekdays" value="{{ ($errors && $errors->any()? old('weekdays') : (isset($item)? $item->weekdays : '')) }}">
                                {!! form_error_message('weekdays', $errors) !!}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="weekends">Weekends</label>
                                <input type="text" class="form-control {{ form_error_class('weekends', $errors) }}" id="weekends" name="weekends" placeholder="Enter Opening Hours for weekends" value="{{ ($errors && $errors->any()? old('weekends') : (isset($item)? $item->weekends : '')) }}">
                                {!! form_error_message('weekends', $errors) !!}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="public_holidays">Public Holidays</label>
                                <input type="text" class="form-control {{ form_error_class('public_holidays', $errors) }}" id="public_holidays" name="public_holidays" placeholder="Enter Opening Hours for public holidays" value="{{ ($errors && $errors->any()? old('public_holidays') : (isset($item)? $item->public_holidays : '')) }}">
                                {!! form_error_message('public_holidays', $errors) !!}
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control {{ form_error_class('address', $errors) }}" id="address" name="address" placeholder="Enter Address" value="{{ ($errors && $errors->any()? old('address') : (isset($item)? $item->address : '')) }}">
                                {!! form_error_message('address', $errors) !!}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="directions">Directions Link</label>
                                <input type="text" class="form-control {{ form_error_class('directions', $errors) }}" id="directions" name="directions" placeholder="Enter Directions Link" value="{{ ($errors && $errors->any()? old('directions') : (isset($item)? $item->directions : '')) }}">
                                {!! form_error_message('directions', $errors) !!}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="po_box">PO BOX</label>
                                <input type="text" class="form-control {{ form_error_class('po_box', $errors) }}" id="po_box" name="po_box" placeholder="Enter PO BOX" value="{{ ($errors && $errors->any()? old('po_box') : (isset($item)? $item->po_box : '')) }}">
                                {!! form_error_message('po_box', $errors) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="facebook">Facebook</label>
                                <div class="input-group">
                                    <input type="text" class="form-control {{ form_error_class('facebook', $errors) }}" id="facebook" name="facebook" placeholder="Enter Facebook" value="{{ ($errors && $errors->any()? old('facebook') : (isset($item)? $item->facebook : '')) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fab fa-facebook-f"></i></span>
                                    </div>
                                    {!! form_error_message('facebook', $errors) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="twitter">Twitter</label>
                                <div class="input-group">
                                    <input type="text" class="form-control {{ form_error_class('twitter', $errors) }}" id="twitter" name="twitter" placeholder="Enter Twitter" value="{{ ($errors && $errors->any()? old('twitter') : (isset($item)? $item->twitter : '')) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                    </div>
                                    {!! form_error_message('twitter', $errors) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="instagram">Instagram</label>
                                <div class="input-group">
                                    <input type="text" class="form-control {{ form_error_class('instagram', $errors) }}" id="instagram" name="instagram" placeholder="Enter Instagram" value="{{ ($errors && $errors->any()? old('instagram') : (isset($item)? $item->instagram : '')) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                    </div>
                                    {!! form_error_message('instagram', $errors) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="linkedin">Linkedin</label>
                                <div class="input-group">
                                    <input type="text" class="form-control {{ form_error_class('linkedin', $errors) }}" id="linkedin" name="linkedin" placeholder="Enter Linkedin" value="{{ ($errors && $errors->any()? old('linkedin') : (isset($item)? $item->linkedin : '')) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fab fa-linkedin-in"></i></span>
                                    </div>
                                    {!! form_error_message('linkedin', $errors) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="youtube">Youtube</label>
                                <div class="input-group">
                                    <input type="text" class="form-control {{ form_error_class('youtube', $errors) }}" id="youtube" name="youtube" placeholder="Enter Youtube" value="{{ ($errors && $errors->any()? old('youtube') : (isset($item)? $item->youtube : '')) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                    </div>
                                    {!! form_error_message('youtube', $errors) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

            </div>
            @include('admin.partials.form.form_footer')
        </form>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Google Map</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body p-0">
            <input id="pac-input" class="controls" type="text" placeholder="Enter Address">
            <div id="map_canvas" class="google_maps" style="height: 450px;">
                &nbsp;
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        function initilizeGoogleMaps(){

            var latitude = {{ isset($item) && strlen($item->latitude) > 2? $item->latitude : -30 }};
            var longitude = {{ isset($item) && strlen($item->longitude) > 2? $item->longitude : 24 }};
            var zoom_level = {{ isset($item) && strlen($item->zoom_level) >= 1? $item->zoom_level : 6 }};

            initGoogleMapEditMarker('map_canvas', latitude, longitude, zoom_level);
        }
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_map_key') }}&libraries=places&callback=initilizeGoogleMaps"></script>
@endsection
