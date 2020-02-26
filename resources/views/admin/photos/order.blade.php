@extends('admin.admin')

@section('content')

            <div class="card card-secondary">
                <div class="card-header">
                    <span>Update Photos List Order</span>
                </div>

                <div class="card-body">
                    <div id="nestable-menu">
                        <a href="javascript:window.history.back();" class="btn btn-secondary">
                            <span class="label"><i class="fa fa-fw fa-chevron-left"></i></span>Back
                        </a>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="dd inline-dd" id="dd-navigation" style="max-width: 100%">
                                <ol class="dd-list">
                                    @foreach($items->sortBy('list_order') as $item)
                                        <li class="dd-item" data-id="{{ $item->id }}" >
                                            <div class="dd-handle" style="overflow: auto;">
                                                <img src="{{ $item->thumb_url }}" style="height: 100px; float: left;margin-right: 15px;">
                                                <p>
                                                    {{ $item->name }}
{{--                                                    <br/>{{ $item->summary }}--}}
                                                </p>

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
            initNestableMenu(1, "/admin/photos/order");
        })
    </script>
@endsection
