@extends('website.website')

@section('content')
    <section class="container body">

           @include('website.partials.page_header')

            <div class="row pb-5">
                <div class="col-sm-7 col-lg-8 content">

                    <p>Thank you - we will contact you in the next 24 hours about your
                        purchase.</p>

                    <p>Click <a href="/account/orders/{{ $item->reference }}/print">here</a> to print your order.<br/>
                    The total of your purchase is <strong class="font-20">N${{ $item->amount }}</strong>.</p>

                    <p>Please use the reference <strong class="font-20">{{ $item->reference }}</strong> when making
                        your EFT payment.</p>

                    <p>Please note that payment is required before your order will be
                        processed.</p>

                    <div class="alert alert-info">
                        <p><strong>EFT Payment Details</strong><br/>
                        Name: XXXX<br/>
                        Account number: XXX<br/>
                        Branch code: XXX<br/>
                        Swift code: XXX</p>
                    </div>

                    <p data-icon="fa fa-shopping-cart">Your orders:
                        <a href="/account/orders">View all your orders.</a>
                    </p>

                </div>

                @include('website.partials.page_side')
            </div>

    </section>
@endsection