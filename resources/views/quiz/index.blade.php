@extends('layouts.admin')

@section('page_title')
Quiz
@endsection

@section('content')

<x-alert />

<div class="panel panel-default panel-custom">
	<div class="panel-heading">
		<div class="row">
			<div class="col-sm-6 col-xs-6">
				<h3 class="panel-title"><i class="fa fa-2x fa-puzzle-piece" aria-hidden="true"></i> Quiz</h3>
			</div>
			<div class="col-sm-6 col-xs-6">
				<div class="btn-toolbar">
					@can('Create Questions')
					<a href="{{ route('question.create') }}" class="btn btn-custom-primary pull-right">
		                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>&nbsp;Add Question
		            </a>
		            @endcan

		            @can('Create Quiz')
					<a href="{{ route('quiz.create') }}" class="btn btn-custom-primary pull-right">
		                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>&nbsp;Add Quiz
		            </a>
		            @endcan
		        </div>
			</div>
		</div>
	</div>

	<div class="panel-body">

		<div class="table-responsive">
			<table id="tbl_quiz" class="table table-striped table-bordered table-hover" style="width: 100%;">
				<thead>
					<tr>
						<th>Quiz</th>
						<th>Per page</th>
						<th>Show definition?</th>
						<th>Show impact?</th>
						<th>Last Modified</th>
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
			"aaSorting": [[4, "desc"]],
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
				url: '{{ route("ajax_get_quizes") }}',
				type: 'GET',
			},
			"columns": [
				{"data": null},
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
						return data.name;
					}
				},
				{
					'targets': 1,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.per_page_questions;
					}
				},
				{
					'targets': 2,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.show_definition;
					}
				},
				{
					'targets': 3,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.show_impact;
					}
				},
				{
					'targets': 4,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.last_modified;
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

		$(document).on('click', '.delete-quiz', function(e) {
			e.preventDefault();

			do_confirmation_before_delete('POST', $(this).attr('href'));

			return false;
		});
	});
</script>

@endsection