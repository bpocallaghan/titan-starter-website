@extends('admin.admin')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span>List All Products</span>
            </h3>
        </div>

        <div class="card-body">

            @include('admin.partials.card.info')

            @include('admin.partials.card.buttons')

            <table id="tbl-list" data-server="false" data-page-length="25" class="dt-table table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Code</th>
                    <th>Amount</th>
                    <th>Cover Photo</th>
                    <th>Category</th>
                    <th>Feature</th>
                    <th>Views</th>
                    <th>Purchased</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->reference }}</td>
                        <td>{{ $item->amount }}</td>
                        <td>
                            @if($item->cover_photo)
                                {!! image_row_link($item->cover_photo->name, $item->cover_photo->thumb, $item->cover_photo->filename) !!}
                            @endif
                        </td>
                        <td>{{ $item->category_and_parent }}</td>
                        <td>
                            @if($item->features->count() > 0)
                                {{ $item->features->implode('name', ' and ') }}
                            @endif
                        </td>
                        <td>{{ $item->total_views }}</td>
                        <td>{{ $item->total_purchases }}</td>
                        <td>

                            {!! action_row($selectedNavigation->url, $item->id, $item->name, [['photo-video' => '/admin/shop/products/'.$item->id.'/resources'], 'edit', 'delete']) !!}

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
