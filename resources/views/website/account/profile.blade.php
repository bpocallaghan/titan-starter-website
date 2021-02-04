@extends('website.website')

@section('content')
    <section class="container body ">


        @include('website.partials.page_header')

        @include('alert::alert')

        <h3>Update my Information</h3>

        <div class="row pb-5">
            <div class="col-sm-7 col-lg-8">
                <form id="form-member-register" method="POST" action="{{ route('profile.submit') }}" accept-charset="UTF-8" class="needs-validation" novalidate>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control {{ form_error_class('firstname', $errors) }}" name="firstname" placeholder="Enter First Name" value="{{ ($errors->any()? old('firstname') : $user->firstname) }}" required>
                                {!! form_error_message('firstname', $errors) !!}
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control {{ form_error_class('lastname', $errors) }}" name="lastname" placeholder="Enter Last Name" value="{{ ($errors->any()? old('lastname') : $user->lastname) }}" required>
                                {!! form_error_message('lastname', $errors) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cellphone">Cellphone</label>
                        <div class="input-group">
                            <input type="text" class="form-control {{ form_error_class('cellphone', $errors) }}" id="cellphone" name="cellphone" placeholder="Please insert the Cellphone" value="{{ ($errors->any()? old('cellphone') : $user->cellphone) }}">
                            {!! form_error_message('cellphone', $errors) !!}
                            <div class="input-group-append"><span class="input-group-text"><i class="fa fa-fw fa-mobile-alt"></i></span></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-group">
                            <input type="text" class="form-control {{ form_error_class('email', $errors) }}" id="id-email" name="email" placeholder="Email Address" value="{{ ($errors->any()? old('email') : $user->email) }}" required>
                            {!! form_error_message('email', $errors) !!}
                            <div class="input-group-append"><span class="input-group-text"><i class="fa fa-fw fa-envelope"></i></span></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Password (leave blank to keep it unchanged)</label>
                        <div class="input-group">
                            <input type="password" class="form-control {{ form_error_class('password', $errors) }}" id="id-password" name="password" placeholder="Password" value="{{ old('password') }}">
                            {!! form_error_message('password', $errors) !!}
                            <div class="input-group-append"><span class="input-group-text"><i class="fa fa-fw fa-lock"></i></span></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control {{ form_error_class('password_confirmation', $errors) }}" id="id-password_confirmation" name="password_confirmation" placeholder="Password Confirm" value="{{ old('password_confirmation') }}">
                            {!! form_error_message('password_confirmation', $errors) !!}
                            <div class="input-group-append"><span class="input-group-text"><i class="fa fa-fw fa-lock"></i></span></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-primary btn-submit">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @include('website.partials.page_side')
        </div>


    </section>
@endsection
