@extends('layouts.admin')

@section('page_title')
Create: {{ ucwords( strtolower( 'AUTHORIZATION TO USE AND/OR DISCLOSE MEDICAL RECORDS FORM' ) ) }}
@endsection

@section('content')

<link rel="stylesheet" href="{{ asset('public/lib/datepickr/jquery-ui.css') }}" />
<script src="{{ asset('public/lib/datepickr/jquery-1.9.1.js') }}"></script>
<script src="{{ asset('public/lib/datepickr/jquery-ui.js') }}"></script>

<!-- this, preferably, goes inside head element: -->
<!--[if lt IE 9]>
<script type="text/javascript" src="{{ asset('public/lib/jSignature/flashcanvas.js') }}"></script>
<![endif]-->

<script src="{{ asset('public/lib/jSignature/jSignature.min.js') }}"></script>

<x-alert />

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">
    
    <div class="col-sm-2 col-xs-12"></div>

    <div class="col-sm-8 col-xs-12">

        <ol class="breadcrumb">
            <li><a href="javascript:;">Document Library</a></li>
            <li class="active">{{ ucwords( strtolower( 'AUTHORIZATION TO USE AND/OR DISCLOSE MEDICAL RECORDS FORM' ) ) }}</li>
        </ol>
        
    	<div class="panel panel-default">

    		<div class="panel-heading">
    			<h3 class="panel-title text-center">{{ ucwords( strtolower( 'AUTHORIZATION TO USE AND/OR DISCLOSE MEDICAL RECORDS FORM' ) ) }} <a href="{{ route('authorize-user-and-disclosure.index') }}" class="btn btn-custom-danger btn-xs pull-right">&laquo; Back</a></h3>
    		</div>

    		<div class="panel-body">
    			
    			<form class="validateForm" name="authorizeUseDisclosureForm" method="POST" action="{{ route('authorize-user-and-disclosure.store') }}">
    				@csrf

    				<div class="row">

    					<div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>NAME OF PATIENT</label>
                                <input type="text" name="name" class="form-control validate[required, maxSize[255]]" />
                                @error('name')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>SS#{!! $required_field_html !!}</label>
                                <input type="text" name="ss" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('ss')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-xs-12">
                        	<h5>TO: (Name, Address. Phone of Recipient of Records)</h5>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Name{!! $required_field_html !!}</label>
                                <input type="text" name="rec_name" class="form-control validate[required, maxSize[255]]" />
                                @error('rec_name')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Phone{!! $required_field_html !!}</label>
                                <input type="text" name="rec_phone" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('rec_phone')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Address{!! $required_field_html !!}</label>
                                <input type="text" name="rec_address" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('rec_address')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>City{!! $required_field_html !!}</label>
                                <input type="text" name="rec_city" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('rec_city')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>State{!! $required_field_html !!}</label>
                                <input type="text" name="rec_state" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('rec_state')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Zip{!! $required_field_html !!}</label>
                                <input type="text" name="rec_zip" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('rec_state')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-xs-12">
                        	<h5>RECORDS FROM (Who is <strong>Releasing</strong> the Records):</h5>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Name{!! $required_field_html !!}</label>
                                <input type="text" name="from_name" class="form-control validate[required, maxSize[255]]" />
                                @error('from_name')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Phone{!! $required_field_html !!}</label>
                                <input type="text" name="from_phone" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('from_phone')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Address{!! $required_field_html !!}</label>
                                <input type="text" name="from_address" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('from_address')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>City{!! $required_field_html !!}</label>
                                <input type="text" name="from_city" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('from_city')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>State{!! $required_field_html !!}</label>
                                <input type="text" name="from_state" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('from_state')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Zip{!! $required_field_html !!}</label>
                                <input type="text" name="from_zip" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('from_zip')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-xs-12">
                        	<div class="form-group">
                                <label>For the Following Purposes{!! $required_field_html !!}</label>
                                <select type="text" name="purposes" class="form-control validate[required]">
    			                    <option value="">-----Select Option-----</option>
    			                    <option value="Continued Medical Care">Continued Medical Care</option>
    			                    <option value="Personal Information">Personal Information</option>
    			                    <option value="Legal Follow-up">Legal Follow-up</option>
    			                    <option value="Disability Insurance">Disability Insurance</option>
    			                </select>
                                
                                @error('purposes')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-xs-12">
                        	<div class="form-group">
                                <label>By Checking the Boxes Below, I Specifically Authorize the Use and/or Disclosure of the Following Health Information And/or Medical Records, If Such Information And/or Records Exist{!! $required_field_html !!}</label>
                                <select type="text" name="authorize" class="form-control validate[required]">
    			                    <option value="">-----Select Option-----</option>
    			                    <option value="medical_records">Please send the entire Medical Record (all information) to the above named recipient</option>
    			                    <option value="office_notes">Office Notes and Reports</option>
    			                    <option value="most_recent_one">Most recent one year history</option>
    			                    <option value="most_recent_three">Most recent three-year history</option>
    			                    <option value="rx_history">Rx History</option>
    			                    <option value="transcribed_reports">Transcribed hospital reports</option>
    			                    <option value="laboratory_reports">Laboratory reports</option>
    			                    <option value="billing_statements">Billing Statements</option>
    			                    <option value="diagnostic_reports">Diagnostic Reports</option>
    			                    <option value="diagrostic_films">Diagrostic Films</option>
    			                </select>
                                
                                @error('authorize')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-xs-12">
                        	<div class="form-group">
                        		<label>The Following Items Must Be Initialed to Be Included in the Use And/or Disclosure</label>
                        		<div class="checkbox">
                        			<label>
                        				<input type="checkbox" name="hiv_aids" value="Yes" /> HIV/AIDS relate information and/or records IIBV, TB or Other Communicable Diseases
                        			</label>
                        		</div>
                        		<div class="checkbox">
                        			<label>
                        				<input type="checkbox" name="mental_health" value="Yes" /> Mental Health Information and/or Records
                        			</label>
                        		</div>
                        		<div class="checkbox">
                        			<label>
                        				<input type="checkbox" name="domestic" value="Yes" /> Domestic Violence
                        			</label>
                        		</div>
                        		<div class="checkbox">
                        			<label>
                        				<input type="checkbox" name="genetic_test" value="Yes" /> Genetic Testing Information and/or records
                        			</label>
                        		</div>
                        		<div class="checkbox">
                        			<label>
                        				<input type="checkbox" name="drug_alcohol" value="Yes" /> Drug/Alcohol diagnosis, treatment or referral information (Federal regulations require a description of how much and what kind of information is to be disclosed.) Describe:
                        			</label>
                        		</div>
                        	</div>
                        </div>

                        <hr />

                        <div class="col-sm-12 col-xs-12">
                        	<p style="text-align:justify;"><b>I understand</b> that, if the person or entity receiving the information is not a health care provider or health plan covered by federal privacy regulations, the information described above may be re-disclosed and no longer protected by HIPPA and other federal and state regulations. However, the recipient may be prohibited from disclosing substance abuse information under the Federal Substance Abuse Confidentiality Requirements.
    					    </p>
    					    <p style="text-align:justify;"><b>I also understand</b> that the person I am authorizing to use and/or disclose the information may not receive compensation for doing so.</p>
    					    <p style="text-align:justify;"><b>I, further understand</b> that I may refuse to sign this authorization and that my refusal to sign will not affect my ability to obtain treatment or payment of my eligibility for benefits. I may inspect or copy any information to be used and/or disclosed under this authorization.
    					        <b>Finally, I understand</b> that <u><b>I may revoke this autliorization</b></u>,in writing, at any time, provided that I do so in writing, except to the extent that action has been taken in reliance upon this authorization. Unless Revoked Earlier, this Authorization Will Expire in Six (6) Months
    					        from the Date of Signing or until (Insert Date): <input type="text" name="insert_date" class="datepicker validate[required, custom[date]]" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" autocomplete="off" />
    					    </p>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                        	<div class="form-group">
                        		<label>Print Patient's Name</label>
                        		<input type="text" name="pat_name" class="form-control validate[required, maxSize[255]]" />

                        		@error('pat_name')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                        	</div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                        	<div class="form-group">
                        		<label>Date</label>
                        		<input type="text" name="date" class="form-control datepicker validate[required, custom[date]]" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" autocomplete="off" />

                        		@error('date')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                        	</div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                        	<div class="form-group">
                        		<label>Signature of patient or Patient's Legal Representative</label>
                        		<input type="text" name="pat_sign" class="form-control validate[required, maxSize[255]]" />

                        		@error('pat_sign')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                        	</div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                        	<div class="form-group">
                        		<label>Print Name of Legal Representative (if applicable)</label>
                        		<input type="text" name="pat_legal" class="form-control validate[required, maxSize[255]]" />

                        		@error('pat_legal')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                        	</div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                        	<div class="form-group">
                        		<label>Relationship to patient</label>
                        		<input type="text" name="pat_rel" class="form-control validate[required, maxSize[255]]" />

                        		@error('pat_rel')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                        	</div>
                        </div>

                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="col-sm-1 col-xs-12">Signature:<a class="clear_signature_pad" data-signature_div_id="authorize_signature_pad" style="cursor: pointer;">(Clear)</a></label>
                                <div class="col-sm-8 col-xs-12">
                                    <div id="authorize_signature_pad"></div>
                                </div>

                                <input type="hidden" name="signature_str_svg" id="authorize_signature_svg" />
                                <input type="hidden" name="signature_str_base" id="authorize_signature_base" />
                            </div>
                        </div>

                    </div>

                    <input type="submit" name="submit" class="btn btn-custom-primary center-block" value="Submit" style="width: 40%;" />

    			</form>

    		</div>

    	</div>

    </div>


    <div class="col-sm-2 col-xs-12"></div>

    <div class="clearfix"></div>

</div>

@endsection