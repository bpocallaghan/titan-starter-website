@extends('admin.admin')

@section('content')


            <div class="card card-primary">
                <div class="card-header">
                    <span>Update Profile</span>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <form method="POST" action="{{ $selectedNavigation->url . "/" . user()->id }}" accept-charset="UTF-8" enctype="multipart/form-data">

                    <div class="card-body">

                        @include('admin.partials.card.info')


                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <input name="_method" type="hidden" value="PUT">

                        <fieldset>
                            <div class="row">
                                <div class="col col-6">
                                    <div class="form-group">
                                        <label for="firstname">Firstname</label>
                                        <div class="input-group">
                                            <input type="text" name="firstname" class="form-control {{ form_error_class('firstname', $errors) }}" placeholder="Firstname" value="{{ ($errors->any()? old('firstname') : user()->firstname) }}">
                                            <div class="input-group-append"><span class="input-group-text"><i class="far fa-user"></i></span></div>
                                            {!! form_error_message('firstname', $errors) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col col-6">
                                    <div class="form-group">
                                        <label for="email">Lastname</label>
                                        <div class="input-group">
                                            <input type="text" name="lastname" class="form-control {{ form_error_class('lastname', $errors) }}" placeholder="Lastname" value="{{ ($errors->any()? old('lastname') : user()->lastname) }}">
                                            <div class="input-group-append"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                                            {!! form_error_message('lastname', $errors) !!}
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cellphone">Cellphone</label>
                                        <div class="input-group">
                                        <input type="text" class="form-control {{ form_error_class('cellphone', $errors) }}" id="cellphone" name="cellphone" placeholder="Please insert the Cellphone" value="{{ ($errors && $errors->any()? old('cellphone') : user()->cellphone ) }}">
                                            <div class="input-group-append"><span class="input-group-text"><i class="fa fa-mobile-alt"></i></span></div>
                                            {!! form_error_message('cellphone', $errors) !!}
                                        </div>

                                    </div>
                                </div>
                                <div class="col col-6">
                                    <section class="form-group">
                                        <label for="email">Email Address (readonly)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control {{ form_error_class('email', $errors) }}" id="email" name="email" placeholder="Email Address" value="{{ ($errors->any()? old('email') : user()->email) }}" readonly>
                                            <div class="input-group-append"><span class="input-group-text"><i class="fa fa-envelope"></i></span></div>
                                            {!! form_error_message('email', $errors) !!}
                                        </div>

                                    </section>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Date of Birth</label>
                                        <div class="input-group">
                                            <input id="born_at" type="text" class="form-control {{ form_error_class('born_at', $errors) }}" name="born_at" placeholder="Select your birth date" value="{{ ($errors->any()? old('born_at') : user()->born_at) }}">
                                            <div class="input-group-append"><span class="input-group-text"><i class="fa fa-calendar"></i></span></div>
                                            {!! form_error_message('born_at', $errors) !!}
                                        </div>

                                    </div>
                                </div>
                                <div class="col col-6">
                                    <div class="form-group ">
                                        <label for="password">Password <small> (leave blank to keep it unchanged)</small></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control {{ form_error_class('password', $errors) }}" id="password" name="password" placeholder="Password" value="" >
                                            <div class="input-group-append"><span class="input-group-text"><i class="fa fa-lock-open"></i></span></div>
                                            {!! form_error_message('password', $errors) !!}
                                        </div>

                                    </div>
                                </div>


                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <label>Gender</label>
                                    <div class="form-group">

                                        <div class="form-check form-check-inline">
                                            <div class="custom-control custom-radio mr-5">
                                                <input class="custom-control-input {{ form_error_class('gender', $errors) }}" type="radio" id="gender1" name="gender" value="male" {{ ($errors->any() && old('gender') == 'male'? 'checked="checked"' : (user()->gender == 'male'? 'checked="checked"':'')) }}>
                                                <label for="gender1" class="custom-control-label">Male</label>
                                                {!! form_error_message('gender', $errors) !!}
                                            </div>

                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input {{ form_error_class('gender', $errors) }}" type="radio" id="gender2" name="gender" value="female" {{ ($errors->any() && old('gender') == 'female'? 'checked="checked"' : (user()->gender == 'female'? 'checked="checked"':'')) }}>
                                                <label for="gender2" class="custom-control-label">Female</label>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Confirm Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control {{ form_error_class('password_confirmation', $errors) }}" id="id-password_confirmation" name="password_confirmation" placeholder="Password Confirm" value="{{ ($errors->any()? old('password_confirmation') : user()->password_confirmation) }}">
                                            <div class="input-group-append"><span class="input-group-text"><i class="fa fa-lock"></i></span></div>
                                            {!! form_error_message('password_confirmation', $errors) !!}
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <section class="form-group ">
                                <label>Profile image (250 x 250)</label>
                                <div class="input-group input-group-sm">
                                    <input id="photo-label" type="text" class="form-control {{ form_error_class('photo', $errors) }}" readonly placeholder="Browse for an image">
                                    <input id="photo" style="display: none" accept="{{ get_file_extensions('image') }}" type="file" name="photo" onchange="document.getElementById('photo-label').value = this.value">
                                    {!! form_error_message('photo', $errors) !!}
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary" onclick="document.getElementById('photo').click();">Browse</button>
                                    </div>
                                </div>

                            </section>

                            @if(user()->image)
                                <section>
                                    <img src="{{ profile_image() }}" style="max-height: 300px;">
                                    <input type="hidden" name="image" value="{{ user()->image }}">
                                </section>
                            @endif
                        </fieldset>

                    </div>
                    @include('admin.partials.form.form_footer')
                </form>
            </div>

@endsection

@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
        $(function ()
        {
            $("#born_at").datetimepicker({
                viewMode: 'years',
                format: 'YYYY-MM-DD'
            });
        })
    </script>
@endsection
