@extends('layouts.admin')

@section('page_title')
Site settings
@endsection

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>

<style>
    .colorpicker-component input {
        width: 20% !important;
    }
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.6/css/bootstrap-colorpicker.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.6/js/bootstrap-colorpicker.js"></script>

<h2 style="margin-top: 0;">Settings</h2>

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<x-alert />

<div class="row">

    <div class="col-sm-6 col-xs-12">
        
        <div class="panel panel-default">

            <div class="panel-body">

                <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                    <li class="active"><a href="#brands" data-toggle="tab">Brand</a></li>
                    <li><a href="#colors" data-toggle="tab">Colors</a></li>
                    <li><a href="#fonts" data-toggle="tab">Font</a></li>
                    <li><a href="#timezones" data-toggle="tab">Timezone</a></li>
                    <!-- <li><a href="#terminate" data-toggle="tab">Terminate</a></li> -->
                </ul>

                <div class="tab-content">

                    <div class="tab-pane active" id="brands">

                        <form action="{{ route('saveSetting') }}" class="validateForm" method="POST" enctype="multipart/form-data" role="form">

                            @csrf
                            
                            <div class="form-group">
                                <div class="col-sm-6 col-xs-12" style="padding: 0;">
                                    <label for="logo">Logo{!! $required_field_html !!}</label>
                                    <input name="logo" id="logo" type="file" onchange="loadFile(event)" accept=".jpg,.jpeg,.png" class="validate[required] image" />

                                    @error('logo')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            

                                <div class="col-sm-6 col-xs-12" style="padding: 0;">
                                    <?php
                                    $logo = App\Models\Setting::select('logo_path')->where( 'user_id', Auth::user()->id )->first();
                                    if( $logo === null ) {
                                        $logo = App\Models\Setting::select('logo_path')->where('predefined', 'Y')->first();
                                    }
                                    ?>
                                    <img id="preview_upload_file" src="{{ asset('public/images/' . $logo->logo_path ) }}" style="width: 200px; height: 140px;-o-object-fit: contain;object-fit: contain;" class="img-thumbnail pull-right" />
                                </div>

                            </div>

                            <input name="submit" type="submit" class="btn btn-custom-primary" value="Update" />

                        </form>
                    </div>

                    <div class="tab-pane" id="colors">

                        <form action="{{ route('saveSetting') }}" class="validateForm" method="POST" enctype="multipart/form-data" role="form">

                            @csrf

                            <?php
                            $colors = isset($setting->layout_colors) ? $setting->layout_colors : [];
                            $default_colors = \App\Models\Setting::defaultLayoutColors();
                            ?>

                            <div class="form-group">
                                <label>Top menu background color{!! $required_field_html !!}</label>
                                <div class="input-group colorpicker-component"> 
                                    <span class="input-group-addon"><i></i></span>

                                    <input type="text"
                                        name="colors[top_menu_background_color]"
                                        class="form-control validate[required]"
                                        value="{{ isset($colors['top_menu_background_color']) ? $colors['top_menu_background_color'] : $default_colors['top_menu_background_color'] }}" /> 
                                </div>

                                @error('top_menu_background_color')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Top menu text color{!! $required_field_html !!}</label>
                                <div class="input-group colorpicker-component"> 
                                    <span class="input-group-addon"><i></i></span>
                                    <input type="text"
                                        name="colors[top_menu_txt_color]"
                                        class="form-control validate[required]" 
                                        value="{{ isset($colors['top_menu_txt_color']) ? $colors['top_menu_txt_color'] : $default_colors['top_menu_txt_color'] }}" /> 
                                </div>

                                @error('top_menu_txt_color')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Left sidebar background color{!! $required_field_html !!}</label>
                                <div class="input-group colorpicker-component"> 
                                    <span class="input-group-addon"><i></i></span>
                                    <input type="text"
                                        name="colors[left_sidebar_bg_color]" 
                                        class="form-control validate[required]" 
                                        value="{{ isset($colors['left_sidebar_bg_color']) ? $colors['left_sidebar_bg_color'] : $default_colors['left_sidebar_bg_color'] }}" /> 
                                </div>

                                @error('left_sidebar_bg_color')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Parent menu background color{!! $required_field_html !!}</label>
                                <div class="input-group colorpicker-component"> 
                                    <span class="input-group-addon"><i></i></span>
                                    <input type="text"
                                        name="colors[parent_menu_bg_color]" 
                                        class="form-control validate[required]" 
                                        value="{{ isset($colors['parent_menu_bg_color']) ? $colors['parent_menu_bg_color'] : $default_colors['parent_menu_bg_color'] }}" /> 
                                </div>

                                @error('parent_menu_bg_color')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Parent menu text color{!! $required_field_html !!}</label>
                                <div class="input-group colorpicker-component"> 
                                    <span class="input-group-addon"><i></i></span>
                                    <input type="text"
                                        name="colors[parent_menu_text_color]" 
                                        class="form-control validate[required]" 
                                        value="{{ isset($colors['parent_menu_text_color']) ? $colors['parent_menu_text_color'] : $default_colors['parent_menu_text_color'] }}" /> 
                                </div>

                                @error('parent_menu_text_color')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Submenu background color{!! $required_field_html !!}</label>
                                <div class="input-group colorpicker-component"> 
                                    <span class="input-group-addon"><i></i></span>
                                    <input type="text"
                                        name="colors[submenu_bg_color]" 
                                        class="form-control validate[required]" 
                                        value="{{ isset($colors['submenu_bg_color']) ? $colors['submenu_bg_color'] : $default_colors['submenu_bg_color'] }}" /> 
                                </div>

                                @error('submenu_bg_color')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Submenu text color{!! $required_field_html !!}</label>
                                <div class="input-group colorpicker-component"> 
                                    <span class="input-group-addon"><i></i></span>
                                    <input type="text"
                                        name="colors[submenu_text_color]" 
                                        class="form-control validate[required]" 
                                        value="{{ isset($colors['submenu_text_color']) ? $colors['submenu_text_color'] : $default_colors['submenu_text_color'] }}" /> 
                                </div>

                                @error('submenu_text_color')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Menu hover color{!! $required_field_html !!}</label>
                                <div class="input-group colorpicker-component"> 
                                    <span class="input-group-addon"><i></i></span>
                                    <input type="text"
                                        name="colors[menu_hover_color]" 
                                        class="form-control validate[required]" 
                                        value="{{ isset($colors['menu_hover_color']) ? $colors['menu_hover_color'] : $default_colors['menu_hover_color'] }}" /> 
                                </div>

                                @error('menu_hover_color')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Page content background color{!! $required_field_html !!}</label>
                                <div class="input-group colorpicker-component"> 
                                    <span class="input-group-addon"><i></i></span>
                                    <input type="text"
                                        name="colors[page_content_bg_color]"
                                        class="form-control validate[required]" 
                                        value="{{ isset($colors['page_content_bg_color']) ? $colors['page_content_bg_color'] : $default_colors['page_content_bg_color'] }}" /> 
                                </div>

                                @error('page_content_bg_color')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Footer background color{!! $required_field_html !!}</label>
                                <div class="input-group colorpicker-component"> 
                                    <span class="input-group-addon"><i></i></span>
                                    <input type="text"
                                        name="colors[footer_bg_color]" 
                                        class="form-control validate[required]" 
                                        value="{{ isset($colors['footer_bg_color']) ? $colors['footer_bg_color'] : $default_colors['footer_bg_color'] }}" /> 
                                </div>

                                @error('footer_bg_color')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <input name="submit" type="submit" class="btn btn-custom-primary" value="Update" />


                        </form>
                        
                    </div>

                    <div class="tab-pane" id="fonts">

                        <form action="{{ route('saveSetting') }}" class="validateForm" method="POST" enctype="multipart/form-data" role="form">

                            @csrf

                            <div class="form-group">
                                <label>Google Font{!! $required_field_html !!}</label>
                                <select name="fonts" id="fonts" class="form-control validate[required]">
                                    <option value="">Select Google Font</option>
                                    <?php
                                    $selected_font = App\Models\Setting::DEFAULT_GOOGLE_FONT;
                                    if( isset( $setting->fonts ) && !empty( $setting->fonts ) ) {
                                        $selected_font = $setting->fonts;
                                    }
                                    ?>
                                    @foreach( $google_fonts as $google )
                                        <option value="{{ $google->font }}" <?php echo $selected_font == $google->font ? 'selected' : ''; ?>>{{ $google->font }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <input name="submit" type="submit" class="btn btn-custom-primary" value="Update" />

                        </form>
                        
                    </div>

                    <div class="tab-pane" id="timezones">

                        <form action="{{ route('saveSetting') }}" class="validateForm" method="POST" enctype="multipart/form-data" role="form">

                            @csrf
                            
                            <div class="form-group">

                                <label for="timezone">Timezone{!! $required_field_html !!}</label>
                                <select name="timezone" id="timezone" class="form-control validate[required]">
                                    <option value="">Select Timezone</option>
                                    @foreach( config('timezones') as $timezone_key => $timezone_val )
                                        <option value="{{ trim( $timezone_key ) }}" <?php echo isset($setting->timezone) && trim( $timezone_key ) === $setting->timezone ? 'selected' : ''; ?>>{{ $timezone_val }}</option>
                                    @endforeach
                                </select>

                                @error('timezone')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror

                            </div>

                            <input name="submit" type="submit" class="btn btn-custom-primary" value="Update" />

                        </form>
                    </div>

                    <!-- <div class="tab-pane" id="terminate">

                        <form method="POST" action={{ route('terminateAccount') }}>

                            @csrf
                            <button type="submit" id="btnTerminateAccount" class="btn btn-custom-danger">Terminate Account</button>

                        </form>

                    </div> -->

                </div>

                

            </div>

        </div>

    </div>

</div>
<style type="text/css">
img {
    display: block;
    max-width: 100%;
}

.preview {
    overflow: hidden;
    width: 160px; 
    height: 160px;
    margin: 10px;
    border: 1px solid red;
}

.modal-lg{
    max-width: 1000px !important;
}
</style>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Crop Image</h4>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img id="modal_logo_image" src="https://avatars0.githubusercontent.com/u/3456749">
                        </div>
                        <div class="col-md-4">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-custom-danger" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-custom-primary" id="crop">Crop</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '#btnTerminateAccount', function(e) {
        e.preventDefault();

        var formTerminateAccount = $(this).parent();

        BootstrapDialog.show({
            title: 'Terminate Account',
            type: 'type-danger',
            message: 'Once you terminate your account, you will instantly get logged out from the site and would not be able to access the site until you repay so are you sure?',
            hotkey: 13, // Enter.
            closeByBackdrop: false,
            closeByKeyboard: true,
            buttons: [{
                label: 'No',
                id: 'btn_dont_delete',
                cssClass: 'btn-custom-danger',
                action: function (dialogItself) {
                    dialogItself.close();
                }
            }, {
                label: 'Yes',
                cssClass: 'btn-custom-success',
                action: function(dialogItself) {

                    $('#btn_dont_delete').prop('disabled', true);
                    
                    var $button = this;

                    $button.disable();
                    $button.spin();

                    formTerminateAccount.submit();

                }
            }],
        });
    });
