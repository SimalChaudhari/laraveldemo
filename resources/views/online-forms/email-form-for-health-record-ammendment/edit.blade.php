@extends('layouts.admin')

@section('page_title')
Edit: {{ ucwords( strtolower( 'EMAIL FORM FOR HEALTH RECORD AMMENDMENT' ) ) }}
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
            <li class="active">{{ ucwords( strtolower( 'EMAIL FORM FOR HEALTH RECORD AMMENDMENT' ) ) }}</li>
        </ol>
        
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title text-center">{{ ucwords( strtolower( 'EMAIL FORM FOR HEALTH RECORD AMMENDMENT' ) ) }}</h3>
            </div>

            <div class="panel-body">

                <form name="emailFormForHealthRecordAmmendment" class="validateForm" method="POST" action="{{ route('ammendment.update', $form->uuid) }}">

                    @csrf

                    <div class="row">
                        
                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Date{!! $required_field_html !!}</label>
                                <div class="input-group">
                                    <input type="text" name="cur_date" class="form-control datepicker validate[required, custom[date]]" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" autocomplete="off" value="{{ \Carbon\Carbon::parse( $form->cur_date )->format( config('app.VIEW_DATE_FORMAT') ) }}" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    @error('cur_date')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>First Name{!! $required_field_html !!}</label>
                                <input type="text" name="f_name" class="form-control validate[required, maxSize[255]]" value="{{ $form->f_name }}" />
                                @error('f_name')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Last Name{!! $required_field_html !!}</label>
                                <input type="text" name="l_name" class="form-control validate[required, maxSize[255]]" value="{{ $form->l_name }}" />
                                
                                @error('l_name')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Address 1{!! $required_field_html !!}</label>
                                <input type="text" name="address1" class="form-control validate[required, maxSize[255]]" value="{{ $form->address1 }}" />
                                
                                @error('address1')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Address 2{!! $required_field_html !!}</label>
                                <input type="text" name="address2" class="form-control validate[required, maxSize[255]]" value="{{ $form->address2 }}" />
                                
                                @error('address2')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>City{!! $required_field_html !!}</label>
                                <input type="text" name="city" class="form-control validate[required, maxSize[255]]" value="{{ $form->city }}" />
                                
                                @error('city')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>State{!! $required_field_html !!}</label>
                                <input type="text" name="state" class="form-control validate[required, maxSize[255]]" value="{{ $form->state }}" />
                                
                                @error('state')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Zip{!! $required_field_html !!}</label>
                                <input type="text" name="zip" class="form-control validate[required, maxSize[255]]" value="{{ $form->zip }}" />
                                
                                @error('zip')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>  

                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="col-sm-2 col-xs-12 control-label no-padding">Dear(Patient Name){!! $required_field_html !!}</label>
                                <div class="col-sm-4 col-x-12">
                                    <input type="text" name="pat_name" class="form-control validate[required, maxSize[255]]" value="{{ $form->pat_name }}" />
                                    
                                    @error('pat_name')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <h4><b>Re: Request to Amend Health Information</b></h4>
                            <p>Dear Ms. Doe:</p>
                            <p style="text-align:justify;">This letter responds to your request that we amend your health information, which we received
                                from you on <input type="text" name="last_date" class="datepicker validate[required, custom[date]]" value="{{ \Carbon\Carbon::parse( $form->last_date )->format( config('app.VIEW_DATE_FORMAT') ) }}" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" autocomplete="off" />. We agree to make the amendment that you have requested. Your records will be updated accordingly.
                            </p>
                            <p style="text-align:justify;">If you agree, we will also notify other persons or organizations about this amendment that may rely on the original (un-amended) information they currently have in a way that may negatively affect you. In addition, we will notify other persons or organizations that you identify that may have the original (un-amended) health information.</p>
                            <p style="text-align:justify;">Please contact the manager of the specific clinic if you would like us to notify these other persons or organizations for you. As always, we are committed to helping you assure that the information about you is kept accurate. Thank you for your assistance  and patience in helping us achieve this goal.</p>
                            <p>Sincerely,</p>
                            <input type="text" name="app_name" value="{{ $form->app_name }}" class="validate[required, maxSize[255]]" />
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