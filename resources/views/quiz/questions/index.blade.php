@extends('layouts.admin')

@section('page_title')
Quiz questions
@endsection

@section('content')

<x-alert />

<div class="panel panel-default panel-custom">
	<div class="panel-heading">
		<div class="row">
			<div class="col-sm-6 col-xs-6">
				<h3 class="panel-title"><i class="fa fa-2x fa-question-circle" aria-hidden="true"></i> Quiz questions</h3>
			</div>
			<div class="col-sm-6 col-xs-6">
				
				@can('Create Questions')
				<a href="{{ route('question.create') }}" class="btn btn-custom-primary pull-right">
	                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>&nbsp;Add
	            </a>
	            @endcan

	            <select class="form-control" id="quiz_filter" style="width: auto; display: inline;float: right;margin-right: 5px;">
					<option value="0">All Quiz</option>
					@foreach($quizes as $quiz)
						<option value="{{ $quiz->id }}">{{ $quiz->name }}</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>

	<div class="panel-body">

		<div class="table-responsive">
			<table id="tbl_questions" class="table table-striped table-bordered table-hover" style="width: 100%;">
				<thead>
					<tr>
						<th>Order</th>
						<th>Question</th>
						<th>Quiz</th>
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

		var tbl_questions = $('#tbl_questions').DataTable({
			"processing": true,
			"serverSide": true,
			"aaSorting": [[3, "desc"]],
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
				url: '{{ route("ajax_get_questions") }}',
				type: 'GET',
				data: function(d) {
					d.quiz_id = $('#quiz_filter').length > 0 ? $('#quiz_filter option:selected').val() : 0;
				}
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
						return data.question_order;
					}
				},
				{
					'targets': 1,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.title;
					}
				},
				{
					'targets': 2,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.quiz_name;
					}
				},
				{
					'targets': 3,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.last_modified;
					}
				},
				{
					'targets': 4,
					'className': 'dt-body-center actions',
					'render': function (data, type, full, meta) {
						return data.actions;
					}
				},
			],
		});

		$(document).on('change', 'select#quiz_filter', function() {
			tbl_questions.ajax.reload();
		});

		$(document).on('click', '.delete-question', function(e) {
			e.preventDefault();

			do_confirmation_before_delete('POST', $(this).attr('href'));

			return false;
		});
	});
</script>

@endsection