</script>

<script type="text/javascript">
    var loadFile = function(event) {
        var output = document.getElementById('preview_upload_file');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };
    $(document).ready(function() {
        $('.colorpicker-component').colorpicker();
    });
</script>

<script>
    var $modal = $('#modal');
    var image = document.getElementById('modal_logo_image');
    var cropper;

    var minCroppedWidth = 200;
    var minCroppedHeight = 60;
    var maxCroppedWidth = 200;
    var maxCroppedHeight = 60;

    $('input.image').change(function(event){
        var files = event.target.files;

        var done = function(url){
            image.src = url;
            $modal.modal('show');
        };

        if(files && files.length > 0)
        {
            reader = new FileReader();
            reader.onload = function(event)
            {
                done(reader.result);
            };
            reader.readAsDataURL(files[0]);
        }
    });

    $modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            // aspectRatio: 1,
            viewMode: 3,
            preview:'.preview',
            cropBoxResizable: false,

            data: {
                width: (minCroppedWidth + maxCroppedWidth) / 2,
                height: (minCroppedHeight + maxCroppedHeight) / 2,
            },

            crop: function (event) {
              var width = event.detail.width;
              var height = event.detail.height;

              if (
                width < minCroppedWidth
                || height < minCroppedHeight
                || width > maxCroppedWidth
                || height > maxCroppedHeight
              ) {
                cropper.setData({
                  width: Math.max(minCroppedWidth, Math.min(maxCroppedWidth, width)),
                  height: Math.max(minCroppedHeight, Math.min(maxCroppedHeight, height)),
                });
              }

              // data.textContent = JSON.stringify(cropper.getData(true));
            },

        });
    }).on('hidden.bs.modal', function(){
        cropper.destroy();
        cropper = null;
    });

    $('#crop').click(function(){
        canvas = cropper.getCroppedCanvas({
            width: maxCroppedWidth,
            height: maxCroppedHeight
        });

        canvas.toBlob(function(blob){
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function(){
                var base64data = reader.result;
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "crop-image-upload",
                    data: {
                        '_token': $('meta[name="_token"]').attr('content'),
                        'image': base64data
                    },
                    success: function (data) {
                        $('#preview_upload_file').attr('src', data.logo_path);
                        $modal.modal('hide');
                    }
                });
            };
        });
    });
</script>

@endsection