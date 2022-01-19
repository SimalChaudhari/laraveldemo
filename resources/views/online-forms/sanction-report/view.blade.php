@extends('layouts.admin')

@section('page_title')
View: {{ ucwords( strtolower( 'SANCTION REPORT FORM' ) ) }}
@endsection

@section('content')

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">

    <div class="col-sm-3 col-xs-12"></div>

    <div class="col-sm-6 col-xs-12">

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

                <table class="table table-bordered table-hover">
                    <tr  class="odd gradeX">
                        <td><strong>Date of Report:</strong></td>
                        <td>{{ \Carbon\Carbon::parse( $form->rep_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Date Violation/Incident Discovered:</strong></td>
                        <td>{{ \Carbon\Carbon::parse( $form->vio_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Individual or Organization Receiving Sanction:</strong></td>
                        <td>{{ ucfirst( $form->org ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Job Title or Description of Duties:</strong></td>
                        <td>{{ ucfirst( $form->job ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Method Violation was Discovered:</strong></td>
                        <td>{{ ucfirst( $form->method ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Description of Violation/Incident:</strong></td>
                        <td>{{ ucfirst( $form->descr ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Group I Offense:</strong></td>
                        <td>{{ ucfirst( $form->grp1 ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Group II Offense:</strong></td>
                        <td>{{ ucfirst( $form->grp2 ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Group III: Willful and/or intentional disclosure of PHI or records</strong></td>
                        <td>{{ ucfirst( $form->grp3 ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Sanction Applied:</strong></td>
                        <td>{{ ucfirst( $form->sanct ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Additional Information on Sanction Applied:</strong></td>
                        <td>{{ ucfirst( $form->add_info ) }}</td>
                    </tr>
                </table>

                <hr/>

                <p>This is a <u>{{ ucfirst( $form->type_of ) }}</u> Sanction.</p>
                <p>Employee/Organization will be on <u>{{ ucfirst( $form->field1 ) }}</u>. for a period of: <u>{{ ucfirst( $form->field2 ) }}</u>.</p>

                <hr/>

                <table class="table table-bordered table-hover">
                    <tr class="odd gradeX">
                        <td colspan="2" align="center"><strong><u>FACTORS USED IN DETHRMINING SANCTION APPLIED</strong></td>
                    </tr>

                    <tr  class="odd gradeX">
                        <td><strong>Did the Violation/Incident Cause a Breach of patient Information (PHI)?</strong></td>
                        <td>{{ ucfirst( $form->breach ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>The Violation/Incident was determined to be:</strong></td>
                        <td>{{ ucfirst( $form->deter ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Did the Violation/Incident Involve Malice or Personal Gain?</strong></td>
                        <td>{{ ucfirst( $form->involve ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>First Offense or Multiple Violations of the Same Type:</strong></td>
                        <td>{{ ucfirst( $form->offence ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Individual/Organization had been Trained and Understood the Policy:</strong></td>
                        <td>{{ ucfirst( $form->train ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>COMMENTS:</strong></td>
                        <td>{{ ucfirst( $form->comments ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Report Completed By (Name & Title):</strong></td>
                        <td>{{ ucfirst( $form->report ) }}</td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

    <div class="col-sm-3 col-xs-12"></div>

    <div class="clearfix"></div>

</div>

@endsection