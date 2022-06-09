<div class="pagination-box">
    <div class="row d-flex justify-content-center store-list">
        @foreach($paginator as $item)
            @include('website.shop.list_item', ['product' => $item, 'productClass' => 'col-sm-6 col-lg-4', 'backgroundImage' => true])
        @endforeach
    </div>
    @if($paginator->total() > 0)
        @include('website.partials.paginator_footer')
    @endif
</div>
