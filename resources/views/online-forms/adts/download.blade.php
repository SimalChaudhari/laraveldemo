<div class="panel panel-default">

	<div class="panel-heading">
		<h3 class="panel-title text-center">{{ ucwords( strtolower( 'ACCOUNTING OF DISCLOSURES TRACKING SHEET' ) ) }}</h3>
	</div>

	<div class="panel-body">

		<p class="col-sm-12 col-xs-12 text-right" style="padding-right: 0;"><small>({!! $required_field_html !!}) fields are mandatory.</small></p>

		<p><strong>Use this form to track all disclosures outside of Treatment, Payment and Health Care Operations (TPO) for the Patient Listed Below. Our practice must keep and be prepared to make this information available to the patient, upon their request, for a period of six (6) years.</strong></p>

		<form class="form-horizontal validateForm" role="form">

			<div class="form-group">
				<label class="col-xs-12 col-sm-2">Name of patient{!! $required_field_html !!}</label>
				<div class="col-xs-12 col-sm-10">
					<p class="form-control-static">{{ $form->name }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-4">Date of birth{!! $required_field_html !!}</label>
				<div class="col-xs-12 col-sm-8">
					<p class="form-control-static">{{ \Carbon\Carbon::parse( $form->dob )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-2">SS#{!! $required_field_html !!}</label>
				<div class="col-xs-12 col-sm-10">
					<p class="form-control-static">{{ $form->ss }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-2">Date of 1<sup>ST</sup> entry{!! $required_field_html !!}</label>
				<div class="col-xs-12 col-sm-4">
					<p class="form-control-static">{{ \Carbon\Carbon::parse( $form->first_entry )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-12">Data information was released{!! $required_field_html !!}</label>
				<div class="col-xs-12 col-sm-12">
					<p class="form-control-static">{{ $form->data_info }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-12">To whom was the information (PHI) released/disclosed{!! $required_field_html !!}</label>
				<div class="col-xs-12 col-sm-12">
					<p class="form-control-static">{{ $form->to_whome }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-12">Description of the information released/discloused{!! $required_field_html !!}</label>
				<div class="col-xs-12 col-sm-12">
					<p class="form-control-static">{{ $form->descri_info }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-12">Additional Information/Notes{!! $required_field_html !!}</label>
				<div class="col-xs-12 col-sm-12">
					<p class="form-control-static">{{ $form->add_info }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-4">Reported by{!! $required_field_html !!}</label>
				<div class="col-xs-12 col-sm-8">
					<p class="form-control-static">{{ $form->reported_by }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-12 col-sm-2">Signature{!! $required_field_html !!}</label>
				<div class="col-xs-12 col-sm-10">
					<p class="form-control-static">{{ $form->sign }}</p>
				</div>
			</div>

		</form>

	</div>

</div>