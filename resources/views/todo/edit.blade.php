@extends('layouts.admin')

@section('page_title')
Remediation Plan For {{ Auth::user()->administrator }}
@endsection

@section('content')

<x-alert />

<div class="row">

    <div class="col-sm-2 col-xs-12"></div>

    <div class="col-sm-8 col-xs-12">

    	<div class="panel panel-default panel-custom">

    		<div class="panel-heading">
        		<div class="row">
					<div class="col-sm-12 col-xs-12">
						<h3 class="panel-title"><i class="fa fa-2x fa-check-circle-o" aria-hidden="true"></i> Remediation Plan For {{ Auth::user()->administrator }}</h3>
					</div>
				</div>
        	</div>

        	<div class="panel-body">

        		<form method="POST" action="{{ route('updateTodo', $todo->id ) }}">
					@csrf
					
					<table class="table table-bordered table-striped">

						<thead>
							<tr>
								<th>ITEM</th>
								<th>Completed</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>{{ $todo->todo_list }}</td>
								<td>
									<select name="todo_status" id="todo_status" class="form-control">
										<option value="YES" <?php echo strtolower( $todo->status ) === 'yes' ? 'selected' : ''; ?>>Yes</option>
										<option value="NO" <?php echo strtolower( $todo->status ) === 'no' ? 'selected' : ''; ?>>No</option>
									</select>
								</td>
							</tr>
						</tbody>

					</table>

					<a href="{{ route('dashboard') }}" class="btn btn-custom-danger">&laquo; Back</a>
					<input type="submit" name="submit" class="btn btn-custom-primary pull-right" value="Update" />
					
				</form>

        	</div>

    	</div>

	</div>

	<div class="col-sm-2 col-xs-12"></div>

</div>

@endsection