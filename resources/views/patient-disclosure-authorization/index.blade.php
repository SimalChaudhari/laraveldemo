@extends('layouts.admin')

@section('page_title')
Patient Disclosure Authorization
@endsection

@section('content')

<x-alert />

<div class="alert alert-info">
	<p>Whenever a patient requests that the patient's confidential medical files be shared with another person or organization, it is imperative to receive written authorization from the patient or the patient's representative.</p>

	<p>This authorization form can be signed electronically on the Hipaamart portal, or it can also be downloaded and printed in hard copy form from the <strong>Document Library, Form no. .06</strong></p>
</div>

<div class="panel panel-default panel-custom">
	<div class="panel-heading">
		<div class="row">
			<div class="col-sm-6 col-xs-6">
				<h3 class="panel-title"><i class="fa fa-2x fa-file-text" aria-hidden="true"></i> Patient Disclosure Authorization</h3>
			</div>
			<div class="col-sm-6 col-xs-6">
				@can('Create Patient Disclosure Authorization Form')
				<a href="{{ route('patient.disclosure.create') }}" class="btn btn-custom-primary pull-right">
	                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>&nbsp;Add New Form
	            </a>
	            @endcan
			</div>
		</div>
	</div>

	<div class="panel-body">

		<div class="table-responsive">
			<table id="tbl_patient_disclosure_authorization" class="table table-striped table-bordered table-hover" style="width: 100%;">
				<thead>
					<tr>
						<th>No.</th>
						<th>Patient Name</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					
				</tbody>
			</table>
		</div>

	</div>

</div>

<script>
	$(document).ready(function() {

		var tbl_patient_disclosure_authorization = $('#tbl_patient_disclosure_authorization').DataTable({
			"processing": true,
			"serverSide": true,
			// "aaSorting": [[5, "desc"]],
			"oLanguage": {
				"sEmptyTable": 'Sorry! No results found.'
			},
			"language": {
				processing: '<i class="fa fa-refresh fa-spin fa-3x fa-fw text-success" style="opacity: 0.6;"></i><span class="sr-only"></span>',
				paginate: {
					next: '<i class="fa fa-angle-right" aria-hidden="true"></i>',
					previous: '<i class="fa fa-angle-left" aria-hidden="true"></i>'
				}
			},
			"pagingType": "full_numbers",
			ajax: {
				url: '{{ route("ajax_get_patient_disclosure_records") }}',
				type: 'GET',
			},
			"columns": [
				{"data": null, "orderable": false},
				{"data": null},
				{"data": null, "orderable": false },
			],
			"columnDefs": [
				{
					'targets': 0,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.no;
					}
				},
				{
					'targets': 1,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.patient_name;
					}
				},
				{
					'targets': 2,
					'className': 'dt-body-center actions',
					'render': function (data, type, full, meta) {
						return data.actions;
					}
				},
			],
		});

		$(document).on('click', '.delete-patient-disclosure-entry', function(e) {
			e.preventDefault();

			do_confirmation_before_delete('POST', $(this).attr('href'));

			return false;
		});
	});
</script>

@endsection