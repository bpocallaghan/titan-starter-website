@extends('website.website')

@section('content')
    <section class="container body">

            @include('website.partials.page_header')

            <div class="row pb-5">
                <div class="col-sm-7 col-lg-8 content">

                    <form action="{{ route('basket.checkout.submit') }}" method="POST" accept-charset="UTF-8" class="needs-validation" novalidate>
                        {!! csrf_field() !!}

                        <div class="row">
                            <div class="col-md-12">
                                @foreach($basket->items as $product)
                                    <div class="cart-item">
                                        <div class="row">
                                            <div class="col-4 col-sm-2">
                                                <figure>
                                                    <a href="/products/show/{{ $product->slug }}"><img src="{{ $product->cover_photo->thumbUrl }}" class="display-block img-fluid"></a>
                                                </figure>
                                            </div>
                                            <div class="col-8 col-sm-6">
                                                <h3 class="text-left mt-0">{!! $product->name !!}</h3>
                                                <p class="item-code m-0"><strong>CODE:</strong> {{ $product->reference }}</p>
                                                <p class="item-category m-0"><strong>Category:</strong>
                                                    <a href="/products/{{ $product->category->slug }}">{{ $product->category->name }} {{ $product->category->parent? " ({$product->category->parent->name})":'' }}</a>
                                                </p>
                                                @if($product->features)
                                                    <p class="item-type m-0"><strong>Feature(s):</strong>
                                                        @foreach($product->features as $feature)
                                                            <a href="/products/{{ $feature->slug }}">{{ $feature->name }}</a>
                                                            @if(!$loop->last) | @endif
                                                        @endforeach
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="col-offset-4 col-4 col-sm-offset-0 col-sm-2">
                                                <p>Price:</p>
                                                <p class="item-price">
                                                    N${{ number_format($product->amount) }}</p>
                                            </div>
                                            <div class="col-4 col-sm-2">
                                                <p>Quantity: </p>
                                                <p>{{ $product->quantity }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @if(!$loop->last)<hr>@endif
                                @endforeach
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">

                                <table class="total table">
                                    <tr>
                                        <td>Delivery Address:</td>
                                        <td>{{ session('basket.address.label') }}</td>
                                    </tr>
                                    {{--<tr>--}}
                                        {{--<td>--}}
                                            {{--<span class="js-total-items">{{ $basket->totalItems }}</span>--}}
                                            {{--Items Total:--}}
                                        {{--</td>--}}
                                        {{--<td>N$--}}
                                            {{--<span class="js-total">{{ number_format($basket->amount_items) }}</span>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                    <tr>
                                        <td>Grand Total:</td>
                                        <td>N$
                                            <span class="js-grand-total">{{ number_format($basket->amount) }}</span>
                                        </td>
                                    </tr>
                                </table>

                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="terms" id="terms" {!! ($errors && old('terms') == 'on'? 'checked' : '') !!} required>
                                    <label class="form-check-label" for="terms">
                                        I agree with the
                                        <a target="_blank" href="/terms-and-conditions">
                                            Terms &amp; Conditions
                                        </a>
                                    </label>
                                    {!! form_error_message('terms', $errors) !!}
                                </div>

                                <p class="text-right">
                                    <button type="submit" class="btn btn-primary" data-icon="fa fa-shopping-cart">
                                        Checkout
                                    </button>
                                </p>
                            </div>
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
