<div class="panel panel-default">

	<div class="panel-heading">
		<h3 class="panel-title text-center">{{ ucwords( strtolower( 'AUTHORIZATION TO USE AND/ORDISCLOSE MEDICAL RECORDS FORM' ) ) }}</h3>
	</div>

	<div class="panel-body">
		
		<form class="form-horizontal">

			<div class="row">

				<div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>NAME OF PATIENT</label>
                        <p class="form-control-static">{{ $form->name }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>SS#{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->ss }}</p>
                    </div>
                </div>

            	<h5><strong>TO: (Name, Address. Phone of Recipient of Records)</strong></h5>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Name{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->rec_name }}"</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Phone{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->rec_phone }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Address{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->rec_address }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>City{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->rec_city }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>State{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->rec_state }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Zip{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->rec_zip }}</p>
                    </div>
                </div>

            	<h5><strong>RECORDS FROM (Who is <strong>Releasing</strong> the Records):</strong></h5>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Name{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->from_name }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Phone{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->from_phone }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Address{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->from_address }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>City{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->from_city }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>State{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->from_state }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Zip{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->from_zip }}</p>
                    </div>
                </div>

                <div class="col-sm-12 col-xs-12">
                	<div class="form-group">
                        <label>For the Following Purposes{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->purposes }}</p>
                    </div>
                </div>

                <div class="col-sm-12 col-xs-12">
                	<div class="form-group">
                        <label>By Checking the Boxes Below, I Specifically Authorize the Use and/or Disclosure of the Following Health Information And/or Medical Records, If Such Information And/or Records Exist{!! $required_field_html !!}</label>
                        <?php
                        $form_authorize = '';
                        switch( $form->authorize ) {
                            case 'medical_records': $form_authorize = 'Please send the entire Medical Record (all information) to the above named recipient'; break;
                            case 'office_notes': $form_authorize = 'Office Notes and Reports'; break;
                            case 'most_recent_one': $form_authorize = 'Most recent one year history'; break;
                            case 'most_recent_three': $form_authorize = 'Most recent three-year history'; break;
                            case 'rx_history': $form_authorize = 'Rx History'; break;
                            case 'transcribed_reports': $form_authorize = 'Transcribed hospital reports'; break;
                            case 'laboratory_reports': $form_authorize = 'Laboratory reports'; break;
                            case 'billing_statements': $form_authorize = 'Billing Statements'; break;
                            case 'diagnostic_reports': $form_authorize = 'Diagnostic Reports'; break;
                            case 'diagrostic_films': $form_authorize = 'Diagrostic Films'; break;
                        }
                        ?>
                        <p class="form-control-static">{{ $form_authorize }}</p>
                    </div>
                </div>

                <div class="col-sm-12 col-xs-12">
                	<div class="form-group">
                		<label>The Following Items Must Be Initialed to Be Included in the Use And/or Disclosure</label>
                		<div class="checkbox">
                			<label>
                				<input type="checkbox" name="hiv_aids" value="Yes" <?php echo $form->hiv_aids == 'Yes' ? 'checked' : '' ?> /> HIV/AIDS relate information and/or records IIBV, TB or Other Communicable Diseases
                			</label>
                		</div>
                		<div class="checkbox">
                			<label>
                				<input type="checkbox" name="mental_health" value="Yes" <?php echo $form->mental_health == 'Yes' ? 'checked' : '' ?> /> Mental Health Information and/or Records
                			</label>
                		</div>
                		<div class="checkbox">
                			<label>
                				<input type="checkbox" name="domestic" value="Yes" <?php echo $form->domestic == 'Yes' ? 'checked' : '' ?> /> Domestic Violence
                			</label>
                		</div>
                		<div class="checkbox">
                			<label>
                				<input type="checkbox" name="genetic_test" value="Yes" <?php echo $form->genetic_test == 'Yes' ? 'checked' : '' ?> /> Genetic Testing Information and/or records
                			</label>
                		</div>
                		<div class="checkbox">
                			<label>
                				<input type="checkbox" name="drug_alcohol" value="Yes" <?php echo $form->drug_alcohol == 'Yes' ? 'checked' : '' ?> /> Drug/Alcohol diagnosis, treatment or referral information (Federal regulations require a description of how much and what kind of information is to be disclosed.) Describe:
                			</label>
                		</div>
                	</div>
                </div>

                <hr />

                <p style="text-align:justify;"><b>I understand</b> that, if the person or entity receiving the information is not a health care provider or health plan covered by federal privacy regulations, the information described above may be re-disclosed and no longer protected by HIPPA and other federal and state regulations. However, the recipient may be prohibited from disclosing substance abuse information under the Federal Substance Abuse Confidentiality Requirements.
			    </p>
			    <p style="text-align:justify;"><b>I also understand</b> that the person I am authorizing to use and/or disclose the information may not receive compensation for doing so.</p>
			    <p style="text-align:justify;"><b>I, further understand</b> that I may refuse to sign this authorization and that my refusal to sign will not affect my ability to obtain treatment or payment of my eligibility for benefits. I may inspect or copy any information to be used and/or disclosed under this authorization.
			        <b>Finally, I understand</b> that <u><b>I may revoke this autliorization</b></u>,in writing, at any time, provided that I do so in writing, except to the extent that action has been taken in reliance upon this authorization. Unless Revoked Earlier, this Authorization Will Expire in Six (6) Months
			        from the Date of Signing or until (Insert Date): <u>{{ \Carbon\Carbon::parse( $form->insert_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</u>
			    </p>

                <div class="col-sm-6 col-xs-6">
                	<div class="form-group">
                		<label>Print Patient's Name</label>
                		<p class="form-control-static">{{ $form->pat_name }}</p>
                	</div>
                </div>

                <div class="col-sm-6 col-xs-6">
                	<div class="form-group">
                		<label>Date</label>
                		<p class="form-control-static">{{ \Carbon\Carbon::parse( $form->date )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
                	</div>
                </div>

                <div class="col-sm-6 col-xs-6">
                	<div class="form-group">
                		<label>Signature of patient or Patient's Legal Representative</label>
                		<p class="form-control-static">{{ $form->pat_sign }}</p>
                	</div>
                </div>

                <div class="col-sm-6 col-xs-6">
                	<div class="form-group">
                		<label>Print Name of Legal Representative (if applicable)</label>
                		<p class="form-control-static">{{ $form->pat_legal }}</p>
                	</div>
                </div>

                <div class="col-sm-6 col-xs-6">
                	<div class="form-group">
                		<label>Relationship to patient</label>
                		<p class="form-control-static">{{ $form->pat_rel }}</p>
                	</div>
                </div>

            </div>

		</form>

	</div>

</div>