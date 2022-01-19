@extends('layouts.admin')

@section('page_title')
Create company
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
                        <h3 class="panel-title"><i class="fa fa-2x fa-building-o" aria-hidden="true"></i> Add Company</h3>
                    </div>
                </div>
            </div>

			<div class="panel-body">

				<p class="col-sm-12 col-xs-12 text-right" style="padding-right: 0;"><small>({!! $required_field_html !!}) fields are mandatory.</small></p>

				<form name="addCompany" class="validateForm" method="POST" action="{{ route('company.store') }}">
					@csrf

					<div class="form-group">
						<label for="company_name">Name{!! $required_field_html !!}</label>
						<input type="text" class="form-control validate[required, maxSize[255]]" name="company_name" value="{{ old('company_name') }}" placeholder="Name" />

						@error('company_name')
							<span class="invalid-feedback" role="alert">{{ $message }}</span>
						@enderror
					</div>
					
                    <div class="form-group">
                        <label for="website">Website{!! $required_field_html !!}</label>
                        <input type="text" class="form-control validate[required, custom[url]]" name="website" value="{{ old('website') }}" placeholder="http:// or https://" />

                        @error('website')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
						<label for="emp_title">Employee Title{!! $required_field_html !!}</label>
						<input type="text" class="form-control validate[required, maxSize[255]]" name="emp_title" value="{{ old('emp_title') }}" placeholder="Name" />

						@error('emp_title')
							<span class="invalid-feedback" role="alert">{{ $message }}</span>
						@enderror
					</div>

                    <div class="form-group">
                        <label for="address_one">Address 1<span style="color: red;">*</span></label>
                        <input type="text" class="form-control validate[required, maxSize[255]]" name="address_one" id="address_one" value="{{ old('address_one') }}" />

                        @error('address_one')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address_two">Address 2</label>
                        <input type="text" class="form-control validate[maxSize[255]]" name="address_two" id="address_two" value="{{ old('address_two') }}" />

                        @error('address_two')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="city">City<span style="color: red;">*</span></label>
                        <input type="text" class="form-control validate[required, maxSize[255]]" name="city" id="city" value="{{ old('city') }}" />

                        @error('city')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="state">State<span style="color: red;">*</span></label>
                        <select name="state" id="state" class="form-control validate[required]">
                            <option value="">Select State</option>
                            <?php
                            $states = DB::table('states')->get();
                            foreach( $states as $state ) {
                            ?>
                            <option value="{{ $state->state_code }}" {{ old('state') == $state->state_code ? 'selected' : '' }}>{{ $state->name }}</option>
                            <?php } ?>
                        </select>

                        @error('state')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
	                    <label for="zip">Zip<span style="color: red;">*</span></label>
	                    <input type="text" class="form-control validate[required, maxSize[255]]" name="zip" id="zip" value="{{ old('zip') }}" />

	                    @error('zip')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
	                </div>

	                <div class="form-group">
                        <label for="phone">Company tel<span style="color: red;">*</span></label>
                        <input type="text" class="form-control validate[required, maxSize[255]]" name="phone" id="phone" value="{{ old('phone') }}" />

                        @error('phone')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
	                

					
					<input type="submit" name="submit" class="btn btn-custom-primary" value="Add Company" />

				</form>

			</div>

		</div>

	</div>

	<div class="col-sm-4 col-xs-12"></div>

</div>

@endsection