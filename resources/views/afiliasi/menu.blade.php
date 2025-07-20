
<div class="navbar-default sidebar" role="navigation">
    <div id="adminmenuback"></div>
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{route('afiliasi')}}"><i class="la la-dashboard fa-fw"></i> Dashboard</a>
            </li>

            <li> <a href="{{ route('user-afiliasi') }}"><i class="la la-users"></i> {{__a('users')}}</a>  </li>

            <li> <a href="{{ route('book-afiliasi') }}"><i class="la la-book"></i> Books</a>  </li>

            <li> <a href="{{ route('payment-afiliasi') }}"><i class="la la-wallet"></i> Payments</a>  </li>

            <li> <a href="{{route('profile_settings')}}"><i class="la la-user"></i> Profile </a>  </li>

            <li> <a href="{{route('afiliasi_change_password')}}"><i class="la la-lock"></i> @lang('admin.change_password')</a>  </li>

            @php
            do_action('admin_menu_item_after');
            @endphp

            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="la la-sign-out"></i> {{__a('logout')}}
                </a>
            </li>

        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
