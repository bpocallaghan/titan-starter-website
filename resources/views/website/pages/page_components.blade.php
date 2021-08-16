@foreach($item->sections->sortBy('list_order') as $section)

    @if(isset($section->name))
        <h2>{!! $section->name !!}</h2>
    @endif

    {!! $section->content !!}

    @include('website.pages.page_gallery' , ['content' => $section])
    @include('website.pages.page_videos' , ['content' => $section])
    @include('website.pages.page_documents' , ['content' => $section])

    @if($section->layout == 'faq')

        @include('website.faq.faq')

    @endif

    @if($section->layout == 'articles')

        @include('website.articles.pagination')

    @endif

    @if($section->layout == 'products')

        @include('website.shop.pagination')

    @endif

    @if($section->layout == 'contact')

        @include('website.partials.form.contact_form', ['resourceable' => (isset($section)? $section : $item)])

    @endif

    @if(isset($section->components) && $section->components->count() > 0)
        <div class="row">

            @foreach($section->components->sortBy('list_order') as $content)
                <section class="{{ isset($section->layout) && strpos($section->layout, 'col') !== false? $section->layout: 'col-12' }} mb-4 mb-md-3">
                    @include('website.pages.page_heading')
                    @include('website.pages.page_content')

                    @include('website.pages.page_gallery')
                    @include('website.pages.page_videos')
                    @include('website.pages.page_documents')
                </section>
            @endforeach
        </div>
    @endif

@endforeach
