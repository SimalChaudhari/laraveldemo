<div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    </button>
    <?php

    $company_logo = App\Models\Setting::select('logo_path')->where( 'user_id', Auth::user()->id )->first();
    if( $company_logo !== null ) { ?>
        <a id="site_logo" class="navbar-brand" href="{{ Auth::user()->company_website  }}" alt="">
            <img src="{{ asset('public/images/' . $company_logo->logo_path ) }}" alt="{{ config( 'app.name' ) }}" />
        </a>
    <?php
    } else {
        $default_logo = App\Models\Setting::select('logo_path')->where('predefined', 'Y')->first();
        ?>

        <a id="site_logo" class="navbar-brand" href="{{ config( 'app.hipaamart_parent_domain' ) }}">
            <img src="{{ asset('public/images/' . $default_logo->logo_path ) }}" alt="{{ config( 'app.name' ) }}" />
        </a>
        
    <?php } ?>

</div>

@if( Session::has('orig_user') )
    <div class="nav navbar-nav" style="padding: 1px 1px 0 17px;">
        <button id="switchBack" class="btn btn-primary navbar-btn">Switch back to Admin</button>
    </div>
@endif
<div id="navbar" class="navbar-collapse collapse" style="height: 1px;z-index: 0; position: inherit;">
    <ul id="main-menu" class="nav navbar-nav navbar-right">
        <li class="dropdown hidden-xs">
            <a href="#" class="dropdown-toggle top_menu_txt_color" data-toggle="dropdown">
            <span class="glyphicon glyphicon-user padding-right-small" style="position:relative;top: 3px;"></span> Welcome {{ Auth::user()->username }}
            <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu">
                

                @if( Auth::user()->company_admin === 'Y' && getCurrentUserRole() === \Config::get('constants.admin') )
                    <li><a href="{{ route('users.create') }}"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add New User</a></li>
                @endif
                <li><a href="{{ route('users.index') }}"><i class="fa fa-users" aria-hidden="true"></i> Users</a></li>
                <li><a href="{{ route('users.edit', Auth::user()->uuid ) }}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> My Account</a></li>
                <li><a href="{{ route('UI_changePassword', Auth::user()->uuid ) }}"><i class="fa fa-shield" aria-hidden="true"></i> Change Password</a></li>
                <li class="divider"></li>
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Logout</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</div>

<script>
    // Switch Back
    $(document).on('click', '#switchBack', function(e) {
        e.preventDefault();
        BootstrapDialog.show({
            title: 'Switch Back',
            type: 'type-primary',
            message: 'Are you sure you want to switch back?',
            hotkey: 13, // Enter.
            closeByBackdrop: false,
            closeByKeyboard: true,
            buttons: [{
                label: 'No',
                id: 'btn_dont_delete',
                cssClass: 'btn-custom-danger',
                action: function (dialogItself) {
                    dialogItself.close();
                }
            }, {
                label: 'Yes',
                cssClass: 'btn-custom-success',
                action: function(dialogItself) {

                    $('#btn_dont_delete').prop('disabled', true);
                    
                    var $button = this;

                    $button.disable();
                    $button.spin();
                    $.ajax({
                        url: '{{ route("company.switchBackUser") }}',
                        method: 'POST',
                        data: {},
                        success: function(response) {
                            dialogItself.close();
                            if (response.success) {
                                location.reload();
                            }
                        }
                    });

                }
            }],
        });
    });
</script>