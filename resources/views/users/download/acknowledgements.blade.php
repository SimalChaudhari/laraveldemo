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

		<div class="container">

			<div class="row">

				<div class="col-xs-12 col-sm-12 text-center">
					<img src="{{ base_path('public/images/613309f84aa66.png') }}" />
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
		                                    <td><b>HIPPA Compliance Officer:</b> {{ ucfirst( $ack->compliance_officer ) }}</td>
		                                    <td><b>Date:</b> {{ \Carbon\Carbon::parse( $ack->compliance_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
		                                </tr>

		                                <tr>
		                                    <td><b>Employee Acknowledgement:</b> {{ ucfirst( $ack->acknowledgement_by ) }}</td>
		                                    <td><b>Acknowledgement Date:</b> {{ \Carbon\Carbon::parse( $ack->acknowledgement_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
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
					<h1>Employee Training Acknowledgement</h1>
		        	<?php if( $emp_training_ack->count() > 0 ) { ?>
		        		
		                <?php $loop = 1; foreach( $emp_training_ack as $ack ) { ?>

		                	<div class="panel panel-primary">
		                		<div class="panel-heading">
		                			<h3 class="panel-title">Employee Training Acknowledgement {{ $loop++ }}</h3>
		                		</div>

		                		<div class="panel-body">

		                			<p>This document serves as recognition by the employee that they completed all of the training, and understand the purpose and severity of protecting patient health information.  Patient health information is vital to the operation of medical practices and the access to it will be dictated by the policies we implement. As such, in accordance with current HIPAA and Omnibus regulations, state law and My Medical Practice policies governing the access, use, and disclosure of protected health information, you have the responsibility to protect such data. This agreement is not intended, and should not be construed, to limit or prevent an employee from exercising rights under the National Labor Relations Act.</p>

									<p>&nbsp;</p>

									<p>This document provides you with the appropriate direction and assists you in understanding your duty and obligations in regards to confidential information. By signing this document it indicates you have been advised and trained on the appropriate way to handle patient health information, and you understand what has been set forth.</p>

									<p>&nbsp;</p>

									<p>You are agreeing to:</p>

									<ol>
										
										<li>To respect the privacy and confidentiality of patient health information you may have access to while performing your job.</li>
										<li>To communicate only with people that are designated to receive patient health information, and also in a way that cannot be overheard or intercepted in an unapproved manner.</li>
										<li>To safeguard and not disclose your password or login id, to anyone. You also must change your password based on the frequency dictated in our policies governing such.</li>
										<li>To not use anyone else login information.</li>
										<li>You must immediately report any suspicions that any of the HIPAA rules may have been violated.</li>
										<li>You must obtain approval for the use of portable media devices from the HIPAA compliant officer. You must also obtain approval to connect any portable media to the network, from the HIPAA compliant officer.</li>
										<li>You must not remove or copy any protected information or reports except to fulfill your job. You must not remove any protected information from the building unless approved by the HIPAA compliance officer.</li>
										<li>You must not sell, loan, alter or destroy protected information unless approved and directed by the HIPAA compliance officer.</li>
										<li>You understand that your actions and the actions on the protected network are monitored and reported on.</li>
										<li>You agree to not visit, view or download anything from any website that has not been approved by you HIPAA compliance officer.</li>
										<li>You agree to not use any part of the network to send, forward or instigate obscene, insulting, defamatory, or threatening messages.</li>

									</ol>

									<p>If your employment is terminated either by the corporation or yourself you agree to:</p>

									<ol>

										<li>
											Deliver to HIPAA compliance officer
											<ul style="list-style-type: lower-alpha;">
												<li>Medical information</li>
												<li>Information manuals</li>
												<li>Notebooks</li>
												<li>Reports</li>
												<li>Login information</li>
												<li>Employee and vendor lists</li>
												<li>Anything else received from the corporation</li>
											</ul>

										</li>

									</ol>

									<p>If any of the above numbered provisions, in whole or in part, of this agreement is declared void or unenforceable by a court of competent jurisdiction, the remainder this agreement or the remainder of such provisions shall remain in full force and effect.</p>

									<p>&nbsp;</p>

									<p>I understand that the governance of this policy continues and applies after the termination, expiration, and cancellation of this agreement. I understand my access to the network and protected information can be revoked if any of the above have been suspected of being violated.</p>

									<p>&nbsp;</p>

									<p><strong>Employee</strong></p>

									<p>&nbsp;</p>

									<p><strong>Printed Name: </strong>{{ $ack->printed_name }}</p>
									<p><strong>Signature: </strong> <img src="data:{{ $ack->signature }}" /></p>
		                			
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
		                                    <td><b>HIPPA Compliance Officer:</b> {{ ucfirst( $ack->compliance_officer ) }}</td>
		                                    <td><b>Date:</b> {{ \Carbon\Carbon::parse( $ack->compliance_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
		                                </tr>

		                                <tr>
		                                    <td><b>Employee Acknowledgement:</b> {{ ucfirst( $ack->acknowledgement_by ) }}</td>
		                                    <td><b>Acknowledgement Date:</b> {{ \Carbon\Carbon::parse( $ack->acknowledgement_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
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