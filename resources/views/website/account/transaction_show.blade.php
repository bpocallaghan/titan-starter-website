@extends('website.website')

@section('content')
    <section class="container body">

            @include('website.partials.page_header')

        <div class="row pb-5">
            <div class="col-sm-7 col-lg-8">

                <form action="{{ request()->url() }}" method="POST" accept-charset="UTF-8">
                    {!! csrf_field() !!}

                    <div class="row">
                        <div class="col-12">
                            @foreach($item->products as $product)
                                <div class="cart-item padding-top-sm padding-bottom-sm">
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="text-left font-25 strong">Order Reference: {{ $item->reference }}</p>
                                        </div>
                                        <div class="col-4 col-sm-2">
                                            <figure>
                                                <a href="/products/show/{{ $product->slug }}"><img src="{{ $product->cover_photo->thumbUrl }}" class="display-block img-fluid"></a>
                                            </figure>
                                        </div>
                                        <div class="col-8 col-sm-6">
                                            <h3 class="text-left">{!! $product->name !!}</h3>
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
                                                N${{ number_format_decimal($product->amount) }}</p>
                                        </div>
                                        <div class="col-4 col-sm-2">
                                            <p>Quantity: </p>
                                            <p>{{ $product->pivot->quantity }}</p>
                                        </div>
                                    </div>
                                </div>
                                @if(!$loop->last)<hr>@endif
                            @endforeach
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <table class="total table text-right">
                                @if($item->shippingAddress)
                                    <tr>
                                        <td>Delivery Address:</td>
                                        <td>{{ $item->shippingAddress->label }}</td>
                                    </tr>
                                @endif
                                {{--<tr>--}}
                                    {{--<td>Items Total:</td>--}}
                                    {{--<td>N$--}}
                                        {{--<span class="js-total">{{ number_format_decimal($item->amount_items) }}</span>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                <tr>
                                    <td>Grand Total:</td>
                                    <td>N$
                                        <span class="js-grand-total">{{ number_format_decimal($item->amount) }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>

            </div>

            @include('website.partials.page_side')
        </div>


    </section>
@endsection