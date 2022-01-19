@extends('layouts.admin')

@section('page_title')
Edit: {{ ucwords( strtolower( 'MEDIA DESTRUCTION AND/OR REUSE FORM' ) ) }}
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
            <li class="active">{{ ucwords( strtolower( 'MEDIA DESTRUCTION AND/OR REUSE FORM' ) ) }}</li>
        </ol>

        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title text-center">{{ ucwords( strtolower( 'MEDIA DESTRUCTION AND/OR REUSE FORM' ) ) }}</h3>
            </div>

            <div class="panel-body">

                <form name="mediaDestructionAndReuseForm" class="validateForm" method="POST" action="{{ route('media.update', $form->uuid) }}">

                    @csrf

                    <div class="row">
                        
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Organization{!! $required_field_html !!}</label>
                                <input type="text" name="org" class="form-control validate[required, maxSize[255]]" value="{{ $form->org }}" />

                                @error('org')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Is device to be reused or destroyed?{!! $required_field_html !!}</label>
                                <input type="text" name="device" class="form-control validate[required, maxSize[255]]" value="{{ $form->device }}" />

                                @error('device')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Media Removed From{!! $required_field_html !!}</label>
                                <input type="text" name="media" class="form-control validate[required, maxSize[255]]" value="{{ $form->media }}" />
                                
                                @error('media')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Location{!! $required_field_html !!}</label>
                                <input type="text" name="loca" class="form-control validate[required, maxSize[255]]" value="{{ $form->loca }}" />
                                
                                @error('loca')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Item Description{!! $required_field_html !!}</label>
                                <input type="text" name="item_desc" class="form-control validate[required, maxSize[255]]" value="{{ $form->item_desc }}" />
                                
                                @error('item_desc')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Make/Model{!! $required_field_html !!}</label>
                                <input type="text" name="model" class="form-control validate[required, maxSize[255]]" value="{{ $form->model }}" />
                                
                                @error('model')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Serial Number{!! $required_field_html !!}</label>
                                <input type="text" name="serial" class="form-control validate[required, maxSize[255]]" value="{{ $form->serial }}" />
                                
                                @error('serial')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Asset ID{!! $required_field_html !!}</label>
                                <input type="text" name="asset" class="form-control validate[required, maxSize[255]]" value="{{ $form->asset }}" />
                                
                                @error('asset')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Backup Made of Information/Data?{!! $required_field_html !!}</label>
                                <select name="backup" class="form-control validate[required]">
                                    <option selected="" value="">-----Select Option-----</option>
                                    <option value="yes" <?php echo strtolower($form->backup) == 'yes' ? 'selected' : '' ?>>Yes</option>
                                    <option value="no" <?php echo strtolower($form->backup) == 'no' ? 'selected' : '' ?>>No</option>
                                </select>
                                
                                @error('backup')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>If Yes, Backup Location{!! $required_field_html !!}</label>
                                <input type="text" name="backup_loc" class="form-control validate[required, maxSize[255]]" value="{{ $form->backup_loc }}" />
                                
                                @error('backup_loc')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Item Description{!! $required_field_html !!}</label>
                                <input type="text" name="descri" class="form-control validate[required, maxSize[255]]" value="{{ $form->descri }}" />
                                
                                @error('descri')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Date Conducted{!! $required_field_html !!}</label>
                                <div class="input-group">
                                    <input type="text" name="con_date" class="form-control datepicker validate[required, custom[date]]" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" autocomplete="off" value="{{ \Carbon\Carbon::parse( $form->con_date )->format( config('app.VIEW_DATE_FORMAT') ) }}" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                                @error('con_date')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Conducted By{!! $required_field_html !!}</label>
                                <input type="text" name="cond" class="form-control validate[required, maxSize[255]]" value="{{ $form->cond }}" />
                                
                                @error('cond')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Validated By{!! $required_field_html !!}</label>
                                <input type="text" name="vali" class="form-control validate[required, maxSize[255]]" value="{{ $form->vali }}" />
                                
                                @error('vali')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Phone Number{!! $required_field_html !!}</label>
                                <input type="text" name="vali_phone" class="form-control validate[required, maxSize[255]]" value="{{ $form->vali_phone }}" />
                                
                                @error('vali_phone')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Sanitization Method Used{!! $required_field_html !!}</label>
                                <input type="text" name="sani" class="form-control validate[required, maxSize[255]]" value="{{ $form->sani }}" />
                                
                                @error('sani')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Notes{!! $required_field_html !!}</label>
                                <input type="text" name="notes" class="form-control validate[required, maxSize[255]]" value="{{ $form->notes }}" />
                                
                                @error('notes')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>IT Professional - I have removed all data or access to data{!! $required_field_html !!}</label>
                                <input type="text" name="prof" class="form-control validate[required, maxSize[255]]" value="{{ $form->prof }}" />
                                
                                @error('prof')
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
                                <label>Date{!! $required_field_html !!}</label>
                                <div class="input-group">
                                    <input type="text" name="sign_date" class="form-control datepicker validate[required, custom[date]]" value="{{ \Carbon\Carbon::parse( $form->sign_date )->format( config('app.VIEW_DATE_FORMAT') ) }}" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" autocomplete="off" />
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