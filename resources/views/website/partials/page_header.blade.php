<div class="row mb-3">
    <div class="col-sm-7 col-lg-8">
        <h2 class="page-header">{!! isset($pageTitle) ? $pageTitle : $page->name !!}</h2>
    </div>
    <div class="col-sm-5 col-lg-4">
        @include('website.partials.breadcrumb')
    </div>
</div>