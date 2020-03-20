@extends('admin.admin')

@section('content')
    @include('admin.analytics.partials.analytics_header')

    <div class="row">
        <div class="col-md-12">
            @include('admin.analytics.partials.visitors_views')
        </div>
    </div>

    {{-- locations + most visited pages --}}
    <div class="row">
        <div class="col-md-5">
            @include('admin.analytics.partials.visited_pages')
        </div>

        <div class="col-md-7">
            @include('admin.analytics.partials.locations')
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            @include('admin.analytics.partials.devices')
        </div>
        <div class="col-md-6">
            @include('admin.analytics.partials.browsers')
        </div>
    </div>
@endsection
