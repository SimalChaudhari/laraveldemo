@extends('layouts.admin')

@section('page_title')
{{ $revision->policy_name }}
@endsection

@section('content')

<div class="row">

    <div class="col-sm-2 col-xs-12"></div>

    <div class="col-sm-8 col-xs-12">

    	<ol class="breadcrumb">
			<li><a href="javascript:;">HIPAA Container</a></li>
			<li><a href="{{ route('UI_policyRevision') }}">Policy Revisions</a></li>
			<li class="active">View</li>
		</ol>

		<div class="panel panel-default panel-custom">
			<div class="panel-heading">
				<div class="row">
					<div class="col-sm-12 col-xs-12">
						<h3 class="panel-title"><i class="fa fa-2x fa-files-o" aria-hidden="true"></i> View: {{ $revision->policy_name }}</h3>
					</div>
				</div>
			</div>

			<div class="panel-body">

				<div class="table-responsive">

					<table class="table table-bordered">
						<tbody>
							<tr>
								<td><strong>Policy Name</strong></td>
								<td>{{ $revision->policie_name }}</td>
							</tr>

							<tr>
								<td><strong>Revision By</strong></td>
								<td>{{ $revision->revision_by }}</td>
							</tr>

							<tr>
								<td><strong>Date</strong></td>
								<td>{{ \Carbon\Carbon::parse( $revision->revision_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
							</tr>

						</tbody>
					</table>
				</div>
				
			</div>

		</div>

	</div>

	<div class="col-sm-2 col-xs-12"></div>

</div>

@endsection