@extends('layouts.app')

@section('page_title')
Verify Your Email Address
@endsection

@section('content')

<div class="dialog">
    <div class="logo" align="center">
        <img src="{{ asset('public/images/hipaamart-logo.png') }}" alt="Logo" />
    </div>

    <div class="panel panel-default">
        <p class="panel-heading no-collapse">{{ __('Verify Your Email Address') }}</p>
        <div class="panel-body">
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            <p>{{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }},</p>
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-custom-primary">{{ __('Click here to request another') }}</button>.
            </form>
        </div>
    </div>

</div>

@endsection
