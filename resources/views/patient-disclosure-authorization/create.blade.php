@extends('layouts.admin')

@section('page_title')
Create: Patient Disclosure Authorization Form
@endsection

@section('content')

<style>
#patient_disclosure_authorization_form input,
#patient_disclosure_authorization_form input:focus,
#patient_disclosure_authorization_form input:active {
    outline: none;
}
#patient_disclosure_authorization_form input {
	margin-bottom: 10px;
	border: 0;
    border-bottom: 1px solid #333;
}
</style>

<link rel="stylesheet" href="{{ asset('public/lib/datepickr/jquery-ui.css') }}" />
<script src="{{ asset('public/lib/datepickr/jquery-1.9.1.js') }}"></script>
<script src="{{ asset('public/lib/datepickr/jquery-ui.js') }}"></script>

<!-- this, preferably, goes inside head element: -->
<!--[if lt IE 9]>
<script type="text/javascript" src="{{ asset('public/lib/jSignature/flashcanvas.js') }}"></script>
<![endif]-->

<script src="{{ asset('public/lib/jSignature/jSignature.min.js') }}"></script>

<x-alert />

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">

	<div class="col-sm-2 col-xs-12"></div>

	<div class="col-sm-8 col-xs-12">

		<ol class="breadcrumb">
	        <li><a href="javascript:;">Document Library</a></li>
	        <li class="active">Patient Disclosure Authorization Form</li>
	    </ol>

		<div class="panel panel-default">

			<div class="panel-heading" style="position: relative;">
				<h3 class="panel-title text-center"><strong>Patient Disclosure Authorization Form</strong></h3>
				<a style="position: absolute;top: 8px;right: 15px;" href="{{ route('patient.disclosure.index') }}" class="btn btn-custom-danger btn-xs pull-right">&laquo; Back</a>
			</div>

			<div class="panel-body">

				<p class="col-sm-12 col-xs-12 text-right" style="padding-right: 0;"><small>({!! $required_field_html !!}) All fields are mandatory.</small></p>

				<form class="validateForm" id="patient_disclosure_authorization_form" method="POST" action="{{ route('patient.disclosure.store') }}" role="form">
					
					@csrf

					<p>I, <input type="text" name="patient_name" class="validate[required, maxSize[255]]" /> hereby authorize the use or disclosure of my protected health information as described below:</p>

					<h4>1. <u>AUTHORIZED PERSONS TO USE AND DISCLOSE PROTECTED HEALTH INFORMATION</u></h4>

					<input type="text" name="section_one_data[field1]" class="validate[required, maxSize[255]]" /> is authorized to disclose the following protected health information to <input type="text" name="section_one_data[field2]" class="validate[required, maxSize[255]]" /> of <input type="text" name="section_one_data[field3]" class="validate[required, maxSize[255]]" />, <input type="text" name="section_one_data[field4]" class="validate[required, maxSize[255]]" />.

					<h4>2. <u>DESCRIPTION OF INFORMATION TO BE DISCLOSED</u></h4>
					<p>The health information that may be disclosed is:</p>
					<p>All past, present, and future periods of health care information may be shared.</p>

					<h4>3. <u>PURPOSE OF THE USE OR DISCLOSURE</u></h4>
					<p>The purpose of this use or disclosure is <input type="text" name="form_purpose" class="validate[required, maxSize[255]]" />.</p>

					<h4>4. <u>VALIDITY OF AUTHORIZATION FORM</u></h4>
					<p>This Authorization Form is valid beginning on <input type="text" class="datepicker validate[required, custom[date]]" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" name="authorization_start" autocomplete="off" /> and expires on <input type="text" class="datepicker validate[required, custom[date]]" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" name="authorization_expiry" autocomplete="off" />.</p>

					<h4>5. <u>ACKNOWLEDGMENT</u></h4>
					<p>I understand that the information used or disclosed under this Authorization Form may be subject to re-disclosure by the person(s) or facility receiving it and would then no longer be protected by federal privacy regulations.</p>

					<p>I have the right to refuse to sign this Authorization Form. If signed, I have the right to revoke this authorization, in writing, at any time. I understand that any action already taken in reliance on this authorization cannot be reversed, and my revocation will not affect those actions.</p>

					<div class="row">
						<div class="col-sm-6 col-xs-12">
							<strong>By:</strong> <input type="text" name="acknowledgement_by" class="validate[required, maxSize[255]]" />
						</div>

						<div class="col-sm-6 col-xs-12">
							<strong>Date:</strong> <u>{{ \Carbon\Carbon::now()->format( config('app.VIEW_DATE_FORMAT') ) }}</u>
						</div>
					</div>

					<div class="row">
						<div class="form-group">
							<label class="col-sm-1 col-xs-12">Signature:<a class="clear_signature_pad" data-signature_div_id="patient_signature_pad" style="cursor: pointer;">(Clear)</a></label>
							<div class="col-sm-8 col-xs-12">
								<div id="patient_signature_pad"></div>
							</div>
							<div class="col-sm-9 col-xs-12 text-right">
								
							</div>
							<input type="hidden" name="signature_str_svg" id="patient_signature_svg" />
							<input type="hidden" name="signature_str_base" id="patient_signature_base" />
						</div>
					</div>

					<input type="submit" name="submit" class="btn btn-custom-primary center-block" value="Submit" style="width: 40%;" />

				</form>

			</div>

		</div>
	</div>

	<div class="col-sm-2 col-xs-12"></div>

	<div class="clearfix"></div>

</div>

@endsection