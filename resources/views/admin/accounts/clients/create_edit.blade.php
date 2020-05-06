@extends('admin.admin')

@section('content')
    <div class="card  card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <span><i class="fa fa-edit"></i></span>
                <span>{{ isset($item)? 'Edit the ' . $item->title . ' entry': 'Create a new Client' }}</span>
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <form method="POST" action="{{$selectedNavigation->url . (isset($item)? "/{$item->id}" : '')}}" accept-charset="UTF-8">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <input name="_method" type="hidden" value="{{isset($item)? 'PUT':'POST'}}">

            <div class="card-body">
                @include('admin.partials.card.info')

                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstname">Firstname</label>
                                <input type="text" class="form-control {{ form_error_class('firstname', $errors) }}" id="firstname" name="firstname" placeholder="Enter Firstname" value="{{ ($errors && $errors->any()? old('firstname') : (isset($item)? $item->firstname : '')) }}">
                                {!! form_error_message('firstname', $errors) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastname">Lastname</label>
                                <input type="text" class="form-control {{ form_error_class('lastname', $errors) }}" id="lastname" name="lastname" placeholder="Enter Lastname" value="{{ ($errors && $errors->any()? old('lastname') : (isset($item)? $item->lastname : '')) }}">
                                {!! form_error_message('lastname', $errors) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cellphone">Cellphone</label>
                                <div class="input-group">
                                    <input type="text" class="form-control {{ form_error_class('cellphone', $errors) }}" id="cellphone" name="cellphone" placeholder="Enter Cellphone" value="{{ ($errors && $errors->any()? old('cellphone') : (isset($item)? $item->cellphone : '')) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-mobile-alt"></i></span>
                                    </div>
                                    {!! form_error_message('cellphone', $errors) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <div class="input-group">
                                    <input type="text" class="form-control {{ form_error_class('email', $errors) }}" id="email" name="email" placeholder="Enter Email" value="{{ ($errors && $errors->any()? old('email') : (isset($item)? $item->email : '')) }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    </div>
                                    {!! form_error_message('email', $errors) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control {{ form_error_class('password', $errors) }}" name="password" placeholder="Password" autocomplete="new-password">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                    </div>
                                    {!! form_error_message('password', $errors) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control {{ form_error_class('password_confirmation', $errors) }}" name="password_confirmation" placeholder="Confirm Password" value="{{ old('password_confirmation') }}" autocomplete="new-password">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                    </div>
                                    {!! form_error_message('password_confirmation', $errors) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            	<label for="roles">Roles</label>
                            	{!! form_select('roles[]', $roles, ($errors && $errors->any()? old('roles') : (isset($item)? $item->roles->pluck('id')->all() : '')), ['class' => 'select2 form-control ' . form_error_class('roles', $errors), 'multiple']) !!}
                            	{!! form_error_message('roles', $errors) !!}
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            @include('admin.partials.form.form_footer')
        </form>
    </div>
@endsection
