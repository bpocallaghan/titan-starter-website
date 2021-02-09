@extends('admin.admin')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span><i class="fa fa-eye"></i></span>
                <span>Products - {{ $item->name }}</span>
            </h3>
        </div>

        <form>
            <div class="card-body">

                @include('admin.partials.card.info')


                <fieldset>
                    <div class="row">
                        <section class="col col-6">
                            <section class="form-group">
                                <label>Product</label>
                                <input type="text" class="form-control" value="{{ $item->name }}" readonly>
                            </section>
                        </section>

                        <section class="col col-6">
                            <section class="form-group">
                                <label>Slug</label>
                                <input type="text" class="form-control" value="{{ $item->slug }}" readonly>
                            </section>
                        </section>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category</label>
                                <input type="text" class="form-control" value="{{ $item->category->name }} {{ $item->category->parent? " ({$item->category->parent->name})":'' }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Features</label>
                                <input type="text" class="form-control" value="{{ implode(', ',$item->features->pluck('name')->toArray()) }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Amount</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">N$</span>
                                    </div>
                                    <input type="text" class="form-control" value="{{ $item->amount }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Reference</label>
                                <input type="text" class="form-control" value="{{ $item->reference }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="superbox">
                        @foreach($item->photos as $photo)
                            <div class="superbox-list">
                                <a href="{{ $photo->urlForName($photo->original) }}" data-lightbox="images" data-title="{{ $photo->name }}">
                                    <img src="{{ $photo->urlForName($photo->thumb) }}" title="{{ $photo->name }}" class="superbox-img">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </fieldset>
            </div>
            @include('admin.partials.form.form_footer', ['submit' => false])
        </form>
    </div>
@endsection
