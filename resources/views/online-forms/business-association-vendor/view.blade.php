@extends('layouts.admin')

@section('page_title')
View: {{ ucwords( strtolower( 'BUSINESS ASSOCIATE/VENDOR TERMINATION FORM' ) ) }}
@endsection

@section('content')

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">

    <div class="col-sm-3 col-xs-12"></div>

    <div class="col-sm-6 col-xs-12">

        <ol class="breadcrumb">
            <li><a href="javascript:;">HIPAA Container</a></li>
            <li><a href="{{ route('UI_allOnlineForms') }}">Online Forms</a></li>
            <li class="active">{{ ucwords( strtolower( 'BUSINESS ASSOCIATE/VENDOR TERMINATION FORM' ) ) }}</li>
        </ol>
        
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title">{{ ucwords( strtolower( 'BUSINESS ASSOCIATE/VENDOR TERMINATION FORM' ) ) }}</h3>
            </div>

            <div class="panel-body">

                <table class="table table-bordered table-hover">
                    <tr  class="odd gradeX">
                        <td><strong>Date:</strong></td>
                        <td>{{ \Carbon\Carbon::parse( $form->cur_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Vendor:</strong></td>
                        <td>{{ $form->vendor }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Reason for Termination:</strong></td>
                        <td>{{ $form->reason }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Date Computer Access Terminated:</strong></td>
                        <td>{{ \Carbon\Carbon::parse( $form->ter_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Key(s), key card or other access devices returned on:</strong></td>
                        <td>{{ $form->key_card }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Notes:</strong></td>
                        <td>{{ $form->notes }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Signature Field:</strong></td>
                        <td>{{ $form->sign }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Date:</strong></td>
                        <td>{{ \Carbon\Carbon::parse( $form->sign_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
                    </tr>
                </table>

            </div>

        </div>

    </div>

    <div class="col-sm-3 col-xs-12"></div>

    <div class="clearfix"></div>

</div>

@endsection