@extends('layouts.admin')

@section('page_title')
Edit Scanned Document
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
					<div class="col-sm-10 col-xs-10">
						<h3 class="panel-title"><i class="fa fa-2x fa-book"></i> Upload Scanned Document</h3>
					</div>
					<div class="col-sm-2 col-xs-2">
						<div class="btn-toolbar">
							@can('Scanned Documents - List')
				            <a href="{{ route('scanned-documents.index') }}" class="btn btn-custom-danger btn-sm pull-right">
				                &laquo; Back
				            </a>
				            @endcan
				        </div>
					</div>
				</div>
        	</div>

            <div class="panel-body">

            	<p class="col-sm-12 col-xs-12 text-right" style="padding-right: 0;"><small>({!! $required_field_html !!}) fields are mandatory.</small></p>

            	<form class="validateForm" action="{{ route('scanned-documents.update', $document->uuid) }}" method="POST" enctype="multipart/form-data" role="form">
					@csrf

					<div class="form-group">
						<label for="name">Title{!! $required_field_html !!}</label>
						<input type="text" class="form-control validate[required, maxSize[255]]" name="title" value="{{ $document->title }}" />

						@error('name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
					</div>

					<div class="form-group">
						<label for="company_name">Company Name{!! $required_field_html !!}</label>
						<select name="company_id" class="form-control validate[required]">
							<?php $company_id = $document->company_id; ?>
							<option value="">-Select Your Company Name</option>
							@foreach( $companies as $company )
								<option value="{{ $company->id }}" <?php echo $company_id == $company->id ? 'selected' : ''; ?>>{{ $company->company_name }}</option>
							@endforeach
						</select>

						@error('company_name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
					</div>

					<div class="form-group">
						<label for="file">Upload document</label>
						<input type="file" name="file" />

						@error('file')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
					</div>
					
					<input type="submit" name="upload" class="btn btn-custom-primary" value="Update" />

				</form>

            </div>

        </div>

    </div>

    <div class="col-sm-4 col-xs-12"></div>

</div>

@endsection