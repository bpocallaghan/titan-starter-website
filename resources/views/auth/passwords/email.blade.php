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

                <form action="{{ route('password.email') }}" accept-charset="UTF-8" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="email">Email Address</label>
                        <div class="input-group">
                            <input type="text" class="form-control {{ form_error_class('email', $errors) }}" name="email" placeholder="Email Address" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            {!! form_error_message('email', $errors) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <button type="submit" class="btn btn-primary btn-block btn-submit">
                                Send Password Reset Link
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
