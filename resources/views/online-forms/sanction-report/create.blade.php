@extends('layouts.admin')

@section('page_title')
Create: {{ ucwords( strtolower( 'SANCTION REPORT FORM' ) ) }}
@endsection

@section('content')

<link rel="stylesheet" href="{{ asset('public/lib/datepickr/jquery-ui.css') }}" />
<script src="{{ asset('public/lib/datepickr/jquery-1.9.1.js') }}"></script>
<script src="{{ asset('public/lib/datepickr/jquery-ui.js') }}"></script>

<style type="text/css">
    label {
        font-size: 13px;
    }
</style>

<x-alert />

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">

    <div class="col-sm-2 col-xs-12"></div>

    <div class="col-sm-8 col-xs-12">

        <ol class="breadcrumb">
            <li><a href="javascript:;">HIPAA Container</a></li>
            <li><a href="{{ route('UI_allOnlineForms') }}">Online Forms</a></li>
            <li class="active">{{ ucwords( strtolower( 'SANCTION REPORT FORM' ) ) }}</li>
        </ol>
        
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title text-center">{{ ucwords( strtolower( 'SANCTION REPORT FORM' ) ) }}</h3>
            </div>

            <div class="panel-body">

                <form name="sanctionReportForm" class="validateForm" method="POST" action="{{ route('saveSanctionsForm') }}">

                    @csrf

                    <div class="row">
                        
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Date of Report{!! $required_field_html !!}</label>
                                <div class="input-group">
                                    <input type="text" name="rep_date" class="form-control datepicker validate[required, custom[date]]" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" autocomplete="off" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    @error('rep_date')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Date Violation/Incident Discovered{!! $required_field_html !!}</label>
                                <div class="input-group">
                                    <input type="text" name="vio_date" class="form-control datepicker validate[required, custom[date]]" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" autocomplete="off" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    @error('vio_date')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Individual or Organization Receiving Sanction{!! $required_field_html !!}</label>
                                <input type="text" name="org" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('org')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Job Title or Description of Duties{!! $required_field_html !!}</label>
                                <input type="text" name="job" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('job')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Method Violation was Discovered{!! $required_field_html !!}</label>
                                <input type="text" name="method" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('method')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Description of Violation/Incident{!! $required_field_html !!}</label>
                                <textarea name="descr" class="form-control validate[required, maxSize[255]]"></textarea>
                                
                                @error('descr')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Group I Offense{!! $required_field_html !!}</label>
                                <input type="text" name="grp1" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('grp1')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Group II Offense{!! $required_field_html !!}</label>
                                <input type="text" name="grp2" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('grp2')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Group III: Willful and/or intentional disclosure of PHI or records{!! $required_field_html !!}</label>
                                <input type="text" name="grp3" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('grp3')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Sanction Applied{!! $required_field_html !!}</label>
                                <input type="text" name="sanct" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('sanct')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Additional Information on Sanction Applied:{!! $required_field_html !!}</label>
                                <textarea name="add_info" class="form-control validate[required]"></textarea>
                                
                                @error('add_info')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <p class="form-control-static">This is a <input type="text" name="type_of" class="validate[required]" /> Sanction</p>
                            </div>
                        </div>

                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <p class="form-control-static">Employee/Organization will be on <input type="text" name="field1" class="validate[required]" />. for a period of: <input type="text" name="field2" class="validate[required]" />.</p>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <h3><u>FACTORS USED IN DETERMINING SANCTION APPLIED</u></h3>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Did the Violation/Incident Cause a Breach of patient Information (PHI)?{!! $required_field_html !!}</label>
                                <input type="text" name="breach" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('breach')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>The Violation/Incident was determined to be{!! $required_field_html !!}</label>
                                <input type="text" name="deter" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('deter')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Did the Violation/Incident Involve Malice or Personal Gain?{!! $required_field_html !!}</label>
                                <input type="text" name="involve" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('involve')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>First Offense or Multiple Violations of the Same Type{!! $required_field_html !!}</label>
                                <input type="text" name="offence" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('offence')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Individual/Organization had been Trained and Understood the Policy{!! $required_field_html !!}</label>
                                <input type="text" name="train" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('train')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>COMMENTS{!! $required_field_html !!}</label>
                                <textarea name="comments" class="form-control validate[required]"></textarea>
                                
                                @error('comments')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Report Completed By (Name & Title){!! $required_field_html !!}</label>
                                <input type="text" name="report" class="form-control validate[required, maxSize[255]]" />
                                
                                @error('report')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
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