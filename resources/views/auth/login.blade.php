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
                    @if (session('success'))
                        <div class="alert alert-success" role="alert" style="margin-top: 0;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert" style="margin-top: 0;">
                            {{ session('error') }}
                        </div>
                    @endif

                    @error('username')
                        <center>
                            <p class="invalid-feedback" role="alert" style="color:red;">
                                <strong>{{ $message }}</strong>
                            </p>
                        </center>
                    @enderror

                    <form method="POST" class="validateForm" name="login" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group has-feedback">
                            <label>{{ __('Username') }}<span style="color: red;">*</span></label>
                            <input type="text" name="username" value="{{ old('username') }}" class="form-control validate[required, maxSize[200]]" autofocus />
                            <span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
                        </div>

                        <div class="form-group has-feedback user_pass">
                            <label>{{ __('Password') }}<span style="color: red;">*</span></label>
                            <input type="password" id="user_pass" name="password" class="form-control validate[required]" />
                            <!-- <span class="glyphicon glyphicon-lock form-control-feedback" aria-hidden="true"></span> -->
                            <span style="pointer-events: unset !important;cursor: pointer;" class="glyphicon glyphicon_eye glyphicon-eye-open form-control-feedback" aria-hidden="true"></span>
                        </div>

                        <input type="submit" name="submit" class="btn btn-custom-primary" value="Sign In" />              
                        <div class="clearfix"></div>
                    </form>

                    <p class="pull-right" style="margin-bottom: 0;"><a href="{{ route('password.request') }}">Forgot your password?</a> | <a href="{{ route('register') }}">Register Here</a></p>

                </div>
                
            </div>

        </div>

        <div class="col-md-4 col-sm-4 col-xs-12 hidden-xs"></div>

    </div>
    
</div>
<script>
    $(document).on('click', '.glyphicon_eye', function(e) {
        e.preventDefault();
        const user_pass = document.getElementById('user_pass');
        if (user_pass.type === 'password') {
            user_pass.type = "text";
            $('.glyphicon_eye').removeClass("glyphicon-eye-open").addClass("glyphicon-eye-close");
        }else {
            user_pass.type = "password";
            $('.glyphicon_eye').removeClass("glyphicon-eye-close").addClass("glyphicon-eye-open");
        }
    });
</script>
@endsection
