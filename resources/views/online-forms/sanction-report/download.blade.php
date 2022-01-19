<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title text-center">{{ ucwords( strtolower( 'SANCTION REPORT FORM' ) ) }}</h3>
    </div>

    <div class="panel-body">

        <form class="form-horizontal">

            @csrf

            <div class="row">
                
                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>Date of Report{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ \Carbon\Carbon::parse( $form->rep_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
                    </div>
                </div>

                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>Date Violation/Incident Discovered{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ \Carbon\Carbon::parse( $form->vio_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
                    </div>
                </div>

                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>Individual or Organization Receiving Sanction{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->org }}</p>
                    </div>
                </div>

                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>Job Title or Description of Duties{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->job }}</p>
                    </div>
                </div>

                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>Method Violation was Discovered{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->method }}</p>
                    </div>
                </div>

                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>Description of Violation/Incident{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->descr }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Group I Offense{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->grp1 }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Group II Offense{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->grp2 }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Group III: Willful and/or intentional disclosure of PHI or records{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->grp3 }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Sanction Applied{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->sanct }}</p>
                    </div>
                </div>

                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>Additional Information on Sanction Applied:{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->add_info }}</p>
                    </div>
                </div>

                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <p class="form-control-static">This is a <u>{{ $form->type_of }}</u></p>
                    </div>
                </div>

                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <p class="form-control-static">Employee/Organization will be on <u>{{ $form->field1 }}</u>. for a period of: <u>{{ $form->field2 }}</u>.</p>
                    </div>
                </div>

                <h3><strong>FACTORS USED IN DETERMINING SANCTION APPLIED</strong></h3>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Did the Violation/Incident Cause a Breach of patient Information (PHI)?{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->breach }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>The Violation/Incident was determined to be{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->deter }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Did the Violation/Incident Involve Malice or Personal Gain?{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->involve }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>First Offense or Multiple Violations of the Same Type{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->offence }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Individual/Organization had been Trained and Understood the Policy{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->train }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>COMMENTS{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->comments }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Report Completed By (Name & Title){!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->report }}</p>
                    </div>
                </div>

            </div>

        </form>

    </div>

</div>