@extends('layouts.admin')

@section('page_title')
Edit: {{ ucwords( strtolower( 'BUSINESS ASSOCIATE/VENDOR TERMINATION FORM' ) ) }}
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
            <li class="active">{{ ucwords( strtolower( 'BUSINESS ASSOCIATE/VENDOR TERMINATION FORM' ) ) }}</li>
        </ol>

        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title text-center">{{ ucwords( strtolower( 'BUSINESS ASSOCIATE/VENDOR TERMINATION FORM' ) ) }}</h3>
            </div>

            <div class="panel-body">

                <form name="businessAssociateVendorForm" class="validateForm" action="{{ route('bba.update', $form->uuid) }}" method="POST">

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
                                <label>Vendor{!! $required_field_html !!}</label>
                                <input type="text" name="vendor" class="form-control validate[required, maxSize[255]]" value="{{ $form->vendor }}" />
                                
                                @error('vendor')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Reason for Termination{!! $required_field_html !!}</label>
                                <input type="text" name="reason" class="form-control validate[required, maxSize[255]]" value="{{ $form->reason }}" />
                                
                                @error('reason')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Date Computer Access Terminated{!! $required_field_html !!}</label>
                                <div class="input-group">
                                    <input type="text" name="ter_date" class="form-control datepicker validate[required, custom[date]]" value="{{ \Carbon\Carbon::parse( $form->ter_date )->format( config('app.VIEW_DATE_FORMAT') ) }}" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" autocomplete="off" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    
                                    @error('ter_date')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Key(s), key card or other access devices returned on{!! $required_field_html !!}</label>
                                <input type="text" name="key_card" class="form-control validate[required, maxSize[255]]" value="{{ $form->key_card }}"  />
                                
                                @error('key_card')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Notes{!! $required_field_html !!}</label>
                                <textarea name="notes" required class="form-control validate[required]">{{ $form->notes }}</textarea>
                                
                                @error('key_card')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Signature Field{!! $required_field_html !!}</label>
                                <input type="text" name="sign" class="form-control validate[required, maxSize[255]]" value="{{ $form->sign }}" />
                                
                                @error('sign')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Date{!! $required_field_html !!}</label>
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