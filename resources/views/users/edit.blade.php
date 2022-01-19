@extends('layouts.admin')

@section('page_title')
Edit user
@endsection

@section('content')

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">

    <div class="col-sm-3 col-xs-12"></div>

    <div class="col-sm-6 col-xs-12">
        
        <div class="panel panel-default panel-custom">

            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <h3 class="panel-title"><i class="fa fa-2x fa-user" aria-hidden="true"></i> User: {{ $user->firstname }} {{ $user->lastname }} <a style="position: absolute;top: 5px;right: 15px;" href="{{ route('users.index') }}" class="btn btn-custom-danger btn-xs pull-right">&laquo; Back</a></h3>
                    </div>
                </div>
            </div>

            <div class="panel-body">

                <p class="col-sm-12 col-xs-12 text-right" style="padding-right: 0;"><small>({!! $required_field_html !!}) fields are mandatory.</small></p>

            	<form id="editUser" name="editUser" class="validateForm" method="POST" action="{{ route('users.update', $user->uuid) }}">
					@csrf

                    <div class="row">

                        <div class="col-sm-6 col-xs-12">
        					<div class="form-group">
                                <label for="firstname">First Name{!! $required_field_html !!}</label>
                                <input type="text" class="form-control validate[required, maxSize[100]]" name="firstname" value="{{ $user->firstname }}" />

                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="lastname">Last Name{!! $required_field_html !!}</label>
                                <input type="text" class="form-control validate[required, maxSize[100]]" name="lastname" value="{{ $user->lastname }}" />

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="email">Email ID{!! $required_field_html !!}</label>
                                <input type="text" class="form-control validate[required, custom[email], maxSize[255]]" name="email" value="{{ $user->email }}" required maxlength="255" />

                                @error('email')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="username">Username{!! $required_field_html !!}</label>
                                <input type="text" class="form-control validate[required, maxSize[200]]" name="username" value="{{ $user->username }}" />

                                @error('username')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group has-feedback user_pass">
                                <label for="password">Password{!! $required_field_html !!}</label>
                                <input type="password"  id="user_pass"  class="form-control" name="password" />
                                <span style="pointer-events: unset !important;cursor: pointer;" class="user_pass_eye glyphicon glyphicon_eye glyphicon-eye-open form-control-feedback" aria-hidden="true"></span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                                <p class="help-block" style="font-size: 12px;margin-top: 0;">Leave blank if you don't want to change</p>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="administrator">User role{!! $required_field_html !!}</label>
                                <select type="text" name="user_role" class="form-control validate[required]">
                                    <option value="">Select Role</option>
                                    <?php if( !empty( $roles ) ) { ?>
                                        <?php foreach( $roles as $role ) { ?>
                                            <option value="{{ $role }}" <?php echo $userRole === $role ? 'selected' : '' ?>>{{ $role }}</option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>

                                @error('administrator')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="company_id">Company{!! $required_field_html !!}</label>
                                
                                <select type="text" name="company_id" class="form-control validate[required]">
                                    <?php $user_company_id = $user->company_id; ?>
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

                        <?php /*
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="company_website">Company website{!! $required_field_html !!}</label>
                                <input type="text" class="form-control validate[required, custom[url]]" name="company_website" value="{{ $user->company_website }}" />

                                @error('company_website')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="employee_title">Employee title<span style="color: red;">*</span></label>
                                <input type="text" class="form-control validate[required, maxSize[255]]" name="employee_title" id="employee_title" value="{{ $user->employee_title }}" />

                                @error('employee_title')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>*/ ?>

                        <?php /*
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="company_address_1">Company address 1<span style="color: red;">*</span></label>
                                <input type="text" class="form-control validate[required, maxSize[255]]" name="company_address_1" id="company_address_1" value="{{ $user->company_address_1 }}" />

                                @error('company_address_1')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="company_address_2">Company address 2</label>
                                <input type="text" class="form-control validate[maxSize[255]]" name="company_address_2" id="company_address_2" value="{{ $user->company_address_2 }}" />

                                @error('company_address_2')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="city">Company city<span style="color: red;">*</span></label>
                                <input type="text" class="form-control validate[required, maxSize[255]]" name="city" id="city" value="{{ $user->city }}" />
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="state">Company state<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control validate[required, maxSize[255]]" name="state" id="state" value="{{ $user->state }}" />
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="zip">Company zip<span style="color: red;">*</span></label>
                                <input type="text" class="form-control validate[required, maxSize[255]]" name="zip" id="zip" value="{{ $user->zip }}" />
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="company_tel">Company tel<span style="color: red;">*</span></label>
                                <input type="text" class="form-control validate[required, maxSize[255]]" name="company_tel" id="company_tel" value="{{ $user->company_tel }}" />
                            </div>
                        </div>*/ ?>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="mobile">Mobile<span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="mobile" id="mobile" placeholder="(111) 111-1111" value="{{ $user->mobile }}" />
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-4 col-xs-12"></div>
                    <div class="col-sm-4 col-xs-12">
                        <input name="btnSubmit" type="submit" value="Update user" class="btn btn-custom-primary btn-block" />
                    </div>
                    <div class="col-sm-4 col-xs-12"></div>

				</form>

    		</div>

    	</div>

    </div>

    <div class="col-sm-3 col-xs-12"></div>

</div>

<script type="text/javascript">
document.getElementById('mobile').addEventListener('input', function (e) {
    var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
    e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
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
@endsection