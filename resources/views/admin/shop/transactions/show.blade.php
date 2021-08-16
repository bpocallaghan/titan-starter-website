@extends('admin.admin')

@section('content')

    <div class="card card-outline box-{{ $item->status? $item->status->category:'secondary' }}">
        <div class="card-header">
            <h3 class="card-title">
                <span>#{{ $item->order_number }} - N$ {{ $item->amount }} </span>
            </h3>
        </div>

        <form>
            <div class="card-body">
                <fieldset>
                    @if($item->status)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group float-right">
                                    {{ $item->reference }}

                                    {!! $item->status->badge !!}
                                    <div class="btn-group">
                                        <div class="btn-group">
                                            <a target="_blank" href="/admin/shop/transactions/{{ $item->id }}/print" class="btn btn-primary btn-xs" data-toggle="tooltip" title="Print Order">
                                                <i class="fa fa-print"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>User</label>
                                <input type="text" class="form-control" value="{{ $item->user->fullname }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" value="{{ $item->user->email }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Cellphone</label>
                                <input type="text" class="form-control" value="{{ $item->user->cellphone }}" readonly>
                            </div>
                        </div>
                    </div>

                    <hr/>

                    @if($item->shippingAddress)
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" value="{{ $item->shippingAddress->address }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Postal Code</label>
                                    <input type="text" class="form-control" value="{{ $item->shippingAddress->postal_code }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control" value="{{ $item->shippingAddress->city }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Province</label>
                                    <input type="text" class="form-control" value="{{ $item->shippingAddress->province }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Country</label>
                                    <input type="text" class="form-control" value="{{ $item->shippingAddress->country }}" readonly>
                                </div>
                            </div>
                        </div>

                        <hr/>
                    @endif

                    @if($item->user->shippingAddress)
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" id="address" class="form-control" value="{{ $item->user->shippingAddress->address }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="postal">Postal Code</label>
                                    <input type="text" id="postal" class="form-control" value="{{ $item->user->shippingAddress->postal_code }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" id="city" class="form-control" value="{{ $item->user->shippingAddress->city }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="province">Province</label>
                                    <input type="text" id="province" class="form-control" value="{{ $item->user->shippingAddress->province }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" id="country" class="form-control" value="{{ $item->user->shippingAddress->country }}" readonly>
                                </div>
                            </div>
                        </div>

                        <hr/>
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="total">Grand Total</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">N$</span></div>
                                    <input type="text" id="total" class="form-control" value="{{ $item->amount }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="reference">EFT Payment Reference</label>
                                <input type="text" id="reference" class="form-control" value="{{ $item->reference }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="created_at">Created At</label>
                                <input type="text" id="created_at" class="form-control" value="{{ $item->created_at }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="total_items">Items Total</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">N$</span></div>
                                    <input type="text" id="total_items" class="form-control" value="{{ $item->amount_items }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="handling">Handling Fee 12%</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">N$</span></div>
                                    <input type="text" id="handling" class="form-control" value="{{ $item->amount_handling }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr/>

                    @include('admin.shop.product_list')
                </fieldset>

            </div>
            @include('admin.partials.form.form_footer', ['submit' => false])
        </form>
    </div>
@endsection
