 <?php
//**
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\HomeController;
// use App\Http\Controllers\Controller;
// use App\Http\Controllers\LoginController;
// use App\Http\Controllers\RegisterController;
// use App\Http\Controllers\UserController;
// use App\Http\Controllers\CompanyController;
// use App\Http\Controllers\SmsController;
// use App\Http\Controllers\DashboardController;
// use App\Http\Controllers\TrainingAcknowledgeController;
// use App\Http\Controllers\RiskAssignmentAcknowledgeController;
// use App\Http\Controllers\TrainingController;
// use App\Http\Controllers\QuizController;
// use App\Http\Controllers\RoleController;
// use App\Http\Controllers\PermissionController;
// use App\Http\Controllers\DocumentLibraryController;
// use App\Http\Controllers\ScannedDocumentController;
// use App\Http\Controllers\BusinessAssociateAgreementController;
// use App\Http\Controllers\TechnologyReportController;
// use App\Http\Controllers\PolicyProcedureController;
// use App\Http\Controllers\EmrByStateController;
// use App\Http\Controllers\PolicyRevisionController;
// use App\Http\Controllers\PatientDisclosureAuthorizationController;
// use App\Http\Controllers\AuthorizeUseDisclosureController;
// use App\Http\Controllers\OnlineFormsController;
// use App\Http\Controllers\AdtsFormController;
// use App\Http\Controllers\EmployeeTerminationController;
// use App\Http\Controllers\EmailFormForAccessToHealthRecordController;
// use App\Http\Controllers\BusinessAssociationVendorController;
// use App\Http\Controllers\RequestToDownloadEphiController;
// use App\Http\Controllers\EmailFormForHealthRecordAmmendmentController;
// use App\Http\Controllers\MediaDestructionOrReuseController;
// use App\Http\Controllers\SanctionReportController;
// use App\Http\Controllers\RiskAssessmentController;
// use App\Http\Controllers\TodoController;
// use App\Http\Controllers\SettingController;
// use App\Http\Controllers\CropImageController;
// /*
// |--------------------------------------------------------------------------
// | Web Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register web routes for your application. These
// | routes are loaded by the RouteServiceProvider within a group which
// | contains the "web" middleware group. Now create something great!
// |
// */
// Route::post('/', [LoginController::class, 'validateLogin'])->name('login');

// Route::get('/clear-cache', function() {
//     $exitCode = Artisan::call('cache:clear');
// });

// Auth::routes(['verify' => true]);

// Route::get('/home', [HomeController::class, 'index'])->name('home')/*->middleware('verified');*/;

// Route::get('complete-signup', [UserController::class, 'completeSignup']);
// Route::post('accept_terms_conditions', [UserController::class, 'acceptTermsConditions'])->name('acceptTermsConditions');
// Route::post('submit-profile', [UserController::class, 'submitProfile'])->name('submitProfile');
// Route::post('add-new-company', [CompanyController::class, 'add_new_company'])->name('add_new_company');
// Route::post('send-otp', [SmsController::class, 'sendSms'])->name('sendSms');
// Route::post('verify-otp', [SmsController::class, 'verifyOTP'])->name('verifyOTP');

// // create new password for the new company
// Route::get('create-password/{company_token}', [CompanyController::class, 'createPassword']);
// Route::post('save-password/{id}', [CompanyController::class, 'savePassword'])->name('save_new_password');


// Route::group(['middleware' => ['auth', 'verified', 'complete.profile', 'prevent.browser.back']], function() {

// 	Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// 	Route::get('hipaa/safe-harbor', [DashboardController::class, 'safeHarbor'])->name('safeHarbor');
// 	Route::get('hipaa/rules', [DashboardController::class, 'hipaaRules'])->name('hipaaRules');
// 	Route::get('hipaa/cybersecurity', [DashboardController::class, 'cybersecurity'])->name('cybersecurity');

// 	Route::prefix('training-acknowledgment')->group(function() {
// 		Route::get('index', [TrainingAcknowledgeController::class, 'index'])->name('training.ack.index');
// 		Route::get('get', [TrainingAcknowledgeController::class, 'ajaxGetAcknowledgements'])->name('ajax_get_training_acknowledgements');
// 		Route::post('store', [TrainingAcknowledgeController::class, 'store'])->name('training.ack.store');	
// 		Route::get('{ack_id}/download', [TrainingAcknowledgeController::class, 'download'])->name('training.ack.download');	
// 	});

