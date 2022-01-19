@extends('layouts.admin')

@section('page_title')
HIPAA Safe Harbor
@endsection

@section('content')

<x-alert />

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">

	<div class="col-sm-12 col-xs-12">

		<div class="panel panel-default panel-custom">

			<div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <h3 class="panel-title"><i class="fa fa-2x fa-universal-access" aria-hidden="true"></i> Safe Harbor</h3>
                    </div>
                </div>
            </div>

			<div class="panel-body">

				<p>"HIPAA Safe Harbor" for Medical Professionals using Best Practices:</p>

				<ul>
					<li style="margin-bottom: 10px;">Before January 5, 2021, fines, settlements and penalties for HIPAA non-compliance totaled over $40 million for the prior two years alone. On that date Congress passed a law introducing a "Safe Harbor" protecting HIPAA-covered practices and Business Associates from those financial penalties—If they adopt so-called Best Practices, and if those Best Practices have been in place for the prior 12 months.</li>
					<li style="margin-bottom: 10px;">Hipaamart provides easy-to-use procedures to comply with Best Practices objectives set forth in the HIPAA Safe Harbor Act with respect to Training and Risk Assessment.</li>
					<li style="margin-bottom: 10px;">A cybersecurity information security specialist should also be retained locally to protect the medical provider's computer system from illegal hacks and ransomware attacks.</li>
					<li style="margin-bottom: 10px;">A medical practice can be audited for HIPAA violations by the Office of Civil Rights (OCR) of the Health and Human Services (HHS) Department.</li>
					<li>There is some flexibility in the Security Rule, depending on your practice's size.</li>
				</ul>

			</div>

		</div>

	</div>

</div>

@endsection