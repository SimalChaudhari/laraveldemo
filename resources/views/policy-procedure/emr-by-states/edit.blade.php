@extends('layouts.admin')

@section('page_title')
Edit: {{ $emr->policy_name }}
@endsection

@section('content')

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/codemirror.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/theme/blackboard.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/theme/monokai.min.css">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

<style>
.note-group-select-from-files {
	display: none;
}
</style>

<x-alert />

<div class="row">

    <div class="col-sm-12 col-xs-12">

    	<ol class="breadcrumb">
			<li><a href="javascript:;">HIPAA Container</a></li>
			<li><a href="{{ route('UI_policyProcedures') }}">Policies & Procedures</a></li>
			<li><a href="{{ route('emr-records.index') }}">EMR Records Per State</a></li>
			<li class="active">Edit</li>
		</ol>

		<div class="panel panel-default panel-custom">
			<div class="panel-heading">
				<div class="row">
					<div class="col-sm-12 col-xs-12" style="position: relative;">
						<h3 class="panel-title"><i class="fa fa-2x fa-envelope-open" aria-hidden="true"></i> Edit: {{ $emr->policy_name }}</h3>
						<a style="position: absolute;top: 5px;right: 15px;" href="{{ route('emr-records.index') }}" class="btn btn-custom-danger btn-xs pull-right">&laquo; Back</a>
					</div>
				</div>
			</div>

			<div class="panel-body">
				<p class="col-sm-12 col-xs-12 text-right" style="padding-right: 0;"><small>({!! $required_field_html !!}) fields are mandatory.</small></p>

				<form class="validateForm" action="{{ route('emr-records.update', $emr->uuid) }}" method="POST" enctype="multipart/form-data" role="form">

					@csrf

					<div class="form-group">
						<label for="name">Name{!! $required_field_html !!}</label>
						<input type="text" class="form-control validate[required, maxSize[255]]" name="policy_name" value="{{ $emr->policy_name }}" />

						@error('policy_name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
					</div>

					<div class="form-group">
						<label for="name">Description{!! $required_field_html !!}</label>
						<textarea class="summernote" name="content">{{ $emr->content }}</textarea>

						@error('content')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
					</div>

					<input type="submit" name="submit" class="btn btn-custom-primary" value="Update" />

				</form>
			</div>

		</div>

	</div>

</div>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/codemirror.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/mode/xml/xml.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

@endsection