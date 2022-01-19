@extends('layouts.app')

@section('page_title')
Forgot Password
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
                            <h3 class="panel-title"><i class="fa fa-key" aria-hidden="true"></i> Forgot Password</h3>
                        </div>
                    </div>

                </div>

                <div class="panel-body">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert" style="margin-top: 0;">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group has-feedback">
                            <label>{{ __('E-Mail Address') }}<span style="color: red;">*</span></label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" autocomplete="email" autofocus />
                            <span class="glyphicon glyphicon-envelope form-control-feedback" aria-hidden="true"></span>

                            @error('email')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror

                        </div>

                        <input type="submit" name="submit" class="btn btn-block btn-custom-primary" id="submit" value="{{ __('Send Password Reset Link') }}" />

                    </form>

                </div>

            </div>

            <p style="margin-bottom: 0;text-align: right;"><a href="{{ route('login') }}">&laquo; Sign In</a></p>

        </div>

        <div class="col-md-4 col-sm-4 hidden-xs"></div>

    </div>

</div>

@endsection
