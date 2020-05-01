<style>
    .shop-products-list figure img {
        height: 100px;
    }

    .shop-products-list h4 {
        margin-top: 0px;
    }

    .shop-products-list p {
        margin: 0 0 5px;
    }

    .shop-products-list .products-item {
        padding-top: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #ddd;
    }
</style>

<div class="shop-products-list">
    @foreach($item->products as $product)
        <div class="products-item">
            <div class="row">
                <div class="col-xs-4 col-sm-2">
                    <figure>
                        <a href="/admin/shop/products/{{ $product->id }}">
                            <img src="{{ $product->cover_photo->thumbUrl }}" class="display-block">
                        </a>
                    </figure>
                </div>
                <div class="col-xs-8 col-sm-6">
                    <h4>{!! $product->name !!}</h4>
                    <p class="item-category">Category:
                        {{ $product->category->name }} {{ $product->category->parent? " ({$product->category->parent->name})":'' }}
                    </p>
                    @if($product->features)
                        <p class="item-type">Features:
                            @foreach($product->features as $feature)
                                {{ $feature->name }} |
                            @endforeach
                        </p>
                    @endif
                    <p class="item-code">
                        Code: {{ $product->reference }}</p>
                </div>
                <div class="col-xs-offset-4 col-xs-4 col-sm-offset-0 col-sm-2">
                    <p>Price:</p>
                    <p class="item-price">
                        N${{ number_format_decimal($product->amount) }}</p>
                </div>
                <div class="col-xs-4 col-sm-2">
                    <p>Quantity: </p>
                    <p>{{ $product->pivot->quantity }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>