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
			h1 {
				text-align: center;
				font-size: 25px;
				font-weight: bold;
			}

			h2 {
				font-weight: bold;
				font-size: 18px;
			}
			.decorate_input_txt {
				border: 0;
				border-bottom: 1px solid;
				width: 100%;
			}
			.decorate_input_txt:focus,
			.decorate_input_txt:active {
				outline: none;
			}
			.no-padding {
				padding: 0;
			}
			p:not(.lead), ol, label, input, textarea, .fs-15 {
                font-size: 15px !important;
            }
            ol li:not(:last-child) {
                margin-bottom: 10px;
            }
		</style>
	</head>
	<body>

		<div class="container" style="page-break-after: always;">

			<div class="row">

				<div class="col-xs-12 col-sm-12 text-center">
					<img src="{{ base_path('public/images/613309f84aa66.png') }}" />
				</div>

				<div class="clearfix"></div>

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<?php if( $results->count() > 0 ) { ?>

		                <?php foreach( $results as $result ) { ?>

		                	@include('quiz.result-question-list')
			                    
		                <?php } ?>

		            <?php } ?>
		        </div>

			</div>

		</div>

	</body>

</html>