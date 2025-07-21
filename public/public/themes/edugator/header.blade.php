@php
    use App\Category;
    $categories = Category::whereStep(2)->orderBy('category_name', 'asc')->get();
@endphp

        <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{get_option('enable_rtl')? 'rtl' : 'auto'}}" >

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('assets/images/favicon.ico') }}" name="favicon" rel="shortcut icon" type="image/x-icon">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (isset($post->meta_description))
        <meta name="description" content="{{ $post->meta_description }}">

        {{-- Meta Facebook --}}
        <meta property="og:title" content="{{ $title }}">
        <meta property="og:type" content="website"/>
        <meta property="og:description" content="{{ $post->meta_description }}">
        <meta property="og:image" content="{{$post->thumbnail_url->image_md}}">
        <meta property="og:url" content="{{ url()->full() }}">

        {{-- Meta Twitter --}}
        <meta name="twitter:title" content="{{ $title }}">
        <meta name="twitter:description" content="{{ $post->meta_description }}">
        <meta name="twitter:image" content="{{$post->thumbnail_url->image_md}}">
    @elseif(isset($course->meta_description))
        <meta name="description" content="{{ $course->meta_description }}">

        {{-- Meta Facebook --}}
        <meta property="og:title" content="{{ $title }}">
        <meta property="og:type" content="website"/>
        <meta property="og:description" content="{{ $course->meta_description }}">
        <meta property="og:url" content="{{ url()->full() }}">

        {{-- Meta Twitter --}}
        <meta name="twitter:title" content="{{ $title }}">
        <meta name="twitter:description" content="{{ $course->meta_description }}">
    @endif

    <link rel="canonical" href="{{ url()->full() }}"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
            href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
            rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick-theme.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome-free-6.0.0-web//css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/google-material-icons/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/plyr/plyr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tailwindcss/typography@0.4.1/dist/typography.css">

    @yield('page-css')

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-242739152-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-242739152-1');
    </script>

    <title>  @if( ! empty($title)) {{ $title }} | {{get_option('site_title')}}  @else {{get_option('site_title')}} @endif </title>

    <script type="text/javascript">
        /* <![CDATA[ */
        window.pageData = @json(pageJsonData());
        /* ]]> */
    </script>

    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
            document,'script','https://connect.facebook.net/en_US/fbevents.js');
        // Insert Your Facebook Pixel ID below.
        fbq('init', '626610628397958');
        fbq('track', 'PageView');
    </script>
    <!-- Insert Your Facebook Pixel ID below. -->
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=626610628397958&amp;ev=PageView&amp;noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->

    <!-- Hotjar Tracking Code for Fiqeeh -->
    <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:3409135,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script>
</head>


<body class="{{get_option('enable_rtl')? 'rtl' : ''}} font-poppins">

