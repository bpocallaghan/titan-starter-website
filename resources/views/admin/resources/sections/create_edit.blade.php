@extends('admin.admin')

@section('content')

    <div class="card card-primary ">
        <div class="card-header">

            <span><i class="fa fa-edit"></i></span>
            <span>{{ isset($item)? 'Edit the ' . $item->title . ' entry': 'Create a new Section' }}</span>

        </div>
        <div>

            @include('admin.resources.sections.collapse')
        </div>
    </div>

@endsection
