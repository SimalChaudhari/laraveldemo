@extends('layouts.admin')

@section('page_title')
Settings
@endsection

@section('content')

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

    <div class="col-sm-4 col-xs-12">

    </div>

    <div class="col-sm-4 col-xs-12">
        
        <div class="panel panel-default">

            <div class="panel-body">

                <p class="col-sm-12 col-xs-12 text-right" style="padding-right: 0;"><small>({!! $required_field_html !!}) fields are mandatory.</small></p>

                <form action="{{ route('saveLogo') }}" method="POST" enctype="multipart/form-data" role="form">

					@csrf

                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label for="logo">Brand Logo{!! $required_field_html !!}</label>
                                <input name="logo" id="logo" type="file" onchange="loadFile(event)" accept=".jpg,.jpeg,.png" />

                                @error('logo')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror

                                <p class="help-block">Please upload logo in size: 60*200 pixels.</p>
                            </div>

                            <div class="col-sm-6">
                                <?php
                                $logo = App\Models\Setting::select('logo_path')->where( 'user_id', Auth::user()->id )->first();
                                if( $logo === null ) {
                                    $logo = App\Models\Setting::select('logo_path')->where('predefined', 'Y')->first();
                                }
                                ?>
                                <img id="preview_upload_file" src="{{ asset('public/images/' . $logo->logo_path ) }}" style="/*width: 200px;*/ height: 140px;-o-object-fit: contain;object-fit: contain;" class="img-thumbnail" />
                            </div>
                        </div>
                    </div>

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
                                class="form-control"
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
                                class="form-control" 
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
                                class="form-control" 
                                value="{{ isset($colors['left_sidebar_bg_color']) ? $colors['left_sidebar_bg_color'] : $default_colors['left_sidebar_bg_color'] }}" /> 
                        </div>

                        @error('left_sidebar_bg_color')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Page content background color{!! $required_field_html !!}</label>
                        <div class="input-group colorpicker-component"> 
                            <span class="input-group-addon"><i></i></span>
                            <input type="text"
                                name="colors[page_content_bg_color]"
                                class="form-control" 
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
                                class="form-control" 
                                value="{{ isset($colors['footer_bg_color']) ? $colors['footer_bg_color'] : $default_colors['footer_bg_color'] }}" /> 
                        </div>

                        @error('footer_bg_color')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <input name="submit" type="submit" class="btn btn-custom-primary" value="Update" />

				</form>

            </div>

        </div>

    </div>

    <div class="col-sm-4 col-xs-12"></div>

</div>

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

@endsection