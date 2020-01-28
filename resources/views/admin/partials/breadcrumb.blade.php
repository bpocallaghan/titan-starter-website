@if(isset($breadcrumbItems))
    <h2 class="d-none">Breadcrumb</h2>
    <div class="ccol-sm-6">
        <ol class="breadcrumb ffloat-sm-right" style="padding: 0px; margin: 0px; background: none; margin-left: 1rem;">
            @foreach($breadcrumbItems as $nav)
                <li class="breadcrumb-item">
                    @if(!$loop->last)
                        <a href="{{ url($nav->url) }}">
                            @if(strlen($nav->icon) > 2)
                                <i class="fa fa-{{ $nav->icon }}"></i>
                            @endif
                            {{ $nav->name }}
                        </a>
                    @else
                        <span class="text-muted">
                            @if(strlen($nav->icon) > 2)
                                <i class="fa fa-{{ $nav->icon }}"></i>
                            @endif
                            {{ $nav->name }}
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
@endif
