<div class="modal fade" id="submitAcknowledgementModal" tabindex="-1" role="dialog" aria-labelledby="submitAcknowledgementModalLabel" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    			<h4 class="modal-title" id="submitAcknowledgementModalLabel">Employee Training Acknowledgement</h4>
			</div>
			<div class="modal-body" style="padding: 1em;">

				<form id="formEmployeeTrainingAcknowledgement" class="form-horizontal validateForm">

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

					<div class="form-group">
						<label class="col-sm-2">Printed Name<span style="color: red;">*</span></label>
						<div class="col-sm-10">
							<input type="text" name="printed_name" id="printed_name" class="form-control validate[required, maxSize[255]]" maxlength="255" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-12">Signature<span style="color: red;">*</span></label>
						<div class="col-sm-12">
							<div id="employee_signature" style="position: relative;">
								<a id="reset_employee_signature" style="position: absolute;right: 65px;bottom: 0;cursor: pointer;">(Reset Signature)</a>
							</div>
						</div>
					</div>

					<button type="button" name="submit_employee_training_acknowledgement_form" id="submit_employee_training_acknowledgement_form" class="btn btn-custom-success" data-redirect_url="{{ $acknowledgement_url }}" data-submit_url="{{ route('quiz.result.submitAcknowledgement', $result->uuid ) }}">Submit Acknowledgement</button>

				</form>
				
			</div>
		</div>
	</div>
</div>