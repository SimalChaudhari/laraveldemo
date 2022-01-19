<div class="panel panel-default">

	<div class="panel-heading">
		<h3 class="panel-title text-center">Employee Termination Form</h3>
	</div>

	<div class="panel-body">

		<p class="col-sm-12 col-xs-12 text-right" style="padding-right: 0;"><small>({!! $required_field_html !!}) fields are mandatory.</small></p>

		<div class="clearfix"></div>

		<form>

			<div class="form-group">
				<label>Name of Practice</label>
				<p class="form-control-static">{{ $form->name_practice }}</p>
			</div>

			<div class="form-group">
				<label>Name of Employee</label>
				<p class="form-control-static">{{ $form->name_employee }}</p>
			</div>

			<div class="form-group">
				<label>Reason For Termination</label>
				<p class="form-control-static">{{ $form->rsn_termination }}</p>
			</div>

			<div class="form-group">
				<div class="checkbox">
					<label>
						<input type="checkbox"  name="termination_vol" value="Yes" <?php echo $form->termination_vol == 'Yes' ? 'checked' : ''; ?> /> Termination voluntary
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="termination_force" value="Yes" <?php echo $form->termination_force == 'Yes' ? 'checked' : ''; ?> /> Termination Forced
					</label>
				</div>
				
			</div>

			<div class="form-group">
				<label>Did the Employee Have Administrator Access?</label>
				<p class="form-control-static">{{ $form->admin_access }}</p>
			</div>

			<div class="form-group">
				<label>Windows Log-in Account Terminated</label>
				<p class="form-control-static">{{ \Carbon\Carbon::parse( $form->windowacc_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
			</div>

			<div class="form-group">
				<label>Practice Management Log-ln Account Terminated</label>
				<p class="form-control-static">{{ \Carbon\Carbon::parse( $form->practiceacc_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
			</div>

			<div class="form-group">
				<label>EHR Log-ln Account Terminated</label>
				<p class="form-control-static">{{ \Carbon\Carbon::parse( $form->ehracc_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
			</div>

			<div class="form-group">
				<label>Key(s) to facility has been returned</label>
				<p class="form-control-static">{{ $form->keys_facility }}</p>
			</div>

			<div class="form-group">
				<label>Employee Individual security Entry code Deactivated?</label>
				<p class="form-control-static">{{ $form->security_entry }}</p>
			</div>

			<div class="form-group">
				<label>If code for entry is the same for all employees, has the access code been changed?</label>
				<p class="form-control-static">{{ $form->code_for_entry }}</p>
			</div>

			<div class="form-group">
				<label>If the employee had a laptop computer or other mobile device has it been returned?</label>
				<p class="form-control-static">{{ $form->device }}</p>
			</div>

			<div class="form-group">
				<label>Did the employee have any patient information accessible from a cell phone?</label>
				<p class="form-control-static">{{ $form->patient_info }}</p>
			</div>

			<div class="form-group">
				<label>If above answer is yes, has all patient information been deleted from the device?</label>
				<p class="form-control-static">{{ $form->patient_info_dlt }}</p>
			</div>

			<div class="form-group">
				<label>Has the password been changed for the employee's company email account?</label>
				<p class="form-control-static">{{ $form->email_pass }}</p>
			</div>

			<div class="form-group">
				<label>Notes about this termination</label>
				<p class="form-control-static">{{ $form->notes }}</p>
			</div>

			<div class="form-group">
				<label>Form Completed By</label>
				<p class="form-control-static">{{ $form->form_name }}</p>
			</div>

			<div class="form-group">
				<label>Title</label>
				<p class="form-control-static">{{ $form->form_title }}</p>
			</div>

			<div class="form-group">
				<label>Date Form Completed</label>
				<p class="form-control-static">{{ \Carbon\Carbon::parse( $form->formcomplte_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
			</div>

		</form>

	</div>

</div>