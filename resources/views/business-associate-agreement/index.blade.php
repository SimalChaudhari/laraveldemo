@extends('layouts.admin')

@section('page_title')
Business Associate Agreements
@endsection

@section('content')

<x-alert />

<div class="alert alert-info">
	<p>A business Associate is a person or company not in the employ of the medical provider, but who will have access to patient confidential information. The Business Associate can be an information technology service, an outside accounting firm or anyone with access to PHI.</p>

	<p>Whenever a medical provider enters into a relationship with a Business Associate, it is imperative that the medical provider obtain a signed Business Associate Agreement with that entity.</p>

	<p style="margin-bottom: 10px;">There are exceptions to this rule for sharing of information with other medical providers and insurance companies for which no Business Associate Agreement is required as follows:</p>

	<ul>
		<li style="margin-bottom: 10px;">The transmission by a covered entity of electronic protected health information to a health care provider concerning the treatment of an individual.</li>
		<li style="margin-bottom: 10px;">The transmission of electronic protected health information by a group health plan or an HMO or health insurance issuer on behalf of a group health plan to a plan sponsor.</li>
		<li style="margin-bottom: 10px;">The transmission of electronic protected health information from or to other agencies providing the services to the patient when the covered entity is a health plan that is a government program providing public benefits.</li>
	</ul>

	<p>An electronic copy of the Business Associate Agreement is provided here.</p>
	<p>A hard copy of the Business Associate Agreement can also be downloaded and printed from the <strong>Document Library, <u>Form no. .01</u></strong>.</p>
</div>

<div class="panel panel-default panel-custom">
	<div class="panel-heading">
		<div class="row">
			<div class="col-sm-6 col-xs-6">
				<h3 class="panel-title"><i class="fa fa-2x fa-file-text" aria-hidden="true"></i> Business Associate Agreements</h3>
			</div>
			<div class="col-sm-6 col-xs-6">
				@can('Create Business Associate Agreement')
				<a href="{{ route('business-associate-agreement.create') }}" class="btn btn-custom-primary pull-right">
	                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>&nbsp;Add New Form
	            </a>
	            @endcan
			</div>
		</div>
	</div>

	<div class="panel-body">

		<div class="table-responsive">
			<table id="tbl_business_associate_agreements" class="table table-striped table-bordered table-hover" style="width: 100%;">
				<thead>
					<tr>
						<th>No.</th>
						<th>Covered Entity</th>
						<th>Business Associate</th>
						<th>Agreement Dated On</th>
						<th>Agreement Effective Date</th>
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

		var tbl_business_associate_agreements = $('#tbl_business_associate_agreements').DataTable({
			"processing": true,
			"serverSide": true,
			"aaSorting": [[1, "desc"]],
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
				url: '{{ route("ajax_get_business_agreements") }}',
				type: 'GET',
			},
			"columns": [
				{"data": null, "orderable": false},
				{"data": null},
				{"data": null},
				{"data": null},
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
						return data.covered_entity;
					}
				},
				{
					'targets': 2,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.business_associate;
					}
				},
				{
					'targets': 3,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.agreement_dated_on;
					}
				},
				{
					'targets': 4,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.effective_date;
					}
				},
				{
					'targets': 5,
					'className': 'dt-body-center actions',
					'render': function (data, type, full, meta) {
						return data.actions;
					}
				},
			],
		});

		$(document).on('click', '.delete-agreements', function(e) {
			e.preventDefault();

			do_confirmation_before_delete('POST', $(this).attr('href'));

			return false;
		});
	});
</script>

@endsection