@extends('layouts.theme')


@section('content')

    <!--  KALAU BELUM BAYAR  -->
    @php
        $user = Auth::user();
        $payment = \App\UserPayment::where('user_id', $user->id)->orderBy('id', 'DESC')->first();
    @endphp
    @if ($user->user_type == 'student' && !empty($user->expired_package_at) && $user->expired_package_at <= date('Y-m-d H:i:s'))
        @if (!empty($payment) && $payment->status == 0 && !empty($payment->detail_payment))
            <!--  KALAU BELUM DIAPPROVE  -->
            <section class="px-6 lg:px-36 py-6 bg-neutral-500">
                <div class="container mx-auto">
                    <div class="md:flex md:items-center md:justify-between">
                        <div class="mb-6 md:mb-0">
                            <p class="text-sm lg:text-lg font-semibold text-white mb-0.5">
                                Kami sedang memproses pembayaran anda
                            </p>
                            <p class="text-sm lg:text-lg font-normal text-neutral-200">
                                Setelah pembayaran berhasil, kami memberikan pesan melalui Whatsapp.
                            </p>
                        </div>
                        <div class="md:ml-6">
                            {{-- <a href="{{ route('payment_detail') }}"
                                class="inline-block text-sm lg:text-base font-normal text-brand-50 py-2.5 md:px-6 w-full md:w-auto text-center rounded-lg bg-brand-500 border border-brand-500 drop-shadow-md md:mr-8">
                                Pembayaran
                            </a> --}}
                        </div>
                    </div>
                </div>
            </section>
        @else
            <!--  KALAU BELUM BAYAR  -->
            <section class="px-6 lg:px-36 py-6 bg-neutral-500">
                <div class="container mx-auto">
                    <div class="md:flex md:items-center md:justify-between">
                        <div class="mb-6 md:mb-0">
                            <p class="text-sm lg:text-lg font-semibold text-white mb-0.5">
                                Selesaikan pembayaran Anda
                            </p>
                            <p class="text-sm lg:text-lg font-normal text-neutral-200">
                                Tonton semua Kelas Pengusaha Syariah dengan Rp. 50.000/bulan
                            </p>
                        </div>
                        <div class="md:ml-6">
                            <a href="{{ route('payment_detail') }}"
                                class="inline-block text-sm lg:text-base font-normal text-brand-50 py-2.5 md:px-6 w-full md:w-auto text-center rounded-lg bg-brand-500 border border-brand-500 drop-shadow-md md:mr-8">
                                Pembayaran
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif

    <!--  Hero  -->
    <section class="px-6 lg:px-36 bg-cover w-full h-auto bg-center relative img-fluid"
        style="background-image: url('{{ asset('assets/images/background/background-beranda-new.jpg') }}');max-height: 610px;">
        <div class="absolute bottom-0 left-0 w-full h-[263px] md:h-[200px] lg:h-[460px]"
            style="background: linear-gradient(180deg, rgba(5, 25, 35, 0) 0%, rgba(5, 25, 35, 0.5) 21.35%);"></div>
        <div class="container mx-auto relative pb-6 lg:pb-10">
            <div class="h-[136px] md:h-[250px] lg:h-[459px]"></div>
            <div class="grid grid-col-1 lg:grid-cols-10 lg:gap-6">
                <div class="lg:col-span-6">
                    <h5 class="text-sm lg:text-xl font-semibold text-white mb-2 lg:mb-4">
                        Program Ide Bisnis
                    </h5>
                    <h1 class="text-2xl lg:text-5xl font-semibold text-white mb-4 lg:mb-8">
                        Cara Benar Jadi Developer Syariah
                    </h1>
                    <div class="grid grid-cols-2 md:flex gap-4 md:gap-0">
                        <!-- KALAU SUDAH BAYAR -->
                        <a href="{{ route('get_free_enroll', 'cara-benar-jadi-developer-syariah-1') }}"
                            class="inline-block text-sm lg:text-base font-normal text-brand-50 py-2.5 md:px-6 w-full md:w-auto text-center rounded-lg bg-brand-500 border border-brand-500 drop-shadow-md md:mr-8">
                            Mulai belajar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @php
        $counting_popular = \App\Enroll::select('course_id', DB::raw('COUNT(enrolls.id) AS counting'))
                                            ->join('courses', 'courses.id', '=', 'enrolls.course_id')
                                            ->join('users', 'users.id', '=', 'enrolls.user_id')
                                            ->where('courses.status', 1)
                                            ->where('users.expired_package_at', '>=', date('Y-m-d'))
                                            ->orderBy('counting', 'DESC')
                                            ->groupBy('course_id')->limit(5)->get()->toArray();
        $featured_courses = [];
        foreach ($counting_popular as $key => $value) {
            $featured_courses[] = \App\Course::with('category')
                                            ->where('id', $value['course_id'])
                                            ->first()->toArray();
        }
    @endphp
    @php
    $kelasku = \App\Enroll::where('enrolls.user_id', \Auth::user()->id)->with('course.media', 'course.category')
            ->join('courses', 'courses.id', '=', 'enrolls.course_id')->paginate(10);
    @endphp

    @php
    $category = \App\Category::where('slug', '!=', 'developer')->where('slug', '!=', 'marketplace-fiqeeh')->where('slug', '!=', 'iklan-fiqeeh')->where('show_home', '!=', 0)->where('step', 2)->get()->toArray();
    $categoryRecomendation = \App\Category::where('step', 2)->where('is_recomendation', 1)->get()->toArray();
    $getCompleted = \App\Complete::where('user_id', \Auth::user()->id)->whereNotNull('completed_course_id')->orderBy('completed_course_id')->get()->toArray();
    @endphp

    <section class="px-6 lg:px-36 pb-16 lg:pb-28 pt-8 lg:pt-16">
        <div class="container mx-auto">
            <div class="text-center mb-10">
                <h3 class="text-xl lg:text-3xl font-semibold text-neutral-500 mb-2">
                    Program Bisnis
                </h3>
                <p class="text-sm lg:text-base font-normal text-neutral-400">
                    Pilih Program Untuk Tampilkan Kelas
                </p>
            </div>
            <div class="slider-tag text-center mb-6 lg:mb-4">
                <div class="pr-3 lg:mx-3 inline-block">
                    <button type="button" data-value=""
                        class="btn13program flex items-center mb-3 text-sm lg:text-base font-normal text-brand-500 border border-brand-500 bg-brand-50 whitespace-nowrap py-2.5 pl-4 pr-3 md:mb-3 lg:mb-6 rounded-3xl">
                        Semua
                    </button>
                </div>
                @foreach ($category as $item)
                    <div class="pr-3 lg:mx-3 inline-block">
                        <button type="button" data-value="{{ $item['slug'] }}"
                            class="btn13program mb-3 text-sm lg:text-base font-normal text-neutral-400 border border-neutral-400 bg-white whitespace-nowrap py-2.5 pl-4 pr-3 md:mb-3 lg:mb-6 rounded-3xl">
                            {{ $item['category_name'] }}
                        </button>
                    </div>
                @endforeach
            </div>
            <div class="relative">
                <div class="programs13list">
                    @php
                        $courses = \App\CategoryCourse::where('category_id','!=',1203)->with('course.media', 'category')->get()->toArray();
                    @endphp
                    @foreach ($courses as $course)
                        @if ($course['course'] != null && (int) $course['course']['status'] == 1)
                            <div class="pr-4 pl-0 lg:p-3">
                                <div class="grid grid-cols-7 md:block border border-brand-100 rounded-lg p-2 mb-6 bg-white">
                                    <div class="col-span-3 rounded-lg relative mb-0 md:mb-2 mr-2 md:mr-0">
                                        <img src="{{$course['course']['thumbnail_url']}}"
                                            class="w-full object-cover rounded-lg h-36 programs-image" alt="" />
                                        <div
                                            class="absolute top-1 left-1 text-xs lg:text-sm font-normal text-brand-500 bg-brand-50 py-1 px-2 rounded-3xl">
                                            {{course_levels($course['course']['level'])}}
                                        </div>
                                    </div>
                                    <div class="col-span-4">
                                        <div>
                                            <p class="text-left text-xs lg:text-sm font-normal text-neutral-400 mb-1 truncate">
                                                {{$course['category']['category_name']}}
                                            </p>
                                            <p
                                                class="text-left text-sm lg:text-base font-semibold text-neutral-500 h-16 lg:h-[72px] mb-3.5 line-clamp-3">
                                                {{$course['course']['title']}}
                                            </p>
                                            
                                        </div>
                                        <div class="flex justify-between">
                                            <div class="flex items-center text-warning-500">
                                                <span class="material-icons-outlined"> star </span>
                                                <p class="text-sm font-semibold text-warning-500 ml-1">
                                                    {{ $course['course']['rating_value'] }}
                                                    <span class="text-xs font-normal text-neutral-300">/5.0</span>
                                                </p>
                                            </div>
                                            <a href="@if (Auth::user() && $course['course']['continue_url']) {{route('get_free_enroll', $course['course']['slug'])}} @else {{route('login')}} @endif" class="programs-link">
                                                <div
                                                    class="flex items-center justify-center rounded-full bg-brand-500 text-white drop-shadow-md w-10 h-10">
                                                    <span class="material-icons-outlined">
                                                        arrow_right_alt
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="absolute -left-[10px] lg:-left-[22px] top-1/4 lg:top-2/4 -translate-y-2/4 pb-5">
                    <div
                        class="prev-program-bisnis cursor-pointer hidden w-6 h-16 rounded-[100px] bg-brand-500 text-white md:flex items-center justify-center">
                        <span class="material-icons-outlined text-18">
                            arrow_back
                        </span>
                    </div>
                </div>
                <div class="absolute -right-[10px] lg:-right-[22px] top-1/4 lg:top-2/4 -translate-y-2/4 pb-5">
                    <div
                        class="next-program-bisnis cursor-pointer hidden w-6 h-16 rounded-[100px] bg-brand-500 text-white md:flex items-center justify-center">
                        <a href="{{route('semua_kelas')}}">
                            <span class="material-icons-outlined text-18">
                                arrow_forward
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

    <!--  Kelas Populer  -->
    <section class="px-[18px] lg:px-[138px] py-8 lg:py-16">
        <div class="container mx-auto">
            <div class="flex justify-between items-end px-1.5 mb-6 lg:mb-8">
                <div>
                    <h3 class="text-xl lg:text-3xl font-semibold text-neutral-500 mb-2">
                        Kelas Populer
                    </h3>
                    <p class="hidden lg:block text-sm lg:text-base font-normal text-neutral-400">
                        Jelajahi Kelas terbaik sesuai Al Qur'an, As Sunnah dan pengalaman kami.
                    </p>
                    <p class="block lg:hidden text-sm lg:text-base font-normal text-neutral-400">
                        Kelas terbaik dari kami.
                    </p>
                </div>
            </div>
            <div class="slider-rencana-kelas">
                @foreach ($featured_courses as $item)
                    <div class="px-2 lg:px-3">
                        <div class="rounded-lg border border-brand-100 p-2 bg-white">
                            <div class="rounded-lg relative mb-2">
                                <img src="{{$item['thumbnail_url']}}"
                                    class="w-full object-cover rounded-lg h-28 lg:h-36" alt="">
                                <div
                                    class="absolute top-1 left-1 text-xs lg:text-sm font-normal text-brand-500 bg-brand-50 py-1 px-2 rounded-3xl">
                                    {{course_levels($item['level'])}}
                                </div>
                            </div>
                            <div>
                                <div>
                                    <p class="text-xs lg:text-sm font-normal text-neutral-400 mb-1 truncate">
                                        {{$item['category']['category_name']}}
                                    </p>
                                    <p class="text-sm lg:text-base font-semibold text-neutral-500 h-16 lg:h-[72px] mb-3.5 line-clamp-3">
                                        {{$item['title']}}
                                    </p>
                                    
                                </div>
                                <div class="flex justify-between">
                                    <div class="flex items-center text-warning-500">
                                        <span class="material-icons-outlined">
                                        star
                                    </span>
                                        <p class="text-sm font-semibold text-warning-500 ml-1">
                                            {{ $item['rating_value'] }}
                                            <span class="text-xs font-normal text-neutral-300">/5.0</span>
                                        </p>
                                    </div>
                                    <a href="@if (Auth::user() && $item['continue_url']) {{route('get_free_enroll', $item['slug'])}} @else {{route('login')}} @endif" class="programs-link">
                                        <div
                                            class="flex items-center justify-center rounded-full bg-brand-500 text-white drop-shadow-md w-10 h-10">
                                            <span class="material-icons-outlined">
                                                arrow_right_alt
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @php
        $new_course = \App\Course::with('category')->where('category_id', '!=', 1203)->publish()->orderBy('created_at', 'desc')->limit(5)->get()->toArray();
    @endphp

    <!--  Kelas Baru  -->
    <section class="px-[18px] lg:px-[138px] py-8 lg:py-16">
        <div class="container mx-auto">
            <div class="flex justify-between items-end px-1.5 mb-6 lg:mb-8">
                <div>
                    <h3 class="text-xl lg:text-3xl font-semibold text-neutral-500 mb-2">
                        Kelas Baru Di Rilis
                    </h3>
                    <p class="hidden lg:block text-sm lg:text-base font-normal text-neutral-400">
                        Kelas terbanyak ditonton untuk meningkatkan skill bisnis Anda
                    </p>
                    <p class="block lg:hidden text-sm lg:text-base font-normal text-neutral-400">
                        Kelas terbanyak ditonton
                    </p>
                </div>
            </div>
            <div class="slider-rencana-kelas">
                @foreach ($new_course as $item)
                    <div class="px-2 lg:px-3">
                        <div class="rounded-lg border border-brand-100 p-2 bg-white">
                            <div class="rounded-lg relative mb-2">
                                <img src="{{$item['thumbnail_url']}}"
                                    class="w-full object-cover rounded-lg h-28 lg:h-36" alt="">
                                <div
                                    class="absolute top-1 left-1 text-xs lg:text-sm font-normal text-brand-500 bg-brand-50 py-1 px-2 rounded-3xl">
                                    {{course_levels($item['level'])}}
                                </div>
                            </div>
                            <div>
                                <div>
                                    <p class="text-xs lg:text-sm font-normal text-neutral-400 mb-1 truncate">
                                        {{$item['category']['category_name']}}
                                    </p>
                                    <p class="text-sm lg:text-base font-semibold text-neutral-500 h-16 lg:h-[72px] mb-3.5 line-clamp-3">
                                        {{$item['title']}}
                                    </p>
                                    
                                </div>
                                <div class="flex justify-between">
                                    <div class="flex items-center text-warning-500">
                                        <span class="material-icons-outlined">
                                        star
                                    </span>
                                        <p class="text-sm font-semibold text-warning-500 ml-1">
                                            {{ $item['rating_value'] }}
                                            <span class="text-xs font-normal text-neutral-300">/5.0</span>
                                        </p>
                                    </div>
                                    <a href="@if (Auth::user() && $item['continue_url']) {{route('get_free_enroll', $item['slug'])}} @else {{route('login')}} @endif" class="programs-link">
                                        <div
                                            class="flex items-center justify-center rounded-full bg-brand-500 text-white drop-shadow-md w-10 h-10">
                                            <span class="material-icons-outlined">
                                                arrow_right_alt
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!--  Marketplace  -->
    @php
        $marketplace = \App\Course::with('content')->where('category_id', 1203)->orderBy('id', 'desc')->where('status', 1)->with('category')->get()->toArray();
    @endphp

    <section class="px-6 lg:px-36 pt-16 lg:pt-28 pb-6 lg:pb-16" style="background: #4592FE;">
        <div class="container mx-auto">
            <div class="flex justify-between items-end px-1.5 mb-6 lg:mb-8">
                <div>
                    <h3 class="text-xl lg:text-3xl font-semibold text-white mb-2">
                        Iklan
                    </h3>
                    <p class="text-sm lg:text-base font-normal text-white ">
                        Apapun kebutuhan bisnis bisa diiklankan!
                    </p>
                </div>
            </div>
            <div class="slider-rencana-kelas">
                @foreach ($marketplace as $item)
                    <div class="px-2 lg:px-3">
                        <div class="rounded-lg border border-brand-100 p-2 bg-white">
                            <div class="rounded-lg relative mb-2">
                                <img src="{{$item['thumbnail_url']}}"
                                    class="w-full object-cover rounded-lg h-28 lg:h-36" alt="">
                                <div
                                    class="absolute top-1 left-1 text-xs lg:text-sm font-normal text-brand-500 bg-brand-50 py-1 px-2 rounded-3xl">
                                    {{course_levels($item['level'])}}
                                </div>
                            </div>
                            <div>
                                <div>
                                    <p class="text-xs lg:text-sm font-normal text-neutral-400 mb-1 truncate">
                                        {{$item['category']['category_name']}}
                                    </p>
                                    <p class="text-sm lg:text-base font-semibold text-neutral-500 h-16 lg:h-[72px] mb-3.5 line-clamp-3">
                                        {{$item['title']}}
                                    </p>
                                </div>
                                <div class="col-span-4">
                                    @if ($item['price'] != null)
                                    <p class="text-left font-normal text-neutral-400" style="margin-bottom: 0px">
                                        @php 
                                        $uang2 = $item['price'];
                                        $uang3 = number_format($uang2);
                                        // echo "<del>Rp.".number_format($uang2)."</del>";
                                        @endphp
                                        <del>Rp.{{$uang3}}</del>
                                    </p>
                                    @endif
                                    {{-- @if ($item['sale_price'] != null) --}}
                                    <p class="text-left text-xs lg:text-lg font-normal mb-1 truncate" style="color: red">
                                        @php 
                                        $uang = $item['sale_price'];
                                        echo "Rp0";
                                        @endphp
                                    </p>
                                    {{-- @endif --}}
                                    {{-- <div class="flex items-center text-warning-500">
                                        <span class="material-icons-outlined">
                                        star
                                    </span>
                                        <p class="text-sm font-semibold text-warning-500 ml-1">
                                            {{ $item['rating_value'] }}
                                            <span class="text-xs font-normal text-neutral-300">/5.0</span>
                                        </p>
                                    </div> --}}
                                    <a href="{{route('markeplace_view', [$item['slug'], $item['content']['slug']])}}" class="programs-link">
                                        <div
                                            class="flex items-center justify-center rounded-full bg-brand-500 text-white drop-shadow-md w-10 h-10">
                                            <span class="material-icons-outlined">
                                                arrow_right_alt
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @php
        $category = \App\Category::where('slug', '!=', 'developer')->where('step', 2)->get()->toArray();
        $categoryRecomendation = \App\Category::where('step', 2)->where('is_recomendation', 1)->get()->toArray();
        $getCompleted = \App\Complete::where('user_id', \Auth::user()->id)->whereNotNull('completed_course_id')->orderBy('completed_course_id')->get()->toArray();
    @endphp

    <!--  Programn Direkomendasikan  -->
    {{-- <section class="px-6 lg:px-36 py-8 lg:py-16">
        <div class="container mx-auto">
            <div class="mb-8">
                <h3 class="text-xl lg:text-3xl font-semibold text-neutral-500 mb-2">
                    Program Direkomendasikan
                </h3>
                <p class="hidden lg:block text-sm lg:text-base font-normal text-neutral-400">
                    Program Bisnis yang Kami rekomendasikan untuk merintis dan mengembangkan bisnis Anda.
                </p>
                <p class="block lg:hidden text-sm lg:text-base font-normal text-neutral-400">
                    Untuk merintis dan mengembangkan bisnis Anda
                </p>
            </div>
            <div class="hidden md:grid grid-cols-2 md:grid-cols-5 gap-x-6">
                @foreach ($categoryRecomendation as $item)
                    <div class="text-center mb-10 lg:mb-0">
                        <img src="{{ $item['thumbnail_url'] }}"
                            class="w-16 lg:w-[102px] h-16 lg:h-[102px] p-2 lg:p-2.5 mb-4 mx-auto" alt="">
                        <h4 class="text-xl lg:text-2xl font-semibold text-neutral-500 mb-2">
                            {{ $item['category_name'] }}
                        </h4>
                        <p class="text-sm lg:text-base font-normal text-neutral-400">
                            {{ \App\CategoryCourse::where('category_id', $item['id'])->get()->count() }} Kelas
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="px-6 lg:px-36 py-8 lg:py-16">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-x-6">
                @php
                    $artikel = \App\Post::post()->publish()->orderBy('updated_at', 'DESC')->limit(2)->get();
                @endphp
                @foreach ($artikel as $item)
                    <a href="{{ route('post', $item->slug) }}">
                        <div class="relative w-full h-40 lg:h-[216px] mb-4 lg:mb-0 p-6 rounded-3xl bg-cover bg-center bg-neutral-500 flex flex-col justify-end"
                            style="background-image: url('{{$item->thumbnail_url->image_lg}}');">
                            <div class="absolute top-0 left-0 w-full h-full rounded-3xl"
                                style="background: linear-gradient(180deg, rgba(5, 25, 35, 0.01) -12.04%, rgba(5, 25, 35, 0.63) 125.93%);">
                            </div>
                            <div class="relative">
                                <p class="text-base lg:text-lg font-semibold text-white mb-2">
                                    {{ $item->title }}
                                </p>
                                <p class="text-base lg:text-sm font-normal text-neutral-50">
                                    {{ tgl_indo(date('Y-m-d', strtotime($item->updated_at))) }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section> --}}

    
    {{-- <section class="px-6 lg:px-36 pb-16 lg:pb-28 pt-8 lg:pt-16">
        <div class="container mx-auto">
            <div class="text-center mb-10">
                <h3 class="text-xl lg:text-3xl font-semibold text-neutral-500 mb-2">
                    {{ count($category) }}  Program Bisnis
                </h3>
                <p class="text-sm lg:text-base font-normal text-neutral-400">
                    Pilih Program Untuk Tampilkan Kelas
                </p>
            </div>
            <div class="slider-tag text-center mb-6 lg:mb-4">
                <div class="pr-3 lg:mx-3 inline-block">
                    <button type="button" data-value=""
                        class="btn13program flex items-center mb-3 text-sm lg:text-base font-normal text-brand-500 border border-brand-500 bg-brand-50 whitespace-nowrap py-2.5 pl-4 pr-3 md:mb-3 lg:mb-6 rounded-3xl">
                        Semua
                    </button>
                </div>
                @foreach ($category as $item)
                    <div class="pr-3 lg:mx-3 inline-block">
                        <button type="button" data-value="{{ $item['slug'] }}"
                            class="btn13program mb-3 text-sm lg:text-base font-normal text-neutral-400 border border-neutral-400 bg-white whitespace-nowrap py-2.5 pl-4 pr-3 md:mb-3 lg:mb-6 rounded-3xl">
                            {{ $item['category_name'] }}
                        </button>
                    </div>
                @endforeach
            </div>
            <div class="relative">
                <div class="programs13list">
                    @php
                        $courses = \App\CategoryCourse::where('category_id','!=',1203)->with('course.media', 'category')->get()->toArray();
                    @endphp
                    @foreach ($courses as $course)
                        @if ($course['course'] != null && (int) $course['course']['status'] == 1)
                            <div class="pr-4 pl-0 lg:p-3">
                                <div class="grid grid-cols-7 md:block border border-brand-100 rounded-lg p-2 mb-6 bg-white">
                                    <div class="col-span-3 rounded-lg relative mb-0 md:mb-2 mr-2 md:mr-0">
                                        <img src="{{$course['course']['thumbnail_url']}}"
                                            class="w-full object-cover rounded-lg h-36 programs-image" alt="" />
                                        <div
                                            class="absolute top-1 left-1 text-xs lg:text-sm font-normal text-brand-500 bg-brand-50 py-1 px-2 rounded-3xl">
                                            {{course_levels($course['course']['level'])}}
                                        </div>
                                    </div>
                                    <div class="col-span-4">
                                        <div>
                                            <p class="text-left text-xs lg:text-sm font-normal text-neutral-400 mb-1 truncate">
                                                Program {{$course['category']['category_name']}}
                                            </p>
                                            <p
                                                class="text-left text-sm lg:text-base font-semibold text-neutral-500 h-16 lg:h-[72px] mb-3.5 line-clamp-3">
                                                {{$course['course']['title']}}
                                            </p>
                                        </div>
                                        <div class="flex justify-between">
                                            <div class="flex items-center text-warning-500">
                                                <span class="material-icons-outlined"> star </span>
                                                <p class="text-sm font-semibold text-warning-500 ml-1">
                                                    {{ $course['course']['rating_value'] }}
                                                    <span class="text-xs font-normal text-neutral-300">/5.0</span>
                                                </p>
                                            </div>
                                            <a href="@if (Auth::user() && $course['course']['continue_url']) {{route('get_free_enroll', $course['course']['slug'])}} @else {{route('login')}} @endif" class="programs-link">
                                                <div
                                                    class="flex items-center justify-center rounded-full bg-brand-500 text-white drop-shadow-md w-10 h-10">
                                                    <span class="material-icons-outlined">
                                                        arrow_right_alt
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="absolute -left-[10px] lg:-left-[22px] top-1/4 lg:top-2/4 -translate-y-2/4 pb-5">
                    <div
                        class="prev-program-bisnis cursor-pointer hidden w-6 h-16 rounded-[100px] bg-brand-500 text-white md:flex items-center justify-center">
                        <span class="material-icons-outlined text-18">
                            arrow_back
                        </span>
                    </div>
                </div>
                <div class="absolute -right-[10px] lg:-right-[22px] top-1/4 lg:top-2/4 -translate-y-2/4 pb-5">
                    <div
                        class="next-program-bisnis cursor-pointer hidden w-6 h-16 rounded-[100px] bg-brand-500 text-white md:flex items-center justify-center">
                        <span class="material-icons-outlined text-18">
                            arrow_forward
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@endsection

@section('page-js')
<script>
    if ($(".programs13list").length) {
        $(".btn13program").on("click", function (event) {
            $(".btn13program").each(function (index, item) {
                $(this).removeClass(
                    "text-brand-500 border border-brand-500 bg-brand-50"
                );
                $(this).addClass(
                    "text-neutral-400 border border-neutral-400 bg-white"
                );
            });
            $(this).removeClass(
                "text-neutral-400 border border-neutral-400 bg-white"
            );
            $(this).addClass(
                "text-brand-500 border border-brand-500 bg-brand-50"
            );

            const value = $(this).data("value");

            $.ajax({
                type: "GET",
                url: `{{ env('APP_URL') }}/api/search/course?user_id={{ $user->id }}&category_name=${value}`,
                success: function (data) {
                    $(".programs13list").slick("unslick");
                    $(".programs13list").empty();

                    for (let i = 0; i < data.length; i++) {
                        const element = data[i];
                        $(".programs13list").append(
                            `<div class="pr-4 pl-0 lg:p-3">
                                <div class="grid grid-cols-7 md:block border border-brand-100 rounded-lg p-2 mb-6 bg-white">
                                    <div class="col-span-3 rounded-lg relative mb-0 md:mb-2 mr-2 md:mr-0">
                                        <img src="${element.thumbnail_url}"
                                            class="w-full object-cover rounded-lg h-36 programs-image" alt="">
                                        <div
                                            class="absolute top-1 left-1 text-xs lg:text-sm font-normal text-brand-500 bg-brand-50 py-1 px-2 rounded-3xl">
                                            ${element.course_level}
                                        </div>
                                    </div>
                                    <div class="col-span-4">
                                        <div>
                                            <p class="text-xs lg:text-sm font-normal text-neutral-400 mb-1 truncate">
                                                Program ${element.category_name}
                                            </p>
                                            <p
                                                class="text-sm lg:text-base font-semibold text-neutral-500 h-16 lg:h-[72px] mb-3.5 line-clamp-3">
                                                ${element.title}
                                            </p>
                                        </div>
                                        <div class="flex justify-between">
                                            <div class="flex items-center text-warning-500">
                                                <span class="material-icons-outlined">
                                                    star
                                                </span>
                                                <p class="text-sm font-semibold text-warning-500 ml-1">
                                                    ${element.rating_value}
                                                    <span class="text-xs font-normal text-neutral-300">/5.0</span>
                                                </p>
                                            </div>
                                            <a href="${element.continue_url}" class="programs-link">
                                                <div
                                                    class="flex items-center justify-center rounded-full bg-brand-500 text-white drop-shadow-md w-10 h-10">
                                                    <span class="material-icons-outlined">
                                                        arrow_right_alt
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>`
                        );
                    }
                    $(".programs13list").slick({
                        infinite: false,
                        slidesPerRow: 5,
                        rows: 2,
                        arrows: true,
                        autoplay: false,
                        dots: true,
                        adaptiveHeight: true,
                        responsive: [
                            {
                                breakpoint: 480,
                                settings: {
                                    slidesPerRow: 1,
                                    rows: 3,
                                    arrows: false,
                                    dots: false,
                                    adaptiveHeight: true,
                                },
                            },
                        ],
                    });
                    $(".prev-program-bisnis").click(function (e) {
                        $(".programs13list").slick("slickPrev");
                    });
                    $(".next-program-bisnis").click(function (e) {
                        $(".programs13list").slick("slickNext");
                    });
                    
                    let currentSlide =  $(".programs13list").slick('slickCurrentSlide') + 1
                    let totalSlide = $(".programs13list").slick('getSlick').slideCount  
                    $(".prev-program-bisnis").addClass("slick-disabled");
                    if(currentSlide == totalSlide) {
                        $(".next-program-bisnis").addClass("slick-disabled");
                    }

                    $(".programs13list").on("afterChange", function () {
                        if ($(".slick-prev").hasClass("slick-disabled")) {
                            $(".prev-program-bisnis").addClass("slick-disabled");
                        } else {
                            $(".prev-program-bisnis").removeClass("slick-disabled");
                        }
                        if ($(".slick-next").hasClass("slick-disabled")) {
                            $(".next-program-bisnis").addClass("slick-disabled");
                        } else {
                            $(".next-program-bisnis").removeClass("slick-disabled");
                        }
                    });
                },
            });
        });
    }
</script>
@endsection