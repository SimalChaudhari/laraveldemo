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
                font-size: 15px !important;
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
                font-size: 18px !important;
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

				<div class="clearfix"></div>

				<h1>Patient Disclosure Authorization</h1>

				<div class="col-sm-12 col-xs-12">
					<p>I, <u>{{ $form->patient_name }}</u> hereby authorize the use or disclosure of my protected health information as described below:</p>

					<h4>1. <u>AUTHORIZED PERSONS TO USE AND DISCLOSE PROTECTED HEALTH INFORMATION</u></h4>

					<u>{{ $form->section_one_data['field1'] }}</u> is authorized to disclose the following protected health information to <u>{{ $form->section_one_data['field2'] }}</u> of <u>{{ $form->section_one_data['field3'] }}</u>, <u>{{ $form->section_one_data['field4'] }}</u>.

					<h4>2. <u>DESCRIPTION OF INFORMATION TO BE DISCLOSED</u></h4>
					<p>The health information that may be disclosed is:</p>
					<p>All past, present, and future periods of health care information may be shared.</p>

					<h4>3. <u>PURPOSE OF THE USE OR DISCLOSURE</u></h4>
					<p>The purpose of this use or disclosure is <u>{{ $form->form_purpose }}</u>.</p>

					<h4>4. <u>VALIDITY OF AUTHORIZATION FORM</u></h4>
					<p>This Authorization Form is valid beginning on <u>{{ $form->authorization_start }}</u> and expires on <u>{{ $form->authorization_expiry }}</u>.</p>

					<h4>5. <u>ACKNOWLEDGMENT</u></h4>
					<p>I understand that the information used or disclosed under this Authorization Form may be subject to re-disclosure by the person(s) or facility receiving it and would then no longer be protected by federal privacy regulations.</p>

					<p>I have the right to refuse to sign this Authorization Form. If signed, I have the right to revoke this authorization, in writing, at any time. I understand that any action already taken in reliance on this authorization cannot be reversed, and my revocation will not affect those actions.</p>

					<div class="row">
						<div class="col-sm-6 col-xs-12">
							<strong>By:</strong> <u>{{ $form->acknowledgement_by }}</u>
						</div>

						<div class="col-sm-6 col-xs-12 text-right">
							<strong>Date:</strong> <u>{{ \Carbon\Carbon::now()->format( config('app.VIEW_DATE_FORMAT') ) }}</u>
						</div>
					</div>

					<div class="row">
						<div class="form-group">
							<label>Signature</label>
							<img src="data:{{ $form->signature_str_svg }}" />
						</div>
					</div>
				</div>

			</div>

		</div>
	</body>
</html>