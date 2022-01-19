@extends('layouts.admin')

@section('page_title')
View {{ ucwords( strtolower( 'AUTHORIZATION TO USE AND/ORDISCLOSE MEDICAL RECORDS FORM' ) ) }}
@endsection

@section('content')

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<div class="row">

    <div class="col-sm-3 col-xs-12"></div>

    <div class="col-sm-6 col-xs-12">

        <ol class="breadcrumb">
            <li><a href="javascript:;">Document Library</a></li>
            <li class="active">{{ ucwords( strtolower( 'AUTHORIZATION TO USE AND/ORDISCLOSE MEDICAL RECORDS FORM' ) ) }}</li>
        </ol>
        
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title">{{ ucwords( strtolower( 'AUTHORIZATION TO USE AND/ORDISCLOSE MEDICAL RECORDS FORM' ) ) }}<a href="{{ route('authorize-user-and-disclosure.index') }}" class="btn btn-custom-danger btn-xs pull-right">&laquo; Back</a></h3>
            </div>

            <div class="panel-body">

                <table class="table table-bordered">

                    <tr class="odd gradeX">
                        <td>NAME OF PATIENT</td>
                        <td>{{ $form->name }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td>SS#</td>
                        <td>{{ $form->ss }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td colspan="2" align="center">TO: (Name, Address. Phone of <strong>Recipient</strong> of Records)</td>
                    </tr>

                    <tr  class="odd gradeX">
                        <td><b>Name:</b></td>
                        <td>{{ $form->rec_name }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Phone</b></td>
                        <td>{{ $form->rec_phone }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Address:</b></td>
                        <td>{{ $form->rec_address }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>City</b></td>
                        <td>{{ $form->rec_city }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>State</b></td>
                        <td>{{ $form->rec_state }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Zip</b></td>
                        <td>{{ $form->rec_zip }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td colspan="2" align="center">RECORDS FROM (Who is <strong>Releasing</strong> the Records):</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Name:</b></td>
                        <td>{{ $form->from_name }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Phone:</b></td>
                        <td>{{ $form->from_phone }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Address:</b></td>
                        <td>{{ $form->from_address }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>City</b></td>
                        <td>{{ $form->from_city }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>State</b></td>
                        <td>{{ $form->from_state }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Zip</b></td>
                        <td>{{ $form->from_zip }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><h4><u><b>For the Following Purposes:</b></u></h4></td>
                        <td>{{ $form->purposes }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><h4><b>By Checking the Boxes Below, I Specifically Authorize the Use and/or Disclosure of the Following Health Information And/or Medical Records, If Such Information And/or Records Exist:</b></h4></td>
                        <td>{{ $form->authorize }}</td>
                    </tr>

                </table>

                <div class="col-sm-12 col-xs-12">

                    <div class="form-group">

                        <label>The Following Items Must Be Initialed to Be Included in the Use And/or Disclosure</label>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="hiv_aids" value="Yes" <?php echo $form->hiv_aids == 'Yes' ? 'checked' : '' ?> /> HIV/AIDS relate information and/or records IIBV, TB or Other Communicable Diseases
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="mental_health" value="Yes" <?php echo $form->mental_health == 'Yes' ? 'checked' : '' ?> /> Mental Health Information and/or Records
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="domestic" value="Yes" <?php echo $form->domestic == 'Yes' ? 'checked' : '' ?> /> Domestic Violence
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="genetic_test" value="Yes" <?php echo $form->genetic_test == 'Yes' ? 'checked' : '' ?> /> Genetic Testing Information and/or records
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="drug_alcohol" value="Yes" <?php echo $form->drug_alcohol == 'Yes' ? 'checked' : '' ?> /> Drug/Alcohol diagnosis, treatment or referral information (Federal regulations require a description of how much and what kind of information is to be disclosed.) Describe:
                            </label>
                        </div>

                    </div>

                </div>

                <div class="col-sm-12 col-xs-12">
                    <p style="text-align:justify;"><b>I understand</b> that, if the person or entity receiving the information is not a health care provider or health plan covered by federal privacy regulations, the information described above may be re-disclosed and no longer protected by HIPPA and other federal and state regulations. However, the recipient may be prohibited from disclosing substance abuse information under the Federal Substance Abuse
                        Confidentiality Requirements.
                    </p>
                    <p style="text-align:justify;"><b>I also understand</b> that the person I am authorizing to use and/or disclose the information may not receive compensation for doing so.</p>
                    <p style="text-align:justify;"><b>I, further understand</b> that I may refuse to sign this authorization and that my refusal to sign will not affect my ability to obtain treatment or payment of my eligibility for benefits. I may inspect or copy any information to be used and/or disclosed under this authorization.
                        <b>Finally, I understand</b> that <u><b>I may revoke this autliorization</b></u>,in writing, at any time, provided that I do so in writing, except to the extent that action has been taken in reliance upon this authorization. Unless Revoked Earlier, this Authorization Will Expire in Six (6) Months
                        from the Date of Signing or until (Insert Date): {{ \Carbon\Carbon::parse( $form->insert_date )->format( config('app.VIEW_DATE_FORMAT') ) }}
                    </p>
                </div>


                <table class="table table-bordered">

                    <tr class="odd gradeX">
                        <td><b>Print Patient's Name:</b></td>
                        <td>{{ $form->pat_name }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Date:</b></td>
                        <td>{{ \Carbon\Carbon::parse( $form->date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Signature of patient or Patient's Legal Representative: </b></td>
                        <td>{{ $form->pat_sign }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Print Name of Legal Representative (if applicable):</b></td>
                        <td>{{ $form->pat_legal }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Relationship to patient:</b></td>
                        <td>{{ $form->pat_rel }}</td>
                    </tr>

                    <tr class="odd gradeX">
                        <td><b>Signature:</b></td>
                        <td><img src="data:{{ $form->signature_str_svg }}" /></td>
                    </tr>

                </table>



            </div>

        </div>

    </div>

    <div class="col-sm-3 col-xs-12"></div>

    <div class="clearfix"></div>

</div>

@endsection