@extends('admin.admin')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <span><i class="fa fa-align-center"></i></span>
                        <span>Update {{ ucfirst($resource) }} List Order</span>
                    </h3>
                </div>

                <div class="box-body">
                    <div class="well well-sm well-toolbar" id="nestable-menu">
                        <a href="javascript:window.history.back();" class="btn btn-labeled btn-default">
                            <span class="btn-label"><i class="fa fa-fw fa-chevron-left"></i></span>Back
                        </a>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="dd" id="dd-navigation" style="max-width: 100%">
                                <ol class="dd-list">
                                    @foreach($items->sortBy('list_order') as $item)
                                        <li class="dd-item" data-id="{{ $item->id }}" style="display:inline-block;">
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