<nav class="flex items-center bg-white border border-brand-100 px-6 lg:px-36 h-[72px] lg:h-20">
    <div class="container mx-auto flex items-center justify-between flex-wrap ">
        <div class="flex items-center flex-shrink-0 text-white mr-6">
            <a href="{{route('home')}}" class="flex items-center">
                @php
                    $logoUrl = media_file_uri(get_option('site_logo'));
                @endphp

                @if($logoUrl)
                    <img src="{{media_file_uri(get_option('site_logo'))}}" class="mr-10 h-8" alt="{{get_option('site_title')}}" />
                @else
                    <img src="{{asset('assets/images/teachify-lms-logo.svg')}}" class="mr-10 h-8" alt="{{get_option('site_title')}}" />
                @endif
            </a>
        </div>
        <div class="block lg:hidden">
            <button class="flex items-center text-base border-none text-neutral-400" type="button"
                    data-drawer-target="drawer-top-example" data-drawer-show="drawer-top-example"
                    data-drawer-placement="top" aria-controls="drawer-top-example" onclick="showDrawer()" >
                    <span class="material-icons-outlined">
                        menu
                    </span>
            </button>
        </div>
        @php
            $user = Auth::user();
        @endphp
        @if ($user)
            <div class="hidden lg:flex flex-grow w-full lg:items-center lg:w-auto">
                <div class="lg:flex-grow">
                    <a href="{{route('beranda')}}"
                       class="block mt-4 lg:inline-block lg:mt-0 mr-10 text-base font-normal text-neutral-400">
                        Beranda
                    </a>
                    <a href="{{route('kelas_saya')}}"
                       class="block mt-4 lg:inline-block lg:mt-0 mr-10 text-base font-normal text-neutral-400">
                        Kelas Saya
                    </a>
                    <a href="{{route('list_kategori')}}"
                       class="block mt-4 lg:inline-block lg:mt-0 mr-10 text-base font-normal text-neutral-400">
                        Kategori
                    </a>
                </div>
                <div class="flex items-center text-warning-500">
                    <a href="{{ route('search_type', 'kelas') }}"
                       class="w-10 h-10 flex items-center justify-center mr-3 rounded-lg text-base text-neutral-400 bg-white border-none">
                            <span class="material-icons-outlined">
                            search
                        </span>
                    </a>
                    <div class="flex items-center text-warning-500">
                        <button class="flex py-3 px-4 text-sm text-gray-900 dark:text-white" id="dropdownDefault" data-dropdown-toggle="dropdown" type="button">
                            <div class="rounded-full bg-brand-50 w-10 h-10 flex items-center justify-center mr-3" >
                                <span class="text-base font-medium text-brand-500">{!! $auth_user->get_photo !!}</span>
                            </div>
                            {{-- <div class="text-left">
                                <p class="text-sm font-semibold text-neutral-500">
                                    {{ $auth_user->name }}
                                </p>
                                @if ($user->user_type == 'student' && !empty($user->expired_package_at) && $user->expired_package_at >= date('Y-m-d H:i:s'))
                                    <p class="text-sm font-normal text-brand-500">
                                        Berakhir {{ date('d M Y', strtotime($user->expired_package_at)) }}
                                    </p>
                                @elseif ($user->user_type == 'admin')
                                    <p class="text-sm font-normal text-brand-500">
                                        Admin
                                    </p>
                                @else
                                    <p class="text-sm font-normal text-danger-500">
                                        Belum Aktif
                                    </p>
                                @endif
                            </div> --}}
                        </button>
                        <div id="dropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700">
                            <div class="flex py-3 px-4 text-sm text-gray-900 dark:text-white">
                                <div class="rounded-full bg-brand-50 w-10 h-10 flex items-center justify-center mr-3">
                                    <span class="text-base font-medium text-brand-500">{!! $auth_user->get_photo !!}</span>
                                </div>
                                <div class="text-left">
                                    <div>{{ $auth_user->name }}</div>
                                    @if ($user->user_type == 'student' && !empty($user->expired_package_at) && $user->expired_package_at >= date('Y-m-d H:i:s'))
                                        <p class="text-sm font-normal text-brand-500">
                                            Berakhir {{ date('d M Y', strtotime($user->expired_package_at)) }}
                                        </p>
                                    @elseif ($user->user_type == 'admin')
                                        <p class="text-sm font-normal text-brand-500">
                                            Admin
                                        </p>
                                    @else
                                        <p class="text-sm font-normal text-danger-500">
                                            Belum Aktif
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <a href="#" class="flex items-center block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-sm" style="color: black;">
                                    <span class="material-icons-outlined text-lg">
                                        person_outline
                                    </span>
                                &nbsp;&nbsp;&nbsp;Profile
                            </a>
                            <a href="#" class="flex items-center block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-sm" style="color: black;">
                                    <span class="material-icons-outlined text-lg">
                                        lock
                                    </span>
                                &nbsp;&nbsp;&nbsp;Password
                            </a>
                            <a href="#" class="flex items-center block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-sm" style="color: black;">
                                    <span class="material-icons-outlined text-lg">
                                        content_copy
                                    </span>
                                &nbsp;&nbsp;&nbsp;Sertifikat
                            </a>
                            <a href="#" class="flex items-center block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-sm" style="color: black;">
                                    <span class="material-icons-outlined text-lg">
                                        shopping_cart_checkout
                                    </span>
                                &nbsp;&nbsp;&nbsp;Buat Iklan
                            </a>
                            <hr>
                            <div class="py-1">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="flex items-center block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-sm" style="color: black;">
                                        <span class="material-icons-outlined text-lg">
                                            exit_to_app
                                        </span>
                                    &nbsp;&nbsp;&nbsp;Keluar
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="hidden lg:flex flex-grow w-full lg:items-center lg:w-auto">
                <div class="lg:flex-grow">
                    <a href="{{route('home')}}"
                       class="block mt-4 lg:inline-block lg:mt-0 mr-10 text-base font-normal text-neutral-400">
                        Home
                    </a>
                    <a href="{{route('blog')}}"
                       class="block mt-4 lg:inline-block lg:mt-0 mr-10 text-base font-normal text-neutral-400">
                        Artikel
                    </a>
                    <a href="{{route('about_us')}}"
                       class="block mt-4 lg:inline-block lg:mt-0 text-base font-normal text-neutral-400">
                        Tentang Kami
                    </a>
                </div>
                <div>
                    <a href="{{route('login')}}"
                       class="inline-block px-9 py-2.5 rounded-lg text-base text-neutral-400 bg-white border border-brand-200">Masuk</a>
                    <a href="{{route('register')}}"
                       class="inline-block px-9 py-2.5 rounded-lg text-base text-brand-50 bg-brand-500 border-none">Daftar</a>
                </div>
            </div>
        @endif
    </div>
</nav>

