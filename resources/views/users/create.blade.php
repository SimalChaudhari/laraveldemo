@extends('layouts.admin')

@section('page_title')
Add new user
@endsection

@section('content')

<x-alert />

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">

    <div class="col-sm-3 col-xs-12"></div>

    <div class="col-sm-6 col-xs-12">
        
        <div class="panel panel-default panel-custom">

            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <h3 class="panel-title"><i class="fa fa-2x fa-user" aria-hidden="true"></i> Add User <a style="position: absolute;top: 5px;right: 15px;" href="{{ route('users.index') }}" class="btn btn-custom-danger btn-xs pull-right">&laquo; Back</a></h3>
                    </div>
                </div>
            </div>

            <div class="panel-body">

                <p class="col-sm-12 col-xs-12 text-right" style="padding-right: 0;"><small>({!! $required_field_html !!}) fields are mandatory.</small></p>

                <form role="form" name="register" id="formRegister" class="validateForm" method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <div class="row">

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                            
                                <label for="firstname">First Name{!! $required_field_html !!}</label>
                                <input type="text" class="form-control validate[required, maxSize[100]]" name="firstname" value="{{ old('firstname') }}" />

                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="lastname">Last Name{!! $required_field_html !!}</label>
                                <input type="text" class="form-control validate[required, maxSize[100]]" name="lastname" value="{{ old('lastname') }}" />

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="email">Email ID{!! $required_field_html !!}</label>
                                <input type="text" class="form-control validate[required, custom[email], maxSize[255]]" name="email" value="{{ old('email') }}" />

                                @error('email')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="username">Username{!! $required_field_html !!}</label>
                                <input type="text" class="form-control validate[required, maxSize[200]]" name="username" value="{{ old('username') }}" />

                                @error('username')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group has-feedback user_pass">
                                <label for="password">Password{!! $required_field_html !!}</label>
                                <input type="password" id="user_pass"  class="form-control validate[required]" name="password" />
                                <span style="pointer-events: unset !important;cursor: pointer;" class="user_pass_eye glyphicon glyphicon_eye glyphicon-eye-open form-control-feedback" aria-hidden="true"></span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group has-feedback user_pass_conf">
                                <label for="password">Confirm Password{!! $required_field_html !!}</label>
                                <input type="password" id="user_pass_conf" class="form-control validate[required]" name="confirmed" />
                                <span style="pointer-events: unset !important;cursor: pointer;" class="user_pass_conf_eye glyphicon glyphicon_eye glyphicon-eye-open form-control-feedback" aria-hidden="true"></span>
                                @error('confirmed')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="user_role">User role{!! $required_field_html !!}</label>
                                <select type="text" name="user_role" class="form-control validate[required]">
                                    <?php $user_role = old('user_role'); ?>
                                    <option value="">Select Role</option>
                                    <?php if( !empty( $roles ) ) { ?>
                                        <?php foreach( $roles as $role ) { ?>
                                            <option value="{{ $role }}" <?php echo $user_role === $role ? 'selected' : '' ?>>{{ $role }}</option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>

                                @error('user_role')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="company_id">Company{!! $required_field_html !!}</label>
                                
                                <select type="text" name="company_id" class="form-control validate[required]">
                                    <?php
                                    if( ! empty( trim( old('company_id') ) ) ) {
                                        $user_company_id = (int) old('company_id');
                                    } else {
                                        $user_company_id = (int) Auth::user()->company_id;
                                    }
                                    ?>
                                    <option value="">Select Company</option>
                                    @foreach( $companies as $company )
                                    <option value="{{ $company->id }}" <?php echo $user_company_id == $company->id ? 'selected' : ''; ?>>{{ $company->company_name }}</option>
                                    @endforeach
                                </select>

                                @error('company_name')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <?php /*
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="company_website">Company Website{!! $required_field_html !!}</label>
                                <?php
                                if( !empty( trim( old('company_website') ) ) ) {
                                    $company_website = old('company_website');
                                } else {
                                    $company_website = Auth::user()->company_website;
                                }
                                ?>
                                <input type="text" class="form-control validate[required, custom[url]]" name="company_website" value="{{ $company_website }}" />

                                @error('company_website')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>*/?>

                        <?php /*
                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="employee_title">Employee title<span style="color: red;">*</span></label>
                                <input type="text" class="form-control validate[required, maxSize[255]]" name="employee_title" id="employee_title" />

                                @error('employee_title')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>*/ ?>

                        <?php /*
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="company_address_1">Company address 1<span style="color: red;">*</span></label>
                                <?php
                                if( !empty( trim( old('company_address_1') ) ) ) {
                                    $company_address1 = old('company_address_1');
                                } else {
                                    $company_address1 = Auth::user()->company_address_1;
                                }
                                ?>
                                <input type="text" class="form-control validate[required, maxSize[255]]" name="company_address_1" id="company_address_1" value="{{ $company_address1 }}" />

                                @error('company_address_1')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="company_address_2">Company address 2</label>
                                <?php
                                if( !empty( trim( old('company_address_2') ) ) ) {
                                    $company_address_2 = old('company_address_2');
                                } else {
                                    $company_address_2 = Auth::user()->company_address_1;
                                }
                                ?>
                                <input type="text" class="form-control validate[maxSize[255]]" name="company_address_2" id="company_address_2" value="{{ $company_address_2 }}" />

                                @error('company_address_2')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="city">Company city<span style="color: red;">*</span></label>
                                <?php
                                if( !empty( trim( old('city') ) ) ) {
                                    $city = old('city');
                                } else {
                                    $city = Auth::user()->city;
                                }
                                ?>
                                <input type="text" class="form-control validate[required, maxSize[255]]" name="city" id="city" value="{{ $city }}" />
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="state">Company state<span style="color: red;">*</span></label>
                                <?php
                                if( !empty( trim( old('state') ) ) ) {
                                    $state = old('state');
                                } else {
                                    $state = Auth::user()->state;
                                }
                                ?>
                                <input type="text" class="form-control validate[required, maxSize[255]]" name="state" id="state" value="{{ $state }}" />
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="zip">Company zip<span style="color: red;">*</span></label>
                                <?php
                                if( !empty( trim( old('zip') ) ) ) {
                                    $zip = old('zip');
                                } else {
                                    $zip = Auth::user()->zip;
                                }
                                ?>
                                <input type="text" class="form-control validate[required, maxSize[255]]" name="zip" id="zip" value="{{ $zip }}" />
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="company_tel">Company tel<span style="color: red;">*</span></label>
                                <?php
                                if( !empty( trim( old('company_tel') ) ) ) {
                                    $company_tel = old('company_tel');
                                } else {
                                    $company_tel = Auth::user()->company_tel;
                                }
                                ?>
                                <input type="text" class="form-control validate[required, maxSize[255]]" name="company_tel" id="company_tel" value="{{ $company_tel }}" />
                            </div>
                        </div>*/ ?>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="mobile">Mobile<span style="color: red;">*</span></label>
                                <input type="text" class="form-control validate[required, maxSize[14]]" name="mobile" id="mobile" placeholder="(111) 111-1111" />
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12" id="verify_otp_input_wrapper" style="display: none;">
                            <div class="form-group">
                                <label for="mobile">OTP<span style="color: red;">*</span></label>
                                <input type="text" class="form-control validate[required, maxSize[4]]" name="one_time_password" id="one_time_password" placeholder="1234" maxlength="4" />
                            </div>
                        </div>

                    </div>
                    
                    <div class="col-sm-4 col-xs-12"></div>
                    <div class="col-sm-4 col-xs-12">
                        <button type="submit" name="submit" id="btn_add_user" class="btn btn-custom-primary btn-block">Add user</button>
                        <button type="submit" id="btnVerifyOTP" class="btn btn-custom-primary btn-block" style="display: none;">Verify OTP</button>
                    </div>
                    <div class="col-sm-4 col-xs-12"></div>
                    
                </form>

            </div>

        </div>

    </div>

    <div class="col-sm-3 col-xs-12"></div>

</div>

<script>
document.getElementById('mobile').addEventListener('input', function (e) {
    var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
    e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
});

$(document).ready(function() {
    $(document).on('click', '#btn_add_user', function(e) {
        e.preventDefault();

        var btn_add = $(this);

        var btn_txt = btn_add.text();


        if( $('form#formRegister').validationEngine('validate') ) {
            // disable submit button
            btn_add.prop('disabled', true).html('Sending OTP&nbsp;<i class="fa fa-spinner fa-spin"></i>');

            var mobile = $('#mobile').val();
            mobile = mobile.replace('(', '');
            mobile = mobile.replace(')', '');
            mobile = mobile.replace('-', '');
            mobile = mobile.replace(/  +/g, ''); // remove space
            mobile = mobile.replace(' ', ''); // remove space

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route("sendSms") }}',
                method: 'POST',
                data: {to_number: mobile},
                success: function(response) {
                    // disable submit button
                    btn_add.prop('disabled', false).text(btn_txt);

                    // hide the GET OTP button when success response come & show the verify otp button
                    if( response.success == true ) {
                        // $('div#profile_fields_wrapper').hide();
                        $('div#verify_otp_input_wrapper').fadeIn();

                        btn_add.remove();
                        $('button#btnVerifyOTP').show();
                    }

                    // if response has failure then show the current GET OTP button
                    if( response.success == false ) {
                        alert(response.message);
                        return false;
                    }

                }
            });

        }
    });

    $(document).on('click', '#btnVerifyOTP', function(e) {
        e.preventDefault();

        var btnVerifyOtp = $(this);

        var btn_text = $(this).text();

        if( $('form#formRegister').validationEngine('validate') ) {

            var otp = $('#one_time_password').val();
            otp = otp.trim();

            // disable submit button
            btnVerifyOtp.prop('disabled', true).html('Verifying OTP&nbsp;<i class="fa fa-spinner fa-spin"></i>');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route("verifyOTP") }}',
                method: 'POST',
                data: {otp: otp},
                success: function(response) {

                    if( response.success == true ) {
                        $('form#formRegister').submit();
                    }
                    if( response.success == false ) {
                        btnVerifyOtp.prop('disabled', false).text(btn_text);
                        alert(response.message);
                        return false;
                    }
                    
                    
                }
            });

        }


    });

    
});
</script>


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