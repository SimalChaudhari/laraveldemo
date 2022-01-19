<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <title>@yield('page_title') | {{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8">
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

    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,700" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" type="text/css" href="{{ asset( 'public/lib/bootstrap/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset( 'public/lib/font-awesome/css/font-awesome.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset( 'public/css/theme.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset( 'public/css/premium.css') }}" />

    <link href="{{ asset('public/lib/jQuery.validationEngine/validationEngine.jquery.css') }}" rel="stylesheet" type="text/css" />

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <script src="{{ asset( 'public/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>

    <style type="text/css">
        form .invalid-feedback {color:red;font-size: 12px;}
        html, body {
            height: 100%;
        }
        .container {
            height: 100%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
                -ms-flex-align: center;
                    align-items: center;
            -webkit-box-pack: center;
                -ms-flex-pack: center;
                    justify-content: center;
        }
        .container .row:not(form .row) {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
                -ms-flex-pack: center;
                    justify-content: center;
            /* align-self: center; */
            -webkit-box-align: center;
                -ms-flex-align: center;
                    align-items: center;
            width: 100%;
        }
        .logo {
            margin-bottom: 15px;
        }
    </style>
</head>
<body class="theme-blue">

    @yield('content')

    <script src="{{ asset('public/lib/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ asset( 'public/lib/jQuery.validationEngine/jquery.validationEngine-en.js') }}" type="text/javascript"></script>
    <script src="{{ asset( 'public/lib/jQuery.validationEngine/jquery.validationEngine.min.js') }}" type="text/javascript"></script>

    <script>
        if( $('form.validateForm').length > 0 ) {
            $('form.validateForm').validationEngine({
                notEmpty: true, // validate field only when there is wrong input entered
            });
        }
    </script>
    
</body>
</html>
