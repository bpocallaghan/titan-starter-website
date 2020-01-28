@if(isset($pagecrumbItems))
    <h2 class="d-none">Pagecrumb</h2>
    <div class="col-sm-6">
        <h1>
            @foreach($pagecrumbItems as $nav)

                @if($loop->first)
                    @if(strlen($nav->icon) > 2)
                        <i class="fa fa-{{ $nav->icon }}"></i>
                    @endif
                    {{ $nav->name }}
                @else
                    <small class="text-muted">
                        @if(strlen($nav->icon) > 2)
                            <i class="fa fa-{{ $nav->icon }}"></i>
                        @endif
                        {{ $nav->name }}
                    </small>
                @endif
            @endforeach
        </h1>
    </div>
@endif
