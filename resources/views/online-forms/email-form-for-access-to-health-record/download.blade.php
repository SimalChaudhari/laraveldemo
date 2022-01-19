<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title text-center">{{ ucwords( strtolower( 'EMAIL FORM FOR ACCESS TO HEALTH RECORD' ) ) }}</h3>
    </div>

    <div class="panel-body">

        <form>

            <div class="row">

                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>Date</label>
                        <p class="form-control-static">{{ \Carbon\Carbon::parse( $form->date )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
                    </div>
                </div>

                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>First Name{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->f_name }}</p>
                    </div>
                </div>

                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>Last Name{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->l_name }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Address 1{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->address1 }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Address 2{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->address2 }}</p>
                    </div>
                </div>

                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>City{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->city }}</p>
                    </div>
                </div>

                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>State{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->state }}</p>
                    </div>
                </div>

                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>Zip{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->zip }}</p>
                    </div>
                </div>

                <div class="col-sm-12 col-xs-12"> 
                    <h4><b>Re: Request for Access To Health Information</b></h4>
                    <p>Dear Ms. Doe:</p>
                    <p style="text-align:justify;">This letter responds to your request for access to your health information, which we received from you on <u>{{ \Carbon\Carbon::parse( $form->req_name )->format( config('app.VIEW_DATE_FORMAT') ) }}</u>. We have determined that the following fees will apply if weprocess your request:</p>
                    <ul style="list-style-type: none;">
                        <li>A fee of $<u>{{ $form->summary_charge }}</u> will be charged to prepare a summary of the information for you.</li>
                        </br>
                        <li>A fee of $<u>{{ $form->explanation_charge }}</u> will be charged to prepare an explanation of the information for you.</li>
                        </br>
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
                    <u>{{ $form->app_name }}</u>
                </div>

            </div>

        </form>

    </div>

</div>