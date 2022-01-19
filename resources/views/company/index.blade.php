@extends('layouts.admin')

@section('page_title')
All Companies
@endsection

@section('content')

<x-alert />
<style>
table .btn-incr-decr {
	background: #dddddd;
    width: 100%;
    display: flex;
    place-content: space-between;
}
table .btn-incr-decr span{
	align-self: center;
}
</style>
<div class="panel panel-default panel-custom">
	<div class="panel-heading">
		<div class="row">
			<div class="col-sm-6 col-xs-6">
				<h3 class="panel-title"><i class="fa fa-2x fa-building-o" aria-hidden="true"></i> Company</h3>
			</div>
			<div class="col-sm-6 col-xs-6">
				@can('Add New Company')
				<a href="{{ route('company.create') }}" class="btn btn-custom-primary pull-right">
	                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>&nbsp;Add
	            </a>
	            @endcan
			</div>
		</div>
	</div>

	<div class="panel-body">
		<div class="alert alert-success success_msg_div" role="alert" style="margin-top: 0;display:none;">
			<span id="success_msg"></span>
		</div>

		<div class="alert alert-danger error_msg_div" role="alert" style="margin-top: 0;display:none;">
			<span id="error_msg"></span>
		</div>

		<div class="table-responsive">
			<table id="tbl_companies" class="table table-striped table-bordered table-hover" style="width: 100%;">
				<thead>
					<tr>
						<th>No.</th>
						<th>Name</th>
						<th>Username</th>
						<th>Registered Users</th>
						<th>Available Licenses</th>
						<th>Purchased Licenses</th>
						<th>Monthly Fees</th>
						<th>Created On</th>
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
	function renderTable() {
		$('#tbl_companies').DataTable({
			"processing": true,
			"serverSide": true,
			"aaSorting": [[5, "desc"]],
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
				url: '{{ route("ajax_get_company") }}',
				type: 'GET',
			},
			"columns": [
				{"data": null, "orderable": false},
				{"data": null},
				{"data": null},
				{"data": null, "orderable": false },
				{"data": null, "orderable": false },
				{"data": null, "orderable": false },
				{"data": null, "orderable": false },
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
						return data.company_name;
					}
				},
				{
					'targets': 2,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.username;
					}
				},
				{
					'targets': 3,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						if (data.is_terminated) {
							return 0;
						} else {
							return data.registered_users;
						}
					}
				},
				{
					'targets': 4,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						if (data.is_terminated) {
							return 0;
						} else {
							return data.available_licenses;
						}
					}
				},
				{
					'targets': 5,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						if (data.is_terminated) {
							return 0;
						} else {
							return `<div class="btn-incr-decr">
								<button class="btn btn-primary fa fa-angle-left" title="Decrease" onClick="onDecreaseClick(${data.id})"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
								<span>${data.purchased_licenses}</span> 
								<button class="btn btn-primary fa fa-angle-right" title="Increase" onClick="onIncreaseClick(${data.id})"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
							</div>`;
						}
					}
				},
				{
					'targets': 6,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return `$${data.monthly_fees ? data.monthly_fees : 0}`;
					}
				},
				{
					'targets': 7,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.created_on;
					}
				},
				{
					'targets': 8,
					'className': 'dt-body-center actions',
					'render': function (data, type, full, meta) {
						return data.actions;
					}
				},
			],
		});
	}
	$(document).ready(function() {
		renderTable();

		$(document).on('click', '.delete-company', function(e) {
			e.preventDefault();

			var delete_company_url = $(this).attr('href');

			// prior to delete the company, check has this company assigned to any user?
			$.ajax({
				url: $(this).data('before_delete_callback'),
				method: 'POST',
				data: {},
				success: function(response) {

					if( response.can_delete ) {

						do_confirmation_before_delete('POST', delete_company_url);
						
					} else {

						BootstrapDialog.show({
							title: 'Delete',
							type: 'type-primary',
							message: 'You can not delete the company because there are already users assigned to this company',
							hotkey: 13, // Enter.
							closeByBackdrop: false,
							closeByKeyboard: true,
							buttons: [{
								label: 'Okay',
								cssClass: 'btn-custom-danger',
								action: function (dialogItself) {
									dialogItself.close();
								}
							}],
						});

					}
				}
			});

			// 

			return false;
		});

		// Terminate the company 
		$(document).on('click', '.terminate-company', function(e) {
			e.preventDefault();
			var terminate_company_url = $(this).attr('href');
			BootstrapDialog.show({
				title: 'Terminate',
				type: 'type-danger',
				message: 'Are you sure you want to terminate?',
				hotkey: 13, // Enter.
				closeByBackdrop: false,
				closeByKeyboard: true,
				buttons: [{
					label: 'No',
					id: 'btn_dont_delete',
					cssClass: 'btn-custom-danger',
					action: function (dialogItself) {
						dialogItself.close();
					}
				}, {
					label: 'Yes',
					cssClass: 'btn-custom-success',
					action: function(dialogItself) {

						$('#btn_dont_delete').prop('disabled', true);
						
						var $button = this;

						$button.disable();
						$button.spin();
						$.ajax({
							url: terminate_company_url,
							method: 'POST',
							data: {},
							success: function(response) {
								dialogItself.close();
								$('#tbl_companies').DataTable().destroy();
								renderTable();
							}
						});

					}
				}],
			});
		});

		// Restore the company 
		$(document).on('click', '.restore-company', function(e) {
			e.preventDefault();
			var restore_company_url = $(this).attr('href');
			BootstrapDialog.show({
				title: 'Restore',
				type: 'type-danger',
				message: 'Are you sure you want to restore?',
				hotkey: 13, // Enter.
				closeByBackdrop: false,
				closeByKeyboard: true,
				buttons: [{
					label: 'No',
					id: 'btn_dont_delete',
					cssClass: 'btn-custom-danger',
					action: function (dialogItself) {
						dialogItself.close();
					}
				}, {
					label: 'Yes',
					cssClass: 'btn-custom-success',
					action: function(dialogItself) {

						$('#btn_dont_delete').prop('disabled', true);
						
						var $button = this;

						$button.disable();
						$button.spin();
						$.ajax({
							url: restore_company_url,
							method: 'POST',
							data: {},
							success: function(response) {
								dialogItself.close();
								$('#tbl_companies').DataTable().destroy();
								renderTable();
							}
						});

					}
				}],
			});
		});

		// Switch user
		$(document).on('click', '.switch-user', function(e) {
			e.preventDefault();
			const url = $(this).attr('href');
			BootstrapDialog.show({
				title: 'Switch User',
				type: 'type-primary',
				message: 'Are you sure you want to switch the user?',
				hotkey: 13, // Enter.
				closeByBackdrop: false,
				closeByKeyboard: true,
				buttons: [{
					label: 'No',
					id: 'btn_dont_delete',
					cssClass: 'btn-custom-danger',
					action: function (dialogItself) {
						dialogItself.close();
					}
				}, {
					label: 'Yes',
					cssClass: 'btn-custom-success',
					action: function(dialogItself) {

						$('#btn_dont_delete').prop('disabled', true);
						
						var $button = this;

						$button.disable();
						$button.spin();
						$.ajax({
							url: url,
							method: 'POST',
							data: {},
							success: function(response) {
								dialogItself.close();
								if (response.success) {
									location.reload();
								} else {
									$('.error_msg_div').show();
									$('#error_msg').html(response.message);
									dialogItself.close();
									setTimeout(() => {
										$('.error_msg_div').hide();
										$('#error_msg').html('');
									}, 5000);
								}
							}
						});

					}
				}],
			});
		});
		
	});

	function onDecreaseClick(id) {
		BootstrapDialog.show({
				title: 'Decrease',
				type: 'type-danger',
				message: 'Are you sure you want to decrease?',
				hotkey: 13, // Enter.
				closeByBackdrop: false,
				closeByKeyboard: true,
				buttons: [{
					label: 'No',
					id: 'btn_dont_delete',
					cssClass: 'btn-custom-danger',
					action: function (dialogItself) {
						dialogItself.close();
					}
				}, {
					label: 'Yes',
					cssClass: 'btn-custom-success',
					action: function(dialogItself) {

						$('#btn_dont_delete').prop('disabled', true);
						
						var $button = this;

						$button.disable();
						$button.spin();
						$.ajax({
							url: '{{ route("company.decreasePurchaseLimit") }}',
							method: 'POST',
							data: {id},
							success: function(response) {
								if (response.success) {
									$('#tbl_companies').DataTable().destroy();
									renderTable();
									dialogItself.close();

									$('.success_msg_div').show();
									$('#success_msg').html(response.message);
									setTimeout(() => {
										$('.success_msg_div').hide();
										$('#success_msg').html('');
									}, 5000);
								} else {
									$('.error_msg_div').show();
									$('#error_msg').html(response.message);
									dialogItself.close();
									setTimeout(() => {
										$('.error_msg_div').hide();
										$('#error_msg').html('');
									}, 5000);
								}
							}
						});
					}
				}],
			});
	}

	function onIncreaseClick(id) {
		BootstrapDialog.show({
				title: 'Increase',
				type: 'type-danger',
				message: 'Are you sure you want to increase?',
				hotkey: 13, // Enter.
				closeByBackdrop: false,
				closeByKeyboard: true,
				buttons: [{
					label: 'No',
					id: 'btn_dont_delete',
					cssClass: 'btn-custom-danger',
					action: function (dialogItself) {
						dialogItself.close();
					}
				}, {
					label: 'Yes',
					cssClass: 'btn-custom-success',
					action: function(dialogItself) {

						$('#btn_dont_delete').prop('disabled', true);
						
						var $button = this;

						$button.disable();
						$button.spin();
						$.ajax({
							url: '{{ route("company.increasePurchaseLimit") }}',
							method: 'POST',
							data: {id},
							success: function(response) {
								if (response.success) {
									$('#tbl_companies').DataTable().destroy();
									renderTable();
									dialogItself.close();

									$('.success_msg_div').show();
									$('#success_msg').html(response.message);
									setTimeout(() => {
										$('.success_msg_div').hide();
										$('#success_msg').html('');
									}, 5000);
								} else {
									$('.error_msg_div').show();
									$('#error_msg').html(response.message);
									dialogItself.close();
									setTimeout(() => {
										$('.error_msg_div').hide();
										$('#error_msg').html('');
									}, 5000);
								}
							}
						});
					}
				}],
			});
	}
	
</script>

@endsection
