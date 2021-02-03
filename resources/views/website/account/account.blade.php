@extends('website.website')

@section('content')
    <section class="container body">

            @include('website.partials.page_header')

        <div class="row pb-5">
            <div class="col-sm-7 col-lg-8">
            @include('alert::alert')

            <div class="row pb-3">
                <div class="col-12 col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="strong font-20" data-icon="fa fa-file-alt fa-fw">Your orders </h3>
                        </div>
                        <div class="card-footer">
                            <span>{{ isset($totalTransactions)? $totalTransactions : 0 }}
                                recent orders. <a href="{{ route('orders') }}">View orders</a></span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="strong font-20" data-icon="fa fa-shopping-cart fa-fw">Your Cart </h3>
                        </div>
                        <div class="card-footer">
                            <span>{{ session('basket.total_items', 0) }}
                                items. <a href="{{ route('basket') }}">Go to cart</a></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="strong font-20" data-icon="fa-user fa-fw">My Profile</h3>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('profile') }}">Update personal information</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="strong font-20" data-icon="fa-building fa-fw">My Shipping Address</h3>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('profile.address') }}">Update shipping address</a>
                        </div>
                    </div>
                </div>
            </div>
            </div>

            @include('website.partials.page_side')
        </div>

    </section>

@endsection
