@extends('layouts.admin')

@section('page_title')
Edit: {{ ucwords( strtolower( 'ACCOUNTING OF DISCLOSURES TRACKING SHEET' ) ) }}
@endsection

@section('content')

<link rel="stylesheet" href="{{ asset('public/lib/datepickr/jquery-ui.css') }}" />
<script src="{{ asset('public/lib/datepickr/jquery-1.9.1.js') }}"></script>
<script src="{{ asset('public/lib/datepickr/jquery-ui.js') }}"></script>

<x-alert />

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">

	<div class="col-sm-2 col-xs-12"></div>

	<div class="col-sm-8 col-xs-12">

		<ol class="breadcrumb">
	        <li><a href="javascript:;">HIPAA Container</a></li>
	        <li><a href="{{ route('UI_allOnlineForms') }}">Online Forms</a></li>
	        <li class="active">{{ ucwords( strtolower( 'ACCOUNTING OF DISCLOSURES TRACKING SHEET' ) ) }}</li>
	    </ol>

		<div class="panel panel-default">

			<div class="panel-heading">
				<h3 class="panel-title text-center">{{ ucwords( strtolower( 'ACCOUNTING OF DISCLOSURES TRACKING SHEET' ) ) }}</h3>
			</div>

			<div class="panel-body">

				<p class="col-sm-12 col-xs-12 text-right" style="padding-right: 0;"><small>({!! $required_field_html !!}) fields are mandatory.</small></p>

				<p><strong>Use this form to track all disclosures outside of Treatment, Payment and Health Care Operations (TPO) for the Patient Listed Below. Our practice must keep and be prepared to make this information available to the patient, upon their request, for a period of six (6) years.</strong></p>

				<form method="POST" class="form-horizontal validateForm" action="{{ route('adts.update', $form->uuid) }}" role="form">
					@csrf

					<div class="form-group">
						<label class="col-xs-12 col-sm-2 control-label">Name of patient{!! $required_field_html !!}</label>
						<div class="col-xs-12 col-sm-10">
							<input type="text" name="name" class="form-control validate[required, maxSize[255]]" value="{{ $form->name }}" />
							@error('name')
	                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
	                        @enderror
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-6 col-xs-12 no-padding">
							<label class="col-xs-12 col-sm-4 control-label">Date of birth{!! $required_field_html !!}</label>
							<div class="col-xs-12 col-sm-8">
								<div class="input-group">
									<input type="text" name="dob" class="form-control datepicker validate[required, custom[date]]" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" autocomplete="off" value="{{ $form->dob }}" />
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
								@error('dob')
		                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
		                        @enderror
							</div>
						</div>

						<div class="col-sm-6 col-xs-12 no-padding">
							<label class="col-xs-12 col-sm-2 control-label">SS#{!! $required_field_html !!}</label>
							<div class="col-xs-12 col-sm-10">
								<input type="text" name="ss" class="form-control validate[required, maxSize[9]]" value="{{ $form->ss }}" />
								@error('ss')
		                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
		                        @enderror
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-2 control-label" style="padding-right: 0;">Date of 1<sup>ST</sup> entry{!! $required_field_html !!}</label>
						<div class="col-xs-12 col-sm-4">
							<div class="input-group">
								<input type="text" name="first_entry" class="form-control datepicker validate[required, custom[date]]" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" autocomplete="off" value="{{ $form->first_entry }}" />
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
							@error('first_entry')
	                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
	                        @enderror
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-12 control-label">Data information was released{!! $required_field_html !!}</label>
						<div class="col-xs-12 col-sm-12">
							<input type="text" name="data_info" class="form-control validate[required]" value="{{ $form->data_info }}" />
							@error('data_info')
	                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
	                        @enderror
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-12 control-label">To whom was the information (PHI) released/disclosed{!! $required_field_html !!}</label>
						<div class="col-xs-12 col-sm-12">
							<input type="text" name="to_whome" class="form-control validate[required]" value="{{ $form->to_whome }}" />
							@error('to_whome')
	                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
	                        @enderror
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-12 control-label">Description of the information released/discloused{!! $required_field_html !!}</label>
						<div class="col-xs-12 col-sm-12">
							<input type="text" name="descri_info" class="form-control validate[required]" value="{{ $form->descri_info }}" />
							@error('descri_info')
	                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
	                        @enderror
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-12 control-label">Additional Information/Notes{!! $required_field_html !!}</label>
						<div class="col-xs-12 col-sm-12">
							<textarea name="add_info" class="form-control validate[required]">{{ $form->add_info }}</textarea>
							@error('add_info')
	                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
	                        @enderror
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-6 col-xs-12 no-padding">
							<label class="col-xs-12 col-sm-4 control-label">Reported by{!! $required_field_html !!}</label>
							<div class="col-xs-12 col-sm-8">
								<input type="text" name="reported_by" class="form-control validate[required]" value="{{ $form->reported_by }}" />
								@error('reported_by')
		                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
		                        @enderror
							</div>
						</div>

						<div class="col-sm-6 col-xs-12 no-padding">
							<label class="col-xs-12 col-sm-2 control-label">Signature{!! $required_field_html !!}</label>
							<div class="col-xs-12 col-sm-10">
								<input type="text" name="sign" class="form-control validate[required]" autocomplete="off" value="{{ $form->sign }}" />
								@error('sign')
		                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
		                        @enderror
							</div>
						</div>
					</div>

					<input type="submit" name="update" class="btn btn-custom-primary center-block" value="Update" style="width: 40%;" />

				</form>

			</div>

		</div>
	</div>

	<div class="col-sm-2 col-xs-12"></div>

	<div class="clearfix"></div>

</div>

@endsection