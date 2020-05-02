<article class="{{ $productClass }}">
    <div class="card h-100">
        <figure class="item-figure card-img-top">
            @if(!isset($backgroundImage))
                <a href="/products/show/{{ $product->slug }}" title="{{ $product->cover_photo->name }}">
                    <img class="img-fluid" src="{{ $product->cover_photo->thumbUrl }}" alt="{{ $product->name }}">
                </a>
            @else
                <a href="/products/show/{{ $product->slug }}" title="{{ $product->cover_photo->name }}" class="cover" style="background-image:url('{{ $item->cover_photo->thumbUrl }}')">
                    <img class="img-fluid" src="{{ $product->cover_photo->thumbUrl }}" alt="{{ $product->name }}">
                </a>
            @endif
        </figure>
        <div class="card-body">
            <h3 class="item-heading card-title"><a href="/products/show/{{ $product->slug }}" title="{{ $product->name }}">{!! $product->name !!}</a></h3>
            <div class="card-text">
                <p class="item-category">Category:
                    <a href="/products/{{ $product->category->slug }}">{{ $product->category->name }} {{ $product->category->parent? " ({$product->category->parent->name})":'' }}</a>

                @if($product->features)
                    <br>Features:
                    @foreach($product->features as $feature)
                        <a href="/products/{{ $feature->slug }}">{{ $feature->name }}</a>
                        @if(!$loop->last) | @endif
                    @endforeach
                @endif
                </p>
            </div>
        </div>
        <div class="card-footer bg-white d-flex justify-content-between align-items-center border-top">
            <strong class="item-price flex-grow-1">N${{ $product->amount }}</strong>
            <div><a href="/products/basket/add/{{$product->id}}" class="btn btn-primary btn-sm item-cart">
                Add to cart
            </a></div>
        </div>
    </div>
</article>