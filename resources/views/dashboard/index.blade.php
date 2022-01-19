@extends('layouts.admin')

@section('page_title')
Dashboard
@endsection

@section('content')

<link rel="stylesheet" href="{{ asset( 'public/css/morris.css') }}">
<script src="{{ asset( 'public/js/raphael-2.0.2.min.js') }}"></script>
<script src="{{ asset( 'public/js/morris.js') }}"></script>

<x-alert />

<div class="row">

    <div class="col-sm-12 col-xs-12">

        <div class="panel panel-default panel-custom">

            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <h3 class="panel-title"><i class="fa fa-2x fa-certificate" aria-hidden="true"></i> Welcome to Hipaamart: Organization and Procedures</h3>
                    </div>
                </div>
            </div>

            <div class="panel-body">

                <p>For a first time user of the Hipaamart portal, we recommend the following:</p>

                <ul>
                    <li>Appoint a HIPAA Compliance Officer.</li>
                    <li>Perform an initial review of the benefits of the portal</li>
                    <li>Under the "Add New User" Tab, enter the names of all the medical and other staff who will be granted access to Protected Health Information (PHI)</li>
                </ul>

                <p>There are three major activities mandated by the HIPAA regulations, and in particular the Safe Harbor created by the 2021 amendment. They are <a href="{{ route('training.welcome') }}">Training</a>, <a href="{{ route('annual-risk-assessment.welcome') }}">Risk Assessment</a> and Cybersecurity.  Hipaamart provides Training and Risk Assessment. Each medical practice should have access to an information technology specialist who can set up the cybersecurity safeguards at the medical office location.</p>

                <h3><strong><u>Training</u></strong></h3>

                <p>After becoming comfortable with the portal, the Compliance Office should schedule each member of the staff to:</p>

                <ol style="list-style-type: lower-roman;">
                    <li>watch the training video,</li>
                    <li>take the training quiz and </li>
                    <li>sign the training acknowledgement.</li>
                </ol>
 
                <p>This will properly document that the employees have watched training video.  In the event that the medical practice is audited by the Office of Civil Rights (OCR), this documentation can be printed and shown to the OCR representative.</p>

                <h5><strong><u>Note:</u></strong></h5>
                <ul>
                    <li>After taking the training quiz, the employee can correct any answers that are incorrect.</li>
                    <li>The "Training Acknowledgement" can be signed on-line.</li>
                    <li>If the employee prefers, the Training Acknowledgement can also be downloaded and printed from Document .03 in the Document Library and then can be signed in hard copy.</li>
                </ul>

                <h3><strong><u>Risk Assessment</u></strong></h3>

                <p>Next, the Compliance Office should complete the Risk Assessment questionnaire.  After completing the questionnaire, the Compliance Officer can evaluate what actions, if any, the medical provider can take to help meet the compliance obligations of HIPAA.</p>

                <p>The Risk Assessment Questionnaire is separated into 11 sections. The Compliance Officer can complete separate sections and then return to the Questionnaire to complete other sections. The sections do not need to be completed at the same time. This will also document one of the activities mandated by HIPAA that can be shown to the OCR in the event of an audit.</p>

                <p>These are the primary initial activities to be taken upon signing onto the Hipaamart portal.</p>
                <ul>
                    <li>Each employee should watch the Training Video once annually.</li>
                    <li>The Risk Assessment Questionnaire should be completed once annually by the Compliance Officer.</li>
                    <li>Cybersecurity responsibilities should be assigned to an information technology specialist.</li>
                </ul>

            </div>

        </div>

        {{-- <div class="panel panel-default panel-custom">

            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <h3 class="panel-title"><i class="fa fa-2x fa-file-text" aria-hidden="true"></i> Online Forms</h3>
                    </div>
                </div>
            </div>

            <div class="panel-body">

                <div id="online-forms-chart" style="height: 350px;"></div>                

            </div>

        </div> --}}

        {{-- <div class="panel panel-default panel-custom">

            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <h3 class="panel-title"><i class="fa fa-2x fa-pie-chart" aria-hidden="true"></i> Site stats</h3>
                    </div>
                </div>
            </div>

            <div class="panel-body">

                <div id="site-stats-chart" style="height: 250px;"></div>                

            </div>

        </div> --}}

        {{-- <div class="panel panel-default panel-custom">
            <a href="#widget1container" class="panel-heading" data-toggle="collapse">Tracking Hipaa</a>
            <div id="widget1container" class="panel-body collapse in">
                <h2><a href="http://trackinghipaa.hipaatrack.com/" target="_blank">Tracking Hipaa</a></h2>
            </div>
        </div> --}}

    </div>

    <div class="col-sm-6 col-xs-12">

        <?php /*
        <div class="panel panel-default panel-custom">

            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <h3 class="panel-title"><i class="fa fa-2x fa-puzzle-piece" aria-hidden="true"></i> Quiz</h3>
                    </div>
                </div>
            </div>

            <div class="panel-body">

                <div id="quiz-bar-chart" style="height: 250px;"></div>

            </div>

        </div>*/ ?>

        <?php /*
        <div class="panel panel-default panel-custom">

            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <h3 class="panel-title"><i class="fa fa-2x fa-book" aria-hidden="true"></i> Document Library</h3>
                    </div>
                </div>
            </div>

            <div class="panel-body">

                <div id="library-chart" style="height: 250px;"></div>                

            </div>

        </div>*/ ?>

        <?php /*
        <div class="panel panel-default">
            <table class="table table-bordered table-hover">
                <?php
                if($has_user_taken_risk_assessment_test > 0) {
                    
                    if ($todo_list->count() > 0) { ?>

                        <thead>
                            <tr>
                                <th>ITEM</th>
                                <th>Completed</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach( $todo_list as $todo )
                        
                                <tr>
                                    <td>{{ $loop->iteration }} . {{ $todo->todo_list }}</td>
                                    <td>{{ $todo->status }}</td>
                                    {{-- <td><a href="{{ route('UI_edit', $todo->id) }}" style="border: 2px solid #330066; padding: 1.2%;" title="Edit">Update</a></td> --}}
                                    <td><a href="{{ route('UI_edit', $todo->id) }}" class="btn btn-xs btn-custom-success"><span class="glyphicon glyphicon-check"></span> Update</a></td>
                                </tr>

                            @endforeach

                        </tbody>
                <?php } else {
                        echo "<h2>You have successfully done all to do work.</h2>";
                    } ?>

                <?php } else {
                    echo "<h2>Please take Online Risk Assessment test</h2>";
                } ?>
            </table>
        </div>
        */ ?>
        

    </div>

