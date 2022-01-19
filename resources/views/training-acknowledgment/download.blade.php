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
		        	<h1>Training Acknowledgement</h1>

                	<div class="panel panel-primary">
                		<div class="panel-heading">
                			<h3 class="panel-title">Acknowledgement 1</h3>
                		</div>

                		<div class="panel-body">
                			<table class="table table-bordered">
                                <tr>
                                    <td style="width: 50%;"><b>HIPPA Compliance Officer:</b> {{ ucfirst( $ack->compliance_officer ) }}</td>
                                    <td style="width: 50%;"><b>Date:</b> {{ \Carbon\Carbon::parse( $ack->compliance_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
                                </tr>

                                <tr>
                                    <td style="width: 50%;"><b>Employee Acknowledgement:</b> {{ ucfirst( $ack->acknowledgement_by ) }}</td>
                                    <td style="width: 50%;"><b>Acknowledgement Date:</b> {{ \Carbon\Carbon::parse( $ack->acknowledgement_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
                                </tr>
                            </table>
                		</div>
                	</div>
		                
		        </div>

			</div>

		</div>

	</body>

</html>