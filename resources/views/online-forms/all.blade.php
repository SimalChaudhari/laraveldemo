@extends('layouts.admin')

@section('page_title')
Online forms
@endsection

@section('content')

<x-alert />

<ol class="breadcrumb">
	<li><a href="javascript:;">HIPAA Container</a></li>
	<li class="active">Online Forms</li>
</ol>

<div class="panel-group" id="online-forms" role="tablist" aria-multiselectable="false">

	@foreach( $forms as $form_slug => $form )

		<div class="panel panel-default panel-custom">

			<div class="panel-heading" role="tab" id="{{ $form_slug }}">

				<div class="row">
					<div class="col-sm-6 col-xs-6">
						<h3 class="panel-title" role="button" data-toggle="collapse" data-parent="#online-forms" href="#collapse_{{ $form_slug }}" aria-expanded="true" aria-controls="collapse_{{ $form_slug }}">
							
							<i class="fa fa-2x fa-file-text" aria-hidden="true"></i> {{ ucwords( strtolower( $form['title'] ) ) }}
							
						</h3>
					</div>

					<div class="col-sm-6 col-xs-6">
						<a href="{{ route( $form['add_route'] ) }}" class="btn btn-custom-primary pull-right">
							<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>&nbsp;Add
						</a>
					</div>
				</div>

			</div>

			<div id="collapse_{{ $form_slug }}" class="panel-collapse collapse {{ $loop->iteration == 1 ? 'in' : '' }}" role="tabpanel" aria-labelledby="{{ $form_slug }}">

				<div class="panel-body">

					<div class="table-responsive">

						<table id="tbl_{{ $form_slug }}" class="table table-striped table-bordered table-hover tbl_fetch_data" style="width: 100%;">

							<thead>
								<tr>
									<th>No</th>
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

					$('#tbl_{{ $form_slug }}').DataTable({
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
							url: '{{ route($form['ajax_results']) }}',
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
									return data.name;
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
					
				});
			</script>

		</div>

	@endforeach

</div> <!-- #online-forms -->

<script>
$(document).ready(function() {
	$(document).on('click', '.delete-record', function(e) {
		e.preventDefault();

		do_confirmation_before_delete('POST', $(this).attr('href'));

		return false;
	});
});
</script>

@endsection