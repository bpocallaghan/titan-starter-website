@extends('admin.admin')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Comments - {{ $item->content }}</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            @include('admin.partials.card.info')

            <form>
                <fieldset>

                    <div class="form-group">
                        <label for="content">Comment</label>
                        <textarea class="form-control" id="content" name="content" rows="5" readonly>{{ ($errors && $errors->any()? old('content') : (isset($item)? $item->content : '')) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ ($errors && $errors->any()? old('name') : (isset($item)? $item->name : '')) }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ ($errors && $errors->any()? old('email') : (isset($item)? $item->email : '')) }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-2">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input readonly disabled type="checkbox" name="is_approved" class="custom-control-input" id="is_approved" {!! ($errors && $errors->any()? (old('is_approved') == 'on'? 'checked':'') : (isset($item)&& $item->is_approved == 1? 'checked' : '' )) !!}>
                                    <label class="custom-control-label" for="is_approved">Approve comment</label>
                                </div>
                            </div>
                        </div>
                    </div>

                </fieldset>
            </form>
        </div>

        @include('admin.partials.form.form_footer', ['submit' => false])

    </div>
@endsection
