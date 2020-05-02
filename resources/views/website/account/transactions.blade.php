@extends('website.website')

@section('content')
    <section class="container body">


        @include('website.partials.page_header')

        <div class="row pb-5">
            <div class="col-sm-7 col-lg-8">

                <table id="tbl-list" data-order-by="0|desc" data-page-length="25" data-server="false" class="dt-table table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Created</th>
                        <th>EFT Reference</th>
                        <th>Amount</th>
                        <th>Total Products</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->created_at->format('H:i \o\n d M Y') }}</td>
                            <td>{{ $item->reference }}</td>
                            <td>N${{ $item->amount }}</td>
                            <td>{{ $item->products->count() }}</td>
                            <td>{!! ($item->status ? $item->status->badge:'') !!}</td>
                            <td>
                                <a href="/account/orders/{{ $item->reference }}">
                                    Show Order
                                </a>

                                <a target="_blank" href="/account/orders/{{ $item->reference }}/print" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Print Order">
                                    <i class="fa fa-fw fa-print"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="alert alert-info">
                    <strong>EFT Payment Details</strong><br/>
                    Name: XXX<br/>
                    Account number: XXXX<br/>
                    Branch code: XXXX<br/>
                    Swift code: XXX
                </div>


            </div>

            @include('website.partials.page_side')
        </div>

    </section>
@endsection