<!-- Navbar component on Mobile -->
<div id="drawer-top-example"
     class="lg:hidden hidden fixed z-40 w-full bg-white transition-transform top-0 left-0 right-0 transform-none"
     tabindex="-1" aria-labelledby="drawer-top-label" aria-modal="true" role="dialog">
    <div class="flex items-center justify-between bg-white px-6 lg:px-36 h-[72px] lg:h-20">
        <h5 id="drawer-top-label">
            <a href="{{route('home')}}" class="flex items-center">
                @php
                    $logoUrl = media_file_uri(get_option('site_logo'));
                @endphp

                @if($logoUrl)
                    <img src="{{media_file_uri(get_option('site_logo'))}}" class="mr-10 h-8" alt="{{get_option('site_title')}}" />
                @else
                    <img src="{{asset('assets/images/teachify-lms-logo.svg')}}" class="mr-10 h-8" alt="{{get_option('site_title')}}" />
                @endif
            </a>

        </h5>
        <div class="flex items-center text-warning-500">
            <a href="{{ route('search_type', 'kelas') }}" style="padding-left: 120px"
               class="w-10 h-10 flex items-center justify-center mr-3 rounded-lg text-base text-neutral-400 bg-white border-none">
                    <span class="material-icons-outlined">
                    search
                </span>
            </a>
        </div>
        <button type="button" data-drawer-dismiss="drawer-top-example" aria-controls="drawer-top-example"
                class="text-neutral-400 text-xl" onclick="showDrawer()">
                <span class="material-icons-outlined">
                    close
                </span>
            <span class="sr-only">Close menu</span>
        </button>
    </div>
    <div class="p-6">
        <a href="{{route('home')}}"
           class="block w-full py-3 px-2 mb-2 text-base font-semibold rounded-lg text-neutral-500 bg-brand-100">
            Home
        </a>
        <a href="{{route('blog')}}"
           class="block w-full py-3 px-2 mb-2 text-base font-semibold rounded-lg text-neutral-400 bg-white">
            Artikel
        </a>
        <a href="{{route('about_us')}}"
           class="block w-full py-3 px-2 text-base font-semibold rounded-lg text-neutral-400 bg-white">
            Tentang Kami
        </a>
    </div>
    @if ($user)
        <div class="flex p-6 text-sm text-gray-900 dark:text-white">
            <div class="rounded-full bg-brand-50 w-10 h-10 flex items-center justify-center mr-3">
                <span class="text-base font-medium text-brand-500">{!! $auth_user->get_photo !!}</span>
            </div>
            <div>
                <div>{{ $auth_user->name }}</div>
                @if ($user->user_type == 'student' && !empty($user->expired_package_at) && $user->expired_package_at >= date('Y-m-d H:i:s'))
                    <p class="text-sm font-normal text-brand-500">
                        Berakhir {{ date('d M Y', strtotime($user->expired_package_at)) }}
                    </p>
                @elseif ($user->user_type == 'admin')
                    <p class="text-sm font-normal text-brand-500">
                        Admin
                    </p>
                @else
                    <p class="text-sm font-normal text-danger-500">
                        Belum Aktif
                    </p>
                @endif
            </div>
        </div>
        <a href="{{route('beranda')}}" class="flex items-center block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-sm" style="color: black;">
                <span class="material-icons-outlined text-lg">
                    home
                </span>
            &nbsp;&nbsp;&nbsp;Beranda
        </a>
        <a href="{{route('kelas_saya')}}" class="flex items-center block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-sm" style="color: black;">
                <span class="material-icons-outlined text-lg">
                    class
                </span>
            &nbsp;&nbsp;&nbsp;Kelas Saya
        </a>
        <a href="#" class="flex items-center block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-sm" style="color: black;">
                <span class="material-icons-outlined text-lg">
                    person_outline
                </span>
            &nbsp;&nbsp;&nbsp;Profile
        </a>
        <a href="#" class="flex items-center block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-sm" style="color: black;">
                <span class="material-icons-outlined text-lg">
                    lock
                </span>
            &nbsp;&nbsp;&nbsp;Password
        </a>
        <a href="#" class="flex items-center block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-sm" style="color: black;">
                <span class="material-icons-outlined text-lg">
                    content_copy
                </span>
            &nbsp;&nbsp;&nbsp;Sertifikat
        </a>
        <a href="#" class="flex items-center block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-sm" style="color: black;">
                <span class="material-icons-outlined text-lg">
                    shopping_cart_checkout
                </span>
            &nbsp;&nbsp;&nbsp;Buat Iklan
        </a>
        <div class="p-6 border border-brand-100 text-center">
            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"
               class="block w-full px-9 py-2.5 rounded-lg text-sm font-normal text-brand-500 bg-brand-100 border-none"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Keluar</a>
        </div>
    @else
        <div class="p-6 border border-brand-100 text-center">
            <a href="{{route('register')}}"
               class="block w-full px-9 py-2.5 mb-3 rounded-lg text-sm font-normal text-brand-50 bg-brand-500 border-none">Langganan Sekarang</a>
            <a href="{{route('login')}}"
               class="block w-full px-9 py-2.5 rounded-lg text-sm font-normal text-neutral-500 bg-white border border-brand-200">Masuk</a>
        </div>
    @endif
</div>
