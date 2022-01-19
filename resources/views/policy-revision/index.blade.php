@extends('layouts.admin')

@section('page_title')
Policy Revision
@endsection

@section('content')

<x-alert />

<ol class="breadcrumb">
	<li><a href="javascript:;">HIPAA Container</a></li>
	<li class="active">Policy Revisions</li>
</ol>

<div class="panel panel-default panel-custom">
	<div class="panel-heading">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<h3 class="panel-title"><i class="fa fa-2x fa-files-o" aria-hidden="true"></i> Policy Revisions</h3>
			</div>
			{{-- <div class="col-sm-6 col-xs-6">
				<a href="{{ route('document-library.create') }}" class="btn btn-custom-primary pull-right">
	                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>&nbsp;Add
	            </a>
			</div> --}}
		</div>
	</div>

	<div class="panel-body">

		<div class="table-responsive">
			<table id="tbl_revisions" class="table table-striped table-bordered table-hover" style="width: 100%;">
				<thead>
					<tr>
						<th>Policy Name</th>
						<th>Revision By</th>
						<th>Date</th>
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

		var tbl_revisions = $('#tbl_revisions').DataTable({
			"processing": true,
			"serverSide": true,
			"aaSorting": [[2, "desc"]],
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
				url: '{{ route("ajax_get_policy_revisions") }}',
				type: 'GET',
			},
			"columns": [
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
						return data.policy_name;
					}
				},
				{
					'targets': 1,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.revision_by;
					}
				},
				{
					'targets': 2,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.revision_date;
					}
				},
				{
					'targets': 3,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.actions;
					}
				},
			],
		});

		$(document).on('click', '.delete-revision', function(e) {
			e.preventDefault();

			do_confirmation_before_delete('POST', $(this).attr('href'));

			return false;
		});
	});
</script>

@endsection