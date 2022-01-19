@extends('layouts.admin')

@section('page_title')
Add Technology Report
@endsection

@section('content')

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">

    <div class="col-sm-4 col-xs-12"></div>

    <div class="col-sm-4 col-xs-12">
        
        <div class="panel panel-default panel-custom">

        	<div class="panel-heading">
        		<div class="row">
					<div class="col-sm-12 col-xs-12">
						<h3 class="panel-title"><i class="fa fa-2x fa-file" aria-hidden="true"></i> Edit Report</h3>
					</div>
				</div>
        	</div>

            <div class="panel-body">
            	<p class="col-sm-12 col-xs-12 text-right" style="padding-right: 0;"><small>({!! $required_field_html !!}) fields are mandatory.</small></p>

            	<form action="{{ route('technology-report.update', $report->uuid) }}" method="POST" enctype="multipart/form-data" role="form">

					@csrf

					<div class="form-group">
						<label>Name{!! $required_field_html !!}</label>
						<input type="text" class="form-control" name="name" value="{{ $report->name }}" required />
						@error('name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
					</div>

					<div class="form-group">
						<label>Company Name{!! $required_field_html !!}</label>
						<select type="text" name="company_name" class="form-control" required />
							<option value="">-----Select Option-----</option>
							@foreach( $companies as $company )
								<option value="{{ $company->company_name }}" <?php echo $report->company_name === $company->company_name ? 'selected' : ''; ?>>{{ $company->company_name }}</option>
							@endforeach
						</select>
						@error('company_name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
					</div>

					<div class="form-group">
						<label>Upload Report{!! $required_field_html !!}</label>
						<input type="file" name="file" />
						@error('file')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
					</div>

					<input type="submit" name="submit" class="btn btn-custom-primary" value="Update Report" />

				</form>

    		</div>

        </div>

   	</div>

   	<div class="col-sm-4 col-xs-12"></div>

</div>

@endsection