@extends('layouts.admin')

@section('page_title')
{{ $emr->policy_name }}
@endsection

@section('content')

<link rel="stylesheet" href="{{ asset('public/lib/datepickr/jquery-ui.css') }}" />
<script src="{{ asset('public/lib/datepickr/jquery-1.9.1.js') }}"></script>
<script src="{{ asset('public/lib/datepickr/jquery-ui.js') }}"></script>

<x-alert />

<div class="row">

    <div class="col-sm-12 col-xs-12">

    	<ol class="breadcrumb">
			<li><a href="javascript:;">HIPAA Container</a></li>
			<li><a href="{{ route('UI_policyProcedures') }}">Policies & Procedures</a></li>
			<li><a href="{{ route('emr-records.index') }}">EMR Records Per State</a></li>
			<li class="active">View</li>
		</ol>

		<div class="panel panel-default panel-custom">
			<div class="panel-heading">
				<div class="row">
					<div class="col-sm-12 col-xs-12">
						<h3 class="panel-title"><i class="fa fa-2x fa-envelope-open" aria-hidden="true"></i> View: {{ $emr->policy_name }}</h3>
					</div>
				</div>
			</div>

			<div class="panel-body">
				{!! $emr->content !!}

				<x-list-policy-revisions :revisions="$revisions" />

				<x-create-policy-revision type="emr_by_state" :parentId="$emr->uuid" />
			</div>

		</div>

	</div>

</div>

@endsection