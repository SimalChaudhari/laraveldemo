<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title text-center">{{ ucwords( strtolower( 'MEDIA DESTRUCTION AND/OR REUSE FORM' ) ) }}</h3>
    </div>

    <div class="panel-body">

        <form>

            <div class="row">
                
                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Organization{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->org }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Is device to be reused or destroyed?{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->device }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Media Removed From{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->media }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Location{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->loca }}</p>
                    </div>
                </div>

                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>Item Description{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->item_desc }}</p>
                    </div>
                </div>

                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>Make/Model{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->model }}</p>
                    </div>
                </div>

                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>Serial Number{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->serial }}</p>
                    </div>
                </div>

                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>Asset ID{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->asset }}</p>
                    </div>
                </div>

                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>Backup Made of Information/Data?{!! $required_field_html !!}</label>
                        <p class="form-control-static"><?php echo strtolower($form->backup) == 'yes' ? 'Yes' : 'No' ?></p>
                    </div>
                </div>

                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>If Yes, Backup Location{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->backup_loc }}</p>
                    </div>
                </div>

                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>Item Description{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->descri }}</p>
                    </div>
                </div>

                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>Date Conducted{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ \Carbon\Carbon::parse( $form->con_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
                    </div>
                </div>

                <div class="col-sm-4 col-xs-4">
                    <div class="form-group">
                        <label>Conducted By{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->cond }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Validated By{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->vali }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Phone Number{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->vali_phone }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Sanitization Method Used{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->sani }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Notes{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->notes }}</p>
                    </div>
                </div>

                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>IT Professional - I have removed all data or access to data{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->prof }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>HIPAA Compliance Officer{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->officer }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Date{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ \Carbon\Carbon::parse( $form->sign_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
                    </div>
                </div>

            </div>

        </form>

    </div>

</div>