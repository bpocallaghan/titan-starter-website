@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <span><i class="fa fa-eye"></i></span>
                        <span>{{ $item->user->fullname }} - N$ {{ $item->amount }}</span>
                    </h3>
                </div>

                <div class="box-body no-padding">

                    <form>
                        <fieldset>
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

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Grand Total</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">N$</span>
                                            <input type="text" class="form-control" value="{{ $item->amount }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Reference</label>
                                        <input type="text" class="form-control" value="{{ $item->token }}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Created At</label>
                                        <input type="text" class="form-control" value="{{ $item->created_at }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Items Total</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">N$</span>
                                            <input type="text" class="form-control" value="{{ $item->amount_items }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Handling Fee 12%</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">N$</span>
                                            <input type="text" class="form-control" value="{{ $item->amount_handling }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                {{--<div class="col-md-4">
                                    <div class="form-group">
                                        <label>Output Tax 15%</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-link"></i></span>
                                            <input type="text" class="form-control" value="{{ $item->amount_tax }}" readonly>
                                        </div>
                                    </div>
                                </div>--}}
                            </div>

                            @include('admin.shop.product_list')
                        </fieldset>

                        @include('admin.partials.form_footer', ['submit' => false])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection