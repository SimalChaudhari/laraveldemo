@extends('layouts.app')

@section('page_title')
Login
@endsection

@section('content')

<div class="container">
    
    <div class="row">

        <div class="col-md-4 col-sm-4 hidden-xs"></div>

        <div class="col-md-4 col-sm-4 col-xs-12">

            <div class="logo text-center">
                <a href="{{ config('app.hipaamart_parent_domain') }}" target="_blank">
                    <img src="{{ asset('public/images/hipaamart-logo.png') }}" alt="Logo" />
                </a>
            </div>

            <div class="panel panel-default panel-custom">

                <div class="panel-body">

                    @error('username')
                        <center>
                            <p class="invalid-feedback" role="alert" style="color:red;">
                                <strong>{{ $message }}</strong>
                            </p>
                        </center>
                    @enderror

                    <form method="POST" class="validateForm" name="save-password" action="{{ route('save_new_password', $user->id) }}">
                        @csrf

                        <div class="form-group has-feedback user_pass">
                            <label>New Password<span style="color: red;">*</span></label>
                            <input type="password" id="user_pass" name="password" autocomplete="new-password" class="form-control validate[required]" />
                            <!-- <span class="glyphicon glyphicon-lock form-control-feedback" aria-hidden="true"></span> -->
                            <span style="pointer-events: unset !important;cursor: pointer;" class="user_pass_eye glyphicon glyphicon_eye glyphicon-eye-open form-control-feedback" aria-hidden="true"></span>
                            @error('password')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span><br/>
                            @enderror
                        </div>

                        <div class="form-group has-feedback user_pass_conf">
                            <label>Confirm Password<span style="color: red;">*</span></label>
                            <input type="password" id="user_pass_conf" name="password_confirmation" autocomplete="new-password" class="form-control validate[required]" />
                            <!-- <span class="glyphicon glyphicon-lock form-control-feedback" aria-hidden="true"></span> -->
                            <span style="pointer-events: unset !important;cursor: pointer;" class="user_pass_conf_eye glyphicon glyphicon_eye glyphicon-eye-open form-control-feedback" aria-hidden="true"></span>
                        </div>

                        <input type="submit" name="submit" class="btn btn-custom-primary" value="Submit" />              
                        <div class="clearfix"></div>
                    </form>

                    <p class="pull-right" style="margin-bottom: 0;"><a href="{{ route('login') }}">Login Here</a></p>

                </div>
                
            </div>

        </div>

        <div class="col-md-4 col-sm-4 col-xs-12 hidden-xs"></div>

    </div>
    
</div>

<script>
    $(document).on('click', '.user_pass_eye', function(e) {
        e.preventDefault();
        const user_pass = document.getElementById('user_pass');
        if (user_pass.type === 'password') {
            user_pass.type = "text";
            $('.user_pass_eye').removeClass("glyphicon-eye-open").addClass("glyphicon-eye-close");
        }else {
            user_pass.type = "password";
            $('.user_pass_eye').removeClass("glyphicon-eye-close").addClass("glyphicon-eye-open");
        }
    });
</script>

<script>
    $(document).on('click', '.user_pass_conf_eye', function(e) {
        e.preventDefault();
        const user_pass = document.getElementById('user_pass_conf');
        if (user_pass.type === 'password') {
            user_pass.type = "text";
            $('.user_pass_conf_eye').removeClass("glyphicon-eye-open").addClass("glyphicon-eye-close");
        }else {
            user_pass.type = "password";
            $('.user_pass_conf_eye').removeClass("glyphicon-eye-close").addClass("glyphicon-eye-open");
        }
    });
</script>
@endsection