<?php
$settings = App\Models\Setting::where( 'user_id', Auth::user()->id )->first();

$colors = [];
if( $settings !== null ) {
	$colors = $settings->layout_colors;
}

$google_font = [];
if( $settings !== null ) {
	$google_font = $settings->fonts;
}

$google_font = App\Models\Setting::mapGoogleFont( $google_font );

$colors = App\Models\Setting::mapLayoutColors( $colors );
?>
<style>

body {
	font-family: {{ $google_font }};
}

.navbar {
	background-color:  {{ $colors['top_menu_background_color'] }};
}
body .top_menu_txt_color, .navbar-default .navbar-nav > li > a {
	color: {{ $colors['top_menu_txt_color'] }};
}

#site-content {
	background-color: {{ $colors['left_sidebar_bg_color'] }};
}
.sidebar-nav .nav-header {
	background-color:  {{ $colors['parent_menu_bg_color'] }};
	color: {{ $colors['parent_menu_text_color'] }};
}
.sidebar-nav .nav-list {
	background-color:  {{ $colors['submenu_bg_color'] }};
}

.sidebar-nav .nav-list>li>a, .sidebar-nav .nav-list>li>a span {
	color: {{ $colors['submenu_text_color'] }};	
}

.sidebar-nav .nav-list>.active, .sidebar-nav .nav-list>li:hover {
    overflow: hidden;
    border-left: 4px solid {{ $colors['parent_menu_bg_color'] }};
}

.sidebar-nav .nav-list>li>a:hover, .sidebar-nav .nav-header:hover, .sidebar-nav .nav-list>.active>a, .sidebar-nav .nav-list>.active>a:hover {
	background-color:  {{ $colors['menu_hover_color'] }};	
}

#site-content .content {
	background-color: {{ $colors['page_content_bg_color'] }};	
}
footer {
	background-color: {{ $colors['footer_bg_color'] }};		
}
</style>