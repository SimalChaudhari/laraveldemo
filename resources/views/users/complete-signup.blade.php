<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <title>Complete Signup | {{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('public/images/HipaaMart.jpg') }}" type="image/x-icon" />
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">

    <?php
    $settings = App\Models\Setting::select('fonts')->where( 'user_id', Auth::user()->id )->first();

    $google_font = App\Models\Setting::DEFAULT_GOOGLE_FONT;
    if( $settings !== null && !empty( $settings->fonts ) ) {
        $google_font = $settings->fonts;
    }
    ?>

    <link href="//fonts.googleapis.com/css?family={{ $google_font }}:400,700" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset( 'public/lib/bootstrap/css/bootstrap.css') }}" />
    
    <link rel="stylesheet" href="{{ asset( 'public/lib/font-awesome/css/font-awesome.css') }}" />
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset( 'public/css/theme.css?'. time() ) }}" /> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset( 'public/css/premium.css') }}" /> --}}

    <link href="{{ asset('public/lib/jQuery.validationEngine/validationEngine.jquery.css') }}" rel="stylesheet" type="text/css" />

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <script src="{{ asset( 'public/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
</head>
<body class="theme-blue">

    @include('template.custom-css')
    <style type="text/css">
        ol li p u {
            font-weight: bold;
        }

        .user_pass span .form-horizontal .has-feedback .form-control-feedback {
            right: 15px;
            pointer-events: unset !important;
        }
    </style>

    <div class="container">

        <div class="text-center">
            <img src="{{ asset('public/images/Hipaamart2-logo.png') }}" style="width: 400px;" />
        </div>

        <div class="panel panel-primary">

            <div class="panel-heading">
                <h3 class="panel-title" style="font-size: 18px;"><span class="glyphicon glyphicon-log-in"></span>&nbsp;Complete Profile</h3>
            </div>

            <div class="panel-body" style="font-size: 16px;">

                <?php
                $is_term_accepted = true;
                if( auth()->user()->term_acceptance == 0 ) {
                    $is_term_accepted = false;
                }

                ?>

                <form id="termConditionForm" method="POST" class="validateForm" role="form" style="display: <?php echo $is_term_accepted ? 'none' : 'block'; ?>;">

                    @csrf

                    <h3 style="margin-top: 0;font-weight: bold;" class="text-center"><u>HIPAAMART LICENSE AGREEMENT</u></h3>

                    <p>This License Agreement ("Agreement") is a legally binding contract between Hipaamart LLC and the licensee of the Hipaamart on-line portal. It should be read in its entirety.</p>

                    <ol style="padding-left: 15px;">
                        <li>
                            <p><u>DEFINITIONS</u></p>
                            <p>As used in this license agreement, the term "you" or "your" shall refer to the individual or entity licensing access to the Hipaamart Portal that is the subject of this license agreement (referred to also as "Licensee").</p>

                            <p>The term "we" or "our" or "us" shall refer to Hipaamart LLC ("Hipaamart").</p>

                            <p>The term "HIPAA" shall refer to the Health Insurance Portability and Accountability Act, The HITECH Omnibus Rule, Breach Notification Rule, Enforcement Rule and associated regulations standards, requirements, and implementation specifications.</p>

                            <p>The term "Hipaamart Portal" or "Portal" refers to all or part of the portal’s contents, whether printed or electronic.</p>

                            <p>The term "law" shall refer to any constitution, statute, regulation, rule, common-law, or other state or federal action having the force and effect of law.</p>

                            <p>The term "organized health care arrangement" shall refer to any entity which would be designated as an organized health care arrangement under the HIPAA regulations (refer to the Glossary of this Agreement for a detailed definition).</p>
                        </li>

                        <li>
                            <p><u>ACCEPTANCE OF THIS LICENSE AGREEMENT</u></p>
                            <p>You agree that, by using or copying any part of the Hipaa Portal materials, you acknowledge that you have read this License Agreement, understand it, and agree to be bound by its terms.</p>
                        </li>

                        <li>
                            <p><u>LICENSE</u></p>
                            <p>We hereby grant you a non-exclusive and non-transferable right to use the Hipaamart Portal in your private office or practice, or at one site of an organized health care arrangement. You shall have the right to copy or modify the materials in the Portal only for use in your private office or practice, in one practice location, or for use at one physical location of an organized health care arrangement. Use of the Portal in multiple physical locations or branch offices/clinics operated by the same entity requires payment of an additional licensing fee for each location. Contact us as specified in Paragraph 12 of this agreement to arrange payment of this fee, if this was not done at the time of purchase. Discounts may be available for volume purchases. You shall not have the right to sell, transfer, or give access to the Portal to another individual or entity, in whole or in part. If there are multiple providers in one location, operating jointly as a group practice or under the auspices of an organized health care arrangement, this license shall cover each provider, and each provider shall have these rights and shall be bound by this License Agreement.</p>
                        </li>

                        <li>
                            <p><u>MULTIPLE USERS</u></p>
                            <p>You acknowledge that you are executing this agreement on behalf of all persons who use the Portal, as permitted under this License Agreement. You shall have the sole responsibility for assuring that all such other users understand and comply with the terms and conditions of this Agreement. You further acknowledge and agree that you are further responsible and liable for any and all breaches of the terms and conditions of this Agreement.</p>
                        </li>

                        <li>
                            <p><u>RESTRICTIONS</u></p>
                            <p>Except as specifically permitted in this agreement, you shall not have the right to:</p>
                            <ol style="list-style-type: lower-roman;">
                                <li>Copy any content of the Portal;</li>
                                <li>Sublicense the Portal;</li>
                                <li>Resell, rent, lease, transfer, distribute, or otherwise provide the Portal to a third party;</li>
                                <li>Modify, translate or create derivative work based upon the Portal, except that you may modify the materials in the Portal for use within your own private office or practice, or for use in an organized health care arrangement, provided that additional licenses are obtained for each site where the Portal (as provided by us or as modified) will be used;</li>
                                <li>Remove any copyright notice or any proprietary trade or service marks or notices of Hipaamart, or any other entities, from the Portal.</li>
                            </ol>
                        </li>

                        <li>
                            <p><u>PURCHASE AND/OR MODIFICATION BY LICENSEES</u></p>
                            <p>A person or organization acting as a licensee for an individual provider, provider group, organized health care arrangement, or other entity may license the Portal on behalf of its clients. Such license of the Portal shall be licensed according to the provisions in this Agreement. The licensee may purchase multi-site licenses of the Portal subject to the license fee arrangements in this Agreement.</p>

                            <p>In no circumstance do we waive our copyright, and the licensee may in no way obscure or remove our copyright from the document.</p>
                        </li>

                        <li>
                            <p><u>ACKNOWLEDGEMENT AND WAIVER</u></p>
                            <p>By agreeing to this License Agreement, you hereby acknowledge that interpretation of the laws and regulations that are the subject of the Portal is subject to legal review and/or alternative interpretations. Furthermore, you acknowledge that, in some cases as defined by HIPAA, materials in the Portal may be preempted, in whole or in part, by the laws of the state(s) in which you practice. You also acknowledge that, in other cases as defined by HIPAA, state laws may be preempted by HIPAA. You acknowledge that it is your responsibility to be aware of the laws of the states in which you practice and determine whether HIPAA or state laws apply in the situation and circumstances in which you practice. In light of these acknowledgments, and by agreeing to this License Agreement, you hereby waive the right to bring a claim, lawsuit, or other legal action against us arising out of the use of the Portal. You acknowledge that model documents included in the Portal should be reviewed and modified with the aid of competent legal counsel to fit your individual circumstances and jurisdiction. You waive the right to bring a claim or lawsuit against any individual or entity that provides material for use in the Portal.</p>
                        </li>

                        <li>
                            <p><u>DISCLAIMER OF WARRANTY</u></p>
                            <p>The Portal is provided "as is" without warranty of any kind. We expressly disclaim all warranties, expressed or implied, including, but not limited to, the implied warranties of design, merchantability, fitness for a particular purpose, or non-infringement of any third party’s patent(s), trade secret(s), copyright(s), or any other intellectual property rights. We do not warrant that the materials  contained in the Portal will meet your requirements or that defects in the Portal will be corrected.</p>
                        </li>

                        <li>
                            <p><u>APPLICABLE LAWS</u></p>
                            <p>This agreement is governed by the laws of the State of New York. In any suit wherein we are named as a party, New York is the exclusive venue if the action includes a claim arising out of or relating to this Agreement or the use of the Portal.</p>
                        </li>

                        <li>
                            <p><u>LIMITATIONS OF LIABILITY</u></p>
                            <p>Unless otherwise prohibited by law, neither Hipaamart nor individuals or entities that contribute information to the Portal will have any liability to you or to any other third party for:</p>
                            <ul style="list-style-type: lower-alpha;">
                                <li>any direct, indirect, incidental, special, punitive, consequential losses or damage, including, but not limited to, loss of profits, loss of earnings, loss of business opportunities, fines, penalties, or personal injuries, resulting directly or indirectly from use of the Portal; or</li>
                                <li>any losses, claims, damages, expenses, liabilities or costs (including legal fees) resulting directly or indirectly of the use of the Portal. The conditions in this paragraph apply to any acts, omissions and negligence of Hipaamart and contributing individuals or entities (and their respective officers, employees, agents, contractors, or representatives) which, but for this provision, would give rise to a course of legal action. You agree to indemnify and hold harmless Hipaamart and its contributing individuals or entities against all claims and expenses (including attorney fees) arising out of the use of the Portal.</li>
                            </ul>
                        </li>

                        <li>
                            <p><u>AGREEMENT TO PAY</u></p>
                            <p>You agree to pay all applicable charges, fees, and taxes. If we have agreed to charge a credit card or debit card for these charges, you authorize us to charge your credit or debit card for all such charges.  If we are unable to charge your credit or debit card due to invalid credit or debit card information or due to insufficient funds, and if the Portal has already been made accessible to you, you agree to make other form of payment within 10 business days from the date we notify you.  If you fail to pay license fees within thirty (30) day of the due date, we are authorized to terminate access to the Portal until the fees have been paid.</p>
                        </li>

                        <li>
                            <p><u>CONTACT ADDRESS</u></p>
                            <p>For any inquiries or notices required in connection with this agreement, you may contact us in writing at Hipaamart LLC,</p>
                            <p>845 United Nations Plaza<br />Suite 16F<br />New York, NY 10017<br />Phone: 1-888-639-9321.</p>
                        </li>

                        <li>
                            <p><u>ENTIRE AGREEMENT</u></p>
                            <p>This Agreement is the entire agreement between you and Hipaamart LLC.</p>
                        </li>

                        <li>
                            <p><u>ENFORCEMENT AND SEVERABILITY</u></p>
                            <p>In the event that any portion of this Agreement is held to be unenforceable, the unenforceable portion shall be construed in accordance with applicable laws as nearly as possible to reflect the original intentions of the parties and the remainder of the provisions shall remain in full force and effect. A failure to insist upon or to enforce performance of any provision of this Agreement shall not be construed as a waiver of any provision or right. Neither course of conduct nor trade practice shall act to modify any provisions of this Agreement. This Agreement may, however, be amended by us without prior notice.</p>
                        </li>

                        <li>
                            <p><u>TERM OF AGREEMENT</u></p>
                            <p>This License Agreement is for a one (1) year term, renewable each year for an additional one (1) year term.  Upon a 30-day notice to discontinue at the end of any one (1) year term, either party may terminate this Agreement, or this Agreement shall automatically renew for an additional one (1) year term.  However, Licensee may terminate this Agreement at any time on thirty (30) days notice, at which time the Portal will become unavailable to Licensee.</p>
                        </li>

                        <li>
                            <p><u>DISCLAIMER</u></p>
                            <p>The Hipaamart Portal is not designed to constitute legal advice, nor does it replace the need to consult with an attorney. You should contact your state licensing board, professional association, or attorney to obtain advice with respect to any particular issue or problem. Your access to and use of the materials in the Portal does not create any professional relationship between you and Hipaamart, or any members, owners or employees of Hipaamart or between you and contributors to the Portal.</p>
                        </li>

                        <li>
                            <p><u>TRADEMARKS AND COPYRIGHT</u></p>
                            <p>Acrobat Reader is a trademark of Adobe Systems, Inc. Windows, Word, and Outlook Express are trademarks of Microsoft Corporation. Hipaamart is a trademark of Hipaamart LLC.</p>
                            <p>Other products or materials that are not original to the Hipaamart Portal or taken directly from U.S. Government publications are copyrighted or trademarked by their respective owners.  All other materials are copyrighted by Hipaamart LLC – All Rights Reserved.</p>
                        </li>

                        <li>
                            <p><u>PRICING</u></p>
                            <p>Pricing is as agreed from time-to-time by Hipaamart and the Licensee.  Hipaamart may revise the pricing at any time on thirty (30) days notice.</p>
                            <p>We require a credit card or debit card to be automatically charged each month.</p>
                        </li>

                    </ol>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="term_condition_cb" class="validate[required]" value="1" /> <strong>I agree to above Terms & conditions.</strong>
                        </label>
                    </div>

                    <div class="col-sm-4 col-xs-12"></div>
                    <div class="col-sm-4 col-xs-12">
                        <button type="submit" name="proceed" id="proceed" class="btn btn-success btn-lg btn-block">Accept</button>
                    </div>
                    <div class="col-sm-4 col-xs-12"></div>
                    
                </form>

                <form id="profile_fields" method="POST" class="validateForm form-horizontal" role="form" style="display: <?php echo $is_term_accepted ? 'block' : 'none'; ?>;" action="{{ route('submitProfile') }}">

                    @csrf

                    <p class="col-sm-12 col-xs-12 text-right" style="padding-right: 0;"><small>(<span style="color: red;">*</span>) are mandatory fields.</small></p>

                    <div id="profile_fields_wrapper">

                        <div class="form-group has-feedback">
                            <label class="col-sm-3 col-xs-12 control-label">First name<span style="color: red;">*</span></label>
                            <div class="col-sm-6 col-xs-12">
                                <input type="text" class="form-control validate[required, maxSize[100]]" name="firstname" id="firstname" value="{{ auth()->user()->firstname }}" />
                                <span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label class="col-sm-3 col-xs-12 control-label">Last name<span style="color: red;">*</span></label>
                            <div class="col-sm-6 col-xs-12">
                                <input type="text" class="form-control validate[required, maxSize[100]]" name="lastname" id="lastname" value="{{ auth()->user()->lastname }}" />
                                <span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label class="col-sm-3 col-xs-12 control-label">Email ID<span style="color: red;">*</span></label>
                            <div class="col-sm-6 col-xs-12">
                                <input type="text" value="<?php echo auth()->user()->email; ?>" class="form-control" readonly disabled />
                                <span class="glyphicon glyphicon-envelope form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label class="col-sm-3 col-xs-12 control-label">Username<span style="color: red;">*</span></label>
                            <div class="col-sm-6 col-xs-12">
                                <input type="text" value="<?php echo auth()->user()->username; ?>" class="form-control" readonly disabled />
                                <span class="glyphicon glyphicon-user form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label  class="col-sm-3 col-xs-12 control-label">Password<span style="color: red;">*</span></label>
                            <div class="col-sm-6 col-xs-12 user_pass">
                                <input type="password" id="user_pass" name="password" autocomplete="new-password" class="form-control validate[required, minSize[8], maxSize[20]]" />
                                <span style="pointer-events: unset !important;cursor: pointer;" class="glyphicon glyphicon_eye glyphicon-eye-open form-control-feedback" aria-hidden="true"></span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span><br/>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label class="col-sm-3 col-xs-12 control-label">User role<span style="color: red;">*</span></label>
                            <div class="col-sm-6 col-xs-12">
                                <p class="form-control-static">{{ $userRole }}</p>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label class="col-sm-3 col-xs-12 control-label">Company name<span style="color: red;">*</span></label>
                            <div class="col-sm-6 col-xs-12">
                                <input type="text" name="company_name" id="company_name" class="form-control validate[required, maxSize[100]]" value="<?php echo getCurrentUserCompanyName(); ?>" />
                                {{-- <select name="company_id" id="company_id" class="form-control select2 validate[required]">
                                    <?php $user_company_id = auth()->user()->company_id; ?>
                                    <option value="">Select Company</option>
                                    @foreach( $companies as $company )
                                        <option value="{{ $company->id }}" <?php echo $user_company_id === $company->id ? 'selected' : ''; ?>>{{ $company->company_name }}</option>
                                    @endforeach
                                </select>
                                <p class="text-right" style="margin-bottom: 0;"><a style="cursor: pointer;" id="add_new_company" data-toggle="modal" data-target="#addNewCompany">+ Add new company</a></p> --}}
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label class="col-sm-3 col-xs-12 control-label">Company website<span style="color: red;">*</span></label>
                            <div class="col-sm-6 col-xs-12">
                                <input type="text" class="form-control validate[required]" name="company_website" id="company_website" value="{{ auth()->user()->company_website }}" />
                                <span class="glyphicon glyphicon-globe form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label class="col-sm-3 col-xs-12 control-label">Employee title<span style="color: red;">*</span></label>
                            <div class="col-sm-6 col-xs-12">
                                <input type="text" class="form-control validate[required, maxSize[255]]" name="employee_title" id="employee_title" value="<?php echo auth()->user()->employee_title; ?>" />
                                <span class="glyphicon glyphicon-tag form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label class="col-sm-3 col-xs-12 control-label">Company address 1<span style="color: red;">*</span></label>
                            <div class="col-sm-6 col-xs-12">
                                <input type="text" class="form-control validate[required, maxSize[255]]" name="company_address_1" id="company_address_1" value="<?php echo auth()->user()->company_address_1; ?>" />
                                <span class="glyphicon glyphicon-map-marker form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label class="col-sm-3 col-xs-12 control-label">Company address 2</label>
                            <div class="col-sm-6 col-xs-12">
                                <input type="text" class="form-control validate[maxSize[255]]" name="company_address_2" id="company_address_2" value="<?php echo auth()->user()->company_address_2; ?>" />
                                <span class="glyphicon glyphicon-map-marker form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label class="col-sm-3 col-xs-12 control-label">Company city<span style="color: red;">*</span></label>
                            <div class="col-sm-6 col-xs-12">
                                <input type="text" class="form-control validate[required, maxSize[255]]" name="city" id="city" value="<?php echo auth()->user()->city; ?>" />
                                <span class="glyphicon glyphicon-map-marker form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label class="col-sm-3 col-xs-12 control-label">Company state<span style="color: red;">*</span></label>
                            <div class="col-sm-6 col-xs-12">
                                <select name="state" id="state" class="form-control validate[required]">
                                    <option value="">Select State</option>
                                    <?php
                                    $states = DB::table('states')->get();
                                    foreach( $states as $state ) {
                                    ?>
                                    <option value="{{ $state->state_code }}">{{ $state->name }}</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label class="col-sm-3 col-xs-12 control-label">Company zip<span style="color: red;">*</span></label>
                            <div class="col-sm-6 col-xs-12">
                                <input type="text" class="form-control validate[required, maxSize[255]]" name="zip" id="zip" value="<?php echo auth()->user()->zip; ?>" />
                                <span class="glyphicon glyphicon-map-marker form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label class="col-sm-3 col-xs-12 control-label">Company tel<span style="color: red;">*</span></label>
                            <div class="col-sm-6 col-xs-12">
                                <input type="text" class="form-control validate[required, maxSize[255]]" name="company_tel" id="company_tel" value="<?php echo auth()->user()->company_tel; ?>" />
                                <span class="glyphicon glyphicon-phone-alt form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label class="col-sm-3 col-xs-12 control-label">Mobile<span style="color: red;">*</span></label>
                            <div class="col-sm-6 col-xs-12">
                                <input type="text" class="form-control validate[required, maxSize[14]]" name="mobile" id="mobile" placeholder="(111) 111-1111" value="<?php echo auth()->user()->mobile; ?>" />
                                <span class="glyphicon glyphicon-earphone form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>

                    </div>

                    <div id="verify_otp_input_wrapper" class="form-group has-feedback" style="display: none;">
                        <label class="col-sm-3 col-xs-12 control-label">One Time Password(OTP)<span style="color: red;">*</span></label>
                        <div class="col-sm-6 col-xs-12">
                            <input type="text" class="form-control validate[required, maxSize[4]]" name="one_time_password" id="one_time_password" maxlength="4" placeholder="1234" />
                            <span class="glyphicon glyphicon-comment form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>

                    <div class="col-sm-4 col-xs-12"></div>
                    <div class="col-sm-4 col-xs-12" id="form_profile_fields_action">
                        <button type="button" id="btn_send_otp" class="btn btn-primary btn-lg btn-block">Get OTP</button>
                        <button type="submit" id="btnVerifyOTP" class="btn btn-primary btn-lg btn-block" style="display: none;">Verify OTP</button>
                    </div>
                    <div class="col-sm-4 col-xs-12"></div>
                    
                </form>

            </div>

        </div>

    </div>

    <div class="modal fade" id="addNewCompany" tabindex="-1" role="dialog" aria-labelledby="addNewCompanyLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-2x fa-building-o" aria-hidden="true"></i> Add new company</h4>
                </div>

                <form method="POST" class="validateForm form-horizontal">
                    <div class="modal-body">

                        @csrf

                        <div class="form-group">
                            <label class="col-sm-12 col-xs-12">Company Name</label>
                            <div class="col-sm-12 col-xs-12">
                                <input type="text" class="form-control validate[required, maxSize[255]]" name="modal_company_name" id="modal_company_name" />
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" id="add_company" class="btn btn-primary">Add</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    

    <script src="{{ asset('public/lib/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ asset( 'public/lib/jQuery.validationEngine/jquery.validationEngine-en.js') }}" type="text/javascript"></script>
    <script src="{{ asset( 'public/lib/jQuery.validationEngine/jquery.validationEngine.min.js') }}" type="text/javascript"></script>

    <script>
        if( $('form#profile_fields').length > 0 ) {
            $('form#profile_fields').validationEngine({
                notEmpty: true, // validate field only when there is wrong input entered
            });
        }

        document.getElementById('mobile').addEventListener('input', function (e) {
            var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
            e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        });

        $(document).ready(function() {

            // $('.select2').select2();

            $(document).on('click', '#proceed', function(e) {
                e.preventDefault();

                var btn = $(this);

                if( $('form#termConditionForm').validationEngine('validate') ) {
                    // disable submit button
                    btn.prop('disabled', true).html('Processing&nbsp;<i class="fa fa-spinner fa-spin"></i>');

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route("acceptTermsConditions") }}',
                        method: 'POST',
                        data: {},
                        success: function(response) {
                            $('form#termConditionForm').hide();
                            $('form#profile_fields').fadeIn();
                        }
                    });
                }

            });

            <?php /*$(document).on('click', '#add_company', function(e) {
                e.preventDefault();

                var btn = $(this);

                var btn_text = btn.text();

                if( $('div#addNewCompany form.validateForm').validationEngine('validate') ) {

                    // disable submit button
                    btn.prop('disabled', true).html('Processing&nbsp;<i class="fa fa-spinner fa-spin"></i>');

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route("add_new_company") }}',
                        method: 'POST',
                        data: {company_name: $('#modal_company_name').val()},
                        success: function(response) {

                            btn.prop('disabled', false).text(btn_text);
                            
                            if( response.error == true ) {
                                alert(response.message);
                                return false;
                            }

                            var companies = response.companies;

                            var options = '';
                            for( var i = 0; i < companies.length; i++ ) {
                                options += '<option value="' + companies[i]['id'] + '">' + companies[i]['company_name'] + '</option>';
                            }

                            $('#company_id').select2('destroy');
                            $('#company_id').html( options ).select2();

                            alert('Company name has been added successfully.');
                            $('#modal_company_name').val('');
                        }
                    });
                }
            });*/?>

            $(document).on('click', '#btn_send_otp', function(e) {
                e.preventDefault();

                var otp_btn = $(this);

                var btn_txt = otp_btn.text();

                if( $('form#profile_fields').validationEngine('validate') ) {

                    // disable submit button
                    otp_btn.prop('disabled', true).html('Sending OTP&nbsp;<i class="fa fa-spinner fa-spin"></i>');

                    var mobile = $('#mobile').val();
                    mobile = mobile.replace('(', '');
                    mobile = mobile.replace(')', '');
                    mobile = mobile.replace('-', '');
                    mobile = mobile.replace(/  +/g, ''); // remove space
                    mobile = mobile.replace(' ', ''); // remove space

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route("sendSms") }}',
                        method: 'POST',
                        data: {to_number: mobile},
                        success: function(response) {
                            // disable submit button
                            otp_btn.prop('disabled', false).text(btn_txt);

                            // hide the GET OTP button when success response come & show the verify otp button
                            if( response.success == true ) {
                                // $('div#profile_fields_wrapper').hide();
                                $('div#verify_otp_input_wrapper').fadeIn();

                                otp_btn.remove();
                                $('button#btnVerifyOTP').show();
                            }

                            // if response has failure then show the current GET OTP button
                            if( response.success == false ) {
                                alert(response.message);
                                return false;
                            }

                        }
                    });
                }
            });

            $(document).on('click', '.glyphicon_eye', function(e) {
                e.preventDefault();
                const user_pass = document.getElementById('user_pass');
                if (user_pass.type === 'password') {
                    user_pass.type = "text";
                    $('.glyphicon_eye').removeClass("glyphicon-eye-open").addClass("glyphicon-eye-close");
                }else {
                    user_pass.type = "password";
                    $('.glyphicon_eye').removeClass("glyphicon-eye-close").addClass("glyphicon-eye-open");
                }
            });

            $(document).on('click', '#btnVerifyOTP', function(e) {
                e.preventDefault();

                var btnVerifyOtp = $(this);

                var btn_text = $(this).text();

                if( $('form#profile_fields').validationEngine('validate') ) {

                    var otp = $('#one_time_password').val();
                    otp = otp.trim();

                    // disable submit button
                    btnVerifyOtp.prop('disabled', true).html('Verifying OTP&nbsp;<i class="fa fa-spinner fa-spin"></i>');

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route("verifyOTP") }}',
                        method: 'POST',
                        data: {otp: otp},
                        success: function(response) {

                            if( response.success == true ) {
                                $('form#profile_fields').submit();
                            }
                            if( response.success == false ) {
                                btnVerifyOtp.prop('disabled', false).text(btn_text);
                                alert(response.message);
                                return false;
                            }
                            
                            
                        }
                    });

                }


            });

        });
    </script>
    
</body>
</html>
