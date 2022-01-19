<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title text-center">{{ ucwords( strtolower( 'BUSINESS ASSOCIATE/VENDOR TERMINATION FORM' ) ) }}</h3>
    </div>

    <div class="panel-body">

        <form>

            @csrf

            <div class="row">

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Date</label>
                        <p class="form-control-static">{{ \Carbon\Carbon::parse( $form->cur_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Vendor{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->vendor }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Reason for Termination{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->reason }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Date Computer Access Terminated{!! $required_field_html !!}</label>
                        <div class="input-group">
                            <p class="form-control-static">{{ \Carbon\Carbon::parse( $form->ter_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Key(s), key card or other access devices returned on{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->key_card }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Notes{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->notes }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Signature Field{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->sign }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Date{!! $required_field_html !!}</label>
                        <div class="input-group">
                            <p class="form-control-static">{{ \Carbon\Carbon::parse( $form->sign_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
                        </div>
                    </div>
                </div>

            </div>

        </form>

    </div>

</div>