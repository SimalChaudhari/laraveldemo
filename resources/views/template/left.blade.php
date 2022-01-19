<ul>

    <li>
        <a href="{{ route('dashboard') }}" class="nav-header">
            <i class="fa fa-fw fa-dashboard"></i> Hipaamart: Organization and Procedures
        </a>
    </li>

    <?php if( Auth::user()->can('role-list') ) { ?>
    <li>
        <a href="{{ route('roles.index') }}" class="nav-header">
            <i class="fa fa-fw fa-user-secret"></i> Roles
        </a>
    </li>
    <?php } ?>

    {{-- <li>
        <a href="{{ route('permission.index') }}" class="nav-header">
            <i class="fa fa-fw fa-unlock-alt"></i> Permissions
        </a>
    </li> --}}

    <?php
    if( Auth::user()->can('HIPAA Safe Harbor') OR Auth::user()->can('HIPAA Rules') ) {
        $hipaa_menus = [
            'safeHarbor' => [
                'title' => 'HIPAA Safe Harbor',
                'permission' => 'HIPAA Safe Harbor'
            ],
            'hipaaRules' => [
                'title' => 'Mandated HIPAA Rules',
                'permission' => 'HIPAA Rules'
            ],
            'cybersecurity' => [
                'title' => 'Cybersecurity',
                'permission' => 'HIPAA Rules'
            ],
        ];

        ?>
        <li>
            <a href="javascript:void();" data-target=".hipaa_rules" class="nav-header  @if( !array_key_exists( Route::currentRouteName(), $hipaa_menus ) ) collapsed @endif" data-toggle="collapse">
                <i class="fa fa-fw fa-universal-access" aria-hidden="true"></i> HIPAA Rules and Safe Harbor<i class="fa fa-collapse"></i>
            </a>
        </li>

        <li>
            <ul class="hipaa_rules nav nav-list collapse @if( array_key_exists( Route::currentRouteName(), $hipaa_menus ) ) in @endif">

                {!! get_submenu_HTML( $hipaa_menus ) !!}
                
            </ul>
        </li>
    <?php } ?>

    <?php
        if( Auth::user()->can('Training Overview')
            //OR Auth::user()->can('Quiz Crud Module')
            OR Auth::user()->can('Training Video')
            OR Auth::user()->can('Training Quiz')
            OR Auth::user()->can('Training Acknowledgement') ) {

            $training_quiz = \App\Models\Quiz::select('uuid')->where('name', 'Training Quiz')->first();

            $training_menu = [
                // route alias name => menu title
                'training.welcome' => [
                    'title' => 'Overview',
                    'permission' => 'Training Overview'
                ],
                /*'quiz.index' => [
                    'title' => 'Testing Admin',
                    'permission' => 'Quiz Crud Module'
                ],*/
                'UI_hipaaTraining' => [
                    'title' => 'Training Video',
                    'permission' => 'Training Video'
                ],
            ];

            //if( Auth::user()->has_video_watched == 1 ) {
                $training_menu['UI_quizOverview'] = [
                    'title' => 'Training Quiz',
                    'args' => $training_quiz->uuid,
                    'target' => '_self',
                    'permission' => 'Training Quiz'
                ];

                $training_menu['training.ack.index'] = [
                    'title' => 'Training Acknowledgement',
                    'permission' => 'Training Acknowledgement'
                ];
            //}

        ?>

            <li>
                <a href="javascript:void();" data-target=".training-menu" class="nav-header @if( !array_key_exists( Route::currentRouteName(), $training_menu ) ) collapsed @endif" data-toggle="collapse">
                    <i class="fa fa-fw fa-superpowers" aria-hidden="true"></i> Training<i class="fa fa-collapse"></i>
                </a>
            </li>

            <li>
                <ul class="nav nav-list collapse @if( array_key_exists( Route::currentRouteName(), $training_menu ) ) in @endif training-menu">

                    {!! get_submenu_HTML( $training_menu ) !!}

                </ul>
            </li>

    <?php } ?>

    <?php
        if( Auth::user()->can('Risk Assessment Overview')
            OR Auth::user()->can('Risk Assessment Quiz')
            OR Auth::user()->can('Risk Assessment Acknowledgment') ) {

            $risk_assessment_quiz = \App\Models\Quiz::select('uuid')->where('name', 'Risk Assessment Questionnaire')->first();

            $training_menu = [
                // route alias name => menu title
                'annual-risk-assessment.welcome' => [
                    'title' => 'Overview',
                    'permission' => 'Risk Assessment Overview',
                ],

                'UI_quizOverview' => [
                    'title' => 'Risk Assessment Questionnaire',
                    'args' => $risk_assessment_quiz->uuid,
                    'target' => '_self',
                    'permission' => 'Risk Assessment Quiz'
                ],
                'risk.ack.index' => [
                    'title' => 'Risk Assessment Acknowledgement',
                    'permission' => 'Risk Assessment Acknowledgment'
                ]
            ];

    ?>

    <li>
        <a href="javascript:void();" data-target=".risk_assessment_menu" class="nav-header @if( !array_key_exists( Route::currentRouteName(), $training_menu ) ) collapsed @endif" data-toggle="collapse">
            <i class="fa fa-fw fa-certificate" aria-hidden="true"></i> Annual Risk Assessment<i class="fa fa-collapse"></i>
        </a>
    </li>

    <li>
        <ul class="nav nav-list risk_assessment_menu collapse @if( array_key_exists( Route::currentRouteName(), $training_menu ) ) in @endif">

            {!! get_submenu_HTML( $training_menu ) !!}

        </ul>
    </li>

    <?php } ?>

    <?php if( Auth::user()->can('Policies and Procedures') ) {
        $container_menus = [
            'UI_policyProcedures' => [
                'title' => 'Policies and Procedures',
                'permission' => 'Policies and Procedures',
            ]
        ];
    ?>

    <li>
        <a href="javascript:void();" data-target=".hipaa_container" class="nav-header @if( !array_key_exists( Route::currentRouteName(), $container_menus ) ) collapsed @endif" data-toggle="collapse">
            <i class="fa fa-fw fa-fighter-jet" aria-hidden="true"></i> HIPAA Container<i class="fa fa-collapse"></i>
        </a>
    </li>

    <li>
        <ul class="nav nav-list hipaa_container collapse @if( array_key_exists( Route::currentRouteName(), $container_menus ) ) in @endif">
            {!! get_submenu_HTML( $container_menus ) !!}
        </ul>
    </li>

    <?php } ?>

    <?php
        if( Auth::user()->can('Document Library')
            OR Auth::user()->can('Scanned Documents - List')
            OR Auth::user()->can('Business Associate Agreement')
            OR Auth::user()->can('Patient Disclosure Authorization Form')
            /*OR Auth::user()->can('Authorization to Use and/or Disclose Medical Records Form')*/
            OR request()->is('online-forms/*')
            /*OR Auth::user()->can('Index to Practice Forms')*/ ) {

            $library_menus = [
                'document-library.index' => [
                    'title' => 'Document Library',
                    'permission' => 'Document Library',
                ],
                'business-associate-agreement.index' => [
                    'title' => 'Business Associate Agreement',
                    'permission' => 'Business Associate Agreement',
                ],
                'patient.disclosure.index' => [
                    'title' => 'Patient Disclosure Authorization Form',
                    'permission' => 'Patient Disclosure Authorization Form',
                ],
                'scanned-documents.index' => [
                    'title' => 'Scanned Documents',
                    'permission' => 'Scanned Documents - List',
                ],
                /*'authorize-user-and-disclosure.index' => [
                    'title' => 'Authorization to Use and/or Disclose Medical Records Form',
                    'permission' => 'Authorization to Use and/or Disclose Medical Records Form',
                ],*/
                /*'UI_allOnlineForms' => [
                    'title' => 'Index to Practice Forms',
                    'permission' => 'Index to Practice Forms',
                ]*/
            ];

    ?>

    <li>
        <a href="javascript:void();" data-target=".document_library" class="nav-header @if( !array_key_exists( Route::currentRouteName(), $library_menus ) OR request()->is('online-forms/*') ) collapsed @endif" data-toggle="collapse">
            <i class="fa fa-fw fa-book" aria-hidden="true"></i> Document Library<i class="fa fa-collapse"></i>
        </a>
    </li>

    <li>
        <ul class="nav nav-list document_library collapse @if( array_key_exists( Route::currentRouteName(), $library_menus ) OR request()->is('online-forms/*') ) in @endif">

            {!! get_submenu_HTML( $library_menus ) !!}

        </ul>
    </li>

    <?php } ?>

    <?php
        if( Auth::user()->can('user-create')
            OR Auth::user()->can('Add New Company')
            OR Auth::user()->can('user-list') ) {

            $users_menu = [
                'users.create' => [
                    // 'title' => 'Add New User',
                    'title' => 'Register New User',
                    'permission' => 'user-create',
                ],
                'company.index' => [
                    'title' => 'Company',
                    'permission' => 'company-list'
                ],
                'users.index' => [
                    // 'title' => 'Users',
                    'title' => 'Registered Users',
                    'permission' => 'user-list'
                ]
            ];
    ?>
    <li>
        <a href="javascript:void();" data-target=".users" class="nav-header  @if( !array_key_exists( Route::currentRouteName(), $users_menu ) ) collapsed @endif" data-toggle="collapse">
            <i class="fa fa-fw fa-users" aria-hidden="true"></i> Users<i class="fa fa-collapse"></i>
        </a>
    </li>
    
    <li>
        <ul class="nav nav-list collapse users @if( array_key_exists( Route::currentRouteName(), $users_menu ) ) in @endif">

            {!! get_submenu_HTML( $users_menu ) !!}

        </ul>
    </li>
    

    <?php } ?>

    <?php
        if( Auth::user()->can('Setting')
            OR Auth::user()->can('Quiz Crud Module') ) {

            $settings_menu = [
                'UI_siteSettings' => [
                    'title' => 'Settings',
                    'permission' => 'Setting',
                ],
                'quiz.index' => [
                    'title' => 'Testing Admin',
                    'permission' => 'Quiz Crud Module'
                ],
            ];
    ?>
    <li>
        <a href="javascript:void();" data-target=".settings" class="nav-header  @if( !array_key_exists( Route::currentRouteName(), $settings_menu ) ) collapsed @endif" data-toggle="collapse">
            <i class="fa fa-fw fa-cogs" aria-hidden="true"></i> Settings<i class="fa fa-collapse"></i>
        </a>
    </li>

    <li>
        <ul class="nav nav-list collapse settings @if( array_key_exists( Route::currentRouteName(), $settings_menu ) ) in @endif">

            {!! get_submenu_HTML( $settings_menu ) !!}

        </ul>
    </li>
    
    <?php } ?>
    
    <li>
        <a href="https://www.hipaamart.com/contact-us" class="nav-header" target="blank">
            <i class="fa fa-fw fa-envelope-open"></i> Contact Us
        </a>
    </li>

    <li class="hidden-sm hidden-md hidden-lg">
        <a href="javascript:void();" data-target=".my_account_menu" class="nav-header collapsed" data-toggle="collapse">
            <i class="fa fa-fw fa-cogs" aria-hidden="true"></i> Account Info<i class="fa fa-collapse"></i>
        </a>
    </li>

    <li class="hidden-sm hidden-md hidden-lg">
        <ul class="nav nav-list collapse my_account_menu">

            <li>
                <a href="{{ route('users.edit', Auth::user()->uuid ) }}">
                    <span class="fa fa-caret-right"></span> My Account
                </a>
            </li>

            <li>
                <a href="{{ route('UI_changePassword', Auth::user()->uuid ) }}">
                    <span class="fa fa-caret-right"></span> Change Password
                </a>
            </li>

            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-fw fa-sign-out" aria-hidden="true"></i> Logout</a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>

        </ul>
    </li>

</ul>