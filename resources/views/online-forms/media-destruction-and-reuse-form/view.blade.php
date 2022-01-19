@extends('layouts.admin')

@section('page_title')
View: {{ ucwords( strtolower( 'MEDIA DESTRUCTION AND/OR REUSE FORM' ) ) }}
@endsection

@section('content')

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">

    <div class="col-sm-3 col-xs-12"></div>

    <div class="col-sm-6 col-xs-12">

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

                <table class="table table-bordered table-hover">
                    <tr  class="odd gradeX">
                        <td><strong>Organization:</strong></td>
                        <td>{{ ucfirst( $form->org ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Is device to be reused or destroyed?:</strong></td>
                        <td>{{ ucfirst( $form->device ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Media Removed From:</strong></td>
                        <td>{{ ucfirst( $form->media ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Location:</strong></td>
                        <td>{{ ucfirst( $form->loca ) }}</td>
                    </tr>

                    <tr  class="odd gradeX">
                        <td colspan="2"><hr/></td>
                    </tr>

                    <tr  class="odd gradeX">
                        <td><strong>Item Description:</strong></td>
                        <td>{{ ucfirst( $form->item_desc ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Make/Model:</strong></td>
                        <td>{{ ucfirst( $form->model ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Serial Number:</strong></td>
                        <td>{{ ucfirst( $form->serial ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Asset ID:</strong></td>
                        <td>{{ ucfirst( $form->asset ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Backup Made of Information/Data?</strong></td>
                        <td>{{ ucfirst( $form->backup ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>If Yes, Backup Location:</strong></td>
                        <td>{{ ucfirst( $form->backup_loc ) }}</td>
                    </tr>

                    <tr  class="odd gradeX">
                        <td colspan="2"><hr/></td>
                    </tr>

                    <tr  class="odd gradeX">
                        <td><strong>Item Description:</strong></td>
                        <td>{{ ucfirst( $form->descri ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Date Conducted:</strong></td>
                        <td>{{ \Carbon\Carbon::parse( $form->con_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Conducted By:</strong></td>
                        <td>{{ ucfirst( $form->cond ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Validated By:</strong></td>
                        <td>{{ ucfirst( $form->vali ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Phone Number:</strong></td>
                        <td>{{ ucfirst( $form->vali_phone ) }}</td>
                    </tr>

                    <tr  class="odd gradeX">
                        <td colspan="2"><hr/></td>
                    </tr>

                    <tr  class="odd gradeX">
                        <td><strong>Sanitization Method Used:</strong></td>
                        <td>{{ ucfirst( $form->sani ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Notes:</strong></td>
                        <td>{{ ucfirst( $form->notes ) }}</td>
                    </tr>

                    <tr  class="odd gradeX">
                        <td><strong>IT Professional - I have removed all data or access to data:</strong></td>
                        <td>{{ ucfirst( $form->prof ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>HIPAA Compliance Officer:</strong></td>
                        <td>{{ ucfirst( $form->officer ) }}</td>
                    </tr>
                    <tr  class="odd gradeX">
                        <td><strong>Date:</strong></td>
                        <td>{{ \Carbon\Carbon::parse( $form->sign_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
                    </tr>


                </table>

                

            </div>

        </div>

    </div>

    <div class="col-sm-6 col-xs-12"></div>

    <div class="clearfix"></div>

</div>

@endsection