</div>

<script>

    $(document).ready(function() {

        <?php /*
        Morris.Area({
            element: 'library-chart',
            data: {!! $agreements_data !!},
            xkey: 'year',
            ykeys: ['total'],
            labels: ['Total'],
            pointSize: 2,
            hideHover: 'auto'
        });*/ ?>


        <?php /*
        Morris.Bar({
            element: 'quiz-bar-chart',
            data: {!! $quiz_data !!},
            xkey: 'month',
            ykeys: ['training', 'riskAssessment'],
            labels: ['Training', 'Risk assessment'],
            barRatio: 0.4,
            xLabelAngle: 35,
            hideHover: 'auto',
            barColors: ['#f57e05', '#2666cb']
        });*/ ?>

        <?php /*Morris.Line({
            element: 'online-forms-chart',
            data: {!! $online_forms_data !!},
            xkey: 'year',
            ykeys: ['adts', 'authorize_use_disclosure', 'bba_vendor', 'email_access_to_health', 'email_health_ammendment', 'emp_termination', 'media_destruction', 'request_to_download', 'sanction_reports'],
            labels: ['Accounting Of Disclosures Tracking Sheet Form', 'Authorization To Use And/or Disclose Medical Records', 'Business Associate/vendor Termination', 'Email Form For Access To Health Record', 'Email Form For Health Record Ammendment', 'Employee Termination Form', 'Media Destruction And/or Reuse Form', 'Request To Download/copy Ephi', 'Sanction Report'],
            hideHover: 'auto',
        });*/ ?>

        /*Morris.Donut({
            element: 'site-stats-chart',
            data: [
              {label: 'Users', value: $users_count },
              {label: 'Library', value: $total_business_associate_agreements },
              {label: 'Online Forms', value: 9 },
            ],
            formatter: function (y) { return y }
        });*/

    });

</script>

@endsection