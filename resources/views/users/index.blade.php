@extends('layouts.admin')

@section('page_title')
Users
@endsection

@section('content')

<x-alert />

<style>
table .user_action a {
	border: 0px solid #330066;
}
table .user_action.search a {
	border: 2px solid #330066;
}
</style>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<div class="alert alert-info">
	<p>New users of the Hipaamart portal can be added under the <a href="{{ route('users.create') }}">Add New User</a> tab.</p>

	<p>Under the "Users" tab, a record is kept of the User:</p>

	<ul>
		<li>Taking the Training Quiz</li>
		<li>Signing the Training Acknowledgement</li>
		<li>Completing the Risk Assessment Questionnaire</li>
	</ul>
</div>

@if( ! empty( $require_subscription_message ) )
<div class="alert alert-danger alert-dismissible" role="alert">
    To add new user, you require to purchase a additional subscription for professional.
</div>
@endif

<div class="panel panel-default panel-custom">
	<div class="panel-heading">
		<div class="row">
			<div class="col-sm-6 col-xs-6">
				<h3 class="panel-title"><i class="fa fa-2x fa-users" aria-hidden="true"></i> Users</h3>
			</div>
			<div class="col-sm-6 col-xs-6">
				@can('user-create')
				<a href="{{ empty( $require_subscription_message ) ? route('users.create') : '' }}" id="add_new_user" class="btn btn-custom-primary pull-right">
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
			<div class="row">
				<div class="col-sm-4 col-xs-12">
					<div class="form-group">
						<!-- <label for="date">Date</label> -->
						<input type="text"class="form-control" name="daterange" placeholder="Daterange" value=""/>
					</div>
				</div>
				
				<div class="col-sm-4 col-xs-12">
					<div class="form-group">
						<!-- <label for="company">Company</label> -->
						<select class="form-control select2" id="company_filter" name="company_filter">
                            <option value="">Choose Company</option>
                            @foreach($companies as $value)
                            <option value="{{$value['id']}}">
                                {{ @$value['company_name']}}
                            </option>
                            @endforeach
                        </select>
					</div>
				</div>
				<div class="col-sm-4 col-xs-12">
					<button class="btn btn-primary btn-search">Search</button>
				</div>

			</div>
			<table id="tbl_users" class="table table-striped table-bordered table-hover" style="width: 100%;">

				<thead>
					<tr>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Email id</th>
						<th>Username</th>
						<th>Company</th>
						<th>Role</th>
						<th>Is Active?</th>
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
	let startDate, endDate;

	function renderTable(startDate, endDate, companyId) {
		$('#tbl_users').DataTable({
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
				url: `{{ route("ajax_get_user_list") }}/?start_date=${startDate}&end_date=${endDate}&company_id=${companyId}`,
				type: 'GET',
			},
			"columns": [
				{"data": null},
				{"data": null},
				{"data": null},
				{"data": null},
				{"data": null},
				{"data": null, "orderable": false},
				{"data": null, "orderable": false},
				{"data": null, "orderable": false},
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
						return data.lastname;
					}
				},
				{
					'targets': 2,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return '<a href="mailto:' + data.email + '">' + data.email + '</a>';
					}
				},
				{
					'targets': 3,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.username;
					}
				},
				{
					'targets': 4,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.company_name;
					}
				},
				{
					'targets': 5,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.user_role;
					}
				},
				{
					'targets': 6,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta) {
						return data.is_active;
					}
				},
				{
					'targets': 7,
					'className': 'dt-body-center actions',
					'render': function (data, type, full, meta) {
						return data.actions;
					}
				},
			],
			"fnRowCallback": function (nRow, data, iDisplayIndex, iDisplayIndexFull) {
				
			}
		});
	}

	$(document).ready(function() {

		$('input[name="daterange"]').daterangepicker({
			// autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			},
			opens: 'left',
			ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
		}, function(start, end, label) {
			startDate = start.format('YYYY-MM-DD');
			endDate = end.format('YYYY-MM-DD');
			console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
		});

		$('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
		});

		$('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
		});

		let companyId = $('#company_filter').val();
		renderTable(startDate, endDate, companyId);

		$(document).on('click', '.delete-user', function(e) {
			e.preventDefault();

			do_confirmation_before_delete('POST', $(this).attr('href'));

			return false;
		});

		$(document).on('click', '.disable-user', function(e) {
			e.preventDefault();

			generateFormAndSubmit('POST', $(this).attr('href'));
		});

		$(document).on('click', '.enable-user', function(e) {
			e.preventDefault();

			generateFormAndSubmit('POST', $(this).attr('href'));
		});

		$(document).on('click', '.btn-search', function(e) {
			e.preventDefault();
			let companyId = $('#company_filter').val();
			console.log('startDate, endDate company', startDate, endDate, companyId);
			$('#tbl_users').DataTable().destroy();
			renderTable(startDate, endDate, companyId);
		});

		@if( ! empty( $require_subscription_message ) )
		$(document).on('click', '#add_new_user', function(e) {
			e.preventDefault();

			BootstrapDialog.show({
				title: 'Delete',
				type: 'type-danger',
				message: '{{ $require_subscription_message }}',
				hotkey: 13, // Enter.
				closeByBackdrop: false,
				closeByKeyboard: true,
				buttons: [{
					label: 'Ok',
					id: 'btn_dont_delete',
					cssClass: 'btn-custom-danger',
					action: function (dialogItself) {
						dialogItself.close();
					}
				}],
			});
		});
		@endif
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
									if (!response.message) {
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
							}
						});

					}
				}],
			});
		});
</script>

@endsection