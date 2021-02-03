@extends('website.website')

@section('content')
     <section class="container body">

         <div class="row mb-3">
             <div class="col-sm-7 col-lg-8">
                 <h2 class="page-header">{!! $item->name !!}</h2>
             </div>
             <div class="col-sm-5 col-lg-4">
                 @include('website.partials.breadcrumb')
             </div>
         </div>

            <!--Row-->
            <div class="row pb-5">
                <!--Content-->
                <div class="col-sm-7 col-lg-8 content">

                    <!--Product-->
                    <section class="row mb-5">
                        <div class="col-sm-8 col-md-5">
                            <div class="owl-carousel item-gallery">
                                @foreach($item->photos as $photo)
                                    <div>
                                        <figure>
                                            <a href="{{ $photo->url }}" title="{{ $photo->name }}" data-lightbox="gallery" data-caption="{{ $photo->name }}">
                                                <img src="{{ $photo->thumbUrl }}" alt="{{ $photo->name }}" class="img-fluid">
                                            </a>
                                            <figcaption>{{ $photo->name }}</figcaption>
                                        </figure>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-7 store-item">
                            <h3>{!! $item->name !!}</h3>
                            <p class="item-category"><strong>Category:</strong>
                                <a href="/products/{{ $item->category->slug }}">{{ $item->category->name }} {{ $item->category->parent? " ({$item->category->parent->name})":'' }}</a>

                                @if($item->features)
                                    <br><strong>Feature(s):</strong>
                                    @foreach($item->features as $feature)
                                        <a href="/products/{{ $feature->slug }}">{{ $feature->name }}</a>
                                        @if(!$loop->last) | @endif
                                    @endforeach
                                @endif
                            </p>
                            <p class="item-code small">CODE: {{ $item->reference }} |
                                @if($item->in_stock)
                                    <span data-icon="fa-check">In Stock</span>
                                @else
                                    <span data-icon="fa-close">Not In Stock</span>
                                @endif
                            </p>
                            @if($item->special_to > Carbon\Carbon::now())
                                <del class="text-muted">N${{ $item->amount }}</del>
                                <span class="text-green">N${{ $item->special_amount }}</span>
                            @else
                                <span class="text-bold">N${{ $item->amount }}</span>
                            @endif
                            <div class="item-description mt-3">
                                {!! $item->content !!}
                            </div>
                            <form class="form-inline padding-bottom">
                                <div class="form-group">
                                    <label for="quantity" class="control-label">Quantity: </label>
                                    <div class="input-group">
                                        <input type="number" class="form-control input-lg" value="1" id="quantity" placeholder="Quantity" min="1">
                                        <div class="input-group-append">
                                            <a data-id="{{$item->id}}" id="js-add-cart" class="btn btn-primary item-cart">
                                                Add to cart{{-- <i data-icon="fa-cart-plus"></i>--}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>


                    </section>

                    <!--Similar-->
                    @if($sameCategoryItems->count() > 0)
                    <section class="similar-products padding padding-top">
                        <h2 class="mb-5">Similar Products</h2>

                        <div class="owl-carousel row">
                            @if($sameCategoryItems->count() > 0)
                                @foreach($sameCategoryItems as $product)
                                    <div class="col-md-4">
                                        <article>

                                            <figure class="dim-1-1 mb-4">
                                                <a href="/products/show/{{ $product->slug }}" title="{{ $product->name }}" style="background-image: url({{ $product->cover_photo->thumbUrl  }});">
                                                    <img alt="{{ $product->cover_photo->name? $product->cover_photo->name: $product->name }}" title="{{ $product->cover_photo->name? $product->cover_photo->name: $product->name }}" src="{{ $product->cover_photo->thumbUrl }}" class="img-fluid">
                                                </a>
                                                <figcaption>
                                                    {{ $product->name }}
                                                </figcaption>
                                            </figure>

                                        </article>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </section>
                    @endif
                    <!--Similar-->

                    @include('website.partials.social_share')

                </div>
                <!--Content-->

                @include('website.partials.page_side')


            </div>
            <!--Row-->


    </section>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function () {
            $('#js-add-cart').on('click', function () {
                var quantity = parseInt($('#quantity').val());

                var url = '/products/basket/add/' + $(this).attr('data-id') + '/' + quantity;
                window.location.href = url;
            })
        })
    </script>
@endsection
