@extends('layouts.admin')

@section('page_title')
View: Employee Termination Form
@endsection

@section('content')

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">

    <div class="col-sm-3 col-xs-12"></div>

    <div class="col-sm-6 col-xs-12">

        <ol class="breadcrumb">
            <li><a href="javascript:;">HIPAA Container</a></li>
            <li><a href="{{ route('UI_allOnlineForms') }}">Online Forms</a></li>
            <li class="active">{{ ucwords( strtolower( 'Employee Termination Form' ) ) }}</li>
        </ol>
        
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title">Employee Termination Form</h3>
            </div>

            <div class="panel-body">

                <table class="table table-bordered">

                    <tr class="odd gradeX">
                        <td><b>Name of Practice</b></td>
                        <td>{{ ucfirst( $form->name_practice ) }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Name of Employee</b></td>
                        <td>{{ ucfirst( $form->name_employee ) }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Reason For Termination</b></td>
                        <td>{{ ucfirst( $form->rsn_termination ) }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Termination voluntary</b></td>
                        @if($form->termination_vol == 'Yes')
                            <td>Yes</td>
                        @else
                            <td>No</td>
                        @endif
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Termination Forced</b></td>
                        @if($form->termination_force == 'Yes')
                            <td>Yes</td>
                        @else
                            <td>No</td>
                        @endif
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Did the Employee Have Administrator Access?</b></td>
                        <td>{{ $form->admin_access }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Windows Log-in Account Terminated</b></td>
                        @if( $form->windowacc == 'Yes')
                            <td>Yes</td>
                        @else
                            <td>No</td>
                        @endif
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Date</b> </td>
                        <td>{{ \Carbon\Carbon::parse( $form->windowacc_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Practice Management Log-ln Account Terminated</b></td>
                        @if( $form->practiceacc == 'Yes')
                            <td>Yes</td>
                        @else
                            <td>No</td>
                        @endif
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Date</b> </td>
                        <td>{{ \Carbon\Carbon::parse( $form->practiceacc_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>EHR Log-ln Account Terminated</b></td>
                        @if( $form->ehracc == 'Yes')
                            <td>Yes</td>
                        @else
                            <td>No</td>
                        @endif
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Date</b></td>
                        <td>{{ \Carbon\Carbon::parse( $form->ehracc_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Key(s) to facility has been returned</b></td>
                        <td>{{ $form->keys_facility }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Employee Individual security Entry code Deactivated:</b></td>
                        <td>{{ $form->security_entry }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>lf code for entry is the same for all employees, has the access code been changed ?</b></td>
                        <td>{{ $form->code_for_entry }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>lf the employee had a laptop computer or other mobile device has it been returned ?</b></td>
                        <td>{{ $form->device }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Did the employee have any patient information accessible from a cell phone ?</b></td>
                        <td>{{ $form->patient_info }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>lf above answer is yes, has all patient information been deleted from the device ?</b></td>
                        <td>{{ $form->patient_info_dlt }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Has the password been changed for the employee's company email account?</b></td>
                        <td>{{ $form->email_pass }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Notes about this termination</b></td>
                        <td>{{ $form->notes }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Form Completed By</b></td>
                        <td>{{ ucfirst( $form->form_name ) }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Title</b></td>
                        <td>{{ ucfirst( $form->form_title ) }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Date Form Completed</b></td>
                        <td>{{ \Carbon\Carbon::parse( $form->formcomplte_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

    <div class="col-sm-3 col-xs-12"></div>

    <div class="clearfix"></div>

</div>

@endsection