@extends('layouts.admin')

@section('page_title')
Create: Employee Termination Form
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

				<form name="employeeTerminationForm" class="validateForm" method="POST" action="{{ route('saveEmployeeTerminationForm') }}">

					@csrf

					<div class="table-responsive">

						<table class="table">

							<tr class="odd gradeX">
								<td><b>Name of Practice</b></td>
								<td colspan="3">
									<input type="text" name="name_practice" class="form-control validate[required, maxSize[255]]" />
								</td>
							</tr>

							<tr class="odd gradeX">
								<td><b>Name of Employee</b></td>
								<td colspan="3">
									<input type="text" name="name_employee" class="form-control validate[required, maxSize[255]]" />
								</td>
							</tr>

							<tr class="odd gradeX">
								<td><b>Reason For Termination</b></td>
								<td colspan="3">
									<input type="text" name="rsn_termination" class="form-control validate[required, maxSize[255]]" />
								</td>
							</tr>

							<tr class="odd gradeX">
								<td><b>Terminationvoluntary</b></td>
								<td><input type="checkbox"  name="termination_vol" value="Yes" /></td>
								<td><b>Termination Forced</b></td>
					        	<td><input type="checkbox" name="termination_force" value="Yes" /></td>
							</tr>

							<tr class="odd gradeX">
					        	<td><b>Did the Employee Have Administrator Access?</b></td>
					        	<td colspan="3">
					        		<select type="text" name="admin_access" class="form-control validate[required]">
						                <option selected="" value="">-----Select Option-----</option>
						                <option value="Yes">Yes</option>
						                <option value="No">No</option>
						        </select>
					        	</td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>Windows Log-in Account Terminated</b></td>
					        	<td><input type="checkbox"  name="windowacc" value="Yes" /></td>
					        	<td><b>Date</b> </td>
					        	<td><input type="text" name="windowacc_date" id="windowacc_date" class="datepicker form-control validate[custom[date]]" autocomplete="off" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" /></td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>Practice Management Log-ln Account Terminated</b></td>
					        	<td><input type="checkbox"  name="practiceacc" value="Yes" /></td>
					        	<td><b>Date</b> </td>
					        	<td><input type="text" name="practiceacc_date" id="practiceacc_date" class="datepicker form-control validate[custom[date]]" autocomplete="off" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" /></td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>EHR Log-ln Account Terminated</b></td>
					        	<td><input type="checkbox"  name="ehracc" value="Yes" /></td>
					        	<td><b>Date</b> </td>
					        	<td><input type="text" name="ehracc_date" id="ehracc_date" class="datepicker form-control validate[custom[date]]" autocomplete="off" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" /></td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>Key(s) to facility has been returned</b></td>
					        	<td colspan="3">
					        		<select type="text" name="keys_facility" class="form-control validate[required]">
						                <option selected="" value="">-----Select Option-----</option>
						                <option value="Yes">Yes</option>
						                <option value="No">No</option>
						                <option value="N/A">N/A</option>
						        	</select>
					        	</td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>Employee Individual security Entry code Deactivated:</b></td>
					        	<td colspan="3">
					        		<select type="text" name="security_entry" class="form-control validate[required]">
						                <option selected="" value="">-----Select Option-----</option>
						                <option value="Yes">Yes</option>
						                <option value="No">No</option>
						                <option value="N/A">N/A</option>
						        </select>
					        	</td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>If code for entry is the same for all employees, has the access code been changed ?</b></td>
					        	<td colspan="3">
					        		<select type="text" name="code_for_entry" class="form-control validate[required]">
						                <option selected="" value="">-----Select Option-----</option>
						                <option value="Yes">Yes</option>
						                <option value="No">No</option>
						        </select>
					        	</td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>If the employee had a laptop computer or other mobile device has it been returned ?</b></td>
					        	<td colspan="3">
					        		<select type="text" name="device" class="form-control validate[required]">
						                <option selected="" value="">-----Select Option-----</option>
						                <option value="Yes">Yes</option>
						                <option value="No">No</option>
						                <option value="N/A">N/A</option>
						        </select>
					        	</td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>Did the employee have any patient information accessible from a cell phone ?</b></td>
					        	<td colspan="3">
					        		<select type="text" name="patient_info" class="form-control validate[required]">
						                <option selected="" value="">-----Select Option-----</option>
						                <option value="Yes">Yes</option>
						                <option value="No">No</option>
						                <option value="N/A">N/A</option>
						        </select>
					        	</td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>If above answer is yes, has all patient information been deleted from the device ?</b></td>
					        	<td colspan="3">
					        		<select type="text" name="patient_info_dlt" class="form-control validate[required]">
						                <option selected="" value="">-----Select Option-----</option>
						                <option value="Yes">Yes</option>
						                <option value="No">No</option>
						                <option value="N/A">N/A</option>
						        </select>
					        	</td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>Has the password been changed for the employee's company email account?</b></td>
					        	<td colspan="3">
					        		<select type="text" name="email_pass" class="form-control validate[required]">
						                <option selected="" value="">-----Select Option-----</option>
						                <option value="Yes">Yes</option>
						                <option value="No">No</option>
						                <option value="N/A">N/A</option>
						        </select>
					        	</td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>Notes about this termination</b></td>
					        	<td colspan="3"><textarea name="notes" class="form-control validate[required]" /></textarea></td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>Form Completed By</b></td>
					        	<td colspan="3"><input type="text" name="form_name" class="form-control validate[required, maxSize[255]]" /></td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>Title</b></td>
					        	<td colspan="3"><input type="text" name="form_title" class="form-control validate[required, maxSize[255]]" /></td>
					        </tr>

					        <tr class="odd gradeX">
					        	<td><b>Date Form Completed</b></td>
					        	<td colspan="3"><input type="text" name="formcomplte_date" id="formcomplte_date" class="datepicker form-control validate[required, custom[date]]" autocomplete="off" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" /></td>
					        </tr>

						</table>

						<input type="submit" name="submit" class="btn btn-primary center-block" value="Submit" style="width: 40%;" />

					</div>

				</form>

			</div>

		</div>

	</div>

	<div class="col-sm-2 col-xs-12"></div>

	<div class="clearfix"></div>

</div>

@endsection