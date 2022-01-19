<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title text-center">{{ ucwords( strtolower( 'Request to Download/Copy' ) ) }} EPHI</h3>
    </div>

    <div class="panel-body">

        <form>

            <div class="row">

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Date</label>
                        <p class="form-control-static">{{ \Carbon\Carbon::parse( $form->cur_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Person Making the Request{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->person }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Reason for download/copy of EPHI{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->reason }}</p>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12">

                    <p class="form-control-static">Minimum Necessary Disclosure: The Privacy Rule generally requires covered entities to take reasonable steps to limit the use or disclosure of, and requests for, protected health information to the mininium necessary to accomplish the intended purpose. The minimum necessary standard does not apply to the following:</p>

                    <ol>
                        <li>Disclosures to or requests by a health care provider for treatment purposes.</li>
                        <li>Disclosures to the individual who is the subject of the information.</li>
                        <li>Uses or disclosures made pursuant to an individual's authorization.</li>
                        <li>Uses or disclosures required for compliance with the Health Insurance Portability and Accountability Act (HIPAA) Administrative Simplification Rules.</li>
                        <li>Disclosures to the Department of Health and Human Services (IHIS) when disclosure of information is required under the Privacy Rule for enforcement purposes.</li>
                        <li>Uses or disclosures that are required by other law.</li>
                    </ol>

                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Description of Information to be Disclosed{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->description }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Purpose of use or disclosure{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->purpose }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Has the Minimum Necessary Standard Been Applied{!! $required_field_html !!}</label>
                        <p class="form-control-static"><?php echo strtolower( $form->necessary ) == 'yes' ? 'Yes' : 'No' ?></p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Approved By{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->approve }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Date</label>
                        <p class="form-control-static">{{ \Carbon\Carbon::parse( $form->app_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Not approved due to the following{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->not_approve }}</p>
                    </div>
                </div>

                <div class="clearfix"></div>

                <h2 style="text-align: center;width: 100%;">Chart Review Policy and Certification Requirement</h2>
                <p style="text-align:justify;"><b>PROTECTING PATEINT PRIVACY</b> is a primary concern in our office. In accordance with HIPAA, Omnibus and our own internal policies and procedrres we have instituted the following policy to ensure the confidentiality of Protected Health Information (PHI) and Electronic Protected Health Irformation (ePHI).</p>
                <p style="text-align:justify;">This policy addresses <u>Chart Reviews</u> or other operations where patient records are to be reviewed and/or removed from our office by business associates to our practice. HIPAA clearly states that our office is responsible for the actions of our business associates and that we must insure that the business associate properly protects PHI/epHI and is HIPAA compliant.</p>

                <h3><b>Business Associate Agreement and Certification Required</b></h3>
                <p style="text-align:justify;">An up-to-date Omnibus Business Associate Agreement must be in place before any business associate or their sub-contractor is allowed access to patient information. In addition, the business associate and any sub-contractor must submit Certification that the business associate(s) have 1 ) had a comprehensive risk assessment in the past year, 2) that all staff handling our PHI/ePHI has been trained on HIPAA protections and 3) that the business associate has a full set of policies and procedures for the HIPAA Privacy and Security Rule. Business associates without these requirements are deemed by the Office of Civil Rights to be in "willful neglect" and are not HIPAA compliant. Therefore for legal reasons and the protection of patient privacy business associates who cannot provide Certification of their HIPAA compliance will not be permitted to access patient records(PHI/ePHI). In addition, sub-contractors of our business associates must submit evidence that an Omnibus updated Business Associate Agreement with our Business Associate is in place.</p>

                <h3><u><b>Only Encrypted Data (PHI/ePHI) Is Allowed To Be Taken Off-site</b></u></h3>
                <p style="text-align:justify;">Our practice requires that all patient data that is taken out of our office in digital format must be
                    encrypted to Department of Defense (DOD) standards. Encryption is a "safe harbor" to the Breach
                    Notification Rule and greatly protects patient privacy. Our staff is instructed to verify that the media
                    device used for downloading of epHI is encrypted. In addition, the business associate or their sub-
                    contractor must provide certification that the media device is new or that the device has been scanned
                    for malware before we will allow the device to be connected to our network.
                    Paper records taken off-site must be in a closed secure container and kept in a locked vehicle and
                    hidden from sight.
                </p>

                <h3><strong>For office use only</strong></h3>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Business Associate{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->buss }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Sub-Contractor{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->sub }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="agree" value="Yes" <?php echo strtolower($form->agree) == 'yes' ? 'checked' : '' ?> /> Business Associate Agreement In-Place with Business Associate
                        </label>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="sub_cont" value="Yes" <?php echo strtolower($form->sub_cont) == 'yes' ? 'checked' : '' ?> /> Sub-Contractor states They Have an omnibus BAA with the B.A.
                        </label>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Portable Media Device Used to remove ePIH{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->port }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div class="col-sm-12 no-padding">
                            <label>
                                <input type="checkbox" name="device" value="Yes" <?php echo strtolower($form->device) == 'yes' ? 'checked' : '' ?> /> Business Associate stated Device is New or scanned for Malware
                            </label>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Encryption Method{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->encry }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div class="col-sm-12 col-xs-12 no-padding">
                            <label>
                                <input type="checkbox" name="encry_veri" value="Yes" <?php echo strtolower($form->encry_veri) == 'yes' ? 'checked' : '' ?> /> Encryption Verified
                            </label>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Number of patient Records Placed On Device{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->records }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>HIPAA Compliance Officer{!! $required_field_html !!}</label>
                        <p class="form-control-static">{{ $form->officer }}</p>
                    </div>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <div class="form-group">
                        <label>Date</label>
                        <p class="form-control-static">{{ \Carbon\Carbon::parse( $form->sign_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</p>
                    </div>
                </div>

            </div>

        </form>

    </div>

</div>