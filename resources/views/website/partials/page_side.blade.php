<div class="side d-none d-sm-block col-sm-5 col-lg-4">
    <div class="card">
        <div class="card-body">
            <h3 class="side-heading">Popular Links</h3>
            <ul class="list-unstyled">
                @foreach($popularPages as $item)
                    <li data-icon="far fa-angle-right"><a href="{{ $item->url }}">{!! $item->name !!}</a></li>
                @endforeach
            </ul>
        </div>
    </div>

    @include('website.partials.side_articles')
</div>
