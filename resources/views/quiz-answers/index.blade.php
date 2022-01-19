@extends('layouts.admin')

@section('page_title')
Risk Assessment/Training Answers
@endsection

@section('content')

<x-alert />

<div class="panel panel-default panel-custom">
	<div class="panel-heading">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<h3 class="panel-title"><i class="fa fa-2x fa-graduation-cap" aria-hidden="true"></i> Risk Assessment/Training Answers</h3>
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
			<table id="tbl_quiz" class="table table-striped table-bordered table-hover" style="width: 100%;">
				<thead>
					<tr>
						<th>First Name</th>
						<th>Company Name</th>
						<th>Date</th>
						<th>Quiz Name</th>
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

		var tbl_quiz = $('#tbl_quiz').DataTable({
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
				url: '{{ route("ajax_get_tests_list") }}',
				type: 'GET',
			},
			"columns": [
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
						return data.firstname;
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
						return data.date;
					}
				},
				{
					'targets': 3,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.name;
					}
				},
				{
					'targets': 4,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.actions;
					}
				},
			],
		});

		$(document).on('click', '.delete-result', function(e) {
			e.preventDefault();

			do_confirmation_before_delete('POST', $(this).attr('href'));

			return false;
		});
	});
</script>

@endsection