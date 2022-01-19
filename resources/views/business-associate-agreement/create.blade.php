@extends('layouts.admin')

@section('page_title')
Create: Business Associate Agreement
@endsection

@section('content')

<style>
#business_associate_agreement_form input,
#business_associate_agreement_form input:focus,
#business_associate_agreement_form input:active {
    outline: none;
}
#business_associate_agreement_form input {
	margin-bottom: 10px;
	border: 0;
    border-bottom: 1px solid #333;
}
</style>

<link rel="stylesheet" href="{{ asset('public/lib/datepickr/jquery-ui.css') }}" />
<script src="{{ asset('public/lib/datepickr/jquery-1.9.1.js') }}"></script>
<script src="{{ asset('public/lib/datepickr/jquery-ui.js') }}"></script>


<!-- this, preferably, goes inside head element: -->
<!--[if lt IE 9]>
<script type="text/javascript" src="{{ asset('public/lib/jSignature/flashcanvas.js') }}"></script>
<![endif]-->

<script src="{{ asset('public/lib/jSignature/jSignature.min.js') }}"></script>

<x-alert />

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">

	<div class="col-sm-2 col-xs-12"></div>

	<div class="col-sm-8 col-xs-12">

		<ol class="breadcrumb">
	        <li><a href="javascript:;">Document Library</a></li>
	        <li class="active">Business Associate Agreement</li>
	    </ol>

		<div class="panel panel-default">

			<div class="panel-heading">
				<h3 class="panel-title text-center"><strong>Business Associate Agreement</strong><a href="{{ route('business-associate-agreement.index') }}" class="btn btn-custom-danger btn-xs pull-right">&laquo; Back</a></h3>
			</div>

			<div class="panel-body">

				<p class="col-sm-12 col-xs-12 text-right" style="padding-right: 0;"><small>({!! $required_field_html !!}) All fields are mandatory.</small></p>

				<form class="validateForm" id="business_associate_agreement_form" method="POST" action="{{ route('business-associate-agreement.store') }}" role="form">
					
					@csrf

					<p>This Business Associate Agreement is made a part of the contract ("Contract") by and between <input type="text" name="covered_entity" class="validate[required, maxSize[255]]" /> the Covered Entity ("CE") and <input type="text" name="business_associate" class="validate[required, maxSize[255]]" /> the Business Associate ("BA"), Dated <input type="text" class="datepicker validate[required, custom[date]]" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" name="agreement_dated_on" autocomplete="off" />.</p>

					<p>This Agreement is effective as of <input type="text" class="datepicker validate[required, custom[date]]" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" name="effective_date" autocomplete="off" /> (the "Agreement Effective Date").</p>

					<h4><u>RECITALS</u></h4>

					<ol style="list-style-type: upper-alpha;">
						<li>CE wishes to disclose certain information to BA pursuant to the terms of the Contract, some of which may constitute protected Health Information ("PHI") (defined below).</li>
						<li>CE and BA intend to protect the privacy and provide for the security of PHI disclosed to BA pursuant to the Contract in compliance with the Health Information Portability and Accountability Act of 1996, Public Law 104-191 ("HIPAA"), the Health Information Technology for Economic and Clinical Health Act (the "HITECH Omnibus Rule"), and regulations promulgated thereunder by the U.S. Department of Health and Human Services (the "HIPAA Regulations") and other applicable laws.</li>
						<li>As part of the HIPAA Regulations, the Privacy Rule and the Security Rule (defined below) require CE to enter into a contract containing specific requirements with BA prior to the disclosure of PHI, as set forth in, but not limited to, 45 C.F.R. § 164.504(e), Title 45, Sections 164.314(a), 164.502(e) and 164.504(e) of the Code of Federal Regulations ("C.F.R."), Final 45 C.F.R. Section 160.103 and contained in this Agreement.</li>
					</ol>

					<p>In consideration of the mutual promises below and the exchange of information pursuant to this Agreement, the parties agree as follows:</p>

					<h4>1. <u>Definitions</u></h4>
					<ol style="list-style-type: lower-alpha;">
						<li>Breach shall have the meaning given to such term under the HITECH Omnibus Rule.</li>
						<li>Business Associate shall have the meaning given to such term under the Privacy Rule, the Security Rule and the HITECH Omnibus Rule, including, but not limited to, Final 45 C.F.R. Section 160.103.</li>
						<li>Covered Entity shall have the meaning given to such term under the Privacy Rule and the Security Rule, including, but not limited to, Final 45 C.F.R. Section 160.103.</li>
						<li>Data Aggregation shall have the meaning given to such term under the privacy Rule, including but not limited to, 45 C.F.R. Section 164.501.</li>
						<li>Designated Record Set shall have the meaning given to such term under the Privacy Rule, including, but not limited to, 45 C.F.R. Section 164.501.</li>
						<li>Electronic Protected Health Information means Protected Health Information that is maintained in or transmitted by electronic media.</li>
						<li>Electronic Health Record shall have the meaning given to such term in the HITECH Omnibus Rule.</li>
						<li>Health Care Operations shall have the meaning given to such term under the Privacy Rule, including, but not limited to, 45 C.F.R. Section 164.501.</li>
						<li>HIPAA Rules. "HIPAA Rules" shall mean the Privacy, Security, Breach Notification and Enforcement Rules at Final 45 CFR Part 160 and Part 164.</li>
						<li>Minimum Necessary shall have the meaning given to such term under the Privacy Rule, including, but not limited to, 45 C.F.R. Section 164.501 and Final 45 C.F.R. § 160.103.</li>
						<li>Privacy Rule shall mean the HIPAA Regulation that is codified at 45 C.F.R. Parts 160 and 164, Subparts A and E.</li>
						<li>Protected Health Information or PHI (also "Protected Information") means any information, whether oral or recorded in any form or medium; (i) that relates to the past, present or future physical or mental condition of an individual; the provision of health care to an individual; or the past, present or future payment for the provision of health care to an individual; and (ii) that identifies the individual or with respect to which there is a reasonable basis to believe the information can be used to identify the individual, and shall have the meaning given to such term under the Privacy Rule, including, but not limited to, 45 C.F.R. Section 164.501. Protected Health Information includes Electronic Protected Health Information [Final 45 C.F.R. Sections 160.103, 164.501].</li>
						<li>Protected Information shall mean PHI provided by CE or BA or created or received by BA on CE's behalf.</li>
						<li>Security Rule shall mean the HIPAA Regulation that is codified at 45 C.F.R. Parts 160 and 164, Subparts A and C.</li>
						<li>Unsecured PHI shall have the meaning given to such term under the HITECH Omnibus Rule and any guidance issued pursuant to such Act including.</li>
					</ol>

					<h4>2. <u>Obligations and Activities of Business Associate</u></h4>
					<ol style="list-style-type: lower-alpha;">
						<li><strong><u>Permitted Uses:</u></strong> BA shall not use Protected Information except for the purpose of performing BA's obligations under the Contract and as permitted under the Contract and Attachments.  Further, BA shall not use Protected Information in any manner that would constitute a violation of the Privacy Rule or the HITECH Omnibus Rule if so used by CE.  However, BA may use Protected Information (i) for the proper management and administration of BA, BA may use Protected Information, (ii) to carry out the legal responsibilities of BA, or (iii) for Data Aggregation purposes for the Health Care Operations of CE [45 C.F.R. Sections 164.504(e)(2)(i), 164.504(e)(2)(ii)(A) and 164.504(e)(4)(i)].</li>
						<li><strong><u>Permitted Disclosures:</u></strong>  BA shall not disclose Protected Information except for the purpose of performing BA's obligations under the Contract and as permitted under the Contract and Agreement.  BA shall not disclose Protected Information in any manner that would constitute a violation of the Privacy Rule or the HITECH Omnibus Rule if so disclosed by CE. However, BA may disclose Protected Information
							<ol style="list-style-type: lower-roman;">
								<li>for the proper internal management and administration of BA;</li>
								<li>to carry out the legal responsibilities of BA;</li>
								<li>as required by law; or</li>
								<li>for Data Aggregation purposes for the Health Care Operation of CE.</li>
							</ol>

							<p>If BA discloses Protected Information to a third party, BA must obtain, prior to making any such disclosure,</p>
							<ol style="list-style-type: lower-roman;">
								<li>reasonable written assurances from such third party that such Protected Information will be held confidential as provided pursuant to this Agreement and only disclosed as required by law or for the purposes for which it was disclosed to such third party, and</li>
								<li>a written agreement from such third party to immediately notify BA of any breaches of confidentiality of the Protected Information, to the extent it has obtained knowledge of such breach [Final 45 C.F.R. § 164.504(e)].</li>
							</ol>
						</li>
						<li><strong><u>Prohibited Uses and Disclosures:</u></strong> BA shall not use or disclose Protected Information for fund-raising or marketing purposes. BA is not allowed to sell CE's Protected Information for any purpose. BA shall not disclose Protected Information to a health plan for payment or health care operations purpose if the patient has requested this special restriction, and has paid out of pocket in full for the health care item or service to which the PHI solely relates 42 U.S.C. Section 17935(a).  BA shall not directly or indirectly receive remuneration in exchange for Protected Information, except with the prior written consent of CE and as permitted by the HITECH Omnibus Rule, however, this prohibition shall not affect payment by CE to BA for services provided pursuant to the Contract.</li>
						<li><strong><u>Appropriate Safeguards:</u></strong> BA shall implement appropriate safeguards as necessary to prevent the use or disclosure of Protected Information otherwise than as permitted by the contract or Attachments, including, but not limited to, administrative, physical and technical safeguards that reasonably and appropriately protect the confidentiality, integrity and availability of the Protected Information, in accordance with 45 C.F.R. Sections 164.308, 164.310, and 164.312.[45 C.F.R. Section 164.504(e)(2)(ii)(b); 45 C.F.R. Section 164.308(b)] and [45 C.F.R. § 164.504(e)]. BA shall comply with the policies and procedures and documentation requirement of the HIPAA Security Rule, including, but not limited to, 45 C.F.R. Section 164.316 and [Final 45 C.F.R. § 164.504(e)].</li>
						<li><strong><u>Reporting Improper Access, Use or Disclosure:</u></strong> BA shall report to CE in writing of any access, use or disclosure of Protected Information not permitted by the Contract and Attachments, and any Breach of Unsecured PHI of which it becomes aware without unreasonable delay and in no case later than seven (7) calendar days after discovery 45 C.F.R. Section 164.504(e)(2)(ii)(c); 45 C.F.R. Section 164.308(b)] and [45 C.F.R. § 164.504(e)] and [Final 45 C.F.R. § 164.504(e)].</li>

						<li><strong><u>Business Associate's Subcontractors and Agents:</u></strong> BA shall ensure that any agents, including subcontractors, to whom it provides Protected Information, agree in writing to the same restrictions and conditions that apply to BA with respect to such PHI and implement the safeguards required by paragraph c above with respect to Electronic PHI [45 C.F.R. Section 164.504(e)(2)(ii); 45 C.F.R. Section 164.308(b)] and [45 C.F.R. § 164.504(e)]. BA shall ensure compliance with and maintain documentation of compliance with the "HIPAA Rules".  BA shall implement and maintain sanctions against agents and subcontractors that violate such restrictions and conditions, and shall mitigate the effects of any such violation (see 45 C.F.R. Sections 164.530(f), 164.530(e)(1)) and [45 C.F.R. § 164.504(e)].</li>

						<li><strong><u>Access to Protected Health Information:</u></strong> BA shall make Protected Health Information maintained by BA or its agents or subcontractors in Designated Record Sets available to CE for inspection and copying within ten (10) days of a request by CE to enable CE to fulfill its obligations under the Privacy Rule, including, but not limited to, 45 C.F.R. Section 164.524 [45 C.F.R. Section 164.504(e)(2)(ii)(E)]. If BA maintains an Electronic Health Record, BA shall provide such information in electronic format to enable CE to fulfill its obligations under the HITECH Omnibus Rule, and [Final 45 C.F.R. § 164.504(e)]. BA shall notify CE within seven (7) days should the individual request Protected Health Information from the BA and forward any Protected Health Information requested to the CE within ten (10) days. Unless agreed to and documented, BA will not directly disclose Protected Health Information.</li>

						<li><strong><u>Amendment of PHI:</u></strong> Within 10 (ten) days of receipt of a request from CE for an amendment of Protected Information or a record about an individual contained in a Designated Record Set, BA or its agents or subcontractors shall make such Protected Information available to CE for amendment and incorporate any such amendment to enable CE to fulfill its obligations under the Privacy Rule, including, but not limited to, 45 C.F.R. Section 164.526. If any individual requests an amendment of Protected Information directly from BA or its agents or subcontractors, BA must notify CE in writing five (5) days of the request.</li>

						<li><strong><u>Accounting of Disclosures Rights:</u></strong> Promptly upon any disclosure of Protected Information for which CE is required to account to an individual, BA and its agents or subcontractors shall make available to CE the information required to provide an accounting of disclosures to enable CE to fulfill its obligations under the Privacy Rule, including, but not limited to, 45 C.F.R. Section 164.528, and the HITECH Omnibus Rule, including but not limited to, as determined by CE. Accounting of disclosures from paper records, outside of payment, treatment or health care operations purposes are required to be collected and maintained by BA and its agent or subcontractors for at least six (6) years prior to the request. However, accounting of disclosures from an Electronic Health Record for treatment, outside of payment, treatment or health care operations purposes are required to be collected and maintained for only three (3) years prior to the request, and only to the extent that BA maintains an electronic health record and is subject to this requirement. At a minimum, the information collected and maintained shall include: (i) the date of disclosure; (ii) the name of the entity or person who received Protected Information and, if known, the address of the entity or person; (iii) a brief description of Protected Information disclose; and (iv) a brief statement of purpose of the disclosure that reasonably informs the individual of the basis for the disclosure. In the event that the request for an account is delivered directly to BA or its agents or subcontractors, BA shall within five (5) days of a request forward it to CE in writing. BA shall not disclose any Protected Information except as set forth in Sections 2.b of this Agreement [45 C.F.R. Sections 164.504(e)(2)(ii)(G) and 165.528]. The provisions of this subparagraph shall survive the termination of this Agreement.</li>

						<li><strong><u>Governmental Access to Records:</u></strong> BA shall make its internal practices, books and records relating to the use and disclosure of Protected Information available to CE and to the Secretary of the U.S. Department of Health and Human Services (the "Secretary") for purposes of determining BA's compliance with the Privacy Rule [45 C.F.R. Section 164.504(e)(2)(ii)(H). BA shall provide to CE a copy of any Protected Information that BA provides to the Secretary concurrently with providing such Protected Information to the Secretary.</li>

						<li><strong><u>Minimum Necessary:</u></strong> BA (and its agents or subcontractors) shall request, use and disclose only the minimum amount of Protected Information necessary to accomplish the purpose of the request, use or disclosure, [45 C.F.R. Section 164.514(d)(3)] BA understands and agrees that the definition of "minimum necessary" is as stated in 78 Fed. Reg. 5,559 and that the standard will "vary based on the circumstances" and that the BA will stay apprised of future guidance by Health and Human Services as to specific application of the minimum necessary standard to business associates.</li>

						<li><strong><u>Data Ownership:</u></strong> BA acknowledges that BA has no ownership rights with respect to the Protected Information.</li>

						<li><strong><u>Notification of Breach:</u></strong> During the term of the Contract, BA shall notify CE within seven (7) days of any suspected or actual breach of security, intrusion or unauthorized use or disclosure of PHI of which BA becomes aware and/or any actual or suspected use or disclosure of data in violation of any applicable federal or state laws or regulations. BA shall take (i) prompt corrective action to cure any such deficiencies and (ii) any action pertaining to such unauthorized disclosure required by applicable federal and state laws and regulations including [Final 45 C.F.R. § 164.504(e)]. n. Breach Pattern or Practice by Covered Entity. If the BA knows of a pattern of activity or practice of the CE that constitutes a material breach or violation of the CE's obligations under the Contract or Attachments or other arrangement, the BA must take reasonable steps to cure the breach or end the violation. If the steps are unsuccessful, the BA must terminate the Contract or other arrangement if feasible. BA shall provide written notice to CE of any pattern of activity or practice of the CE that BA believes constitutes a material breach or violation of the CE's obligations under the Contract or Attachments or other arrangement within five (5) days of discovery and shall meet with CE to discuss and attempt to resolve the problem as one of the reasonable steps to cure the breach or end the violation.</li>

						<li><strong><u>Audits, Inspection and Enforcement:</u></strong> Within ten (10) days of a written request by CE, BA and its agents or subcontractors shall allow CE to conduct a reasonable inspection of the facilities, systems, books, records, agreement, policies and procedures relating to the use or disclosure of Protected Information pursuant to this Agreement for the purpose of determining whether B.A. has complied with this Agreement; provided, however that (i) BA and CE shall mutually agree in advance upon the scope, timing and location of such an inspection, (ii) CE shall protect the confidentiality of all confidential and proprietary information of BA to which CE has access during the course of such inspection' and (iii) CE shall execute a nondisclosure agreement, upon terms mutually agreed upon by the parties, if requested by BA. The fact that CE inspects, or fails to inspect, or has the right to inspect, BA's facilities, systems, books, records, agreement, policies and procedures does not relieve BA of its responsibility to comply with this Agreement, nor does CE's (i) failure to detect or (ii) detection, but failure to notify BA or require BA's remediation of any unsatisfactory practices, constitute acceptance of such practice or a waiver of CE's enforcement rights under the Contract or Agreement. BA shall notify CE within ten (10) days of learning that BA has become the subject an audit, compliance review, or complaint investigation by the Office of Civil Rights.</li>

						<li><strong><u>Remedies in Event of Breach:</u></strong> BA hereby recognizes that irreparable harm will result to CE, and to the business of CE, in the event of breach by BA or subcontractor of the BA of any of the covenants and assurances contained in Paragraphs a thru o of this section. As such, in the event of breach of any of the covenants and assurances contained in Paragraph 2. a thru o above, CE shall be entitled to enjoin and restrain BA from any continued violation of Paragraph 2. a thru o. Further, in the event of breach of Paragraph 2. a thru o by BA or subcontractor of the BA, CE shall be entitled to reimbursement and indemnification from BA for the CE's reasonable attorneys fees and expenses and costs that were reasonably incurred as a proximate result of the BA's breach. The remedies constrained in this Paragraph p shall be in addition to (and not supersede) any action for damages and/or other remedy CE may have for breach of any part of this Agreement.</li>
					</ol>

					<h4>3. <u>Termination</u></h4>
					<ol style="list-style-type: lower-alpha;">
						<li><strong><u>Material Breach:</u></strong> A breach by BA of any provision of this Agreement, as determined by CE, shall constitute a material breach of the Contract and shall provide grounds for immediate termination of the Contract, any provision in the Contract to the contrary notwithstanding. [45 C.F.R. Section 164.504(e)(2)(iii)] and [Final 45 C.F.R. § 164.504(e)].</li>

						<li><strong><u>Judicial or Administrative Proceedings:</u></strong> CE may terminate the Contract, effective immediately, if (i) BA is named as a defendant in a criminal proceeding for a violation of HIPAA, The HITECH Omnibus Rule, the HIPAA Regulations or other security or privacy laws or (ii) a finding or stipulation that the BA has violated any standard or requirement of HIPAA, the HITECH Omnibus Rule, the HIPAA Regulations or other security or privacy laws is made in any administrative, civil or criminal proceeding in which the party has been joined.</li>

						<li><strong><u>Effect of Termination:</u></strong> Upon termination of the Contract for any reason, BA shall, at the option of CE, return or destroy all Protected Information that BA or its agents or subcontractors still maintain in any form, and shall retain no copies of such Protected Information. If return or destruction is not feasible, as determined by CE, BA shall continue to extend the protections of Section 3 of this Agreement to such information, and limit further use of such PHI to those purposes that make the return or destruction of such PHI infeasible [45 C.F.R. Section 164.504(e)(ii)(2)(1)]. If CE elects destruction of the PHI, BA shall certify in writing to CE that such PHI has been destroyed in compliance with standards set by "HIPAA Rule" Regulations.</li>

						<li>Survival. The obligations to protect Protected Health Information of BA shall survive the termination of this agreement.</li>

					</ol>

					<h4>4. <u>Disclaimer</u></h4>
					<p>CE makes no warranty or representation that compliance by BA with this Addendum, HIPAA, the HITECH Omnibus Rule, or the HIPAA Regulations will be adequate or satisfactory for BA's own purposes. BA is solely responsible for all decisions made by BA regarding the safeguarding of PHI.</p>

					<h4>5. <u>Certification</u></h4>
					<p>To the extent that CE determines that such examination is necessary to comply with CE's legal obligation pursuant to HIPAA relating to certification of its security practices, CE or its authorized agents or subcontractors, may at CE's expense, examine BA's facilities, security risk assessment, policies, procedures, employee training requirements, employee files and other systems. BA will follow procedures and complete records as may be necessary for such agents or subcontractors to certify to CE the extent to which BA's security safeguards comply with HIPAA, the HITECH Omnibus Rule, the HIPAA Regulations or this Agreement.</p>

					<h4>6. <u>Amendment</u></h4>
					<ol style="list-style-type: lower-alpha;">
						<li>Amendment to Comply with Law. The parties acknowledge the state and federal laws relating to data security and privacy are rapidly evolving and that amendment of the Contract or Agreement may be required to provide for procedures to ensure compliance with such development. The parties specifically agree to take such action as is necessary to implement the standards and requirements of HIPAA, the HITECH Omnibus Rule, the Privacy Rule, The Security Rule and other applicable laws relating to the security or confidentiality of PHI. The parties understand and agree that CE must receive satisfactory written assurance from BA that BA will adequately safeguard all Protected Information. Upon the request of either party, the other party agrees to promptly enter into negotiations concerning the terms of an amendment to this Agreement embodying written assurances consistent with the standards and requirements of HIPAA, The HITECH Omnibus Rule, the Privacy Rule or other applicable laws. CE may terminate the Contract upon thirty (30) days written notice in the event (i) BA does not promptly enter into negotiations to amend the Contract or Addendum when requested by CE pursuant to this Section or (ii) BA does not enter into an amendment to the Contract or Agreement providing assurances regarding the safeguarding of PHI that CE, in its sole discretion, deems sufficient to satisfy the standards and requirements of applicable laws.</li>
					</ol>

					<h4>7. <u>Assistance in Litigation or Administrative Proceedings</u></h4>
					<p>BA shall make itself, and any subcontractors, employees or agents assisting BA in the perform ace of its obligations under the Contract or Agreement, available to CE, at no cost to CE, to testify as a witnesses, or otherwise in the event of litigation or administrative proceedings being commenced against CE, its directors, officers or employees based upon a claimed violation of HIPAA, the HITECH Omnibus Rule, the Privacy Rule, The Security Rule, or other laws relating to security and privacy, except where BA or its subcontractors, employee or agent is a named adverse party.</p>

					<h4>8. <u>No Third-Party Beneficiaries</u></h4>
					<p>Nothing express or implied in the Contract or Agreement is intended to confer, nor shall anything herein confer, upon any person other than CE, BA and their respective successors or assigns, any rights, remedies, obligations or liabilities whatsoever.</p>

					<h4>9. <u>Effect on Contract</u></h4>
					<p>Except as specifically required to implement the purposes of this Agreement, or to the extent inconsistent with this Agreement, all other terms of the Contract shall remain in force and effect.</p>

					<h4>10. <u>Interpretation</u></h4>
					<p>The provisions of the Agreement shall prevail over any provisions in the Contract that may conflict or appear inconsistent with any provision in the Agreement. This Agreement and the Contract shall be interpreted as broadly as necessary to implement and comply with HIPAA, the HITECH Omnibus Rule, the Privacy Rule and the Security Rule. The parties agree that any ambiguity in this Agreement shall be resolved in favor of a meaning that complies and is consistent with HIPAA, the HITECH Omnibus Rule, the Privacy Rule and the Security Rule.</p>

					<p>IN WITNESS WHEREOF, the parties hereto have duly executed this Agreement as of the Agreement Effective Date.</p>

					<div class="row">
						<div class="col-sm-12 col-xs-12">

							<h4>COVERED ENTITY</h4>

							<p><input type="text" name="covered_entity_name_footer" class="validate[required, maxSize[255]]" /></p>

							<div class="form-group">
								<label class="col-sm-1 col-xs-12">By:</label>
								<div class="col-sm-8 col-xs-12" style="border-bottom: 1px solid;">
									<div id="covered_entity_signature_pad"></div>
								</div>
								<div class="col-sm-9 col-xs-12 text-right">
									<a class="clear_signature_pad" data-signature_div_id="covered_entity_signature_pad" style="cursor: pointer;">(Clear)</a>
								</div>

								<input type="hidden" name="covered_entity_signature_base" id="covered_entity_signature_base" />
								<input type="hidden" name="covered_entity_signature_svg" id="covered_entity_signature_svg" />
							</div>

							<div class="clearfix"></div>
							<p>&nbsp;</p>
							<p><strong>Print Name:</strong> <input type="text" name="coverted_entity_print_name" class="validate[required, maxSize[255]]" /></p>
							<p><strong>Title:</strong> <input type="text" name="covered_entity_title" class="validate[required, maxSize[255]]" /></p>
							<p><strong>Date:</strong> <input type="text" name="covered_entity_date" class="datepicker validate[required, custom[date]]" /></p>
						</div>

						<div class="col-sm-12 col-xs-12">
							<h4>BUSINESS ASSOCIATE</h4>
							
							<p><input type="text" name="business_associate_name_footer" class="validate[required, maxSize[255]]" /></p>

							<div class="form-group">
								<label class="col-sm-1 col-xs-12">By:</label>
								<div class="col-sm-8 col-xs-12" style="border-bottom: 1px solid;">
									<div id="business_associate_signature_pad"></div>
								</div>
								<div class="col-sm-9 col-xs-12 text-right">
									<a class="clear_signature_pad" data-signature_div_id="business_associate_signature_pad" style="cursor: pointer;">(Clear)</a>
								</div>
								<input type="hidden" name="business_associate_signature_base" id="business_associate_signature_base" />
								<input type="hidden" name="business_associate_signature_svg" id="business_associate_signature_svg" />
							</div>

							<div class="clearfix"></div>
							<p>&nbsp;</p>
							<p><strong>Print Name:</strong> <input type="text" name="business_associate_print_name" class="validate[required, maxSize[255]]" /></p>
							<p><strong>Title:</strong> <input type="text" name="business_associate_title" class="validate[required, maxSize[255]]" /></p>
							<p><strong>Date:</strong> <input type="text" name="business_associate_date" class="datepicker validate[required, custom[date]]" autocomplete="off" /></p>
						</div>


					</div>

					<input type="submit" name="submit" class="btn btn-custom-primary center-block" value="Submit" style="width: 40%;" />

				</form>

			</div>

		</div>
	</div>

	<div class="col-sm-2 col-xs-12"></div>

	<div class="clearfix"></div>

</div>

@endsection