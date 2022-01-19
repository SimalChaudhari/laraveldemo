@extends('layouts.admin')

@section('page_title')
View: {{ ucwords( strtolower( 'EMAIL FORM FOR ACCESS TO HEALTH RECORD' ) ) }}
@endsection

@section('content')

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">

    <div class="col-sm-3 col-xs-12"></div>

    <div class="col-sm-6 col-xs-12">

        <ol class="breadcrumb">
            <li><a href="javascript:;">HIPAA Container</a></li>
            <li><a href="{{ route('UI_allOnlineForms') }}">Online Forms</a></li>
            <li class="active">{{ ucwords( strtolower( 'EMAIL FORM FOR ACCESS TO HEALTH RECORD' ) ) }}</li>
        </ol>

        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title">{{ ucwords( strtolower( 'EMAIL FORM FOR ACCESS TO HEALTH RECORD' ) ) }}</h3>
            </div>

            <div class="panel-body">

                <table class="table table-bordered">
                    <tr class="odd gradeX">
                        <td><b>Date:</b></td>
                        <td>{{ \Carbon\Carbon::parse( $form->date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><b>First Name:</b></td>
                        <td>{{ $form->f_name }}</td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><b>Last Name:</b></td>
                        <td>{{ $form->l_name }}</td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><b>Address1:</b></td>
                        <td>{{ $form->address1 }}</td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><b>Address2:</b></td>
                        <td>{{ $form->address2 }}</td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><b>City:</b></td>
                        <td>{{ $form->city }}</td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><b>State:</b></td>
                        <td>{{ $form->state }}</td>
                    </tr>
                    <tr class="odd gradeX">
                        <td><b>Zip:</b></td>
                        <td>{{ $form->zip }}</td>
                    </tr>
                </table>

                
                <h4><b>Re: Request for Access To Health Information</b></h4>
                <p>Dear <b>{{ $form->f_name }}:</b></p>
                <p style="text-align:justify;">This letter responds to your request for access to your health information, which we received from you on <u>{{ \Carbon\Carbon::parse( $form->req_name )->format( config('app.VIEW_DATE_FORMAT') ) }}</u>. We have determined that the following fees will apply if weprocess your request:</p>
                <ul style="list-style-type: none;">
                    <li>A fee of $<u>{{ $form->summary_charge }}</u> will be charged to prepare a summary of the information for you.</li>
                    <li>A fee of $<u>{{ $form->explanation_charge }}</u> will be charged to prepare an explanation of the information for you.</li>
                    <li>A fee of $<u>{{ $form->expedited_charge }}</u> will be charged for expedited request.</li>
                </ul>
                <p>We want you to know that you have the following options:</p>
                <ul>
                    <li>You may ask us to proceed with your request and pay the fee provided in this letter.</li>
                    <li>You may modify your request and reduce the applicable fee.</li>
                    <li>You may withdraw your request and pay no fee.</li>
                </ul>
                <p style="text-align:justify;">Please contact [insert name, address and telephone number of responsible person] to discuss your preferences and arrange for payment of any applicable fees. If we do not hear from you within 60 days, we will assume that you have decided to withdraw your request</p>
                <p>Sincerely,</p>
                <p><u>{{ $form->app_name }}.</u></p>


            </div>

        </div>

    </div>

    <div class="col-sm-3 col-xs-12"></div>

    <div class="clearfix"></div>

</div>

@endsection