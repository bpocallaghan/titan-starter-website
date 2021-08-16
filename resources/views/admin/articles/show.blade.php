@extends('admin.admin')

@section('content')

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <span><i class="fa fa-eye"></i></span>
                        <span>Articles - {{ $item->name }}</span>
                    </h3>
                </div>
                <form>
                    <div class="card-body">

                        @include('admin.partials.card.info')

                        <fieldset>
                            <div class="row">
                                <div class="col col-6">
                                    <section class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" value="{{ $item->name }}" readonly>
                                    </section>
                                </div>

                                <div class="col col-6">
                                    <section class="form-group">
                                        <label>Slug</label>
                                        <input type="text" class="form-control" value="{{ $item->slug }}" readonly>
                                    </section>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Summary</label>
                                <input type="text" class="form-control" value="{{ $item->summary }}" readonly>
                            </div>

                            <div class="row">
                                <div class="col col-4">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <input type="text" class="form-control" value="{{ $item->category->name }}" readonly>
                                    </div>
                                </div>

                                <div class="col col-4">
                                    <div class="form-group">
                                        <label>Active From</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="{{ $item->active_from }}" readonly>
                                            <div class="input-group-append"><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col col-4">
                                    <div class="form-group">
                                        <label>Active To</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="{{ $item->active_to }}" readonly>
                                            <div class="input-group-append"><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <div class="well well-sm">
                                    {!! $item->content !!}
                                </div>
                            </div>

                            <div class="row">
                                @foreach($item->photos as $photo)
                                    <div class="col-2">
                                        <figure>
                                            <a href="{{ $photo->urlForName($photo->original) }}" data-lightbox="images" data-title="{{ $photo->name }}">
                                                <img src="{{ $photo->urlForName($photo->thumb) }}" title="{{ $photo->name }}" class="img-fluid">
                                            </a>
                                        </figure>
                                    </div>
                                @endforeach
                            </div>
                        </fieldset>
                    </div>
                    @include('admin.partials.form.form_footer', ['submit' => false])
                </form>
            </div>

@endsection
