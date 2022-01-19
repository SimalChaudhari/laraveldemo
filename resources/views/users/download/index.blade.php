<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style>
        	<?php include(public_path() . '/lib/bootstrap/css/bootstrap.min.css'); ?>

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

		<div class="container" style="page-break-after: always;">

			<div class="row">

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		        	<h1>Training Acknowledgement</h1>
		        	<?php if( $training_ack->count() > 0 ) { ?>
		        		
		                <?php $loop = 1; foreach( $training_ack as $ack ) { ?>

		                	<div class="panel panel-primary">
		                		<div class="panel-heading">
		                			<h3 class="panel-title">Acknowledgement {{ $loop++ }}</h3>
		                		</div>

		                		<div class="panel-body">
		                			<table class="table table-bordered">
		                                <tr>
		                                    <td colspan="2" class=""><b>HIPPA Compliance Officer:</b> {{ ucfirst( $ack->compliance_officer ) }}</td>
		                                    <td><b>Date:</b> {{ \Carbon\Carbon::parse( $ack->compliance_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
		                                </tr>

		                                <tr>
		                                    <td><b>Acknowledgement Date:</b> {{ \Carbon\Carbon::parse( $ack->acknowledgement_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
		                                    <td><b>Acknowledgement:</b> {{ $ack->acknowledgement_text }}</td>
		                                    <td><b>Employee Acknowledgement:</b> {{ ucfirst( $ack->acknowledgement_by ) }}</td>
		                                </tr>
		                            </table>
		                		</div>
		                	</div>
			                    
		                <?php } ?>

		            <?php } ?>
		        </div>

			</div>

		</div>

		<div class="container" style="page-break-after: always;">

			<div class="row">

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		        	<h1>Risk Assessment Acknowledgement</h1>
		        	<?php if( $risk_ack->count() > 0 ) { ?>
		        		
		                <?php $loop = 1; foreach( $risk_ack as $ack ) { ?>

		                	<div class="panel panel-primary">
		                		<div class="panel-heading">
		                			<h3 class="panel-title">Acknowledgement {{ $loop++ }}</h3>
		                		</div>

		                		<div class="panel-body">
		                			<table class="table table-bordered">
		                                <tr>
		                                    <td colspan="2" class=""><b>HIPPA Compliance Officer:</b> {{ ucfirst( $ack->compliance_officer ) }}</td>
		                                    <td><b>Date:</b> {{ \Carbon\Carbon::parse( $ack->compliance_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
		                                </tr>

		                                <tr>
		                                    <td><b>Acknowledgement Date:</b> {{ \Carbon\Carbon::parse( $ack->acknowledgement_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
		                                    <td><b>Acknowledgement:</b> {{ $ack->acknowledgement_text }}</td>
		                                    <td><b>Employee Acknowledgement:</b> {{ ucfirst( $ack->acknowledgement_by ) }}</td>
		                                </tr>
		                            </table>
		                		</div>
		                	</div>
			                    
		                <?php } ?>

		            <?php } ?>
		        </div>
				
			</div>

		</div>

	</body>
</html>