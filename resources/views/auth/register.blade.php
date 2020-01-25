@extends('auth.auth')

@section('content')
    <div class="register-box">
        <div class="login-logo">
            <a href="/"><strong>{!! config('app.name') !!}</strong></a>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Register your Account</h3>
            </div>
            <div class="card-body login-card-body">
                <div class="">
                    @include('alert::alert')
                </div>

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="firstname">Firstname</label>
                        <input type="text" class="form-control {{ form_error_class('firstname', $errors) }}" id="firstname" name="firstname" value="{{ old('firstname') }}" required autofocus>
                        {!! form_error_message('firstname', $errors) !!}
                    </div>

                    <div class="form-group">
                        <label for="lastname">Lastname</label>
                        <input type="text" class="form-control {{ form_error_class('lastname', $errors) }}" id="lastname" name="lastname" value="{{ old('lastname') }}" required>
                        {!! form_error_message('lastname', $errors) !!}
                    </div>

                    <div class="form-group mb-3">
                        <label for="cellphone">Cellphone</label>
                        <div class="input-group">
                            <input type="text" class="form-control {{ form_error_class('cellphone', $errors) }}" id="cellphone" name="cellphone" placeholder="" value="{{ old('cellphone') }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-mobile-alt"></i></span>
                            </div>
                            {!! form_error_message('cellphone', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">Email Address</label>
                        <div class="input-group">
                            <input type="text" class="form-control {{ form_error_class('email', $errors) }}" name="email" placeholder="Email Address" value="{{ old('email') }}" required autocomplete="email">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            {!! form_error_message('email', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control {{ form_error_class('password', $errors) }}" name="password" placeholder="Password" required autocomplete="new-password">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>
                            {!! form_error_message('password', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password_confirmation">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control {{ form_error_class('password_confirmation', $errors) }}" name="password_confirmation" placeholder="Confirm Password" value="{{ old('password_confirmation') }}" required autocomplete="new-password">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>
                            {!! form_error_message('password_confirmation', $errors) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <a class="btn btn-link pl-0" href="{{ route('login') }}">I have an account!</a>
                        </div>

                        <div class="col-6 text-right">
                            <button type="submit" class="btn btn-primary btn-block btn-submit">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
