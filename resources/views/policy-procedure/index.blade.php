@extends('layouts.admin')

@section('page_title')
Policies and Procedures
@endsection

@section('content')

<x-alert />

<ol class="breadcrumb">
	<li><a href="javascript:;">HIPAA Container</a></li>
	<li class="active">Policies & Procedures</li>
</ol>

<div class="alert alert-info">
	<p>Policies and Procedures</p>

	<ul>
		<li>The HIPAA regulators have promulgated a great many policies and procedures to be implemented by medical providers to protect Protected Health Information (PHI).</li>

		<li>The Policies and Procedures contained in this section of the Hipaamart portal describe in detail many of the Policies and Procedures required by the HIPAA regulations and the OCR.</li>

		<li>The Policies and Procedures included in this section are intended to be a reference for the HIPAA Compliance Officer should the officer require clarification of any of the regulations.</li>

		<li>Over a period of time, the Compliance Officer should review these Policies and Procedures to get a good sense of what is required by the HIPAA regulations.</li>
	</ul>
</div>

<div class="panel panel-default panel-custom">
	<div class="panel-heading">
		<div class="row">
			<div class="col-sm-6 col-xs-6">
				<h3 class="panel-title"><i class="fa fa-2x fa-envelope-open" aria-hidden="true"></i> Policies and Procedures</h3>
			</div>
			<div class="col-sm-6 col-xs-6">
				<div class="btn-toolbar">
					@can('EMR Records')
					<a href="{{ route('emr-records.index') }}" class="btn btn-custom-primary pull-right">
		                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&nbsp;EMR Records
		            </a>
		            @endcan
		            @can('Create Policy and Procedures')
					<a href="{{ route('policy-procedure.create') }}" class="btn btn-custom-primary pull-right">
		                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>&nbsp;Add
		            </a>
		            @endcan
		        </div>
			</div>
		</div>
	</div>

	<div class="panel-body">

		

		<div class="table-responsive">
			<table id="tbl_policies" class="table table-striped table-bordered table-hover" style="width: 100%;">
				<thead>
					<tr>
						<th>No</th>
						<th>Policy Name</th>
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

		var tbl_user = $('#tbl_policies').DataTable({
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
				url: '{{ route("ajax_get_policy_procedures") }}',
				type: 'GET',
			},
			"columns": [
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
						return data.policy_name;
					}
				},
				{
					'targets': 2,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.actions;
					}
				},
			],
		});

		$(document).on('click', '.delete-policy', function(e) {
			e.preventDefault();

			do_confirmation_before_delete('POST', $(this).attr('href'));

			return false;
		});
	});
</script>

{{-- <h1>Policies and Procedures</h1>

<h2><a href="{{ route('UI_emrRecordsPerState') }}">Access to Emr Records per state</a></h2></br>

<table width="80%" border="1">

	<tr>
		<th style="padding:2%;">No.</th>
	    <th style="padding:2%;">File Name</th>    
	    <th style="padding:2%;">View</th>
	</tr>

	@if( $uploads->count() > 0 )

		@foreach( $uploads as $upload )

			<tr>
				<td style="padding:2%;">{{ $loop->iteration }}</td>
				<td style="padding:2%;">{{ $upload->name }}</td>
				<td style="padding:2%;"><a href="{{ route('viewPolicyFile', $upload->id) }}" target="_blank">view file</a></td>
			</tr>

		@endforeach

	@else

		<tr>
			<td colspan="3">Sorry! no record found.</td>
		</tr>

	@endif

</table>
 --}}

@endsection