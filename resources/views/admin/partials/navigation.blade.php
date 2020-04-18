<h2 class="d-none">Navigation</h2>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/" class="brand-link">
        <img src="/images/logo_small.png" alt="{{ config('app.name') }} Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <section class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent text-sm" data-widget="treeview" role="menu" data-accordion="false">
                @include('admin.partials.navigation.navigation_list', ['collection' => $navigation['root']])
            </ul>
        </nav>
    </section>
</aside>
