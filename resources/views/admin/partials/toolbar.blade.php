<div class="mb-3" role="group" aria-label="Page functionality">
    <a class="btn btn-primary" href="{{ request()->url().'/create' }}">
        <i class="fa fa-fw fa-plus"></i> Create {{ ucfirst($resource) }}
    </a>

    @if(isset($order) && $order === true)
        <a class="btn btn-light" href="{{ request()->url().'/order' }}">
            <i class="fa fa-fw fa-align-center"></i> {{ ucfirst($resource) }}
            Order
        </a>
    @endif
</div>