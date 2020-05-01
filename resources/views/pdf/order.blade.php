@extends('pdf.pdf')

@section('content')
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <img src="{{ config('app.url') }}/images/logo.png" style="width: 150px;" alt="Logo">
        </div>

        <div class="col-md-6">
            <h1 class="text-right">PRODUCT ORDER</h1>
            <p class="text-right text-muted">#{{ $item->order_number }}</p>
            <p class="text-right text-muted">{{ $item->reference }}</p>
            {{--<p class="text-right text-muted">N${{ $item->amount }}</p>--}}
        </div>
    </div>

    <div class="row margin-top-20">
        <div class="col-md-12 text-left">
            <h3>Order #{{ $item->order_number }}</h3>
            <p>Created on {!! $item->created_at->format('l, d F Y H:i:s') !!}</p>
        </div>
    </div>

    <div class="row margin-top-30 margin-bottom-50">
        <div class="col-md-6">
            <strong class="font-large">User Information</strong><br>
            {!! $item->user->fullname !!}<br>
            {!! $item->user->email !!}<br>
            {!! $item->user->cellphone !!}<br>
        </div>

        @if($item->shippingAddress)
            <div class="col-md-6">
                <strong class="font-large">Shipping Address</strong><br>
                {!! $item->shippingAddress->address !!}<br>
                {!! $item->shippingAddress->city !!}<br>
                {!! $item->shippingAddress->province !!}<br>
                {!! $item->shippingAddress->country !!}<br>
                {!! $item->shippingAddress->postal_code !!}<br>
            </div>
        @endif
        @if($item->user->shippingAddress)
            <div class="col-md-6">
                <strong class="font-large">Shipping Address</strong><br>
                {!! $item->user->shippingAddress->address !!}<br>
                {!! $item->user->shippingAddress->city !!}<br>
                {!! $item->user->shippingAddress->province !!}<br>
                {!! $item->user->shippingAddress->country !!}<br>
                {!! $item->user->shippingAddress->postal_code !!}<br>
            </div>
        @endif
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>Product</th>
            <th class="text-right">Price</th>
            <th class="text-right">Quantity</th>
            <th class="text-right">Subtotal</th>
        </tr>
        </thead>
        <tbody>
        @foreach($item->products as $product)
            <tr>
                <td>
                    {!! $product->name !!}
                    <p class="item-category">Category:
                        {{ $product->category->name }} {{ $product->category->parent? " ({$product->category->parent->name})":'' }}
                    </p>

                    @if($product->features)
                        <p class="item-type">Features:
                            @foreach($product->features as $feature)
                                {{ $feature->name }} |
                            @endforeach
                        </p>
                    @endif
                    <p class="item-code">
                        Code: {{ $product->reference }}
                    </p>
                </td>
                <td class="text-right">N${{ number_format_decimal($product->amount) }}</td>
                <td class="text-right">{{ $product->pivot->quantity }}</td>
                <td class="text-right">N${{ number_format_decimal($product->amount * $product->pivot->quantity) }}</td>
            </tr>
        @endforeach
        {{--<tr class="text-right text-bold">--}}
            {{--<td class="no-border"></td>--}}
            {{--<td class="no-border"></td>--}}
            {{--<td>Handling Fee</td>--}}
            {{--<td>N${{ number_format($item->amount_handling, 2) }}</td>--}}
        {{--</tr>--}}
        <tr class="text-right text-bold">
            <td class="no-border"></td>
            <td class="no-border"></td>
            <td>Subtotal</td>
            <td>N${{ number_format($item->amount_items, 2) }}</td>
        </tr>
        <tr class="text-right text-bold">
            <td class="no-border"></td>
            <td class="no-border"></td>
            <td class="font-medium">Total</td>
            <td class="font-medium">N${{ number_format($item->amount, 2) }}</td>
        </tr>
        </tbody>
    </table>

    <div class="row margin-top-20">
        <div class="col-md-12 text-left">
            <p><br/>Please use <strong>{{ $item->reference }}</strong> as your reference when making payemnt.</p>

            <div class="alert alert-info">
                <br/>
                <strong>EFT Payment Details</strong><br/>
                Name: XXX<br/>
                Account number: XXXX<br/>
                Branch code: XXX<br/>
                Swift  code: XXX
            </div>
        </div>
    </div>
@endsection
