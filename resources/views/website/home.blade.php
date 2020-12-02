@extends('website.website')

@section('content')

    <div class="container mb-5">
        @foreach($page->components as $content)
            <div class="mb-5">
                @include('website.pages.page_heading')
                @include('website.pages.page_content')

                @include('website.pages.page_gallery')
                @include('website.pages.page_videos')
                @include('website.pages.page_documents')
            </div>
        @endforeach

        <div class="row mt-5 mb-5">
            <div class="d-none d-md-block col-md-4">
                <figure>
                    <img src="/images/logo.png" class="img-fluid">
                </figure>
            </div>
            <div class="col-12 col-md-8">
                <ul class="list-unstyled list-group list-group-horizontal-md mb-3">
                    <li class="list-group-item"><strong>Laravel v8.x</strong></li>
                    <li class="list-group-item"><strong>AdminLTE v3.0.5</strong></li>
                    <li class="list-group-item"><strong>Bootstrap v4.4.1</strong></li>
                    <li class="list-group-item"><strong>jQuery v3.5</strong></li>
                </ul>

                <p>A Laravel Website with Admin access Starter project with AdminLTE theme and basic features.</p>

                <ul class="list-unstyled style-1"><li>Test Driven Development (111 tests, 466 assertions)</li></ul>


            </div>
        </div>


        <div class="clearfix">
            <hr>
        </div>

        <div class="row mt-5 mb-5">

            <!-- start feature box item -->
            <div class="col-12 d-table mb-3">
                <span style="width: 50px" class="d-table-cell align-top text-primary font-20"><i class="fa fa-fw fa-gifts mr-3"></i></span>
                <div class="d-table-cell">
                    <h4 class="d-block mb-3 text-uppercase font-20 page-header">Free &amp; Open Source</h4>

                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <ul class="list-unstyled style-1">
                                <li>Auth <small>(Login, Register, Forgot Password)</small></li>
                                <li>Roles</li>
                                <li>Log Activity <small>(website and admin)</small></li>
                                <li>Notifications</li>
                                <li>Google Analytics Reports</li>
                                <li>Website Page Builder</li>
                            </ul>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <ul class="list-unstyled style-1">
                                        <li>Banners</li>
                                        <li>Photos</li>
                                        <li>Videos</li>
                                        <li>Documents</li>
                                    </ul>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <ul class="list-unstyled style-1">
                                        <li>News</li>
                                        <li>FAQ's</li>
                                        <li>Locations</li>
                                        <li>Shop</li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <!-- end feature box item -->

        </div>

        <div class="row mt-5">
            <div class="col-12">
                <h2 class="page-header text-center mb-5">Core Packages Included</h2>
            </div>
        </div>
        <div class="row mt-2 packages text-center justify-content-center">
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="card-title">File Generators</div>
                    </div>
                    <div class="card-body">
                        <div class="description">
                            <a target="_blank" href="https://github.com/bpocallaghan/generators">
                                Laravel 5 File Generators with config and publishable stubs
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="card-title">Impersonate User</div>
                    </div>
                    <div class="card-body">
                        <div class="description">
                            <a target="_blank" href="https://github.com/bpocallaghan/impersonate">
                                This allows you to authenticate as any of your customers.
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="card-title">Sluggable</div>
                    </div>
                    <div class="card-body">
                        <div class="description">
                            <a target="_blank" href="https://github.com/bpocallaghan/sluggable">
                                Provides a HasSlug trait that will generate a unique slug when
                                saving your Laravel Eloquent model.
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="card-title">Notification</div>
                    </div>
                    <div class="card-body">
                        <div class="description">
                            <a target="_blank" href="https://github.com/bpocallaghan/notify">
                                Laravel 5 Flash Notifications with icons and animations and with a
                                timeout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="card-title">Alert</div>
                    </div>
                    <div class="card-body">
                        <div class="description">
                            <a target="_blank" href="https://github.com/bpocallaghan/alert">
                                A helper package to flash a bootstrap alert to the browser via a
                                Facade or a helper function.
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <p>A Laravel CMS Starter project with AdminLTE, Roles, Impersonations,
                            Analytics, Activity, Notifications and more.</p>
                    </div>
                    <div class="col-12 col-md-4">
                        <a class="btn btn-lg btn-light btn-block" href="https://github.com/bpocallaghan/titan-starter">
                            <i class="fab fa-fw fa-github"></i>
                            Read More on GitHub
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
