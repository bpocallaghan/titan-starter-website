@extends('auth.auth')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="/"><strong>{!! config('app.name') !!}</strong></a>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sign In</h3>
            </div>
            <div class="card-body login-card-body">
                <div class="">
                    @include('alert::alert')
                </div>

                <form action="{{ route('login') }}" accept-charset="UTF-8" method="POST">
                    @csrf

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
                            <input type="password" class="form-control {{ form_error_class('password', $errors) }}" name="password" placeholder="Password">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>
                            {!! form_error_message('password', $errors) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input id="remember" type="checkbox" name="remember" checked="checked">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block btn-submit">
                                Sign In
                            </button>
                        </div>
                    </div>
                </form>

                <p class="mb-1">
                    <a href="{{ route('password.request') }}">Forgot password?</a>
                </p>
                <p class="mb-0">
                    <a href="{{ route('register') }}" class="text-center">Register your account?</a>
                </p>
            </div>
        </div>
    </div>
@endsection
