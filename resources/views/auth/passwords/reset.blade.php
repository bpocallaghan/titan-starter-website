@extends('auth.auth')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="/"><strong>{!! config('app.name') !!}</strong></a>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Reset Password</h3>
            </div>
            <div class="card-body login-card-body">
                <div class="">
                    @include('alert::alert')
                </div>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group mb-3">
                        <label for="email">Email Address</label>
                        <div class="input-group">
                            <input type="text" class="form-control {{ form_error_class('email', $errors) }}" name="email" placeholder="Email Address" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            {!! form_error_message('email', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control {{ form_error_class('password', $errors) }}" name="password" placeholder="Password" value="{{ old('password') }}" required autocomplete="new-password">
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
                        <div class="col-md-6 offset-md-3">
                            <button type="submit" class="btn btn-primary btn-block btn-submit">
                                Reset Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
