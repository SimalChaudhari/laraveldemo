@extends('layouts.admin')

@section('page_title')
View: {{ ucwords( strtolower( 'Request to Download/Copy' ) ) }} EPHI
@endsection

@section('content')

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">

	<div class="col-sm-3 col-xs-12"></div>

	<div class="col-sm-6 col-xs-12">

		<ol class="breadcrumb">
            <li><a href="javascript:;">HIPAA Container</a></li>
            <li><a href="{{ route('UI_allOnlineForms') }}">Online Forms</a></li>
            <li class="active">{{ ucwords( strtolower( 'Request to Download/Copy' ) ) }} EPHI</li>
        </ol>
        
		<div class="panel panel-default">

			<div class="panel-heading">
				<h3 class="panel-title">{{ ucwords( strtolower( 'Request to Download/Copy' ) ) }} EPHI</h3>
			</div>

			<div class="panel-body">

				<table class="table table-bordered table-hover">
					<tr class="odd gradeX">
						<td><strong>Date:</strong></td>
						<td>{{ \Carbon\Carbon::parse( $form->cur_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
					</tr>
					<tr class="odd gradeX">
						<td><strong>Person Making the Request:</strong></td>
						<td>{{ ucfirst( $form->person ) }}</td>
					</tr>
					<tr class="odd gradeX">
						<td><strong>Reason for download/copy of EPHI:</strong></td>
						<td>{{ ucfirst( $form->reason ) }}</td>
					</tr>
					<tr class="odd gradeX">
						<td colspan=2>
							<p style="text-align:justify;">Minimum Necessary Disclosure: The Privacy Rule generally requires covered entities to take reasonable steps to limit the use or disclosure of, and requests for, protected health information to the mininium necessary to accomplish the intended purpose. The minimum necessary standard does not apply to the following:
								<br> 1) Disclosures to or requests by a health care provider for treatment purposes. 2) Disclosures to the individual who is the subject of the information. 3) Uses or disclosures made pursuant to an individual's authorization. 4) Uses or disclosures required for compliance with the Health Insurance Portability and Accountability Act (HIPAA) Administrative Simplification Rules. 5) Disclosures to the Department of Health and Human Services (IHIS) when disclosure of information is required under the Privacy Rule for enforcement purposes. 6) Uses or disclosures that are required by other law.</p>
						</td>
					</tr>
					<tr class="odd gradeX">
						<td><strong>Description of Information to be Disclosed:</strong></td>
						<td>{{ ucfirst( $form->description ) }}</td>
					</tr>
					<tr class="odd gradeX">
						<td><strong>Purpose of use or disclosure</strong></td>
						<td>{{ ucfirst( $form->purpose ) }}</td>
					</tr>
					<tr class="odd gradeX">
						<td><strong>Has the Minimum Necessary Standard Been Applied:</strong></td>
						<td>{{ ucfirst( $form->necessary ) }}</td>
					</tr>
					<tr class="odd gradeX">
						<td><strong>Approved By:</strong></td>
						<td>{{ ucfirst( $form->approve ) }}</td>
					</tr>
					<tr class="odd gradeX">
						<td><strong>Date:</strong></td>
						<td>{{ \Carbon\Carbon::parse( $form->app_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
					</tr>
					<tr class="odd gradeX">
						<td><strong>Not approved due to the following:</strong></td>
						<td>{{ ucfirst( $form->not_approve ) }}</td>
					</tr>
				</table>

				<h2 style="text-align: center;">Chart Review Policy and Certification Requirement</h2>
				<p style="text-align:justify;"><b>PROTECTING PATEINT PRIVACY</b> is a primary concern in our office. In accordance with HIPAA, Omnibus and our own internal policies and procedrres we have instituted the following policy to ensure the confidentiality of Protected Health Information (PHI) and Electronic Protected Health Irformation (ePHI).</p>
				<p style="text-align:justify;">This policy addresses <u>Chart Reviews</u> or other operations where patient records are to be reviewed and/or removed from our office by business associates to our practice. HIPAA clearly states that our office is responsible for the actions of our business associates and that we must insure that the business associate properly protects PHI/epHI and is HIPAA compliant.</p>
				<h3><b>Business Associate Agreement and Certification Required</b></h3>
				<p style="text-align:justify;">An up-to-date Omnibus Business Associate Agreement must be in place before any business associate or their sub-contractor is allowed access to patient information. In addition, the business associate and any sub-contractor must submit Certification that the business associate(s) have 1 ) had a comprehensive risk assessment in the past year, 2) that all staff handling our PHI/ePHI has been trained on HIPAA protections and 3) that the business associate has a full set of policies and procedures for the HIPAA Privacy and Security Rule. Business associates without these requirements are deemed by the Office of Civil Rights to be in "willful neglect" and are not HIPAA compliant. Therefore for legal reasons and the protection of patient privacy business associates who cannot provide Certification of their HIPAA compliance will not be permitted to access patient records(PHI/ePHI). In addition, sub-contractors of our business associates must submit evidence that an Omnibus updated Business Associate Agreement with our Business Associate is in place.</p>
				<h3><u><b>Only Encrypted Data (PHI/ePHI) Is Allowed To Be Taken Off-site</b></u></h3>
				<p style="text-align:justify;">Our practice requires that all patient data that is taken out of our office in digital format must be encrypted to Department of Defense (DOD) standards. Encryption is a "safe harbor" to the Breach Notification Rule and greatly protects patient privacy. Our staff is instructed to verify that the media device used for downloading of epHI is encrypted. In addition, the business associate or their sub- contractor must provide certification that the media device is new or that the device has been scanned for malware before we will allow the device to be connected to our network. Paper records taken off-site must be in a closed secure container and kept in a locked vehicle and hidden from sight.</p>

				<table class="table table-bordered table-hover">
					<tr class="odd gradeX">
						<td><strong>Business Associate:</strong></td>
						<td>{{ ucfirst( $form->buss ) }}</td>
					</tr>
					<tr class="odd gradeX">
						<td><strong>Sub-Contractor</strong></td>
						<td>{{ ucfirst( $form->sub ) }}</td>
					</tr>
					<tr class="odd gradeX">
						<td><strong>Business Associate Agreement In-Place with Business Associate:</strong></td>
						@if($form->agree == 'Yes')
							<td>Yes</td>
						@else
							<td>No</td>
						@endif
					</tr>
					<tr class="odd gradeX">
						<td><strong>Sub-Contractor states They Have an omnibus BAA with the B.A.:</strong></td>
						@if( $form->sub_cont == 'Yes')
							<td>Yes</td>
						@else
							<td>No</td>
						@endif
					</tr>
					<tr class="odd gradeX">
						<td><strong>Portable Media Device Used to remove ePIH:</strong></td>
						<td>{{ ucfirst( $form->port ) }}</td>
					</tr>
					<tr class="odd gradeX">
						<td><strong>Business Associate stated Device is New or scanned for Malware:</strong></td>
						@if($form->device == 'Yes')
							<td>Yes</td>
						@else
							<td>No</td>
						@endif
					</tr>
					<tr class="odd gradeX">
						<td><strong>Encryption Method:</strong></td>
						<td>{{ ucfirst( $form->encry ) }}</td>
					</tr>
					<tr class="odd gradeX">
						<td><strong>Encryption Verified:</strong></td>
						@if( $form->encry_veri == 'Yes') 
							<td>Yes</td>
						@else
							<td>No</td>
						@endif
					</tr>
					<tr class="odd gradeX">
						<td><strong>Number of patient Records Placed On Device:</strong></td>
						<td>{{ ucfirst( $form->records ) }}</td>
					</tr>
					<tr class="odd gradeX">
						<td><strong>HIPAA Compliance Officer:</strong></td>
						<td>{{ ucfirst( $form->officer ) }}</td>
					</tr>
					<tr class="odd gradeX">
						<td><strong>Date:</strong></td>
						<td>{{ \Carbon\Carbon::parse( $form->sign_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
					</tr>
				</table>

			</div>

		</div>

	</div>

	<div class="col-sm-3 col-xs-12"></div>

	<div class="clearfix"></div>

</div>

@endsection