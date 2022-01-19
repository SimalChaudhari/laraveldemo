@extends('layouts.admin')

@section('page_title')
Document Library
@endsection

@section('content')

<x-alert />

<div class="alert alert-info">
	<p>There are many documents that can be used to record a medical provider's compliance with HIPAA regulations.</p>

	<p>The documents included in this Document Library are intended to provide useful documents for the medical practice. These documents can be downloaded from the Document Library and printed.</p>

	<p>These documents can be signed by the medical practitioner, business associates, patients, employees or others who have access to confidential PHI patient medical information.</p>

	<p>These documents are as follows:</p>
</div>

<div class="panel panel-default panel-custom">
	<div class="panel-heading">
		<div class="row">
			<div class="col-sm-6 col-xs-6">
				<h3 class="panel-title"><i class="fa fa-2x fa-book" aria-hidden="true"></i> Document Library</h3>
			</div>
			<div class="col-sm-6 col-xs-6">
			    @can('Create Document Library')
				<a href="{{ route('document-library.create') }}" class="btn btn-custom-primary pull-right">
	                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>&nbsp;Add New
	            </a>
	            @endcan
			</div>
		</div>
	</div>

	<div class="panel-body">

		<div class="table-responsive">
			<table id="tbl_document_libraries" class="table table-striped table-bordered table-hover" style="width: 100%;">
				<thead>
					<tr>
						<th>Name</th>
						<th>Company Name</th>
						<th>File Name</th>
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

		var tbl_document_libraries = $('#tbl_document_libraries').DataTable({
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
				url: '{{ route("ajax_get_document_library") }}',
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
						return data.name;
					}
				},
				{
					'targets': 1,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.company_name;
					}
				},
				{
					'targets': 2,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.file;
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

		$(document).on('click', '.delete-library', function(e) {
			e.preventDefault();

			do_confirmation_before_delete('POST', $(this).attr('href'));

			return false;
		});
	});
</script>

@endsection