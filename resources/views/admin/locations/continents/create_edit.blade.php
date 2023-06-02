@extends('admin.admin')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span><i class="fa fa-edit"></i></span>
                <span>{{ isset($item)? 'Edit the ' . $item->title . ' entry': 'Create a new Continent' }}</span>
            </h3>
        </div>

        <form method="POST" action="{{$selectedNavigation->url . (isset($item)? "/{$item->id}" : '')}}" accept-charset="UTF-8">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <input name="_method" type="hidden" value="{{isset($item)? 'PUT':'POST'}}">

            <input name="zoom_level" type="hidden" value="{{ isset($item)? $item->zoom_level : old('zoom_level') }}" readonly/>
            <input name="latitude" type="hidden" value="{{ isset($item)? $item->latitude : old('latitude') }}" readonly/>
            <input name="longitude" type="hidden" value="{{ isset($item)? $item->longitude : old('longitude') }}" readonly/>

            <div class="card-body no-padding">

                @include('admin.partials.card.info')

                <fieldset>
                    <section class="form-group">
                        <label for="title">Name</label>
                        <input type="text" class="form-control {{ form_error_class('name', $errors) }}" id="title" name="name" placeholder="Please insert the Name" value="{{ ($errors && $errors->any()? old('name') : (isset($item)? $item->name : '')) }}">
                        {!! form_error_message('name', $errors) !!}
                    </section>
                </fieldset>

            </div>
            @include('admin.partials.form.form_footer')
        </form>
    </div>



    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span><i class="fa fa-map-marker"></i></span>
                <span>Google Map</span>
            </h3>
        </div>

        <div class="card-body p-0">
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

            initGoogleMapEditClean('map_canvas', latitude, longitude, zoom_level);
        }
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_map_key') }}&callback=initilizeGoogleMaps"></script>
@endsection