// 	Route::prefix('risk-assignment-acknowledgment')->group(function() {
// 		Route::get('index', [RiskAssignmentAcknowledgeController::class, 'index'])->name('risk.ack.index');
// 		Route::get('get', [RiskAssignmentAcknowledgeController::class, 'ajaxGetAcknowledgements'])->name('ajax_get_risk_assignment_acknowledgements');
// 		Route::post('store', [RiskAssignmentAcknowledgeController::class, 'store'])->name('risk.ack.store');	
// 		Route::get('{ack_id}/download', [RiskAssignmentAcknowledgeController::class, 'download'])->name('risk.ack.download');	
// 	});

// 	Route::resource('users', UserController::class);

// 	Route::post('training/video-watched', [TrainingController::class, 'trainingVideoWatched'])->name('postTrainingVideoWatched');

// // 	Route::prefix('quiz')->group(function() {
// // 		Route::get('index', [QuizController::class, 'index'])->name('quiz.index');
// // 		Route::get('get', [QuizController::class, 'ajaxGetQuizes'])->name('ajax_get_quizes');
// // 		Route::get('create', [QuizController::class, 'create'])->name('quiz.create');
// // 		Route::post('store', [QuizController::class, 'store'])->name('quiz.store');
// // 		Route::get('{quiz}/edit', [QuizController::class, 'edit'])->name('quiz.edit');
// // 		Route::post('{quiz}/update', [QuizController::class, 'update'])->name('quiz.update');
// // 		Route::post('{quiz}/destroy', [QuizController::class, 'destroy'])->name('quiz.destroy');
// // 		Route::get('{quiz}/preview', [QuizController::class, 'preview'])->name('quiz.preview');

// // 		Route::post('{quiz}/question/set-order', [QuestionController::class, 'setOrder'])->name('question.set.order');

// // 		Route::prefix('question')->group(function() {
			
// // 			Route::get('index', [QuestionController::class, 'index'])->name('question.index');
// // 			Route::get('get', [QuestionController::class, 'ajaxGetQuestions'])->name('ajax_get_questions');
// // 			Route::get('create', [QuestionController::class, 'create'])->name('question.create');
// // 			Route::post('store', [QuestionController::class, 'store'])->name('question.store');
// // 			Route::get('{question}/edit', [QuestionController::class, 'edit'])->name('question.edit');
// // 			Route::post('{question}/update', [QuestionController::class, 'update'])->name('question.update');
// // 			Route::post('{question}/destroy', [QuestionController::class, 'destroy'])->name('question.destroy');

			

// // 		});

// // 		Route::get('{quiz_id}/overview', [QuizController::class, 'overview'])->name('UI_quizOverview');

// // 		Route::match(['get', 'post'], '{quiz_uuid}/start', [QuizController::class, 'beginQuiz'])->name('beginQuiz');
// // 		Route::match(['get', 'post'], '{result_uuid}/result', [QuizController::class, 'getQuizResult'])->name('UI_quizResult');
// // 		//update quiz answers 
// // 		Route::match(['get', 'post'], '{result_uuid}/resultupdate',[QuizController::class, 'resultupdate'])->name('quiz.result.update');

// // 		Route::post('{result_uuid}/submit-acknowledgement', [QuizController::class, 'submitAcknowledgement'])->name('quiz.result.submitAcknowledgement');
// // 	});

// 	Route::prefix('roles')->group(function() {
// 		Route::get('/', [RoleController::class, 'index'])->name('roles.index');
// 		Route::get('create', [RoleController::class, 'create'])->name('roles.create');
// 		Route::post('store', [RoleController::class, 'store'])->name('roles.store');
// 		Route::get('{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
// 		Route::post('{role}/update', [RoleController::class, 'update'])->name('roles.update');
// 		Route::post('{role}/destroy', [RoleController::class, 'destroy'])->name('roles.destroy');
// 		Route::post('save-order', [RoleController::class, 'saveRoleOrder'])->name('roles.save_order');
// 	});

// 	Route::prefix('permissions')->group(function() {
// 		Route::get('/', [PermissionController::class, 'index'])->name('permission.index');
// 		Route::get('create', [PermissionController::class, 'create'])->name('permission.create');
// 		Route::post('store', [PermissionController::class, 'store'])->name('permission.store');
// 		Route::get('{role}/edit', [PermissionController::class, 'edit'])->name('permission.edit');
// 		Route::post('{role}/update', [PermissionController::class, 'update'])->name('permission.update');
// 		Route::post('{role}/destroy', [PermissionController::class, 'destroy'])->name('permission.destroy');
// 	});

// 	Route::prefix('users')->group(function() {

