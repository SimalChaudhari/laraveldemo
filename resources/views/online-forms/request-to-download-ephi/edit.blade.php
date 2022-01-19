@extends('layouts.admin')

@section('page_title')
Edit: {{ ucwords( strtolower( 'Request to Download/Copy' ) ) }} EPHI
@endsection

@section('content')

<link rel="stylesheet" href="{{ asset('public/lib/datepickr/jquery-ui.css') }}" />
<script src="{{ asset('public/lib/datepickr/jquery-1.9.1.js') }}"></script>
<script src="{{ asset('public/lib/datepickr/jquery-ui.js') }}"></script>

<x-alert />

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">

    <div class="col-sm-2 col-xs-12"></div>

    <div class="col-sm-8 col-xs-12">

        <ol class="breadcrumb">
            <li><a href="javascript:;">HIPAA Container</a></li>
            <li><a href="{{ route('UI_allOnlineForms') }}">Online Forms</a></li>
            <li class="active">{{ ucwords( strtolower( 'Request to Download/Copy' ) ) }} EPHI</li>
        </ol>

        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title text-center">{{ ucwords( strtolower( 'Request to Download/Copy' ) ) }} EPHI</h3>
            </div>

            <div class="panel-body">

                <form name="requestToDownloadEphiForm" class="validateForm" method="POST" action="{{ route('ephi.update', $form->uuid) }}">

                    @csrf

                    <div class="row">

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Date</label>
                                <div class="input-group">
                                    <input type="text" name="cur_date" class="form-control datepicker validate[required, custom[date]]" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" autocomplete="off" value="{{ \Carbon\Carbon::parse( $form->cur_date )->format( config('app.VIEW_DATE_FORMAT') ) }}" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    @error('cur_date')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Person Making the Request{!! $required_field_html !!}</label>
                                <input type="text" name="person" class="form-control validate[required, maxSize[255]]" value="{{ $form->person }}" />
                                
                                @error('person')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Reason for download/copy of EPHI{!! $required_field_html !!}</label>
                                <input type="text" name="reason" class="form-control validate[required, maxSize[255]]" value="{{ $form->reason }}" />
                                
                                @error('reason')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12">

                            <p class="form-control-static">Minimum Necessary Disclosure: The Privacy Rule generally requires covered entities to take reasonable steps to limit the use or disclosure of, and requests for, protected health information to the mininium necessary to accomplish the intended purpose. The minimum necessary standard does not apply to the following:</p>

                            <ol>
                                <li>Disclosures to or requests by a health care provider for treatment purposes.</li>
                                <li>Disclosures to the individual who is the subject of the information.</li>
                                <li>Uses or disclosures made pursuant to an individual's authorization.</li>
                                <li>Uses or disclosures required for compliance with the Health Insurance Portability and Accountability Act (HIPAA) Administrative Simplification Rules.</li>
                                <li>Disclosures to the Department of Health and Human Services (IHIS) when disclosure of information is required under the Privacy Rule for enforcement purposes.</li>
                                <li>Uses or disclosures that are required by other law.</li>
                            </ol>

                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Description of Information to be Disclosed{!! $required_field_html !!}</label>
                                <textarea name="description" class="form-control validate[required]">{{ $form->description }}</textarea>
                                
                                @error('description')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Purpose of use or disclosure{!! $required_field_html !!}</label>
                                <textarea name="purpose" class="form-control validate[required]">{{ $form->purpose }}</textarea>
                                
                                @error('purpose')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Has the Minimum Necessary Standard Been Applied{!! $required_field_html !!}</label>
                                <select type="text" name="necessary" class="form-control validate[required]">
                                    <option value="">-----Select Option-----</option>
                                    <option value="Yes" <?php echo strtolower( $form->necessary ) == 'yes' ? 'selected' : '' ?>>Yes</option>
                                    <option value="no" <?php echo strtolower( $form->necessary ) == 'no' ? 'selected' : '' ?>>No</option>
                                </select>
                                
                                @error('necessary')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Approved By{!! $required_field_html !!}</label>
                                <input type="text" name="approve" class="form-control validate[required, maxSize[255]]" value="{{ $form->approve }}" />
                                
                                @error('approve')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Date</label>
                                <div class="input-group">
                                    <input type="text" name="app_date" class="form-control datepicker validate[required, custom[date]]" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" autocomplete="off" value="{{ \Carbon\Carbon::parse( $form->app_date )->format( config('app.VIEW_DATE_FORMAT') ) }}" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    @error('app_date')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Not approved due to the following{!! $required_field_html !!}</label>
                                <input type="text" name="not_approve" class="form-control validate[required, maxSize[255]]" value="{{ $form->not_approve }}" />
                                
                                @error('not_approve')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-xs-12">
                            <h2 style="text-align: center;">Chart Review Policy and Certification Requirement</h2>
                            <p style="text-align:justify;"><b>PROTECTING PATEINT PRIVACY</b> is a primary concern in our office. In accordance with HIPAA, Omnibus and our own internal policies and procedrres we have instituted the following policy to ensure the confidentiality of Protected Health Information (PHI) and Electronic Protected Health Irformation (ePHI).</p>
                            <p style="text-align:justify;">This policy addresses <u>Chart Reviews</u> or other operations where patient records are to be reviewed and/or removed from our office by business associates to our practice. HIPAA clearly states that our office is responsible for the actions of our business associates and that we must insure that the business associate properly protects PHI/epHI and is HIPAA compliant.</p>
                            <h3><b>Business Associate Agreement and Certification Required</b></h3>
                            <p style="text-align:justify;">An up-to-date Omnibus Business Associate Agreement must be in place before any business associate or their sub-contractor is allowed access to patient information. In addition, the business associate and any sub-contractor must submit Certification that the business associate(s) have 1 ) had a comprehensive risk assessment in the past year, 2) that all staff handling our PHI/ePHI has been trained on HIPAA protections and 3) that the business associate has a full set of policies and procedures for the HIPAA Privacy and Security Rule. Business associates without these requirements are deemed by the Office of Civil Rights to be in "willful neglect" and are not HIPAA compliant. Therefore for legal reasons and the protection of patient privacy business associates who cannot provide Certification of their HIPAA compliance will not be permitted to access patient records(PHI/ePHI). In addition, sub-contractors of our business associates must submit evidence that an Omnibus updated Business Associate Agreement with our Business Associate is in place.</p>
                            <h3><u><b>Only Encrypted Data (PHI/ePHI) Is Allowed To Be Taken Off-site</b></u></h3>
                            <p style="text-align:justify;">Our practice requires that all patient data that is taken out of our office in digital format must be
                                encrypted to Department of Defense (DOD) standards. Encryption is a "safe harbor" to the Breach
                                Notification Rule and greatly protects patient privacy. Our staff is instructed to verify that the media
                                device used for downloading of epHI is encrypted. In addition, the business associate or their sub-
                                contractor must provide certification that the media device is new or that the device has been scanned
                                for malware before we will allow the device to be connected to our network.
                                Paper records taken off-site must be in a closed secure container and kept in a locked vehicle and
                                hidden from sight.
                            </p>
                        </div>

                        <div class="col-sm-12 col-xs-12">
                            <h3>For office use only</h3>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Business Associate{!! $required_field_html !!}</label>
                                <input type="text" name="buss" class="form-control validate[required, maxSize[255]]" value="{{ $form->buss }}" />
                                
                                @error('buss')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Sub-Contractor{!! $required_field_html !!}</label>
                                <input type="text" name="sub" class="form-control validate[required, maxSize[255]]" value="{{ $form->sub }}" />
                                
                                @error('sub')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="agree" value="Yes" <?php echo strtolower($form->agree) == 'yes' ? 'checked' : '' ?> /> Business Associate Agreement In-Place with Business Associate
                                </label>
                                
                                @error('agree')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="sub_cont" value="Yes" <?php echo strtolower($form->sub_cont) == 'yes' ? 'checked' : '' ?> /> Sub-Contractor states They Have an omnibus BAA with the B.A.
                                </label>
                                
                                @error('sub_cont')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Portable Media Device Used to remove ePIH{!! $required_field_html !!}</label>
                                <input type="text" name="port" class="form-control validate[required, maxSize[255]]" value="{{ $form->port }}" />
                                
                                @error('port')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div class="col-sm-12 no-padding">
                                    <label>
                                        <input type="checkbox" name="device" value="Yes" <?php echo strtolower($form->device) == 'yes' ? 'checked' : '' ?> /> Business Associate stated Device is New or scanned for Malware
                                    </label>
                                    
                                    @error('device')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Encryption Method{!! $required_field_html !!}</label>
                                <input type="text" name="encry" class="form-control validate[required, maxSize[255]]" value="{{ $form->encry }}" />
                                
                                @error('encry')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div class="col-sm-12 col-xs-12 no-padding">
                                    <label>
                                        <input type="checkbox" name="encry_veri" value="Yes" <?php echo strtolower($form->encry_veri) == 'yes' ? 'checked' : '' ?> /> Encryption Verified
                                    </label>
                                    
                                    @error('encry_veri')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Number of patient Records Placed On Device{!! $required_field_html !!}</label>
                                <input type="text" name="records" class="form-control validate[required, maxSize[255]]" value="{{ $form->records }}" />
                                
                                @error('records')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>HIPAA Compliance Officer{!! $required_field_html !!}</label>
                                <input type="text" name="officer" class="form-control validate[required, maxSize[255]]" value="{{ $form->officer }}" />
                                
                                @error('officer')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Date</label>
                                <div class="input-group">
                                    <input type="text" name="sign_date" class="form-control datepicker validate[required, custom[date]]" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" autocomplete="off" value="{{ \Carbon\Carbon::parse( $form->sign_date )->format( config('app.VIEW_DATE_FORMAT') ) }}" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    @error('sign_date')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>

                    <input type="submit" name="update" class="btn btn-custom-primary center-block" value="Update" style="width: 40%;" />

                </form>

            </div>

        </div>

    </div>

    <div class="col-sm-2 col-xs-12"></div>

    <div class="clearfix"></div>
    
</div>

@endsection