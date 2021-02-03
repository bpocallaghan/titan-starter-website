@extends('website.website')

@section('content')
    <section class="container body">

            @include('website.partials.page_header')

            <!--Row-->
            <div class="row pb-5">

                <!--Content-->
                <div class="col-sm-7 col-lg-8 content pagination-box">
                    <form id="form-basket" action="{{ route('basket.submit') }} " method="POST" accept-charset="UTF-8" class="needs-validation" novalidate>
                        {!! csrf_field() !!}

                        <div class="row">
                            <div class="col-12">
                                @foreach($items as $product)
                                    <div class="cart-item padding-top-sm padding-bottom-sm text-left">
                                        <div class="row">
                                            <div class="col-4 col-sm-2">
                                                <figure>
                                                    <a href="/products/show/{{ $product->slug }}"><img src="{{ $product->cover_photo->thumbUrl }}" class="img-fluid display-block"></a>
                                                </figure>
                                            </div>
                                            <div class="col-8 col-sm-5">
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
                                            <div class="col-2 col-sm-2">
                                                <p>Quantity: </p>
                                                <input name="quantity[{{$product->id}}]" data-id="{{ $product->id }}" type="number" class="form-control js-quantity" data-amount="{{ $product->amount }}" value="{{ $product->quantity }}" placeholder="Quantity" min="1" required>
                                            </div>
                                            <div class="col-2 col-sm-1">
                                                <a href="/products/basket/remove/{{$product->id}}" class="btn btn-sm btn-danger" title="Remove Product" data-toggle="tooltip">
                                                    <i class="fa fa-times"></i>
                                                </a>
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
                                    {{--<tr>--}}
                                        {{--<td class="text-left"><span class="js-total-items">0</span> Items Total:</td>--}}
                                        {{--<td class="text-right">N$ <span class="js-total">0</span></td>--}}
                                    {{--</tr>--}}
                                    <tr>
                                        <td class="text-left">Grand Total:</td>
                                        <td class="text-right">N$ <span class="js-grand-total">0</span></td>
                                    </tr>
                                </table>

                                <p class="text-right">
                                    @if($items->count() > 0)
                                        @if(auth()->check())
                                            <button type="submit" role="button" class="btn btn-primary" data-icon="fa fa-shopping-cart">
                                                Proceed to checkout
                                            </button>
                                        @else
                                            <a href="/auth/login" class="btn btn-light" title="Login" data-icon="fa-sign-in-alt">
                                                Login
                                            </a>
                                        @endif
                                    @endif
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
    <script type="text/javascript" charset="utf-8">
        $(function () {
            // on change

            $('[type="submit"]').on('click', function(){
                BTN.loading($(this));
            });

            $('.js-quantity').on('change', function () {
                updateCheckoutAmounts();
            });

            function formatNumber(num)
            {
                return parseFloat(Math.round(num * 100) / 100).toFixed(2);
            }

            function updateCheckoutAmounts()
            {
                var total = 0;
                var totalItems = 0;
                $('.js-quantity').each(function () {
                    var quantity = parseInt($(this).val());
                    var id = $(this).attr('data-id');
                    var amount = parseFloat($(this).attr('data-amount'));

                    total += (amount * quantity);
                    totalItems += quantity;
                });

                // get 12% hnadling fee
                //var handlingFee = total * 0.12;
                var subtotal = total;
                // get 15% tax
                // var tax = subtotal * 0.15;
                // get the grand total
                var grandTotal = total;

                // update the html
                $('.js-total').html(formatNumber(total));
                $('.js-subtotal').html(formatNumber(subtotal));
                $('.js-grand-total').html(formatNumber(grandTotal));
                $('.js-total-items').html(totalItems);
                //$('.js-handling-fee').html(formatNumber(handlingFee));
            }

            updateCheckoutAmounts();
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
