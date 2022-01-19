@extends('layouts.admin')

@section('page_title')
View: Patient Disclosure Authorization Form
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
				<h3 class="panel-title text-center"><strong>Patient Disclosure Authorization Form</strong> <a style="position: absolute;right: 15px;top: 8px;" href="{{ route('patient.disclosure.index') }}" class="btn btn-custom-danger btn-xs pull-right">&laquo; Back</a></h3>
			</div>

			<div class="panel-body">

				<p class="col-sm-12 col-xs-12 text-right" style="padding-right: 0;"><small>({!! $required_field_html !!}) All fields are mandatory.</small></p>

				<form id="patient_disclosure_authorization_form" method="POST" action="{{ route('patient.disclosure.update', $form->uuid) }}" role="form">

					@csrf

					<p>I, <u>{{ $form->patient_name }}</u> hereby authorize the use or disclosure of my protected health information as described below:</p>

					<h4>1. <u>AUTHORIZED PERSONS TO USE AND DISCLOSE PROTECTED HEALTH INFORMATION</u></h4>

					<u>{{ $form->section_one_data['field1'] }}</u> is authorized to disclose the following protected health information to <u>{{ $form->section_one_data['field2'] }}</u> of <u>{{ $form->section_one_data['field3'] }}</u>, <u>{{ $form->section_one_data['field4'] }}</u>.

					<h4>2. <u>DESCRIPTION OF INFORMATION TO BE DISCLOSED</u></h4>
					<p>The health information that may be disclosed is:</p>
					<p>All past, present, and future periods of health care information may be shared.</p>

					<h4>3. <u>PURPOSE OF THE USE OR DISCLOSURE</u></h4>
					<p>The purpose of this use or disclosure is <u>{{ $form->form_purpose }}</u>.</p>

					<h4>4. <u>VALIDITY OF AUTHORIZATION FORM</u></h4>
					<p>This Authorization Form is valid beginning on <u>{{ $form->authorization_start }}</u> and expires on <u>{{ $form->authorization_expiry }}</u>.</p>

					<h4>5. <u>ACKNOWLEDGMENT</u></h4>
					<p>I understand that the information used or disclosed under this Authorization Form may be subject to re-disclosure by the person(s) or facility receiving it and would then no longer be protected by federal privacy regulations.</p>

					<p>I have the right to refuse to sign this Authorization Form. If signed, I have the right to revoke this authorization, in writing, at any time. I understand that any action already taken in reliance on this authorization cannot be reversed, and my revocation will not affect those actions.</p>

					<div class="row">
						<div class="col-sm-6 col-xs-12">
							<strong>By:</strong> <u>{{ $form->acknowledgement_by }}</u>
						</div>

						<div class="col-sm-6 col-xs-12 text-right">
							<strong>Date:</strong> <u>{{ \Carbon\Carbon::now()->format( config('app.VIEW_DATE_FORMAT') ) }}</u>
						</div>
					</div>

					<div class="row">
						<div class="form-group">
							<label>Signature</label>
							<img src="data:{{ $form->signature_str_svg }}" />
						</div>
					</div>

				</form>



			</div>

		</div>

		
	</div>

	<div class="col-sm-2 col-xs-12"></div>

	<div class="clearfix"></div>

</div>

@endsection