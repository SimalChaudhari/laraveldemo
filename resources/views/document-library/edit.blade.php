@extends('layouts.admin')

@section('page_title')
Edit Document Library
@endsection

@section('content')

<x-alert />

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">

    <div class="col-sm-4 col-xs-12"></div>

    <div class="col-sm-4 col-xs-12">
        
        <div class="panel panel-default panel-custom">

        	<div class="panel-heading">
        		<div class="row">
					<div class="col-sm-12 col-xs-12">
						<h3 class="panel-title"><i class="fa fa-2x fa-book"></i> Edit Document Library <a style="position: absolute;top: 5px;right: 15px;" href="{{ route('document-library.index') }}" class="btn btn-custom-danger btn-xs pull-right">&laquo; Back</a></h3>
					</div>
				</div>
        	</div>

            <div class="panel-body">

            	<p class="col-sm-12 col-xs-12 text-right" style="padding-right: 0;"><small>({!! $required_field_html !!}) fields are mandatory.</small></p>

            	<form class="validateForm" action="{{ route('document-library.update', $agreement->uuid) }}" method="POST" enctype="multipart/form-data" role="form">
					@csrf

					<div class="form-group">
						<label for="name">Name{!! $required_field_html !!}</label>
						<input type="text" class="form-control validate[required, maxSize[255]]" name="name" value="{{ $agreement->name }}" />

						@error('name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
					</div>

					<div class="form-group">
						<label for="company_name">Company Name{!! $required_field_html !!}</label>
						<select name="company_name" class="form-control validate[required]">
							<?php $company_name = $agreement->company_name; ?>
							<option value="">-Select Your Company Name</option>
							@foreach( $companies as $company )
								<option value="{{ $company->company_name }}" <?php echo $company_name === $company->company_name ? 'selected' : ''; ?>>{{ $company->company_name }}</option>
							@endforeach
						</select>

						@error('company_name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
					</div>

					<div class="form-group">
						<label for="file">Upload agreement{!! $required_field_html !!}</label>
						<input type="file" name="file" />

						@error('file')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
					</div>
					
					<input type="submit" name="submit" class="btn btn-custom-primary" value="Update" />

				</form>

            </div>

        </div>

    </div>

    <div class="col-sm-4 col-xs-12"></div>

</div>

@endsection