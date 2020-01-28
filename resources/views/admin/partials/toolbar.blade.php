<div class="card">
    <div class="card-body">
        <a class="btn btn-primary" href="{{ request()->url().'/create' }}">
            <i class="fa fa-fw fa-plus"></i> Create {{ ucfirst($resource) }}
        </a>

        @if(isset($order) && $order === true)
            <a class="btn btn-default text-primary" href="{{ request()->url().'/order' }}">
                <i class="fa fa-fw fa-align-center"></i> {{ ucfirst($resource) }}
                Order
            </a>
        @endif
    </div>
</div>