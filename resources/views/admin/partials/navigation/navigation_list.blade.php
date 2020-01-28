@foreach ($collection as $nav)
    <li class="nav-item {{ array_search_value($nav->id, $selectedNavigationParents) ? 'active menu-open' : '' }} {{ isset($navigation[$nav->id])? 'has-treeview':'' }}">
        <a class="nav-link {{ array_search_value($nav->id, $selectedNavigationParents) ? 'active' : '' }}" href="{{ isset($navigation[$nav->id])? '#' : $nav->url }}">
            <i class="nav-icon fas fa-fw fa-{{ $nav->icon }}"></i>
            <p>
                {!! $nav->name !!}
                @if (isset($navigation[$nav->id]))
                    <i class="right fas fa-angle-left"></i>
                @endif
            </p>
        </a>

        @if (isset($navigation[$nav->id]))
            <ul class="nav nav-treeview">
                @include('admin.partials.navigation.navigation_list', ['collection' => $navigation[$nav->id]])
            </ul>
        @endif
    </li>
@endforeach
