@extends('layouts.admin')

@section('page_title')
View: {{ ucwords( strtolower( 'EMAIL FORM FOR HEALTH RECORD AMMENDMENT' ) ) }}
@endsection

@section('content')

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">

    <div class="col-sm-3 col-xs-12"></div>

    <div class="col-sm-6 col-xs-12">

        <ol class="breadcrumb">
            <li><a href="javascript:;">HIPAA Container</a></li>
            <li><a href="{{ route('UI_allOnlineForms') }}">Online Forms</a></li>
            <li class="active">{{ ucwords( strtolower( 'EMAIL FORM FOR HEALTH RECORD AMMENDMENT' ) ) }}</li>
        </ol>

        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title">{{ ucwords( strtolower( 'EMAIL FORM FOR HEALTH RECORD AMMENDMENT' ) ) }}</h3>
            </div>

            <div class="panel-body">

                <table class="table table-bordered table-hover">
                    <tr  class="odd gradeX">
                        <td><b>Date:</b></td>
                        <td>{{ \Carbon\Carbon::parse( $form->cur_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><b>First Name:</b></td>
                        <td>{{ $form->f_name }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><b>Last Name:</b></td>
                        <td>{{ $form->l_name }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><b>Address1:</b></td>
                        <td>{{ ucfirst( $form->address1 ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><b>Address2:</b></td>
                        <td>{{ ucfirst( $form->address2 ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><b>City:</b></td>
                        <td>{{ $form->city }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><b>State:</b></td>
                        <td>{{ $form->state }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><b>Zip:</b></td>
                        <td>{{ $form->zip }}</td>
                    </tr>
                </table>

                <b>Dear(Patient Nme):</b> {{ ucfirst( $form->pat_name ) }}
                <h4><b>Re: Request to Amend Health Information</b></h4>
                <p>Dear Ms. Doe:</p>
                <p style="text-align:justify;">This letter responds to your request that we amend your health information, which we received
                    from you on <u>{{ \Carbon\Carbon::parse( $form->last_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</u>. We agree to make the amendment that you have requested. Your records will be updated accordingly.
                </p>
                <p style="text-align:justify;">If you agree, we will also notify other persons or organizations about this amendment that may rely on the original (un-amended) information they currently have in a way that may negatively affect you. In addition, we will notify other persons or organizations that you identify that may have the original (un-amended) health information.</p>
                <p style="text-align:justify;">Please contact the manager of the specific clinic if you would like us to notify these other persons or organizations for you. As always, we are committed to helping you assure that the information about you is kept accurate. Thank you for your assistance  and patience in helping us achieve this goal.</p>
                <p>Sincerely,</p>
                {{ ucfirst( $form->app_name ) }}

            </div>

        </div>

    </div>

    <div class="col-sm-3 col-xs-12"></div>

    <div class="clearfix"></div>

</div>

@endsection