// 		Route::get('index', [UserController::class, 'index'])->name('users.index');
// 		Route::get('get', [UserController::class, 'ajaxGetUsers'])->name('ajax_get_user_list'); 
// 		Route::get('create', [UserController::class, 'create'])->name('users.create');
// 		Route::post('store', [UserController::class, 'store'])->name('users.store');
// 		Route::get('{user}/edit', [UserController::class, 'edit'])->name('users.edit');
// 		Route::post('{user}/update', [UserController::class, 'update'])->name('users.update');
// 		Route::post('{user}/destroy', [UserController::class, 'destroy'])->name('users.destroy');

// 		// enable/disable user	
// 		Route::post('{user_id}/disable', [UserController::class, 'disableUser'])->name('disableUser');
// 		Route::post('{user_id}/enable', [UserController::class, 'enableUser'])->name('enableUser');

// 		// change password
// 		Route::get('{user_id}/change-password', [UserController::class, 'changePassword'])->name('UI_changePassword');
// 		Route::post('{user_id}/update-password', [UserController::class, 'updatePassword'])->name('post_updatePassword');

// 		Route::get('{user_uuid}/download/training-quiz', [UserController::class, 'downloadTrainingQuiz'])->name('users.downloadTrainingQuiz');
// 		Route::get('{user_uuid}/download/risk-assessment', [UserController::class, 'downloadRiskAssessment'])->name('users.downloadRiskAssessment');
// 		Route::get('{user_uuid}/download/acknowledgements', [UserController::class, 'downloadAcknowledgements'])->name('users.downloadAcknowledgements');
// 		Route::post('{user}/switchuser', [UserController::class, 'switchUser'])->name('users.switchUser');
// 		Route::post('switchback_user', [UserController::class, 'switchBackUser'])->name('users.switchBackUser');
		
// 	});

// // 	// company routes
// 	Route::prefix('company')->group(function() {
// 		Route::get('index', [CompanyController::class, 'index'])->name('company.index');
// 		Route::get('get', [CompanyController::class, 'ajax_getRecords'])->name('ajax_get_company');
// 		Route::get('create', [CompanyController::class, 'create'])->name('company.create');
// 		Route::post('store', [CompanyController::class, 'store'])->name('company.store');
// 		Route::get('{company}/edit', [CompanyController::class, 'edit'])->name('company.edit');
// 		Route::post('{company}/update', [CompanyController::class, 'update'])->name('company.update');
// 		Route::post('{company}/destroy', [CompanyController::class, 'destroy'])->name('company.destroy');
// 		Route::post('{company}/terminate', [CompanyController::class, 'terminate'])->name('company.terminate');
// 		Route::post('{company}/restore', [CompanyController::class, 'restore'])->name('company.restore');

// 		Route::post('{company}/users', [CompanyController::class, 'hasAnyUser'])->name('company.hasAnyUser');
// 		Route::post('increase_purchase_limit', [CompanyController::class, 'increasePurchaseLimit'])->name('company.increasePurchaseLimit');
// 		Route::post('decrease_purchase_limit', [CompanyController::class, 'decreasePurchaseLimit'])->name('company.decreasePurchaseLimit');
// 		Route::post('{company}/switch_user', [CompanyController::class, 'switchUser'])->name('company.switchUser');
// 		Route::post('switch_back_user', [CompanyController::class, 'switchBackUser'])->name('company.switchBackUser');
// 	});


// 	Route::prefix('document-library')->group(function() {
// 		Route::get('index', [DocumentLibraryController::class, 'index'])->name('document-library.index');
// 		Route::get('get', [DocumentLibraryController::class, 'ajaxGetDocumentLibraries'])->name('ajax_get_document_library');
// 		Route::get('create', [DocumentLibraryController::class, 'create'])->name('document-library.create');
// 		Route::post('store', [DocumentLibraryController::class, 'store'])->name('document-library.store');
// 		Route::get('{document_library}/edit', [DocumentLibraryController::class, 'edit'])->name('document-library.edit');
// 		Route::post('{document_library}/update', [DocumentLibraryController::class, 'update'])->name('document-library.update');

// 		Route::post('{document_library}/destroy', [DocumentLibraryController::class, 'destroy'])->name('document-library.destroy');

// 		Route::get('{uuid}/file', [DocumentLibraryController::class, 'getDocument'])->name('viewDocument');
// 		Route::get('{uuid}/download', [DocumentLibraryController::class, 'download'])->name('downloadAgreement');
// 	});

// 	Route::prefix('documents/scanned')->group(function() {
// 		Route::get('index', [ScannedDocumentController::class, 'index'])->name('scanned-documents.index');
// 		Route::get('get', [ScannedDocumentController::class, 'ajaxGetScannedDocuments'])->name('ajax_get_scanned_documents');
// 		Route::get('create', [ScannedDocumentController::class, 'create'])->name('scanned-documents.create');
// 		Route::post('store', [ScannedDocumentController::class, 'store'])->name('scanned-documents.store');
// 		Route::get('{scanned_document_id}/edit', [ScannedDocumentController::class, 'edit'])->name('scanned-documents.edit');
// 		Route::post('{scanned_document_id}/update', [ScannedDocumentController::class, 'update'])->name('scanned-documents.update');

