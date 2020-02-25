@extends('admin.admin')

@section('content')

    <div class="card card-secondary">
        <div class="card-header">
            <span>Update Video List Order</span>
        </div>

        <div class="card-body">
            <div id="nestable-menu">
                <a href="javascript:window.history.back();" class="btn btn-secondary">
                    <span class="label"><i class="fa fa-fw fa-chevron-left"></i></span> Back
                </a>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="dd inline-dd" id="dd-navigation" style="max-width: 100%">
                        <ol class="dd-list">
                            @foreach($items->sortBy('list_order') as $item)
                                <li class="dd-item" data-id="{{ $item->id }}">
                                    <div class="dd-handle" style="overflow: auto;">
                                        @if(isset($item->image))
                                            <figure>
                                                <a href="{{ ($item->is_youtube)? 'https://www.youtube.com/embed/'.$item->link : $item->link}}" style="background-image: url({{ $item->thumbUrl }});" data-fancybox="iframe" data-caption="{{ $item->name }}" title="{{ $item->name }}"><img src="{{ $item->thumbUrl }}" title="{{ $item->name }}" alt="{{ $item->name }}" class="img-fluid"></a>
                                            </figure>
                                        @else
                                            @if(isset($item->is_youtube))
                                                <figure>
                                                    <a href="{{ ($item->is_youtube)? 'https://img.youtube.com/vi/'.$item->link.'/hqdefault.jpg' : $item->link}}" style="background-image: url({{ $item->thumbUrl }});" data-fancybox="iframe" data-caption="{{ $item->name }}" title="{{ $item->name }}"><img width="200px" src="{{ 'https://img.youtube.com/vi/'.$item->link.'/hqdefault.jpg' }}" title="{{ $item->name }}" alt="{{ $item->name }}" class="img-fluid"></a>
                                                </figure>
                                                <span>{{ $item->name }}</span>
                                            @else
                                                <div class="dim-16-9 bg-grunge">
                                                    <iframe class="animate-slow" title="{{ $item->name }}" src="{{ ($item->is_youtube)? 'https://www.youtube.com/embed/'.$item->link : $item->link}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                </div>
                                            @endif

                                        @endif

                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.nestable')
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function ()
        {
            initNestableMenu(1, "/admin/photos/videos/order");
        })
    </script>
@endsection
