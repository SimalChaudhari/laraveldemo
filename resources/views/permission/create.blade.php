@extends('layouts.admin')

@section('page_title')
Create Permission
@endsection

@section('content')

<x-alert />

<div class="row">

	<div class="col-sm-2 col-xs-12"></div>

	<div class="col-sm-8 col-xs-12">

		<div class="panel panel-default">

			<div class="panel-heading">
				<h3 class="panel-title"><strong>Add Permission</strong> <a href="{{ route('permission.index') }}" class="btn btn-custom-danger btn-xs pull-right">&laquo; Back</a></h3>
			</div>

			<div class="panel-body">

				<form method="POST" action="{{ route('permission.store') }}" role="form">

					@csrf

					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control" value="{{ old('name') }}" />

						@error('name')
							<span class="invalid-feedback" role="alert">{{ $message }}</span>
						@enderror
					</div>

					<input type="submit" name="submit" value="Submit" class="btn btn-custom-primary" />

				</form>

			</div>

		</div>

		

		</form>

	</div>

	<div class="col-sm-2 col-xs-12"></div>

</div>

@endsection