// 		Route::post('{scanned_document_id}/destroy', [ScannedDocumentController::class, 'destroy'])->name('scanned-documents.destroy');

// 		Route::get('{uuid}/file', [ScannedDocumentController::class, 'getDocument'])->name('viewScannedDocument');
// 		Route::get('{uuid}/download', [ScannedDocumentController::class, 'download'])->name('downloadScannedDocument');
// 	});

// 	Route::prefix('business-associate-agreements')->group(function() {
// 		Route::get('index', [BusinessAssociateAgreementController::class, 'index'])->name('business-associate-agreement.index');
// 		Route::get('get', [BusinessAssociateAgreementController::class, 'ajax_getRecords'])->name('ajax_get_business_agreements');

// 		Route::get('create', [BusinessAssociateAgreementController::class, 'create'])->name('business-associate-agreement.create');
// 		Route::post('store', [BusinessAssociateAgreementController::class, 'store'])->name('business-associate-agreement.store');

// 		Route::get('{business_associate_agreement}/edit', [BusinessAssociateAgreementController::class, 'edit'])->name('business-associate-agreement.edit');
// 		Route::post('{business_associate_agreement}/update', [BusinessAssociateAgreementController::class, 'update'])->name('business-associate-agreement.update');

// 		Route::get('{business_associate_agreement}/view', [BusinessAssociateAgreementController::class, 'show'])->name('business-associate-agreement.view');
// 		Route::get('{business_associate_agreement}/download', [BusinessAssociateAgreementController::class, 'download'])->name('business-associate-agreement.download');

// 		Route::post('{business_associate_agreement}/destroy', [BusinessAssociateAgreementController::class, 'destroy'])->name('business-associate-agreement.destroy');
// 	});

// 	Route::prefix('technology-reports')->group(function() {
// 		Route::get('index', [TechnologyReportController::class, 'index'])->name('technology-report.index');
// 		Route::get('get', [TechnologyReportController::class, 'ajaxGetTechnologyReport'])->name('ajax_get_technology_reports');
// 		Route::get('create', [TechnologyReportController::class, 'create'])->name('technology-report.create');
// 		Route::post('store', [TechnologyReportController::class, 'store'])->name('technology-report.store');
// 		Route::get('{technology_report}/edit', [TechnologyReportController::class, 'edit'])->name('technology-report.edit');
// 		Route::post('{technology_report}/update', [TechnologyReportController::class, 'update'])->name('technology-report.update');

// 		Route::post('{technology_report}/destroy', [TechnologyReportController::class, 'destroy'])->name('technology-report.destroy');

// 		Route::get('{uuid}/file', [TechnologyReportController::class, 'getDocument'])->name('viewTechDocument');
// 		Route::get('{uuid}/download', [TechnologyReportController::class, 'download'])->name('downloadTechReport');
// 	});

// 	Route::prefix('policy-procedure')->group(function() {
// 		Route::get('/', [PolicyProcedureController::class, 'index'])->name('UI_policyProcedures');
// 		Route::get('get', [PolicyProcedureController::class, 'ajaxGetPolicies'])->name('ajax_get_policy_procedures');

// 		Route::get('create', [PolicyProcedureController::class, 'create'])->name('policy-procedure.create');
// 		Route::post('store', [PolicyProcedureController::class, 'store'])->name('policy-procedure.store');
// 		Route::get('{policy_procedure}/edit', [PolicyProcedureController::class, 'edit'])->name('policy-procedure.edit');
// 		Route::get('{policy_procedure}/view', [PolicyProcedureController::class, 'show'])->name('policy-procedure.view');

// 		Route::get('{policy_procedure}/download', [PolicyProcedureController::class, 'download'])->name('policy-procedure.download');

// 		Route::post('{policy_procedure}/update', [PolicyProcedureController::class, 'update'])->name('policy-procedure.update');

// 		Route::post('{policy_procedure}/destroy', [PolicyProcedureController::class, 'destroy'])->name('policy-procedure.destroy');

// 		// emr records by state
// 		Route::prefix('emr-records')->group(function() {
// 			Route::get('/', [EmrByStateController::class, 'index'])->name('emr-records.index');
// 			Route::get('get', [EmrByStateController::class, 'ajaxGetPolicies'])->name('ajax_get_emr_records');

