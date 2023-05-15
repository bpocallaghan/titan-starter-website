@extends('admin.admin')

@section('content')
    {{-- most visited and referrers --}}
    <div class="row">
        <div class="col-md-6">
            @include('admin.analytics.partials.visited_pages')
        </div>

        <div class="col-md-6">
            @include('admin.analytics.partials.referrers')
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            @include('admin.analytics.partials.session_group')
        </div>
    </div>
@endsection