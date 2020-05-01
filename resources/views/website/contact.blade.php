@extends('website.website')

@section('content')
    <section class="container body contact">

        <div class="row mb-5">
            <div class="col-12">
                <h2 class="page-header text-center">{!! isset($pageTitle) ? $pageTitle : $page->name !!}</h2>
            </div>
        </div>

        @foreach($page->components as $content)
            <div class="mb-5">
                @include('website.pages.page_heading')
                @include('website.pages.page_content')

                @include('website.pages.page_gallery')
                @include('website.pages.page_documents')
            </div>
        @endforeach

        <div class="row pb-5">
            <div class="col-lg-5 col-xl-6">
                <form id="form-contact-us" accept-charset="UTF-8" action="{{ request()->url().'/submit' }}" method="POST" class="needs-validation" novalidate>
                    {!! csrf_field() !!}

                    <div class="form-group form-row">
                        <div class="col">
                            <label class="sr-only">First name</label>
                            <input type="text" class="form-control form-control-lg" name="firstname" id="firstname" placeholder="First name" required>
                        </div>
                        <div class="col">
                            <label class="sr-only">Last name</label>
                            <input type="text" class="form-control form-control-lg" name="lastname" id="lastname" placeholder="Last name" required>
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <div class="col">
                            <label class="sr-only">Email Address</label>
                            <input type="email" class="form-control form-control-lg" name="email" id="email" placeholder="Email Address" required>
                        </div>
                        <div class="col">
                            <label class="sr-only">Telephone Number</label>
                            <input type="text" class="form-control form-control-lg" name="phone" id="phone" placeholder="Telephone Number">
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <div class="col">
                            <label class="sr-only">Your Message</label>
                            <textarea class="form-control form-control-lg" rows="3" name="content" id="content" placeholder="Any additional comments" required></textarea>
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <div class="col">
                            <button type="submit" id="g-recaptcha-contact" class="btn btn-lg btn-primary btn-submit g-recaptcha" data-widget-id="0"><span>Submit</span></button>
                        </div>
                    </div>

                    @include('website.partials.form.feedback')
                </form>
            </div>

            <div class="col-lg-5 col-xl-6 contact-details">
                <p class="border p-3">
                    <strong>Phone </strong><br>
                    @if(isset($settings->telephone))  <a href="tel:{{ trim($settings->telephone) }}">{{ $settings->telephone }}</a> <br>@endif
                    @if(isset($settings->cellphone)) <a href="tel:{{ trim($settings->cellphone) }}">{{ $settings->cellphone }}</a>@endif
                </p>

                @if(isset($settings->email))<p class="border p-3"> <strong>Email </strong><br> <a href="mailto:{{ trim($settings->email) }}">{{ $settings->email }}</a></p>@endif
                @if(isset($settings->address))<p class="border p-3"> <strong>Physical Address</strong> <br>{{ $settings->address }}</p>@endif
                @if(isset($settings->po_box))<p class="border p-3"> <strong>Postal Address</strong> <br> {{ $settings->po_box }}</p>@endif

            </div>
        </div>
    </section>
    <section class="location-map">
        <h3 class="d-none">Location Map</h3>

        <div id="js-map-contact-us" class="google-maps" style="height: 400px"></div>
    </section>

    @include('website.partials.form.captcha')
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_map_key') }}"></script>
    <script type="text/javascript" charset="utf-8">
        $(function () {
            var map = initGoogleMapView('js-map-contact-us', '{{ $settings->latitude }}', '{{ $settings->longitude }}', {{ $settings->zoom_level }});
            addGoogleMapMarker(map, '{{ $settings->latitude }}', '{{ $settings->longitude }}', false);

            var content = '<h4>{{ $settings->name }}</h4>' + $('.contact-details').html();
            addGoogleMapMarkerClick(map, '{{ $settings->name }}', '{{ $settings->latitude }}', '{{ $settings->longitude }}', content);
        });
    </script>
@endsection