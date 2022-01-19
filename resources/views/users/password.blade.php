@extends('layouts.admin')

@section('page_title')
Reset Password
@endsection

@section('content')

<x-alert />

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">

    <div class="col-sm-4 col-xs-12"></div>

    <div class="col-sm-4 col-xs-12">
        
        <div class="panel panel-default panel-custom">

        	<div class="panel-heading">
        		<div class="row">
    				<div class="col-sm-12 col-xs-12">
        				<h3 class="panel-title"><i class="fa fa-2x fa-key" aria-hidden="true"></i> Reset Password for user: {{ $user->firstname }} {{ $user->lastname }}</h3>
        			</div>
        		</div>
    		</div>

            <div class="panel-body">

            	<form name="frmChange" class="validateForm" method="post" action="{{ route('post_updatePassword', $user->uuid) }}">
					@csrf
					
					<div class="form-group has-feedback user_pass">
						<label>New Password{!! $required_field_html !!}</label>
						<input type="password" id="user_pass" name="password" autocomplete="new-password" class="form-control validate[required]" />
						<span style="pointer-events: unset !important;cursor: pointer;" class="user_pass_eye glyphicon glyphicon_eye glyphicon-eye-open form-control-feedback" aria-hidden="true"></span>
						@error('password')
		                    <span class="invalid-feedback" role="alert">{{ $message }}</span><br/>
		                @enderror
					</div>

					<div class="form-group has-feedback user_pass_conf">
						<label>Confirm Password{!! $required_field_html !!}</label>
						<input type="password" id="user_pass_conf" name="password_confirmation" autocomplete="new-password" class="form-control validate[required]" />
						<span style="pointer-events: unset !important;cursor: pointer;" class="user_pass_conf_eye glyphicon glyphicon_eye glyphicon-eye-open form-control-feedback" aria-hidden="true"></span>
					</div>

					
					<input type="submit" name="submit" class="btn btn-custom-primary" value="Reset password" />

				</form>

            </div>

        </div>

    </div>

    <div class="col-sm-4 col-xs-12"></div>

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