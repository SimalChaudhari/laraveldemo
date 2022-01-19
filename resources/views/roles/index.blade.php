@extends('layouts.admin')

@section('page_title')
Role Management
@endsection

@section('content')

<script src="{{ asset( 'public/lib/Sortable/Sortable.js') }}"></script>

<x-alert />

<div class="alert alert-info">
	The following are the four Roles identified in a medical practice.  The "Professional" is someone who touches the patient such as a physician, dentist, physical therapist, chiropractor, nurse, physician’s assistant, dental technician, etc.
</div>

<div class="panel panel-default panel-custom">
	<div class="panel-heading">
		<div class="row">
			<div class="col-sm-6 col-xs-6">
				<h3 class="panel-title"><i class="fa fa-2x fa-briefcase" aria-hidden="true"></i> Roles</h3>
			</div>
			<div class="col-sm-6 col-xs-6">
				<a href="{{ route('roles.create') }}" class="btn btn-custom-primary pull-right">
	                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>&nbsp;Add
	            </a>
	            <span id="saving_order" class="pull-right" style="color: red;margin-top: 8px;font-style: italic;display: none;">Saving order...</span>
			</div>
		</div>
	</div>

	<div class="panel-body">

		<div class="table-responsive">
			<table id="tbl_business_associate_agreements" class="table table-striped table-bordered table-hover" style="width: 100%;">
				<thead>
					<tr>
						<th>No.</th>
						<th>Role</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody id="roles_tbody">

					@foreach ($roles as $key => $role)

						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $role->name }}</td>
							<td>
								<input type="hidden" name="role_ids[]" value="{{ $role->id }}" />
								 @can('role-edit')
								 	<a class="btn btn-xs btn-custom-primary" href="{{ route('roles.edit',$role->id) }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
								 @endcan

								 @can('role-delete')
								 	<a class="btn btn-xs btn-custom-danger delete-role" href="{{ route('roles.destroy',$role->id) }}"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>
								 @endcan
							</td>
						</tr>

					@endforeach
					
				</tbody>
			</table>
		</div>

	</div>

</div>

<script>
$(document).ready(function() {

	new Sortable(roles_tbody, {
		/*swap: true,
		swapClass: 'highlight',*/
	    animation: 150,
	    ghostClass: 'blue-background-class',
	    onEnd: function(evt) {

	    	$('#saving_order').show();

	    	var itemEl = evt.item;  // dragged HTMLElement

	    	var role_ids = [];

	    	var i = 1;
	    	$('input[name^=role_ids]').each(function() {
	    		$(this).parents().closest('tr').find('td:first').text( i++ );
	    		role_ids.push( $(this).val() );
	    	});



	    	role_ids = role_ids.join(',');

	    	$.ajax({
		        url: '{{ route("roles.save_order") }}', 
		        type: "POST",             
		        data: {role_ids: role_ids},
		        success: function(response) {
		            $('#saving_order').hide();
		        }
		    });
	    }
	});

	$(document).on('click', '.delete-role', function(e) {
		e.preventDefault();

		do_confirmation_before_delete('POST', $(this).attr('href'));

		return false;
	});

});
</script>

@endsection