@extends('layouts.app')

@section('page_title')
Reset Password
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

                <div class="panel-heading">

                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <h3 class="panel-title"><i class="fa fa-unlock" aria-hidden="true"></i> Reset Password</h3>
                        </div>
                    </div>

                </div>

                <div class="panel-body">

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}" />

                        <div class="form-group has-feedback">
                            <label>{{ __('E-Mail Address') }}<span style="color: red;">*</span></label>
                            <input type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus />
                            <span class="glyphicon glyphicon-envelope form-control-feedback" aria-hidden="true"></span>

                            @error('email')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror

                        </div>

                        <div class="form-group has-feedback">
                            <label>{{ __('Password') }}<span style="color: red;">*</span></label>
                            <input type="password" class="form-control" name="password" required autocomplete="new-password" />
                            <span class="glyphicon glyphicon-lock form-control-feedback" aria-hidden="true"></span>

                            @error('password')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror

                        </div>

                        <div class="form-group has-feedback">
                            <label>{{ __('Confirm Password') }}<span style="color: red;">*</span></label>
                            <input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" />
                            <span class="glyphicon glyphicon-lock form-control-feedback" aria-hidden="true"></span>
                        </div>

                        <input type="submit" name="submit" class="btn btn-custom-primary" id="submit" value="{{ __('Reset Password') }}" />

                    </form>

                </div>

            </div>

        </div>

        <div class="col-md-4 col-sm-4 hidden-xs"></div>

    </div>

</div>

@endsection
