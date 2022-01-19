@extends('layouts.admin')

@section('page_title')
Annual Risk Assessment
@endsection

@section('content')

<div class="row">

    <div class="col-sm-12 col-xs-12">

        <div class="panel panel-default panel-custom">

            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <h3 class="panel-title"><i class="fa fa-2x fa-certificate" aria-hidden="true"></i> Annual Risk Assessment</h3>
                    </div>
                </div>
            </div>

            <div class="panel-body">

                <p>HIPAA requires that a Risk Assessment of the medical provider’s installation be performed annually.</p>

                <p>The objective of the Risk Assessment is:</p>

                <ul>
                    <li>(i) to verify that steps have been taken to protect confidential information and</li>
                    <li>(ii) to assure that the physical and electronic facilities are secure.</li>
                </ul>

                <p>The purpose of the Risk Assessment is to assure that the medical provider is cognizant of the potential risks of privacy and security. After each year’s risk assessment, the HIPAA Compliance Officer of the medical provider should take whatever steps the medical provider deems advisable to improve on the privacy and security of HIPAA PHI.</p>

                <p>A record of the annual Risk Assessment should be preserved in the event of any audit by the Federal OCR regulators.</p>

                <p>For the annual Risk Assessment requirement, the following are provided:</p>

                <ol style="list-style-type: lower-alpha;">
                    <?php
                    $risk_assessment_quiz = \App\Models\Quiz::select('uuid')->where('name', 'Risk Assessment Questionnaire')->first();
                    ?>
                    <li><a href="{{ route('UI_quizOverview', $risk_assessment_quiz->uuid) }}" target="_blank">Risk Assessment Questionnaire</a></li>
                    <li><a href="{{ route('risk.ack.index') }}">Risk assessment acknowledgement</a> which can be completed electronically by the designated HIPAA compliance officer in the organization.</li>
                </ol>

                <p>The Risk Assessment Questionnaire is separated into 11 sections.  The Compliance Officer can complete separate sections and then return to the Questionnaire to complete other sections.  The sections do not need to be completed at the same time.  Completion of the Risk Assessment Questionnaire will document one of the activities mandated by HIPAA that can be shown to the OCR in the event of an audit.</p>

                <p>After completion of the Risk Assessment Questionnaire, the Risk Assessment Acknowledgement can be completed electronically by the designated HIPAA compliance officer in the organization. This Risk Assessment Acknowledgement will be stored on the portal if it needs to be exhibited to an OCR representative in the event of an audit.</p>

            </div>

        </div>

    </div>

</div>

@endsection