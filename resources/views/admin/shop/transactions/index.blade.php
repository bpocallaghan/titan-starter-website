@extends('admin.admin')

@section('styles')
    @parent
    <style>
        #form-modal-status .select2.select2-container {
            display: block;
            width: 100% !important;
        }
    </style>
@endsection

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span>List Latest Transactions</span>
            </h3>
        </div>

        <div class="card-body">

            @include('admin.partials.card.info')

            <table id="tbl-list" data-order-by="0|desc" data-page-length="25" data-server="false" class="dt-table table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Order #</th>
                    <th>Reference</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th># Products</th>
                    <th>Address</th>
                    <th>Purchased At</th>
                    <th>Status</th>
                    <th style="min-width: 80px;">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->order_number }}</td>
                        <td>{{ $item->reference }}</td>
                        <td>{{ $item->user->fullname }}</td>
                        <td>N${{ $item->amount }}</td>
                        <td>{{ $item->products->count() }}</td>
                        <td>
                            @if($item->shippingAddress)
                                {!! $item->shippingAddress->label !!}
                            @else
                                {!! $item->user->shippingAddress? $item->user->shippingAddress->label :'' !!}
                            @endif
                        </td>
                        <td>{{ $item->created_at->format('H:i \o\n d M Y') }}</td>
                        <td>{!! ($item->status?  $item->status->badge:'') !!}</td>
                        <td>
                            <a href="{{ "{$selectedNavigation->url}/{$item->id}" }}" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Show Details">
                                <i class="fa fa-fw fa-credit-card"></i>
                            </a>

                            <a data-id="{{ $item->id }}" data-name="{{ $item->order_number }}" data-status-id="{{ $item->status_id }}" class="btn btn-info btn-xs btn-modal-status-row" data-toggle="tooltip" title="Update Status">
                                <i class="fa fa-fw fa-tag"></i>
                            </a>

                            <a target="_blank" href="/admin/shop/transactions/{{ $item->id }}/print" class="btn btn-light btn-xs" data-toggle="tooltip" title="Print Order">
                                <i class="fa fa-fw fa-print"></i>
                            </a>

                            {{--@if($item->checkout_id && user()->isDeveloper())
                                <div class="btn-group">
                                    <a href="/admin/shop/checkouts/{{ $item->checkout_id }}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Show Checkout">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>
                                </div>
                            @endif--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="modal fade" id="modal-status" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header alert-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Update Status</h4>
                </div>
                <div class="modal-body">
                    <form id="form-modal-status">
                        <input type="hidden" name="id"/>

                        <div class="form-group">
                            <label for="name">Order Number</label>
                            <input type="text" class="form-control" name="name" placeholder="Text to display" value="">
                        </div>

                        <div class="form-group">
                            <label for="status_id">Status</label>
                            {!! form_select('status_id', ([0 => 'Select a Status'] + $statuses), null, ['class' => 'select2 form-control']) !!}
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel
                    </button>
                    <button id="modal-status-submit" type="button" class="btn btn-primary btn-ajax-submit" data-dismiss="modal">
                        Update Status
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function () {
            $('.dt-table').on('click', '.btn-modal-status-row', onUpdateStatusClick);

            function onUpdateStatusClick(e)
            {
                e.preventDefault();
                $('#modal-status').modal('show');

                $('#form-modal-status input[name="id"]').val($(this).attr('data-id'));
                $('#form-modal-status input[name="name"]').val($(this).attr('data-name'));
                $('#form-modal-status select[name="status_id"]').val($(this).attr('data-status-id'));
                $('#form-modal-status select[name="status_id"]').change();

                return false;
            }

            // on insert link
            $('#modal-status-submit').on('click', function () {
                var transactionId = $('#form-modal-status input[name="id"]').val();
                var statusId = $('#form-modal-status select[name="status_id"]').find(":selected").val();

                doAjax("/admin/shop/transactions/" + transactionId + "/status", {'status_id': statusId}, function () {
                    window.location.reload(true);
                })
            })
        })
    </script>
@endsection
