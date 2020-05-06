@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <span><i class="fa fa-table"></i></span>
                        <span>List Latest Checkouts</span>
                    </h3>
                </div>

                <div class="box-body">

                    @include('admin.partials.card.info')

                    <table id="tbl-list" data-order-by="0|desc" data-page-length="25" data-server="false" class="dt-table table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Total Products</th>
                            <th>Transaction</th>
                            <th>Reference</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->user->fullname }}</td>
                                <td>N${{ $item->amount }}</td>
                                <td>{{ $item->products->count() }}</td>
                                <td>
                                    @if($item->transaction_id)
                                        <a target="_blank" href="/admin/shop/transactions/{{ $item->transaction_id }}">
                                            Show Transaction
                                        </a>
                                    @endif
                                </td>
                                <td>{{ $item->token }}</td>
                                <td>{{ $item->created_at->format('H:i \o\n d M Y') }}</td>
                                <td>
                                        {!! action_row($selectedNavigation->url, $item->id, $item->name, ['show']) !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
