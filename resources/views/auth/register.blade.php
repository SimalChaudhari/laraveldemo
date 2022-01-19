@extends('layouts.app')

@section('page_title')
Register
@endsection

@section('content')

<div class="container">
    
    <div class="row">

        <div class="col-md-2 col-sm-3 hidden-xs"></div>

        <div class="col-md-8 col-sm-6 col-xs-12">

            <div class="logo text-center">
                <a href="{{ config('app.hipaamart_parent_domain') }}" target="_blank">
                    <img src="{{ asset('public/images/hipaamart-logo.png') }}" alt="Logo" />
                </a>
            </div>

            <div class="panel panel-default panel-custom">

                <div class="panel-heading">

                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <h3 class="panel-title"><i class="fa fa-user" aria-hidden="true"></i> Sign Up</h3>
                        </div>
                    </div>

                </div>

                <div class="panel-body">

                    <form name="register" id="formRegister" class="validateForm" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">

                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group has-feedback">
                                    <label>First Name<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control validate[required, maxSize[100]]" name="firstname" value="{{ old('firstname') }}" />
                                    <span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>

                                    @error('firstname')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>

                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group has-feedback">
                                    <label>Last Name<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control validate[required, maxSize[100]]" name="lastname" value="{{ old('lastname') }}" />
                                    <span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>

                                    @error('lastname')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group has-feedback">
                                    <label>Email Address<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control validate[required, custom[email], maxSize[255]]" name="email" value="{{ old('email') }}" />
                                    <span class="glyphicon glyphicon-envelope form-control-feedback" aria-hidden="true"></span>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group has-feedback">
                                    <label>Username<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control validate[required, maxSize[200]]" name="username" value="{{ old('username') }}" />
                                    <span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group has-feedback user_pass">
                                    <label>Password<span style="color: red;">*</span></label>
                                    <input type="password" id="user_pass" class="form-control validate[required]" name="password" />
                                    <!-- <span class="glyphicon glyphicon-lock form-control-feedback" aria-hidden="true"></span> -->
                                    <span style="pointer-events: unset !important;cursor: pointer;" class="glyphicon glyphicon_eye glyphicon-eye-open form-control-feedback" aria-hidden="true"></span>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>User Role<span style="color: red;">*</span></label>
                                    <select name="user_role" class="form-control validate[required]">
                                        <?php $user_role = old('user_role'); ?>
                                        <option value="">Select</option>
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
                                    <label>Company name<span style="color: red;">*</span></label>
                                    
                                    <select name="company_id" class="form-control validate[required]">
                                        <?php $user_company_id = old('company_id'); ?>
                                        <option value="">Select Company</option>
                                        @foreach( $companies as $company )
                                        <option value="{{ $company->id }}" <?php echo $user_company_id === $company->id ? 'selected' : ''; ?>>{{ $company->company_name }}</option>
                                        @endforeach
                                    </select>

                                    @error('company_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group has-feedback">
                                    <label>Company website<span style="color: red;">*</span></label>
                                    <input type="test" class="form-control validate[required, custom[url]]" name="company_website" value="{{ old('company_website') }}" />
                                    <span class="glyphicon glyphicon-globe form-control-feedback" aria-hidden="true"></span>

                                    @error('company_website')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12 col-xs-12">
                                <div class="form-group has-feedback">
                                    <label for="employee_title">Employee title<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control validate[required, maxSize[255]]" name="employee_title" id="employee_title" />
                                    <span class="glyphicon glyphicon-tag form-control-feedback" aria-hidden="true"></span>

                                    @error('employee_title')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group has-feedback">
                                    <label for="company_address_1">Company address 1<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control validate[required, maxSize[255]]" name="company_address_1" id="company_address_1" />
                                    <span class="glyphicon glyphicon-map-marker form-control-feedback" aria-hidden="true"></span>

                                    @error('company_address_1')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group has-feedback">
                                    <label for="company_address_2">Company address 2</label>
                                    <input type="text" class="form-control validate[maxSize[255]]" name="company_address_2" id="company_address_2" />
                                    <span class="glyphicon glyphicon-map-marker form-control-feedback" aria-hidden="true"></span>

                                    @error('company_address_2')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group has-feedback">
                                    <label for="city">Company city<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control validate[required, maxSize[255]]" name="city" id="city" />
                                    <span class="glyphicon glyphicon-map-marker form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xs-12 has-feedback">
                                <div class="form-group">
                                    <label for="state">Company state<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control validate[required, maxSize[255]]" name="state" id="state" />
                                    <span class="glyphicon glyphicon-map-marker form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group has-feedback">
                                    <label for="zip">Company zip<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control validate[required, maxSize[255]]" name="zip" id="zip" />
                                    <span class="glyphicon glyphicon-map-marker form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group has-feedback">
                                    <label for="company_tel">Company tel<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control validate[required, maxSize[255]]" name="company_tel" id="company_tel" />
                                    <span class="glyphicon glyphicon-phone-alt form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xs-12">
                                <div class="form-group has-feedback">
                                    <label for="mobile">Mobile<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control validate[required, maxSize[14]]" name="mobile" id="mobile" placeholder="(111) 111-1111" />
                                    <span class="glyphicon glyphicon-earphone form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xs-12" id="verify_otp_input_wrapper" style="display: none;">
                                <div class="form-group has-feedback">
                                    <label for="mobile">OTP<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control validate[required, maxSize[4]]" name="one_time_password" id="one_time_password" maxlength="4" />
                                    <span class="glyphicon glyphicon-comment form-control-feedback" aria-hidden="true"></span>
                                </div>
                            </div>

                        </div>
                        
                        <div class="col-sm-4 col-xs-12"></div>
                        <div class="col-sm-4 col-xs-12">
                            <button type="submit" name="submit" id="btn_add_user" class="btn btn-custom-primary btn-block">Create Account</button>
                            <button type="submit" id="btnVerifyOTP" class="btn btn-custom-primary btn-block" style="display: none;">Verify OTP</button>
                        </div>
                        <div class="col-sm-4 col-xs-12"></div>
                        
                    </form>

                </div>

            </div>

            <p style="margin-bottom: 0;text-align: right;"><a href="{{ route('login') }}">&laquo; Sign In</a></p>

        </div>

        <div class="col-md-2 col-sm-2 hidden-xs"></div>

    </div>

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
                url: '{{ route("verifyOTP") }}',
                method: 'POST',
                data: {otp: otp, to_number: mobile},
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
