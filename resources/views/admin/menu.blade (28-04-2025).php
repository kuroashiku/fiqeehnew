
<div class="navbar-default sidebar" role="navigation">
    <div id="adminmenuback"></div>
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{route('beranda')}}"><i class="la la-home fa-fw"></i> Beranda</a>
            </li>

            <li>
                <a href="{{route('admin')}}"><i class="la la-dashboard fa-fw"></i> @lang('admin.admin_home')</a>
            </li>

            @php
                do_action('admin_menu_item_before');
            @endphp

            <li>
                <a href="#"><i class="la la-newspaper-o fa-fw"></i> @lang('admin.cms')<span class="la arrow"></span></a>
                <ul class="nav nav-second-level" style="display: none;">
                    <li> <a href="{{ route('posts') }}">@lang('admin.posts')</a> </li>
                    {{-- <li> <a href="{{ route('pages') }}">@lang('admin.pages')</a> </li> --}}
                    <li> <a href="{{ route('ebooks') }}">Book</a> </li>
                    <li> <a href="{{ route('admin_buku_list') }}">Book Payment</a> </li>
                </ul><!-- /.nav-second-level -->
            </li>

            <li>
                <a href="{{route('media_manager')}}"><i class="la la-photo-video"></i> @lang('admin.media_manager')</a>
            </li>

            <li>
                <a href="{{route('category_index')}}"><i class="la la-folder"></i> @lang('admin.categories')</a>
            </li>

            <li>
                <a href="#"><i class="la la-chalkboard"></i> Courses<span class="la arrow"></span></a>
                <ul class="nav nav-second-level" style="display: none;">
                    @php
                        do_action('admin_menu_settings_item_before');
                    @endphp
                    <li> <a href="{{ route('create_course') }}"> Create Courses </a> </li>
                    <li> <a href="{{ route('admin_courses') }}"> {{__a('courses')}} </a> </li>
                    <li> <a href="{{ route('my_courses_reviews') }}"> My Courses Reviews </a> </li>
                    <li><a href="{{ route('courses_has_quiz') }}"> Post Tests </a></li>
                    @php
                        do_action('admin_menu_settings_item_after');
                    @endphp
                </ul>
                <!-- /.nav-second-level -->
            </li>
            {{-- <li>
                <a href="{{route('plugins')}}" class="{{request()->is('admin/plugins*') ? 'active' : ''}}" >
                    <i class="la la-plug"></i> {{__a('plugins')}}
                </a>
            </li> --}}

            {{-- <li>
                <a href="{{route('themes')}}" class="{{request()->is('admin/themes*') ? 'active' : ''}}">
                    <i class="la la-brush"></i> {{__a('themes')}}
                </a>
            </li> --}}

            <li>
                <a href="#"><i class="la la-tools fa-fw"></i> @lang('admin.settings')<span class="la arrow"></span></a>
                <ul class="nav nav-second-level" style="display: none;">
                    @php
                        do_action('admin_menu_settings_item_before');
                    @endphp
                    <li> <a href="{{ route('general_settings') }}">@lang('admin.general_settings')</a> </li>
                    <li> <a href="{{ route('packages') }}">Packages Setting</a> </li>
                    <li> <a href="{{ route('lms_settings') }}">@lang('admin.lms_settings')</a> </li>
                    {{-- <li> <a href="{{ route('payment_settings') }}">@lang('admin.payment_settings')</a> </li> --}}
                    {{-- <li> <a href="{{ route('payment_gateways') }}">@lang('admin.payment_gateways')</a> </li> --}}
                    {{-- <li> <a href="{{ route('withdraw_settings') }}">@lang('admin.withdraw')</a> </li> --}}
                    {{-- <li> <a href="{{ route('theme_settings') }}">@lang('admin.theme_settings')</a> </li> --}}
                    {{-- <li> <a href="{{ route('invoice_settings') }}">@lang('admin.invoice_settings')</a> </li> --}}
                    <li> <a href="{{ route('social_settings') }}"> {{__a('social_login_settings')}} </a> </li>
                    <li> <a href="{{ route('storage_settings') }}"> {{__a('storage')}} </a> </li>
                    <li> <a href="{{ route('survey_settings') }}"> Survey Settings </a> </li>
                    <li> <a href="{{ route('komisi_settings') }}"> Komisi Settings </a> </li>
                    <li> <a href="{{ route('link_wa') }}"> Link WA Settings </a> </li>
                    <li> <a href="{{ route('blasting_settings') }}"> Blasting Settings </a> </li>
                    <li> <a href="{{ route('text_settings') }}"> Text Settings </a> </li>
                    @php
                        do_action('admin_menu_settings_item_after');
                    @endphp
                </ul>
                <!-- /.nav-second-level -->
            </li>

            <li> <a href="{{route('reports')}}"><i class="la la-file-invoice"></i> Laporan</a>  </li>
            
            <li> <a href="{{route('date_report')}}"><i class="la la-file-invoice"></i> Laporan End Date </a>  </li>

            <li> <a href="{{route('payments')}}"><i class="la la-file-invoice-dollar"></i> {{__a('payments')}}</a>  </li>
            {{-- <li> <a href="{{route('paymentsads')}}"><i class="la la-file-invoice-dollar"></i> Payments Ads</a>  </li> --}}
            {{-- <li> <a href="{{route('withdraws')}}"><i class="la la-wallet"></i> {{__a('withdraws')}}</a>  </li> --}}

            <li> <a href="{{route('admin_staff')}}"><i class="la la-users"></i> Staff</a>  </li>

            <li>
                <a href="#"><i class="la la-user fa-fw"></i> Afiliasi<span class="la arrow"></span></a>
                <ul class="nav nav-second-level" style="display: none;">
                    <li> <a href="{{ route('admin_afiliasi') }}">User</a> </li>
                    {{-- <li> <a href="{{ route('pages') }}">@lang('admin.pages')</a> </li> --}}
                    <li> <a href="{{ route('admin_afiliasi_buku') }}">Book</a> </li>
                    <li> <a href="{{ route('admin_afiliasi_payment') }}">Payment</a> </li>
                </ul><!-- /.nav-second-level -->
            </li>

            <li> <a href="{{ route('users') }}"><i class="la la-users"></i> {{__a('users')}}</a>  </li>

            <li> <a href="{{route('admin_blasting')}}"><i class="la la-folder"></i> Blasting Expired</a>  </li>

            <li> <a href="{{route('admin_blasting_ac')}}"><i class="la la-folder"></i> Blasting Active</a>  </li>

            <li> <a href="{{route('profile_settings')}}"><i class="la la-user"></i> Profile </a>  </li>

            <li> <a href="{{route('change_password')}}"><i class="la la-lock"></i> @lang('admin.change_password')</a>  </li>

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
