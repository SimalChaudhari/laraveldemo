<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title text-center">{{ ucwords( strtolower( 'EMAIL FORM FOR HEALTH RECORD AMMENDMENT' ) ) }}</h3>
    </div>

    <div class="panel-body">

        <form>

            <div class="row">
                
                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>Date{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ \Carbon\Carbon::parse( $form->cur_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
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
                    <div class="form-group">
                        <label>Dear(Patient Name){!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->pat_name }}</p>
                    </div>
                </div>

                <div class="col-sm-12">
                    <h4><b>Re: Request to Amend Health Information</b></h4>
                    <p>Dear Ms. Doe:</p>
                    <p style="text-align:justify;">This letter responds to your request that we amend your health information, which we received
                        from you on <u>{{ \Carbon\Carbon::parse( $form->last_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</u>. We agree to make the amendment that you have requested. Your records will be updated accordingly.
                    </p>

                    <p style="text-align:justify;">If you agree, we will also notify other persons or organizations about this amendment that may rely on the original (un-amended) information they currently have in a way that may negatively affect you. In addition, we will notify other persons or organizations that you identify that may have the original (un-amended) health information.</p>

                    <p style="text-align:justify;">Please contact the manager of the specific clinic if you would like us to notify these other persons or organizations for you. As always, we are committed to helping you assure that the information about you is kept accurate. Thank you for your assistance  and patience in helping us achieve this goal.</p>
                    <p>Sincerely,</p>
                    <u>{{ $form->app_name }}</u>
                </div>

            </div>

        </form>

    </div>

</div>