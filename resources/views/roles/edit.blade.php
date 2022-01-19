@extends('layouts.admin')

@section('page_title')
Role Management
@endsection

@section('content')

<x-alert />

<div class="row">

	<div class="col-sm-2 col-xs-12"></div>

	<div class="col-sm-8 col-xs-12">

		<div class="panel panel-default">

			<div class="panel-heading">
				<h3 class="panel-title"><strong>Edit role: {{ $role->name }} permission</strong> <a href="{{ route('roles.index') }}" class="btn btn-custom-danger btn-xs pull-right">&laquo; Back</a></h3>
			</div>

			<div class="panel-body">

				<form method="POST" action="{{ route('roles.update', $role->id) }}" role="form">

					@csrf
					
					<input type="hidden" name="name" class="form-control" value="{{ $role->name }}" />

					<div class="form-group">
						<label>Permissions</label>
						<br/>
						<div class="row">
							@foreach($permissions as $menu_title => $menu_permission)
							<div class="col-sm-4 col-xs-12">
								<div class="panel panel-default">
									<div class="panel-heading">{{ $menu_title }}</div>
									<div class="panel-body">
										<?php foreach( $menu_permission as $key => $val ) { ?>
										<div class="checkbox">
											<label>
												<input type="checkbox" name="permission[]" value="{{ $key }}" <?php echo in_array( $key, $rolePermissions ) ? 'checked' : '' ?> /> {{ $val }}
											</label>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<?php
							if( $loop->iteration % 3 == 0 ) {
								echo '<div class="clearfix"></div>';
							}
							?>
							@endforeach
						</div>

					</div>

					<div class="clearfix"></div>

					<p>&nbsp;</p>

					<input type="submit" name="update" value="Update" class="btn btn-custom-primary" />

				</form>

			</div>

		</div>

		

		</form>

	</div>

	<div class="col-sm-2 col-xs-12"></div>

</div>

@endsection