// 			Route::get('create', [EmrByStateController::class, 'create'])->name('emr-records.create');
// 			Route::post('store', [EmrByStateController::class, 'store'])->name('emr-records.store');
// 			Route::get('{emr_records}/edit', [EmrByStateController::class, 'edit'])->name('emr-records.edit');
// 			Route::get('{emr_records}/view', [EmrByStateController::class, 'show'])->name('emr-records.view');
// 			Route::post('{emr_records}/update', [EmrByStateController::class, 'update'])->name('emr-records.update');

// 			Route::post('{emr_records}/destroy', [EmrByStateController::class, 'destroy'])->name('emr-records.destroy');
// 		});
// 	});

// 	Route::prefix('policies-procedures')->group(function() {

// 		// Route::get('/', [PolicyProcedureController::class, 'list'])->name('UI_policyProcedures');
// 		Route::get('{id}/view', [PolicyProcedureController::class, 'view'])->name('viewPolicyFile');

// 		Route::get('emr-records-per-state', [PolicyProcedureController::class, 'emrByState'])->name('UI_emrRecordsPerState');
// 		Route::get('emr-records-per-state/{id}/view', [PolicyProcedureController::class, 'viewEmr'])->name('viewEmrRecordsFile');

// 	});

// // 	Route::prefix('policy-revision')->group(function() {
// // 		Route::get('index', [PolicyRevisionController::class, 'index'])->name('UI_policyRevision');
// // 		Route::get('get', [PolicyRevisionController::class, 'ajaxGetPolicyRevisions'])->name('ajax_get_policy_revisions');

// // 		Route::get('{policy_revision}/view', [PolicyRevisionController::class, 'show'])->name('policy-revision.view');
// // 		Route::post('{policy_revision}/destroy', [PolicyRevisionController::class, 'destroy'])->name('policy-revision.destroy');

// // 		Route::post('save', [PolicyRevisionController::class, 'store'])->name('savePolicyRevision');
// // 	});

// // 	Route::prefix('patient-disclosure-authorization')->group(function() {
// // 		Route::get('index', [PatientDisclosureAuthorizationController::class, 'index'])->name('patient.disclosure.index');
// // 		Route::get('get', [PatientDisclosureAuthorizationController::class, 'ajax_getRecords'])->name('ajax_get_patient_disclosure_records');

// // 		Route::get('create', [PatientDisclosureAuthorizationController::class, 'create'])->name('patient.disclosure.create');
// // 		Route::post('store', [PatientDisclosureAuthorizationController::class, 'store'])->name('patient.disclosure.store');

// // 		Route::get('{form_uuid}/edit', [PatientDisclosureAuthorizationController::class, 'edit'])->name('patient.disclosure.edit');
// // 		Route::post('{form_uuid}/update', [PatientDisclosureAuthorizationController::class, 'update'])->name('patient.disclosure.update');

// // 		Route::get('{policy_revision}/view', [PatientDisclosureAuthorizationController::class, 'show'])->name('patient.disclosure.view');
// // 		Route::get('{policy_revision}/download', [PatientDisclosureAuthorizationController::class, 'download'])->name('patient.disclosure.download');
		
// // 		Route::post('{policy_revision}/destroy', [PatientDisclosureAuthorizationController::class, 'destroy'])->name('patient.disclosure.destroy');
// // 	});

// // 	Route::prefix('authorize-use-and-disclosure')->group(function() {

// // 		Route::get('/', [AuthorizeUseDisclosureController::class, 'index'])->name('authorize-user-and-disclosure.index');
// // 		Route::get('get', [AuthorizeUseDisclosureController::class, 'ajax_getResults'])->name('ajax_get_aud_records');

// // 		Route::get('create', [AuthorizeUseDisclosureController::class, 'create'])->name('authorize-user-and-disclosure.create');
// // 		Route::post('save', [AuthorizeUseDisclosureController::class, 'save'])->name('authorize-user-and-disclosure.store');

// // 		Route::get('{form_id}/edit', [AuthorizeUseDisclosureController::class, 'edit'])->name('authorize-user-and-disclosure.edit');
// // 		Route::post('{form_id}/update', [AuthorizeUseDisclosureController::class, 'update'])->name('authorize-user-and-disclosure.update');

// // 		Route::get('{form_id}/view', [AuthorizeUseDisclosureController::class, 'view'])->name('authorize-user-and-disclosure.view');
// // 		Route::get('{form_id}/download', [AuthorizeUseDisclosureController::class, 'download'])->name('authorize-user-and-disclosure.download');
// // 		Route::post('{form_id}/destroy', [AuthorizeUseDisclosureController::class, 'destroy'])->name('authorize-user-and-disclosure.destory');
		
// // 	});

