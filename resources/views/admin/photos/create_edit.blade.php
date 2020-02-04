@extends('admin.admin')

@section('content')

    @include('admin.photos.videos.videoable', ['videoable' => $photoable])

    @include('admin.photos.photoable')

@endsection
