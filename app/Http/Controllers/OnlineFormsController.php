<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Redirect;
use Gate;

class OnlineFormsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function list()
    {
        $forms = $this->getForms( false );

        return view('online-forms.list', compact( 'forms' ) );
    }

    public function allOnlineForms() {

        abort_if(Gate::denies('Index to Practice Forms'), redirect(url('/dashboard')));

        $forms = $this->getForms( true );

        return view('online-forms.all', compact( 'forms' ) );
    }

    public function getForms( $include_results = false ) {
        $forms = [
            'accounting-of-disclosures-tracking-sheet' => [
                'title'         => 'ACCOUNTING OF DISCLOSURES TRACKING SHEET FORM',
                'add_route'     => 'UI_createADTSForm',
                'view_route'    => 'viewADTSForm',
                'update_route'  => 'saveADTSForm',
                'ajax_results'  => 'ajax_get_adts_records'
                // 'data'          => $include_results ? (new \App\Http\Controllers\OnlineForms\AdtsFormController())->getResults() : '',
            ],
            'employee-termination-form' => [
                'title'         => 'EMPLOYEE TERMINATION FORM',
                'add_route'     => 'UI_createEmployeeTerminationForm',
                'view_route'    => 'viewEmployeeTerminationForm',
                'update_route'  => 'saveEmployeeTerminationForm',
                'ajax_results'  => 'ajax_get_et_records'
                // 'data'          => $include_results ? (new \App\Http\Controllers\OnlineForms\EmployeeTerminationController())->getResults() : '',
            ],
            'authorize-use-and-disclosure' => [
                'title'         => 'AUTHORIZATION TO USE AND/OR DISCLOSE MEDICAL RECORDS',
                'add_route'     => 'UI_createAuthorizeUseAndDisclosure',
                'view_route'    => 'viewAuthorizeUseAndDisclosureForm',
                'update_route'  => 'saveAuthorizeUseAndDisclosureForm',
                'ajax_results'  => 'ajax_get_aud_records'
                // 'data'          => $include_results ? (new \App\Http\Controllers\OnlineForms\AuthorizeUseDisclosureController())->getResults() : '',
            ],
            'email-form-for-access-to-health-record' => [
                'title'         => 'EMAIL FORM FOR ACCESS TO HEALTH RECORD',
                'add_route'     => 'UI_createEmailFormForAccessToHealthRecord',
                'view_route'    => 'viewEmailFormForAccessToHealthRecord',
                'update_route'  => 'saveEmailFormForAccessToHealthRecord',
                'ajax_results'  => 'ajax_get_efathr_records'
                // 'data'          => $include_results ? (new \App\Http\Controllers\OnlineForms\EmailFormForAccessToHealthRecordController())->getResults() : '',
            ],
            'business-associate-vendor-termination' => [
                'title'         => 'BUSINESS ASSOCIATE/VENDOR TERMINATION',
                'add_route'     => 'UI_createBusinessAssociateVendorTerminationForm',
                'view_route'    => 'viewBusinessAssociateVendorTerminationForm',
                'update_route'  => 'saveBusinessAssociateVendorTerminationForm',
                'ajax_results'  => 'ajax_get_bavt_records'
                // 'data'          => $include_results ? (new \App\Http\Controllers\OnlineForms\BusinessAssociationVendorController())->getResults() : '',
            ],
            'request-to-download-ephi' => [
                'title'         => 'REQUEST TO DOWNLOAD/COPY EPHI',
                'add_route'     => 'UI_createRequestToDownloadEPHI',
                'view_route'    => 'viewRequestToDownloadEPHI',
                'update_route'  => 'saveRequestToDownloadEPHI',
                'ajax_results'  => 'ajax_get_rtde_records'
                // 'data'          => $include_results ? (new \App\Http\Controllers\OnlineForms\RequestToDownloadEphiController())->getResults() : '',
            ],
            'email-form-for-health-record-ammendment' => [
                'title'         => 'EMAIL FORM FOR HEALTH RECORD AMMENDMENT',
                'add_route'     => 'UI_createEmailFormForHealthRecordAmmendment',
                'view_route'    => 'viewEmailFormForHealthRecordAmmendment',
                'update_route'  => 'saveEmailFormForHealthRecordAmmendment',
                'ajax_results'  => 'ajax_get_efhra_records'
                // 'data'          => $include_results ? (new \App\Http\Controllers\OnlineForms\EmailFormForHealthRecordAmmendmentController())->getResults() : '',
            ],
            'media-destruction-and-reuse-form' => [
                'title'         => 'MEDIA DESTRUCTION AND/OR REUSE FORM',
                'add_route'     => 'UI_createMediaDestructionAndReuseForm',
                'view_route'    => 'viewMediaDestructionAndReuseForm',
                'update_route'  => 'saveMediaDestructionAndReuseForm',
                'ajax_results'  => 'ajax_get_mdrf_records'
                // 'data'          => $include_results ? (new \App\Http\Controllers\OnlineForms\MediaDestructionOrReuseController())->getResults() : '',
            ],
            'sanction-form' => [
                'title'         => 'SANCTION REPORT',
                'add_route'     => 'UI_createSanctionsForm',
                'view_route'    => 'viewSanctionsForm',
                'update_route'  => 'saveSanctionsForm',
                'ajax_results'  => 'ajax_get_sf_records'
                // 'data'          => $include_results ? (new \App\Http\Controllers\OnlineForms\SanctionReportController())->getResults() : '',
            ],
        ];

        return $forms;
    }
    
}
