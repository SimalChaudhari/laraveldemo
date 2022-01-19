@extends('layouts.admin')

@section('page_title')
Edit: Employee Termination Form
@endsection

@section('content')

<link rel="stylesheet" href="{{ asset('public/lib/datepickr/jquery-ui.css') }}" />
<script src="{{ asset('public/lib/datepickr/jquery-1.9.1.js') }}"></script>
<script src="{{ asset('public/lib/datepickr/jquery-ui.js') }}"></script>

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<x-alert />

<div class="row">

	<div class="col-sm-2 col-xs-12"></div>

	<div class="col-sm-8 col-xs-12">

		<ol class="breadcrumb">
	        <li><a href="javascript:;">HIPAA Container</a></li>
	        <li><a href="{{ route('UI_allOnlineForms') }}">Online Forms</a></li>
	        <li class="active">{{ ucwords( strtolower( 'Employee Termination Form' ) ) }}</li>
	    </ol>

		<div class="panel panel-default">

			<div class="panel-heading">
				<h3 class="panel-title text-center">Employee Termination Form</h3>
			</div>

			<div class="panel-body">

				<p class="col-sm-12 col-xs-12 text-right" style="padding-right: 0;"><small>({!! $required_field_html !!}) fields are mandatory.</small></p>

				<div class="clearfix"></div>

				<form name="employeeTerminationForm" class="validateForm" method="POST" action="{{ route('emp-termination.update', $form->uuid) }}">

					@csrf

					<div class="table-responsive">

						<table class="table">

							<tr class="odd gradeX">
								<td><b>Name of Practice{!! $required_field_html !!}</b></td>
								<td colspan="3">
									<input type="text" name="name_practice" value="{{ $form->name_practice }}" class="form-control validate[required, maxSize[255]]" />
								</td>
							</tr>

							<tr class="odd gradeX">
								<td><b>Name of Employee{!! $required_field_html !!}</b></td>
								<td colspan="3">
									<input type="text" name="name_employee" value="{{ $form->name_employee }}" class="form-control validate[required, maxSize[255]]" />
								</td>
							</tr>

							<tr class="odd gradeX">
								<td><b>Reason For Termination{!! $required_field_html !!}</b></td>
								<td colspan="3">
									<input type="text" name="rsn_termination" value="{{ $form->rsn_termination }}" class="form-control validate[required, maxSize[255]]" />
								</td>
							</tr>

							<tr class="odd gradeX">
								<td><b>Terminationvoluntary</b></td>
								<td><input type="checkbox"  name="termination_vol" value="Yes" <?php echo $form->termination_vol == 'Yes' ? 'checked' : ''; ?> /></td>
								<td><b>Termination Forced</b></td>
					        	<td><input type="checkbox" name="termination_force" value="Yes" <?php echo $form->termination_force == 'Yes' ? 'checked' : ''; ?> /></td>
							</tr>

							<tr class="odd gradeX">
					        	<td><b>Did the Employee Have Administrator Access?{!! $required_field_html !!}</b></td>
					        	<td colspan="3">
					        		<select type="text" name="admin_access" class="form-control validate[required]">
						                <option value="">-----Select Option-----</option>
						                <option value="Yes" <?php echo $form->admin_access == 'Yes' ? 'selected' : ''; ?>>Yes</option>
						                <option value="No" <?php echo $form->admin_access == 'No' ? 'selected' : ''; ?>>No</option>
						        </select>
					        	</td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>Windows Log-in Account Terminated</b></td>
					        	<td><input type="checkbox" name="windowacc" value="Yes" <?php echo $form->windowacc == 'Yes' ? 'checked' : ''; ?> /></td>
					        	<td><b>Date</b> </td>
					        	<td><input type="text" name="windowacc_date"  id="windowacc_date" class="datepicker form-control validate[custom[date]]" autocomplete="off" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" value="{{ \Carbon\Carbon::parse( $form->windowacc_date )->format( config('app.VIEW_DATE_FORMAT') ) }}" /></td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>Practice Management Log-ln Account Terminated</b></td>
					        	<td><input type="checkbox" name="practiceacc" value="Yes" <?php echo $form->practiceacc == 'Yes' ? 'checked' : ''; ?> /></td>
					        	<td><b>Date</b> </td>
					        	<td><input type="text" name="practiceacc_date"  id="practiceacc_date" class="datepicker form-control validate[custom[date]]" autocomplete="off" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" value="{{ \Carbon\Carbon::parse( $form->practiceacc_date )->format( config('app.VIEW_DATE_FORMAT') ) }}" /></td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>EHR Log-ln Account Terminated</b></td>
					        	<td><input type="checkbox" name="ehracc" value="Yes" <?php echo $form->ehracc == 'Yes' ? 'checked' : ''; ?> /></td>
					        	<td><b>Date</b> </td>
					        	<td><input type="text" name="ehracc_date"  id="ehracc_date" class="datepicker form-control validate[custom[date]]" autocomplete="off" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" value="{{ \Carbon\Carbon::parse( $form->ehracc_date )->format( config('app.VIEW_DATE_FORMAT') ) }}" /></td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>Key(s) to facility has been returned{!! $required_field_html !!}</b></td>
					        	<td colspan="3">
					        		<select type="text" name="keys_facility" class="form-control validate[required]">
						                <option value="">-----Select Option-----</option>
						                <option value="Yes" <?php echo $form->keys_facility == 'Yes' ? 'selected' : ''; ?>>Yes</option>
						                <option value="No" <?php echo $form->keys_facility == 'No' ? 'selected' : ''; ?>>No</option>
						                <option value="N/A" <?php echo $form->keys_facility == 'N/A' ? 'selected' : ''; ?>>N/A</option>
						        	</select>
					        	</td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>Employee Individual security Entry code Deactivated:{!! $required_field_html !!}</b></td>
					        	<td colspan="3">
					        		<select type="text" name="security_entry" class="form-control validate[required]">
						                <option value="">-----Select Option-----</option>
						                <option value="Yes" <?php echo $form->security_entry == 'Yes' ? 'selected' : ''; ?>>Yes</option>
						                <option value="No" <?php echo $form->security_entry == 'No' ? 'selected' : ''; ?>>No</option>
						                <option value="N/A" <?php echo $form->security_entry == 'N/A' ? 'selected' : ''; ?>>N/A</option>
						        </select>
					        	</td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>If code for entry is the same for all employees, has the access code been changed?{!! $required_field_html !!}</b></td>
					        	<td colspan="3">
					        		<select type="text" name="code_for_entry" class="form-control validate[required]">
						                <option value="">-----Select Option-----</option>
						                <option value="Yes" <?php echo $form->code_for_entry == 'Yes' ? 'selected' : ''; ?>>Yes</option>
						                <option value="No" <?php echo $form->code_for_entry == 'No' ? 'selected' : ''; ?>>No</option>
						        </select>
					        	</td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>If the employee had a laptop computer or other mobile device has it been returned?{!! $required_field_html !!}</b></td>
					        	<td colspan="3">
					        		<select type="text" name="device" class="form-control validate[required]">
						                <option value="">-----Select Option-----</option>
						                <option value="Yes" <?php echo $form->device == 'Yes' ? 'selected' : ''; ?>>Yes</option>
						                <option value="No" <?php echo $form->device == 'No' ? 'selected' : ''; ?>>No</option>
						                <option value="N/A" <?php echo $form->device == 'N/A' ? 'selected' : ''; ?>>N/A</option>
						        </select>
					        	</td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>Did the employee have any patient information accessible from a cell phone?{!! $required_field_html !!}</b></td>
					        	<td colspan="3">
					        		<select type="text" name="patient_info" class="form-control validate[required]">
						                <option value="">-----Select Option-----</option>
						                <option value="Yes" <?php echo $form->patient_info == 'Yes' ? 'selected' : ''; ?>>Yes</option>
						                <option value="No" <?php echo $form->patient_info == 'No' ? 'selected' : ''; ?>>No</option>
						                <option value="N/A" <?php echo $form->patient_info == 'N/A' ? 'selected' : ''; ?>>N/A</option>
						        </select>
					        	</td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>If above answer is yes, has all patient information been deleted from the device?{!! $required_field_html !!}</b></td>
					        	<td colspan="3">
					        		<select type="text" name="patient_info_dlt" class="form-control validate[required]">
						                <option value="">-----Select Option-----</option>
						                <option value="Yes" <?php echo $form->patient_info_dlt == 'Yes' ? 'selected' : ''; ?>>Yes</option>
						                <option value="No" <?php echo $form->patient_info_dlt == 'No' ? 'selected' : ''; ?>>No</option>
						                <option value="N/A" <?php echo $form->patient_info_dlt == 'N/A' ? 'selected' : ''; ?>>N/A</option>
						        </select>
					        	</td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>Has the password been changed for the employee's company email account?{!! $required_field_html !!}</b></td>
					        	<td colspan="3">
					        		<select type="text" name="email_pass" class="form-control validate[required]">
						                <option value="">-----Select Option-----</option>
						                <option value="Yes" <?php echo $form->email_pass == 'Yes' ? 'selected' : ''; ?>>Yes</option>
						                <option value="No" <?php echo $form->email_pass == 'No' ? 'selected' : ''; ?>>No</option>
						                <option value="N/A" <?php echo $form->email_pass == 'N/A' ? 'selected' : ''; ?>>N/A</option>
						        </select>
					        	</td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>Notes about this termination{!! $required_field_html !!}</b></td>
					        	<td colspan="3"><textarea name="notes" class="form-control validate[required]">{{ $form->notes }}</textarea></td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>Form Completed By{!! $required_field_html !!}</b></td>
					        	<td colspan="3"><input type="text" name="form_name" class="form-control validate[required, maxSize[255]]" value="{{ $form->form_name }}" /></td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>Title{!! $required_field_html !!}</b></td>
					        	<td colspan="3"><input type="text" name="form_title" class="form-control validate[required, maxSize[255]]" value="{{ $form->form_title }}" /></td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>Date Form Completed{!! $required_field_html !!}</b></td>
					        	<td colspan="3"><input type="text" name="formcomplte_date" id="formcomplte_date" class="datepicker form-control validate[required, custom[date]]" autocomplete="off" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" value="{{ \Carbon\Carbon::parse( $form->formcomplte_date )->format( config('app.VIEW_DATE_FORMAT') ) }}" /></td>
					        </tr>

						</table>

						<input type="submit" name="update" class="btn btn-custom-primary center-block" value="Update" style="width: 40%;" />

					</div>

				</form>

			</div>

		</div>

	</div>

	<div class="col-sm-2 col-xs-12"></div>

	<div class="clearfix"></div>

</div>

@endsection