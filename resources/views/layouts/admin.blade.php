<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <title>@yield('page_title') | {{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8">

    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('public/images') }}/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('public/images') }}/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('public/images') }}/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('public/images') }}/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('public/images') }}/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('public/images') }}/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('public/images') }}/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('public/images') }}/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/images') }}/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('public/images') }}/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/images') }}/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('public/images') }}/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/images') }}/favicon-16x16.png">
    <link rel="manifest" href="{{ asset('public/images') }}/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('public/images') }}/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    
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
    <link href="{{ asset('public/lib/bootstrap-dialog/bootstrap-dialog.min.css') }}" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="{{ asset( 'public/css/theme.css?'. time() ) }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset( 'public/css/premium.css') }}" />

    <link href="{{ asset('public/lib/dataTables/datatables.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('public/lib/jQuery.validationEngine/validationEngine.jquery.css') }}" rel="stylesheet" type="text/css" />

    
    

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <script src="{{ asset( 'public/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>

    
    

    <script type="text/javascript">
        var site = {
            'dateFormat': '{{ config("app.JS_DATEPICKER_DATE_FORMAT") }}',
        };
    </script>
</head>
<body class="theme-blue">

    @include('template.custom-css')

    <style type="text/css">
        form .invalid-feedback {color:red;font-size: 12px;}
        .alert-info {
            color: #171a1d;
            background-color: #93bbe1;
            border-color: #0a0a0a;
            font-weight: bold;
            font-size: 16px;
        }
        .alert-info p, .alert-info ul li, .alert-info ol li {
            font-size: 16px;
        }
    </style>

    <script type="text/javascript">
        $(function() {
            var match = document.cookie.match(new RegExp('color=([^;]+)'));
            if(match) var color = match[1];
            if(color) {
                $('body').removeClass(function (index, css) {
                    return (css.match (/\btheme-\S+/g) || []).join(' ')
                })
                $('body').addClass('theme-' + color);
            }

            $('[data-popover="true"]').popover({html: true});
            
        });
    </script>

    <script type="text/javascript">
        $(function() {
            var uls = $('.sidebar-nav > ul > *').clone();
            uls.addClass('visible-xs');
            $('#main-menu').append(uls.clone());
        });
    </script>

    <div class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container-fluid">
            @include('template.header')
        </div>
    </div>

    <div id="site-content" class="container-fluid">

        <div class="row">

            <aside class="sidebar-nav">
                @include('template.left')
            </aside>
            

            <div class="content">

                <div class="page-content">

                    @yield('content')

                </div>

                @include('template.footer')

            </div>

            

        </div>

    </div>

    <script src="{{ asset('public/lib/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/lib/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('public/lib/bootstrap-dialog/bootstrap-dialog.min.js') }}"></script>
    <script src="{{ asset( 'public/lib/jQuery.validationEngine/jquery.validationEngine-en.js') }}" type="text/javascript"></script>
    <script src="{{ asset( 'public/lib/jQuery.validationEngine/jquery.validationEngine.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/custom.js?' . time() ) }}"></script>
    
</body>
</html>
