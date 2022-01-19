<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="{{ asset( 'public/lib/bootstrap/css/bootstrap.css') }}" />
        <style>
        	body {
                color: #333333;
                font-family: "Open Sans", sans-serif !important;
                padding: 0px !important;
                margin: 0px !important;
                font-size: 13px !important;
                direction: ltr;
            }
            .no-padding {
                padding: 0 !important;
            }
            h3.panel-title {
            	font-weight: bold;
            }
            label {
				width: 100%;
				margin-bottom: 5px;
			}
		</style>
	</head>
	<body>
		
		<div class="container">

			<div class="row">

				<div class="col-xs-12 col-sm-12 text-center">
					<img src="{{ base_path('public/images/613309f84aa66.png') }}" />
				</div>

			</div>

		</div>

		<div class="clearfix"></div>

		<div class="container">

			<div class="row">
				
				<?php $required_field_html = '<span style="color: red;">*</span>'; ?>
				@include('online-forms.' . $form_folder_name . '.download')

			</div>

		</div>

	</body>

</html>