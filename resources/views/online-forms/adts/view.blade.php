@extends('layouts.admin')

@section('page_title')
View: {{ ucwords( strtolower( 'ACCOUNTING OF DISCLOSURES TRACKING SHEET' ) ) }}
@endsection

@section('content')

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">
	<div class="col-sm-3 col-xs-12"></div>

	<div class="col-sm-6 col-xs-12">

		<ol class="breadcrumb">
			<li><a href="javascript:;">HIPAA Container</a></li>
			<li><a href="{{ route('UI_allOnlineForms') }}">Online Forms</a></li>
			<li class="active">{{ ucwords( strtolower( 'ACCOUNTING OF DISCLOSURES TRACKING SHEET' ) ) }}</li>
		</ol>

		<div class="panel panel-default">

			<div class="panel-heading">
				<h3 class="panel-title">{{ ucwords( strtolower( 'ACCOUNTING OF DISCLOSURES TRACKING SHEET' ) ) }}</h3>
			</div>

			<div class="panel-body">

				<p><strong>Use this form to track all disclosures outside of Treatment, Payment and Health Care Operations (TPO) for the Patient Listed Below. Our practice must keep and be prepared to make this information available to the patient, upon their request, for a period of six (6) years.</strong></p>

				<form method="POST" class="form-horizontal" role="form">

					<div class="form-group">
						<label class="col-xs-12 col-sm-4 control-label">Name of patient:</label>
						<div class="col-xs-12 col-sm-8">
							<p class="form-control-static">{{ ucfirst( $form->name ) }}</p>
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-4 control-label">Date of birth:</label>
						<div class="col-xs-12 col-sm-8">
							<p class="form-control-static">{{ \Carbon\Carbon::parse( $form->dob )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-4 control-label">SS#:</label>
						<div class="col-xs-12 col-sm-8">
							<p class="form-control-static">{{ $form->ss }}</p>
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-5 control-label">Date of 1<sup>ST</sup> entry:</label>
						<div class="col-xs-12 col-sm-7">
							<p class="form-control-static">{{ \Carbon\Carbon::parse( $form->first_entry )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-12 control-label">Data information was released:</label>
						<div class="col-xs-12 col-sm-12">
							<p class="form-control-static">{{ ucfirst( $form->data_info ) }}</p>
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-12 control-label">To whom was the information (PHI) released/disclosed:</label>
						<div class="col-xs-12 col-sm-12">
							<p class="form-control-static">{{ ucfirst( $form->to_whome ) }}</p>
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-12 control-label">Description of the information released/discloused:</label>
						<div class="col-xs-12 col-sm-12">
							<p class="form-control-static">{{ ucfirst( $form->descri_info ) }}</p>
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-12 control-label">Additional Information/Notes:</label>
						<div class="col-xs-12 col-sm-12">
							<p class="form-control-static">{{ ucfirst( $form->add_info ) }}</p>
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-4 control-label">Reported by:</label>
						<div class="col-xs-12 col-sm-8">
							<p class="form-control-static">{{ ucfirst( $form->reported_by ) }}</p>
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-12 col-sm-4 control-label">Signature:</label>
						<div class="col-xs-12 col-sm-8">
							<p class="form-control-static">{{ ucfirst( $form->sign ) }}</p>
						</div>
					</div>

				</form>

			</div>

		</div>

	</div>

	<div class="col-sm-3 col-xs-12"></div>

	<div class="clearfix"></div>

</div>

@endsection