@include(theme('header'))

<div class="dashboard-wrap">

    <div class="container py-4" style="min-height: 70vh;">
        <div class="row">
            <div class="col-3 dashboard-menu-col">
                @include(theme('afiliasi.sidebar-menu'))
            </div>

            <div class="col-9">
                @include('inc.flash_msg')
                @yield('content')
            </div>

        </div>
    </div>

</div>

@include(theme('footer'))