// // 	Route::prefix('online-forms')->group(function() {

// // 		Route::get('all', [OnlineFormsController::class, 'allOnlineForms'])->name('UI_allOnlineForms');
// // 		Route::get('list', [OnlineFormsController::class, 'list'])->name('UI_onlineForms');

// // 		Route::prefix('authorize-use-and-disclosure')->group(function() {

// // 			// Route::get('/', [AuthorizeUseDisclosureController::class, 'ajax_getResults'])->name('ajax_get_aud_records');

// // 			Route::get('create', [AuthorizeUseDisclosureController::class, 'create'])->name('UI_createAuthorizeUseAndDisclosure');
// // 			Route::post('save', [AuthorizeUseDisclosureController::class, 'save'])->name('saveAuthorizeUseAndDisclosureForm');

// // 			Route::get('{form_id}/edit', [AuthorizeUseDisclosureController::class, 'edit'])->name('authorize-disclosure.edit');
// // 			Route::post('{form_id}/update', [AuthorizeUseDisclosureController::class, 'update'])->name('authorize-disclosure.update');

// // 			Route::get('{form_id}/view', [AuthorizeUseDisclosureController::class, 'view'])->name('viewAuthorizeUseAndDisclosureForm');
// // 			Route::post('{form_id}/destroy', [AuthorizeUseDisclosureController::class, 'destroy'])->name('deleteAuthorizeDisclosureForm');
			
// // 		});

// // 		Route::prefix('accounting-of-disclosures-tracking-sheet')->group(function() {

// // 			Route::get('/', [AdtsFormController::class, 'ajax_getResults'])->name('ajax_get_adts_records');

// // 			Route::get('create', [AdtsFormController::class, 'create'])->name('UI_createADTSForm');
// // 			Route::post('save', [AdtsFormController::class, 'save'])->name('saveADTSForm');

// // 			Route::get('{form_id}/edit', [AdtsFormController::class, 'edit'])->name('adts.edit');
// // 			Route::post('{form_id}/update', [AdtsFormController::class, 'update'])->name('adts.update');

// // 			Route::get('{form_id}/view', [AdtsFormController::class, 'view'])->name('viewADTSForm');
// // 			Route::get('{form_id}/download', [AdtsFormController::class, 'download'])->name('downloadADTSForm');
// // 			Route::post('{form_id}/destroy', [AdtsFormController::class, 'destroy'])->name('deleteADTSForm');

// // 		});

// // 		Route::prefix('employee-termination-form')->group(function() {

// // 			Route::get('/', [EmployeeTerminationController::class, 'ajax_getResults'])->name('ajax_get_et_records');

// // 			Route::get('create', [EmployeeTerminationController::class, 'create'])->name('UI_createEmployeeTerminationForm');
// // 			Route::post('save', [EmployeeTerminationController::class, 'save'])->name('saveEmployeeTerminationForm');

// // 			Route::get('{form_id}/edit', [EmployeeTerminationController::class, 'edit'])->name('emp-termination.edit');
// // 			Route::post('{form_id}/update', [EmployeeTerminationController::class, 'update'])->name('emp-termination.update');

// // 			Route::get('{form_id}/view', [EmployeeTerminationController::class, 'view'])->name('viewEmployeeTerminationForm');
// // 			Route::get('{form_id}/download', [EmployeeTerminationController::class, 'download'])->name('downloadEmployeeTerminationForm');
// // 			Route::post('{form_id}/destroy', [EmployeeTerminationController::class, 'destroy'])->name('deleteEmployeeTerminationFormRecord');

// // 		});

		

// // 		Route::prefix('email-form-for-access-to-health-record')->group(function() {

// // 			Route::get('/', [EmailFormForAccessToHealthRecordController::class, 'ajax_getResults'])->name('ajax_get_efathr_records');

// // 			Route::get('create', [EmailFormForAccessToHealthRecordController::class, 'create'])->name('UI_createEmailFormForAccessToHealthRecord');

// // 			Route::post('save', [EmailFormForAccessToHealthRecordController::class, 'save'])->name('saveEmailFormForAccessToHealthRecord');

// // 			Route::get('{form_id}/edit', [EmailFormForAccessToHealthRecordController::class, 'edit'])->name('email-for-access-health.edit');
// // 			Route::post('{form_id}/update', [EmailFormForAccessToHealthRecordController::class, 'update'])->name('email-for-access-health.update');

// // 			Route::get('{form_id}/view', [EmailFormForAccessToHealthRecordController::class, 'view'])->name('viewEmailFormForAccessToHealthRecord');

// // 			Route::get('{form_id}/download', [EmailFormForAccessToHealthRecordController::class, 'download'])->name('downloadEmailFormForAccessToHealthRecord');

