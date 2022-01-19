@extends('layouts.admin')

@section('page_title')
Edit: {{ ucwords( strtolower( 'EMAIL FORM FOR ACCESS TO HEALTH RECORD' ) ) }}
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
            <li class="active">{{ ucwords( strtolower( 'EMAIL FORM FOR ACCESS TO HEALTH RECORD' ) ) }}</li>
        </ol>

        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title text-center">{{ ucwords( strtolower( 'EMAIL FORM FOR ACCESS TO HEALTH RECORD' ) ) }}</h3>
            </div>

            <div class="panel-body">

                <form name="emailFormForAccessToHealthRecordForm" class="validateForm" method="POST" action="{{ route('email-for-access-health.update', $form->uuid) }}">

                    @csrf

                    <div class="row">

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Date</label>
                                <div class="input-group">
                                    <input type="text" name="date" class="form-control datepicker validate[required, custom[date]]" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" autocomplete="off" value="{{ \Carbon\Carbon::parse( $form->date )->format( config('app.VIEW_DATE_FORMAT') ) }}" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    @error('date')
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
                                <input type="text" name="zip" class="form-control validate[required, maxSize[6]]" value="{{ $form->zip }}" />
                                
                                @error('zip')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-xs-12"> 
                            <h4><b>Re: Request for Access To Health Information</b></h4>
                            <p>Dear Ms. Doe:</p>
                            <p style="text-align:justify;">This letter responds to your request for access to your health information, which we received from you on <input type="text" name="req_name" class="datepicker" value="{{ \Carbon\Carbon::parse( $form->req_name )->format( config('app.VIEW_DATE_FORMAT') ) }}" class="validate[required, custom[date]]" />. We have determined that the following fees will apply if weprocess your request:</p>
                            <ul style="list-style-type: none;">
                                <li>A fee of $<input type="text" name="summary_charge" value="{{ $form->summary_charge }}" class="validate[required]" size="10"/> will be charged to prepare a summary of the information for you.</li>
                                </br>
                                <li>A fee of $<input type="text" name="explanation_charge" class="validate[required]" value="{{ $form->explanation_charge }}" size="10"/> will be charged to prepare an explanation of the information for you.</li>
                                </br>
                                <li>A fee of $<input type="text" name="expedited_charge" class="validate[required]" size="10" value="{{ $form->expedited_charge }}" /> will be charged for expedited request.</li>
                            </ul>
                            <p>We want you to know that you have the following options:</p>
                            <ul>
                                <li>You may ask us to proceed with your request and pay the fee provided in this letter.</li>
                                <li>You may modify your request and reduce the applicable fee.</li>
                                <li>You may withdraw your request and pay no fee.</li>
                            </ul>
                            <p style="text-align:justify;">Please contact [insert name, address and telephone number of responsible person] to discuss your preferences and arrange for payment of any applicable fees. If we do not hear from you within 60 days, we will assume that you have decided to withdraw your request</p>
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