@extends('layouts.admin')

@section('page_title')
Permission Management
@endsection

@section('content')

<x-alert />

<div class="panel panel-default panel-custom">
	<div class="panel-heading">
		<div class="row">
			<div class="col-sm-6 col-xs-6">
				<h3 class="panel-title"><i class="fa fa-2x fa-unlock-alt" aria-hidden="true"></i> Permissions</h3>
			</div>
			<div class="col-sm-6 col-xs-6">
				<a href="{{ route('permission.create') }}" class="btn btn-custom-primary pull-right">
	                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>&nbsp;Add
	            </a>
			</div>
		</div>
	</div>

	<div class="panel-body">

		<div class="table-responsive">
			<table id="tbl_business_associate_agreements" class="table table-striped table-bordered table-hover" style="width: 100%;">
				<thead>
					<tr>
						<th>No.</th>
						<th>Permission</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>

					@foreach ($permissions as $key => $permission)

						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $permission->name }}</td>
							<td>
								 @can('role-edit')
								 	<a class="btn btn-xs btn-custom-primary" href="{{ route('permission.edit',$permission->id) }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
								 @endcan

								 @can('role-delete')
								 	<a class="btn btn-xs btn-custom-danger delete-role" href="{{ route('permission.destroy',$permission->id) }}"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>
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

	$(document).on('click', '.delete-role', function(e) {
		e.preventDefault();

		do_confirmation_before_delete('POST', $(this).attr('href'));

		return false;
	});

});
</script>

@endsection