// // 			Route::post('{form_id}/destroy', [EmailFormForAccessToHealthRecordController::class, 'destroy'])->name('deleteEmailForAccessToHealthRecord');
			
// // 		});

// // 		Route::prefix('business-associate-vendor-termination')->group(function() {

// // 			Route::get('/', [BusinessAssociationVendorController::class, 'ajax_getResults'])->name('ajax_get_bavt_records');

// // 			Route::get('create', [BusinessAssociationVendorController::class, 'create'])->name('UI_createBusinessAssociateVendorTerminationForm');

// // 			Route::post('save', [BusinessAssociationVendorController::class, 'save'])->name('saveBusinessAssociateVendorTerminationForm');

// // 			Route::get('{form_id}/edit', [BusinessAssociationVendorController::class, 'edit'])->name('bba.edit');
// // 			Route::post('{form_id}/update', [BusinessAssociationVendorController::class, 'update'])->name('bba.update');

// // 			Route::get('{form_id}/view', [BusinessAssociationVendorController::class, 'view'])->name('viewBusinessAssociateVendorTerminationForm');

// // 			Route::get('{form_id}/download', [BusinessAssociationVendorController::class, 'download'])->name('downloadBusinessAssociateVendorTerminationForm');

// // 			Route::post('{form_id}/destroy', [BusinessAssociationVendorController::class, 'destroy'])->name('deleteBusinessAssociationForm');
			
// // 		});

// // 		Route::prefix('request-to-download-ephi')->group(function() {

// // 			Route::get('/', [RequestToDownloadEphiController::class, 'ajax_getResults'])->name('ajax_get_rtde_records');

// // 			Route::get('create', [RequestToDownloadEphiController::class, 'create'])->name('UI_createRequestToDownloadEPHI');

// // 			Route::post('save', [RequestToDownloadEphiController::class, 'save'])->name('saveRequestToDownloadEPHI');

// // 			Route::get('{form_id}/edit', [RequestToDownloadEphiController::class, 'edit'])->name('ephi.edit');
// // 			Route::post('{form_id}/update', [RequestToDownloadEphiController::class, 'update'])->name('ephi.update');

// // 			Route::get('{form_id}/view', [RequestToDownloadEphiController::class, 'view'])->name('viewRequestToDownloadEPHI');

// // 			Route::get('{form_id}/download', [RequestToDownloadEphiController::class, 'download'])->name('downloadRequestToDownloadEPHI');

// // 			Route::post('{form_id}/destroy', [RequestToDownloadEphiController::class, 'destroy'])->name('deleteRequestToDownloadEPHIForm');
			
// // 		});

// // 		Route::prefix('email-form-for-health-record-ammendment')->group(function() {

// // 			Route::get('/', [EmailFormForHealthRecordAmmendmentController::class, 'ajax_getResults'])->name('ajax_get_efhra_records');

// // 			Route::get('create', [EmailFormForHealthRecordAmmendmentController::class, 'create'])->name('UI_createEmailFormForHealthRecordAmmendment');

// // 			Route::post('save', [EmailFormForHealthRecordAmmendmentController::class, 'save'])->name('saveEmailFormForHealthRecordAmmendment');

// // 			Route::get('{form_id}/edit', [EmailFormForHealthRecordAmmendmentController::class, 'edit'])->name('ammendment.edit');
// // 			Route::post('{form_id}/update', [EmailFormForHealthRecordAmmendmentController::class, 'update'])->name('ammendment.update');

// // 			Route::get('{form_id}/view', [EmailFormForHealthRecordAmmendmentController::class, 'view'])->name('viewEmailFormForHealthRecordAmmendment');

// // 			Route::get('{form_id}/download', [EmailFormForHealthRecordAmmendmentController::class, 'download'])->name('downloadEmailFormForHealthRecordAmmendment');

// // 			Route::post('{form_id}/destroy', [EmailFormForHealthRecordAmmendmentController::class, 'destroy'])->name('deleteEmailForHealthAmmendmentRecord');
			
// // 		});

// // 		Route::prefix('media-destruction-and-reuse-form')->group(function() {

// // 			Route::get('/', [MediaDestructionOrReuseController::class, 'ajax_getResults'])->name('ajax_get_mdrf_records');

// // 			Route::get('create', [MediaDestructionOrReuseController::class, 'create'])->name('UI_createMediaDestructionAndReuseForm');

// // 			Route::post('save', [MediaDestructionOrReuseController::class, 'save'])->name('saveMediaDestructionAndReuseForm');

