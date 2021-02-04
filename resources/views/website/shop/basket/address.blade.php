@extends('website.website')

@section('content')
    <section class="container body">

            @include('website.partials.page_header')

            <div class="row pb-5">
                <div class="col-sm-7 col-lg-8 content">


                    <form action="{{ route('basket.address.submit') }}" method="POST" accept-charset="UTF-8" class="needs-validation" novalidate>
                        {!! csrf_field() !!}

                        <h2 class="hiddenn">Delivery address</h2>
                        <p>Enter your shipping address below.</p>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control {{ form_error_class('address', $errors) }}" id="address" name="address" placeholder="Please insert the Address" value="{{ ($errors && $errors->any()? old('address') : session('basket.address.address', '')) }}" required>
                                    {!! form_error_message('address', $errors) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control {{ form_error_class('city', $errors) }}" id="city" name="city" placeholder="Please insert the City" value="{{ ($errors && $errors->any()? old('city') : session('basket.address.city', '')) }}" required>
                                    {!! form_error_message('city', $errors) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="province">Province</label>
                                    <input type="text" class="form-control {{ form_error_class('province', $errors) }}" id="province" name="province" placeholder="Please insert the Province" value="{{ ($errors && $errors->any()? old('province') : session('basket.address.province', '')) }}">
                                    {!! form_error_message('province', $errors) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control {{ form_error_class('country', $errors) }}" id="country" name="country" placeholder="Please insert the Country" value="{{ ($errors && $errors->any()? old('country') : session('basket.address.country', '')) }}" required>
                                    {!! form_error_message('country', $errors) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="postal_code">Postal Code or Zip Code</label>
                            <input type="text" class="form-control {{ form_error_class('postal_code', $errors) }}" id="postal_code" name="postal_code" placeholder="Postal code or Zip code" value="{{ ($errors && $errors->any()? old('postal_code') : session('basket.address.postal_code', '')) }}">
                            {!! form_error_message('postal_code', $errors) !!}
                        </div>

                        <div>
                            <p class="text-right">
                                <button type="submit" class="btn btn-primary" data-icon="fa fa-shopping-cart">
                                    Continue to Checkout
                                </button>
                            </p>
                        </div>
                    </form>
                </div>


                @include('website.partials.page_side')

            </div>

    </section>
@endsection

@section('scripts')
    @parent
    <script>

        $('[type="submit"]').on('click', function(){
            BTN.loading($(this));
        });

        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();

                            BTN.reset($('[type="submit"]'));
                        }
                        form.classList.add('was-validated');

                    }, false);
                });
            }, false);
        })();
    </script>
@endsection
