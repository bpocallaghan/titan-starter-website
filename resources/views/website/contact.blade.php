@extends('website.website')

@section('content')
    <section class="container body contact">

        <div class="row mb-5">
            <div class="col-12">
                <h2 class="page-header text-center">{!! isset($pageTitle) ? $pageTitle : $page->name !!}</h2>
            </div>
        </div>

        @include('website.pages.page_components', ['item' => $page])

        <div class="row pb-5">
            <div class="order-2 order-md-1 col-12 col-md-7 col-lg-6">
                @include('website.partials.form.contact_form', ['resourceable' => $page])
            </div>

            <div class="order-1 order-md-2 col-12 col-md-5 col-lg-6 contact-details">
                <div class="border mb-3 p-3">
                    <div class="row">
                        <div class="col-1 text-primary" data-icon="fa fa-fw fa-phone pr-3"></div>
                        <div class="col"><strong>Phone </strong><br>
                            @if(isset($settings->telephone))  <a href="tel:{{ trim($settings->telephone) }}">{{ $settings->telephone }}</a> <br>@endif
                            @if(isset($settings->cellphone)) <a href="tel:{{ trim($settings->cellphone) }}">{{ $settings->cellphone }}</a>@endif
                        </div>
                    </div>
                </div>


                @if(isset($settings->email))
                <div class="border mb-3 p-3">
                    <div class="row">
                        <div class="col-1 text-primary" data-icon="fa fa-fw fa-envelope pr-3"></div>
                        <div class="col">
                            <strong>Email </strong><br>
                            <a href="mailto:{{ trim($settings->email) }}">{{ $settings->email }}</a>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($settings->address))
                <div class="border mb-3 p-3">
                    <div class="row">
                        <div class="col-1 text-primary" data-icon="fa fa-fw fa-map-marked-alt pr-3"></div>
                        <div class="col">
                            <strong>Physical Address</strong>
                            <br>{{ $settings->address }}
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($settings->po_box))
                <div class="border mb-3 p-3">
                    <div class="row">
                        <div class="col-1 text-primary" data-icon="fa fa-fw fa-print pr-3"></div>
                        <div class="col">
                            <strong>Postal Address</strong>
                            <br> {{ $settings->po_box }}
                        </div>
                    </div>
                </div>
            @endif


            </div>
        </div>
    </section>
    <section class="location-map">
        <h3 class="d-none">Location Map</h3>

        <div id="js-map-contact-us" class="google-maps" style="height: 400px"></div>
    </section>

@endsection

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        function initilizeGoogleMaps(){
            var map = initGoogleMapView('js-map-contact-us', '{{ $settings->latitude }}', '{{ $settings->longitude }}', {{ $settings->zoom_level }});
            addGoogleMapMarker(map, '{{ $settings->latitude }}', '{{ $settings->longitude }}', false);

            var content = '<h4>{{ $settings->name }}</h4>' + $('.contact-details').html();
            addGoogleMapMarkerClick(map, '{{ $settings->name }}', '{{ $settings->latitude }}', '{{ $settings->longitude }}', content);
        };
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_map_key') }} &callback=initilizeGoogleMaps"></script>

@endsection