// // 			Route::get('{form_id}/edit', [MediaDestructionOrReuseController::class, 'edit'])->name('media.edit');
// // 			Route::post('{form_id}/update', [MediaDestructionOrReuseController::class, 'update'])->name('media.update');

// // 			Route::get('{form_id}/view', [MediaDestructionOrReuseController::class, 'view'])->name('viewMediaDestructionAndReuseForm');

// // 			Route::get('{form_id}/download', [MediaDestructionOrReuseController::class, 'download'])->name('downloadMediaDestructionAndReuseForm');

// // 			Route::post('{form_id}/destroy', [MediaDestructionOrReuseController::class, 'destroy'])->name('deleteMediaDestructionAndReuseRecord');
			
// // 		});

// // 		Route::prefix('sanction-form')->group(function() {

// // 			Route::get('/', [SanctionReportController::class, 'ajax_getResults'])->name('ajax_get_sf_records');

// // 			Route::get('create', [SanctionReportController::class, 'create'])->name('UI_createSanctionsForm');

// // 			Route::post('save', [SanctionReportController::class, 'save'])->name('saveSanctionsForm');

// // 			Route::get('{form_id}/edit', [SanctionReportController::class, 'edit'])->name('sanction.edit');
// // 			Route::post('{form_id}/update', [SanctionReportController::class, 'update'])->name('sanction.update');

// // 			Route::get('{form_id}/view', [SanctionReportController::class, 'view'])->name('viewSanctionsForm');
			
// // 			Route::get('{form_id}/download', [SanctionReportController::class, 'download'])->name('downloadSanctionsForm');

// // 			Route::post('{form_id}/destroy', [SanctionReportController::class, 'destroy'])->name('deleteSanctionsFormRecord');
			
// // 		});

// // 	});

// // 	Route::get('annual-risk-assessment/welcome', [TrainingController::class, 'AnnualRiskAssessmentWelcome'])->name('annual-risk-assessment.welcome');

// 	Route::prefix('training')->group(function() {
// 		Route::get('welcome', [TrainingController::class, 'welcome'])->name('training.welcome');
// 		Route::get('hipaa', [TrainingController::class, 'hipaaTraining'])->name('UI_hipaaTraining');
// 		Route::get('quiz/{quiz_id}/overview', [TrainingController::class, 'quizOverviewPage'])->name('UI_quizOverviewPage');
		
// 		Route::match(['get', 'post'], 'quiz/{test_id}/start', [TrainingController::class, 'startQuiz'])->name('startQuiz');
// 		Route::match(['get', 'post'], 'quiz/{test_id}/result/{sess_id}', [TrainingController::class, 'getQuizResult'])->name('UI_showQuizResult');

// 		Route::get('quiz/risk-assessment/{quiz_id}/overview', [TrainingController::class, 'riskAssessmentQuizOverviewPage'])->name('UI_riskAssessmentQuizOverviewPage');
// 		Route::match(['get', 'post'], 'quiz/risk-assessment/{test_id}/start', [TrainingController::class, 'startRiskAssessmentQuiz'])->name('startRiskAssessmentQuiz');
// 		Route::match(['get', 'post'], 'quiz/risk-assessment/{test_id}/result/{sess_id}', [TrainingController::class, 'getRiskAssessmentQuizResult'])->name('UI_showRiskAssessmentQuizResult');
// 	});

// 	Route::prefix('risk-assessment-answers')->group(function() {
// 		Route::get('/', [RiskAssessmentController::class, 'index'])->name('UI_listRiskAssessmentTest');
// 		Route::get('get', [RiskAssessmentController::class, 'ajaxGetTests'])->name('ajax_get_tests_list');

// 		Route::get('{result_id}/view', [RiskAssessmentController::class, 'show'])->name('UI_showQuizAnswers');
// 		Route::post('{result_id}/destroy', [RiskAssessmentController::class, 'destroy'])->name('post_deleteResult');
// 	});

// 	Route::prefix('todo')->group(function() {

// 		Route::get('{todo_id}/edit', [TodoController::class, 'editTodo'])->name('UI_edit');
// 		Route::post('{todo_id}/update', [TodoController::class, 'updateTodo'])->name('updateTodo');

// 	});

// 	Route::prefix('settings')->group(function() {

// 		Route::get('site', [SettingController::class, 'showSettings'])->name('UI_siteSettings');
// 		Route::post('save/site', [SettingController::class, 'saveSetting'])->name('saveSetting');

// 		Route::get('crop-image-upload', [CropImageController::class, 'index']);
// 		Route::post('crop-image-upload', [CropImageController::class, 'uploadCropImage']);

// 		Route::post('terminate-account', [UserController::class, 'terminateAccount'])->name('terminateAccount');

// 	});

// });

