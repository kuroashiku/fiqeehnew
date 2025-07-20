@extends('layouts.theme')


@section('content')

    <!-- JUMBOTRON -->
    <section class="px-6 lg:px-36 relative">
        <img src="{{ asset('assets/images/background/landing-page-header-background.webp') }}" alt="background" class="hidden lg:block absolute top-0 left-0 opacity-30 w-5/12">
        <div class="relative container mx-auto pt-0 pb-6 lg:py-28">
            <div class="flex flex-col-reverse md:grid md:grid-cols-5 md:gap-4 text-center md:text-left">
                <div class="md:col-span-3 pt-14 lg:pt-0">
                    <div class="mb-16 lg:mb-28">
                        <p class="text-sm lg:text-base text-brand-500 font-semibold mb-4 md:mb-6 lg:mb-8">
                            MENTORNYA PENGUSAHA
                        </p>
                        <h1 class="text-3xl lg:text-5xl font-semibold text-neutral-500 mb-2 md:mb-4 lg:mb-6">
                            Kampus
                        </h1>
                        <h1 class="text-3xl lg:text-5xl font-semibold text-neutral-500 mb-2 md:mb-4 lg:mb-6">
                            Bisnis Syariah
                        </h1>
                        <p class="text-sm lg:text-base font-normal text-neutral-400 w-3/4 md:w-auto mb-12 lg:mb-16 lg:pr-12 mx-auto">
                            Belajar bisnis online Rp50.000/bulan
                        </p>
                        <a href="{{ route('login') }}"
                            class="inline-block text-sm lg:text-base font-normal text-brand-50 py-2.5 w-full md:w-auto mb-2 px-16 bg-brand-500 rounded-lg">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                            class="inline-block text-sm lg:text-base text-neutral-500 font-normal py-2.5 w-full md:w-auto mb-2 px-16 bg-white border border-brand-200 rounded-lg">
                            Langganan Sekarang
                        </a>
                    </div>
                    @php
                     $categoryku = \App\Category::where('slug', '!=', 'developer')->where('slug', '!=', 'iklan-fiqeeh')->where('show_home', '!=', 0)->where('is_delete', '!=', '1')->where('step', 2)->get()->toArray();
                    @endphp

                    <div class="grid grid-cols-2 md:grid-cols-4">
                        <div class="mb-8 md:pr-4 md:mr-4 lg:pr-8 lg:mr-8 md:border-r border-neutral-100">
                            <h3 class="text-2xl lg:text-3xl font-semibold text-neutral-500 mb-2">{{ count($categoryku) }}</h3>
                            <p class="text-sm font-normal text-neutral-400">Program</p>
                        </div>
                        <div class="mb-8 md:pr-4 md:mr-4 lg:pr-8 lg:mr-8 md:border-r border-neutral-100">
                            <h3 class="text-2xl lg:text-3xl font-semibold text-neutral-500 mb-2">100+</h3>
                            <p class="text-sm font-normal text-neutral-400">Instruktur</p>
                        </div>
                        
                        @php
                            $courseCount = \App\Course::where('category_id','!=',1203)->where('category_id','!=',1205)->where('category_id', '!=', 1206)->where('category_id', '!=', 1207)->where('category_id', '!=', 1208)->where('category_id', '!=', 1209)
                            ->where('status', '=', 1)->count();
                        @endphp
                        <div class="mb-8 md:pr-4 md:mr-4 lg:pr-8 lg:mr-8 md:border-r border-neutral-100">
                            <h3 class="text-2xl lg:text-3xl font-semibold text-neutral-500 mb-2">{{ $courseCount }}</h3>
                            <p class="text-sm font-normal text-neutral-400">Kelas</p>
                        </div>
                        <div class="mb-8">
                            <h3 class="text-2xl lg:text-3xl font-semibold text-neutral-500 mb-2">1.000+</h3>
                            <p class="text-sm font-normal text-neutral-400">Materi</p>
                        </div>
                    </div>
                </div>
                <div class="md:col-span-2 relative">
                    <img src="{{ asset('assets/images/background/landing-page-header-talent-1.webp') }}" class="w-full sm:w-3/4 md:80% mx-auto relative lg:-mt-20" alt="Image">
                    <div class="absolute -bottom-5 lg:-bottom-7 px-5 lg:px-10">
                        <div>
                            <div class="text-left py-3 lg:py-4 px-4 lg:px-5 bg-white drop-shadow-md rounded-lg">
                                <p class="text-[10px] lg:text-xs font-normal text-neutral-500 mb-3 lg:mb-4 line-clamp-2 h-8">
                                    Jalan berbisnis syariah ini panjang dan penuh kerikil, namun yakinlah <b class="font-bold">surga hadiahnya</b> 
                                </p>
                                <p class="text-[9px] lg:text-[10px] font-semibold text-neutral-500 mb-0.5">
                                    Yudha Adhyaksa
                                </p>
                                <p class="text-[9px] lg:text-[10px] font-normal text-neutral-500 mb-0.5">
                                    Developer Property Syariah
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BANNER -->
    {{-- <section class="px-6 lg:px-36 pt-5 lg:py-32 relative">
        <div class="slider-banner">
            <div class="text-center cursor-pointer md:mb-16">
                <img src="{{ asset('assets/images/banner/Banner.webp') }}"
                    class="w-full mx-auto" alt="Photo">
            </div>
            <div class="text-center cursor-pointer md:mb-16">
                <img src="{{ asset('assets/images/banner/Banner-1.webp') }}"
                    class="w-full mx-auto" alt="Photo">
            </div>
            <div class="text-center cursor-pointer md:mb-16">
                <img src="{{ asset('assets/images/banner/Banner-2.webp') }}"
                    class="w-full mx-auto" alt="Photo">
            </div>
            <div class="text-center cursor-pointer md:mb-16">
                <img src="{{ asset('assets/images/banner/Banner-3.webp') }}"
                    class="w-full mx-auto" alt="Photo">
            </div>
        </div>
    </section> --}}

    <!--  Kelas Populer  -->
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
    <section class="px-6 lg:px-36 pt-16 lg:pt-28 pb-6 lg:pb-16" style="background: url('{{ asset('assets/images/background/popular-home.webp') }}');background-size: cover;background-repeat: no-repeat;">
        <div class="container mx-auto">
            <div class="flex justify-between items-end px-1.5 mb-6 lg:mb-8">
                <div>
                    <h3 class="text-xl lg:text-3xl font-semibold text-white mb-2">
                        Kelas Populer
                    </h3>
                    <p class="text-sm lg:text-base font-normal text-white ">
                        Bisnis untung berkah dengan ilmu syariah
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
                                    <p class="text-xs lg:text-sm font-normal text-neutral-400 mb-1 truncate" style="margin-bottom: 0px">
                                        {{$item['category']['category_name']}}
                                    </p>
                                    <p class="text-sm lg:text-base font-semibold text-neutral-500 h-16 lg:h-[72px] mb-3.5 line-clamp-3" style="margin-bottom: 0px">
                                        {{$item['title']}}
                                    </p>
                                    <p class="text-left font-normal text-neutral-400" style="margin-bottom: 0px">
                                        @php 
                                        $uang2 = $item['price'];
                                        echo "<del>Rp.".number_format($uang2)."</del>";
                                        @endphp
                                    </p>
                                    @if ($item['sale_price'] != null)
                                    <p class="text-left text-xs lg:text-lg font-normal mb-1 truncate" style="color: red">
                                        @php 
                                            $uang = $item['sale_price'];
                                            echo "Rp0";
                                        @endphp
                                    </p>
                                    @endif
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
                                    <a href="@if (Auth::user() && $item['continue_url']) {{route('get_free_enroll', $item['slug'])}} @else {{route('course', $item['slug'])}} @endif" class="programs-link">
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
        $category = \App\Category::where('slug', '!=', 'developer')->where('show_home', '!=', 0)->where('is_delete', '!=', 1)->where('step', 2)->get()->toArray();
        $categoryRecomendation = \App\Category::where('step', 2)->where('is_recomendation', 1)->get()->toArray();
    @endphp

    <!-- SEMUA PROGRAM BISNIS -->
    <section class="px-6 lg:px-36 pb-16 lg:pb-28 pt-8 lg:pt-16">
        <div class="container mx-auto">
            <div class="text-center mb-10">
                <h3 class="text-xl lg:text-3xl font-semibold text-neutral-500 mb-2">
                    Program Bisnis
                </h3>
                <p class="text-sm lg:text-base font-normal text-neutral-400">
                    Tonton semua kelas berlangganan
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
                                            <p class="text-left text-xs lg:text-sm font-normal text-neutral-400 mb-1 truncate" style="margin-bottom: 0px">
                                                {{$course['category']['category_name']}}
                                            </p>
                                            <p
                                                class="text-left text-sm lg:text-base font-semibold text-neutral-500 h-16 lg:h-[72px] mb-3.5 line-clamp-3" style="margin-bottom: 0px">
                                                {{$course['course']['title']}}
                                            </p>
                                            <p class="text-left font-normal text-neutral-400" style="margin-bottom: 0px">
                                                @php 
                                                $uang2 = $course['course']['price'];
                                                $uang3 = number_format($uang2);
                                                // echo "<del>Rp.".number_format($uang2)."</del>";
                                                @endphp
                                                <del>Rp.{{$uang3}}</del>
                                            </p>
                                            @if ($course['course']['sale_price'] != null)
                                            <p class="text-left text-xs lg:text-lg font-normal mb-1 truncate" style="color: red">
                                                @php 
                                                $uang = $course['course']['sale_price'];
                                                echo "Rp0";
                                                @endphp
                                            </p>
                                            @endif
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
                        <a href="{{route('home_kelas')}}">
                            <span class="material-icons-outlined text-18">
                                arrow_forward
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONI -->
    <section class="px-6 lg:px-36 pt-0 lg:py-32">
        <div class="container mx-auto bg-white relative">
            <div class="grid grid-cols-1 text-center rounded-[32px] px-6 lg:px-32 py-10 border-2 border-neutral-100">
                <div class="mb-8 lg:mb-16">
                    <p class="text-sm lg:text-base text-brand-500 font-semibold uppercase mb-4">
                        Testimoni
                    </p>
                    <h2 class="text-2xl lg:text-4xl font-semibold text-neutral-500 mb-2">
                        Kata Pembeli
                    </h2>
                </div>
                <div class="slider-testimoni">
                    <div class="text-center cursor-pointer md:mb-16">
                        <p class="text-sm lg:text-base text-neutral-400 font-normal mb-6 lg:mb-10">
                            Atas izin Allah kita dipertemukan untuk belajar lebih memahami batasan dalam berbisnis secara syariah. Semoga Allah ridho memberi kemudahan, keberkahan dan jadi amal jariyah Coach Yudha. Aamiin.
                        </p>
                        <img src="{{ asset('assets/images/photos/Richani.webp') }}"
                            class="rounded-full w-12 lg:w-16 h-12 lg:h-16 mb-1 mx-auto" alt="Photo">
                        <p class="text-base lg:text-lg text-neutral-500 font-semibold mb-1">
                            Rochani
                        </p>
                        <p class="text-xs lg:text-sm font-normal text-neutral-400">
                            Owner Hotel Grand Rohan Jogja
                        </p>
                    </div>
                    <div class="text-center cursor-pointer md:mb-16">
                        <p class="text-sm lg:text-base text-neutral-400 font-normal mb-6 lg:mb-10">
                            Saya sudah berdagang 25 tahun tapi ilmu bisnis syar’i nya sedikit karena bingung mau bertanya ke siapa. Setelah dapat ilmu Fiqeeh, kami memperbaiki kekurangan bisnis kami.
                        </p>
                        <img src="{{ asset('assets/images/photos/ninik.webp') }}"
                            class="rounded-full w-12 lg:w-16 h-12 lg:h-16 mb-1 mx-auto" alt="Photo">
                        <p class="text-base lg:text-lg text-neutral-500 font-semibold mb-1">
                            Ninik Sugiharyani
                        </p>
                        <p class="text-xs lg:text-sm font-normal text-neutral-400">
                            Owner Supermarket Pacitan
                        </p>
                    </div>
                    <div class="text-center cursor-pointer md:mb-16">
                        <p class="text-sm lg:text-base text-neutral-400 font-normal mb-6 lg:mb-10">
                            Bagi teman yang mau belajar bisnis tidak sekedar mencari untung tapi juga berkah, ini ada website yang cukup bagus banget bagi saya. Masa depan belajar bisnis ya di Fiqeeh.com.
                        </p>
                        <img src="{{ asset('assets/images/photos/aryo.webp') }}"
                            class="rounded-full w-12 lg:w-16 h-12 lg:h-16 mb-1 mx-auto" alt="Photo">
                        <p class="text-base lg:text-lg text-neutral-500 font-semibold mb-1">
                            Aryo Diponegoro
                        </p>
                        <p class="text-xs lg:text-sm font-normal text-neutral-400">
                            Developer Property Nasional
                        </p>
                    </div>
                    <div class="text-center cursor-pointer md:mb-16">
                        <p class="text-sm lg:text-base text-neutral-400 font-normal mb-6 lg:mb-10">
                            Kita belajar menjalankan bisnis itu harus sesuai syariat, ada halal haramnya disini. Karena itu saya pilih Fiqeeh.com. Kebetulan motto saya juga pekerjaan itu ibadah. 
                        </p>
                        <img src="{{ asset('assets/images/photos/wirna-wita.webp') }}"
                            class="rounded-full w-12 lg:w-16 h-12 lg:h-16 mb-1 mx-auto" alt="Photo">
                        <p class="text-base lg:text-lg text-neutral-500 font-semibold mb-1">
                            Wirna Wita
                        </p>
                        <p class="text-xs lg:text-sm font-normal text-neutral-400">
                            Pedagang Tanah Abang
                        </p>
                    </div>
                    <div class="text-center cursor-pointer md:mb-16">
                        <p class="text-sm lg:text-base text-neutral-400 font-normal mb-6 lg:mb-10">
                            Saya tahu Fiqeeh dari kerjasama Kemenperin dengan Disperindag Sragen. Setelah bergabung, saya jadi tahu banyak bisnis syariah, cara pemasaran, upload produk yang bagus dan cara disain.
                        </p>
                        <img src="{{ asset('assets/images/photos/yayuk.webp') }}"
                            class="rounded-full w-12 lg:w-16 h-12 lg:h-16 mb-1 mx-auto" alt="Photo">
                        <p class="text-base lg:text-lg text-neutral-500 font-semibold mb-1">
                            Sri Rahayu
                        </p>
                        <p class="text-xs lg:text-sm font-normal text-neutral-400">
                            Produsen Minuman Tradisional
                        </p>
                    </div>
                    <div class="text-center cursor-pointer md:mb-16">
                        <p class="text-sm lg:text-base text-neutral-400 font-normal mb-6 lg:mb-10">
                            "Itu 'proyek akhirat', kalau pak Yudha itu."
                        </p>
                        <img src="{{ asset('assets/images/photos/risma.webp') }}"
                            class="rounded-full w-12 lg:w-16 h-12 lg:h-16 mb-1 mx-auto" alt="Photo">
                        <p class="text-base lg:text-lg text-neutral-500 font-semibold mb-1">
                            Risma Fattahatin
                        </p>
                        <p class="text-xs lg:text-sm font-normal text-neutral-400">
                            Kementrian Perindustrian Jakarta Pusat
                        </p>
                    </div>
                    <div class="text-center cursor-pointer md:mb-16">
                        <p class="text-sm lg:text-base text-neutral-400 font-normal mb-6 lg:mb-10">
                            Sebelum mengenal Fiqeeh, usaha saya mulai turun karena pandemi. Manfaat saya dapatkan cukup banyak, saya diajak berhijrah, tidak berutang ribawi dan berusaha di bisnis sesuai tuntunan syariah saja.
                        </p>
                        <img src="{{ asset('assets/images/photos/musdalifah.webp') }}"
                            class="rounded-full w-12 lg:w-16 h-12 lg:h-16 mb-1 mx-auto" alt="Photo">
                        <p class="text-base lg:text-lg text-neutral-500 font-semibold mb-1">
                            Musdalifah
                        </p>
                        <p class="text-xs lg:text-sm font-normal text-neutral-400">
                            Pengusaha Batik Tulis
                        </p>
                    </div>
                    <div class="text-center cursor-pointer md:mb-16">
                        <p class="text-sm lg:text-base text-neutral-400 font-normal mb-6 lg:mb-10">
                            Alhamdulillah, hasil pembelajaran dari materi Coach Yudha di Kelas Cara Benar Jadi Developer Property, proyek ke 4 bisa di launching bulan ini. Cluster seluas 2.100 meter tersedia jadi 20an unit.
                        </p>
                        <img src="{{ asset('assets/images/photos/nasludin.webp') }}"
                            class="rounded-full w-12 lg:w-16 h-12 lg:h-16 mb-1 mx-auto" alt="Photo">
                        <p class="text-base lg:text-lg text-neutral-500 font-semibold mb-1">
                            Nasludin Meilana
                        </p>
                        <p class="text-xs lg:text-sm font-normal text-neutral-400">
                            Developer Property
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6 MANFAAT -->
    <section class="px-6 lg:px-36 bg-brand-50 relative">
        <img src="{{ asset('assets/images/background/landing-page-section2-flower.webp') }}" alt="background"
            class="hidden lg:block absolute bottom-0 left-0 w-2/12">
        <img src="{{ asset('assets/images/background/landing-page-section2-dot.webp') }}" alt="background"
            class="hidden lg:block absolute top-0 right-0 w-2/12">
        <div class="container mx-auto pt-6 pb-2 lg:pt-28 lg:pb-10 relative">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 md:gap-4 lg:gap-6">
                <div class="md:col-span-2 lg:col-span-3 mb-8 lg:mb-12">
                    <p class="text-sm lg:text-base text-brand-500 font-semibold uppercase mb-4">
                        6 ALASAN
                    </p>
                    <h2 class="text-2xl lg:text-4xl font-semibold text-neutral-500 mb-2 lg:mb-4">
                        Harus Bisnis Syariah
                    </h2>
                    <h3 class="text-xl lg:text-3xl font-semibold text-brand-500">
                        Sekarang Juga
                    </h3>
                </div>
                <div class="mb-4 lg:mb-8 py-5 px-6 bg-white border border-brand-200 rounded-2xl">
                    <div class="flex items-center text-warning-500">
                        <img src="{{ asset('assets/images/icons/landing-page-icons-3.png') }}" class="w-10 lg:w-12 h-10 lg:h-12"
                            alt="icons">
                        <div class="ml-4">
                            <p class="text-sm lg:text-base font-semibold text-neutral-500 mb-1">
                                Iman Bertambah
                            </p>
                            <p class="text-sm lg:text-base font-normal text-neutral-400">
                                Karena menjalankan bisnis sesuai Al Qur'an & As Sunnah
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mb-4 lg:mb-8 py-5 px-6 bg-white border border-brand-200 rounded-2xl">
                    <div class="flex items-center text-warning-500">
                        <img src="{{ asset('assets/images/icons/landing-page-icons-1.png') }}" class="w-10 lg:w-12 h-10 lg:h-12"
                            alt="icons">
                        <div class="ml-4">
                            <p class="text-sm lg:text-base font-semibold text-neutral-500 mb-1">
                                Bisnis Berkembang
                            </p>
                            <p class="text-sm lg:text-base font-normal text-neutral-400">
                                Kembali ke jalan yang benar, agar untung dengan berkah
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mb-4 lg:mb-8 py-5 px-6 bg-white border border-brand-200 rounded-2xl">
                    <div class="flex items-center text-warning-500">
                        <img src="{{ asset('assets/images/icons/landing-page-icons-2.png') }}" class="w-10 lg:w-12 h-10 lg:h-12"
                            alt="icons">
                        <div class="ml-4">
                            <p class="text-sm lg:text-base font-semibold text-neutral-500 mb-1">
                                Terhindar dari Dosa Riba
                            </p>
                            <p class="text-sm lg:text-base font-normal text-neutral-400">
                                Riba, harta haram yang membuat rugi dunia & akhirat
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mb-4 lg:mb-8 py-5 px-6 bg-white border border-brand-200 rounded-2xl">
                    <div class="flex items-center text-warning-500">
                        <img src="{{ asset('assets/images/icons/landing-page-icons-6.png') }}" class="w-10 lg:w-12 h-10 lg:h-12"
                            alt="icons">
                        <div class="ml-4">
                            <p class="text-sm lg:text-base font-semibold text-neutral-500 mb-1">
                                Terjaga dari Dosa Zalim
                            </p>
                            <p class="text-sm lg:text-base font-normal text-neutral-400">
                                Tidak terkena dampak dari menzalimi orang lain
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mb-4 lg:mb-8 py-5 px-6 bg-white border border-brand-200 rounded-2xl">
                    <div class="flex items-center text-warning-500">
                        <img src="{{ asset('assets/images/icons/landing-page-icons-5.png') }}" class="w-10 lg:w-12 h-10 lg:h-12"
                            alt="icons">
                        <div class="ml-4">
                            <p class="text-sm lg:text-base font-semibold text-neutral-500 mb-1">
                                Jauh dari Dosa Gharar
                            </p>
                            <p class="text-sm lg:text-base font-normal text-neutral-400">
                                Ketidakjelasan besar yang merugikan harta orang lain
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mb-4 lg:mb-8 py-5 px-6 bg-white border border-brand-200 rounded-2xl">
                    <div class="flex items-center text-warning-500">
                        <img src="{{ asset('assets/images/icons/landing-page-icons-4.png') }}" class="w-10 lg:w-12 h-10 lg:h-12"
                            alt="icons">
                        <div class="ml-4">
                            <p class="text-sm lg:text-base font-semibold text-neutral-500 mb-1">
                                Banyak Pekerjaan Haram
                            </p>
                            <p class="text-sm lg:text-base font-normal text-neutral-400">
                                Lebih baik berbisnis sendiri, bisa pastikan halal dari hulu ke hilir
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

    <!-- 4 LANGKAH MUDAH -->
    {{-- <section class="px-6 lg:px-36 py-14 lg:pt-16 relative">
        <img src="{{ asset('assets/images/background/landing-page-section5-flower.png') }}" alt="background"
            class="hidden lg:block absolute lg:top-40 left-0 opacity-90 w-2/12">
        <div class="container mx-auto">
            <div class="flex flex-col-reverse lg:grid lg:grid-cols-5 lg:gap-4">
                <div class="lg:col-span-3 lg:pt-5">
                    <div class="mb-6 lg:mb-12">
                        <p class="text-sm lg:text-base text-brand-500 font-semibold uppercase mb-4">
                            4 langkah mudah belajar
                        </p>
                        <h2 class="text-2xl lg:text-4xl font-semibold text-neutral-500 mb-2 lg:mb-4">
                            <span class="hidden lg:inline-block">Semua</span> Ilmu Pengusaha Syariah
                        </h2>
                        <h3 class="text-xl lg:text-3xl font-semibold text-brand-500">
                            Ada Disini
                        </h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-8">
                        <div class="mb-10 lg:mb-12">
                            <h2 class="text-2xl lg:text-4xl font-semibold text-neutral-500 mb-2">
                                1.
                            </h2>
                            <h2 class="text-xl lg:text-2xl font-semibold text-neutral-500 mb-2">
                                Pendaftaran
                            </h2>
                            <p class="text-sm lg:text-base font-normal text-neutral-400">
                                Daftarkan diri Anda untuk melihat isi Kelas dalam Fiqeeh
                            </p>
                        </div>
                        <div class="mb-10 lg:mb-12">
                            <h2 class="text-2xl lg:text-4xl font-semibold text-neutral-500 mb-2">
                                2.
                            </h2>
                            <h2 class="text-xl lg:text-2xl font-semibold text-neutral-500 mb-2">
                                Pembayaran
                            </h2>
                            <p class="text-sm lg:text-base font-normal text-neutral-400">
                                Selesaikan pendaftaran dengan membayar biaya berlangganan
                            </p>
                        </div>
                        <div class="mb-10 lg:mb-12">
                            <h2 class="text-2xl lg:text-4xl font-semibold text-neutral-500 mb-2">
                                3.
                            </h2>
                            <h2 class="text-xl lg:text-2xl font-semibold text-neutral-500 mb-2">
                                Masuk
                            </h2>
                            <p class="text-sm lg:text-base font-normal text-neutral-400">
                                Masukkan email dan sandi Anda untuk mulai belajar
                            </p>
                        </div>
                        <div class="mb-10 lg:mb-12">
                            <h2 class="text-2xl lg:text-4xl font-semibold text-neutral-500 mb-2">
                                4.
                            </h2>
                            <h2 class="text-xl lg:text-2xl font-semibold text-neutral-500 mb-2">
                                Menonton Kelas
                            </h2>
                            <p class="text-sm lg:text-base font-normal text-neutral-400">
                                Tonton semua video Kelas, unduh dokumennya lalu praktekkan.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-2 mb-6 lg:mb-0">
                    <div class="hidden  lg:grid lg:grid-cols-2 lg:gap-4 lg:mb-4">
                        <div class="grid grid-cols-1">
                            <img src="{{ asset('assets/images/background/landing-page-section3-1.webp') }}"
                                class="w-full h-[187px] object-cover rounded-2xl mb-4" alt="">
                            <img src="{{ asset('assets/images/background/landing-page-section3-2.webp') }}"
                                class="w-full h-[187px] object-cover rounded-2xl" alt="">
                        </div>
                        <img src="{{ asset('assets/images/background/landing-page-section3-3.webp') }}"
                            class="w-full h-[391px] object-cover rounded-2xl" alt="">
                    </div>
                    <img src="{{ asset('assets/images/background/landing-page-section3-4.webp') }}"
                        class="w-full h-[162px] md:h-[137px] object-cover rounded-2xl" alt="">
                </div>
            </div>
        </div>
    </section> --}}

    

    <!--  Marketplace  -->
    @php
        $marketplace = \App\Course::with('content')->where('category_id', 1203)->orderBy('id', 'desc')->where('status', 1)->with('category')->get()->toArray();
    @endphp

    <section class="px-6 lg:px-36 pt-16 lg:pt-28 pb-6 lg:pb-16" style="background: #4592FE;">
        <div class="container mx-auto">
            <div class="flex justify-between items-end px-1.5 mb-6 lg:mb-8">
                <div>
                    <h3 class="text-xl lg:text-3xl font-semibold text-white mb-2">
                        Marketplace
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
                                    <a href="{{ route('markeplace_view', [$item['slug'] ?? 'default-slug', $item['content']['slug'] ?? 'default-content-slug']) }}" class="programs-link">
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



    <!-- FAQ -->
    <section class="px-6 lg:px-36 pt-10 pb-10 lg:pt-16 lg:pb-10 bg-white">
        <div class="container mx-auto">
            <div class="text-center lg:px-32">
                <p class="text-sm lg:text-base text-brand-500 font-semibold uppercase mb-4">
                    FAQ
                </p>
                <h2 class="text-2xl lg:text-4xl font-semibold text-neutral-500 mb-2">
                    Ada Pertanyaan?
                </h2>
                <p class="text-sm lg:text-base text-neutral-400 font-normal mb-10 lg:mb-16">
                    Ini jawabannya!
                </p>
            </div>
            <div class="flex flex-col-reverse lg:grid lg:grid-cols-5 lg:gap-4">
                <div class="lg:col-span-3">
                    <div class="lg:grid grid-cols-10 los">
                        <div class="hidden md:block col-span-2 lg:col-span-1">
                            <img src="{{ asset('assets/images/icons/landing-page-vector-1.png') }}" class="w-[24px] h-[24px] p-2.5" alt="Icons">
                        </div>
                        <div class="px-1.5 lg:px-0 lg:col-span-8 stem">
                            <p class="text-base lg:text-lg font-semibold text-neutral-500 mb-2">
                                Bagaimana Cara Daftarnya?
                            </p>
                            <p class="text-xs lg:text-sm font-normal text-neutral-400 text-mobile">
                                Klik tombol "Langganan Sekarang", isi data diri dan transfer pembayaran.
                                Selanjutnya Anda menerima Whatsapp dari Customer Service untuk
                                akses belajarnya.
                            </p>
                        </div>
                    </div>
                    <div class="lg:grid grid-cols-10 los mt-10">
                        <div class="hidden md:block col-span-2 lg:col-span-1">
                            <img src="{{ asset('assets/images/icons/landing-page-vector-2.png') }}" class="w-[24px] h-[24px] p-2.5" alt="Icons">
                        </div>
                        <div class="px-1.5 lg:px-0 col-span-7 lg:col-span-8 stem">
                            <p class="text-base lg:text-lg font-semibold text-neutral-500 mb-2">
                                Bagaimana Cara Belajarnya?
                            </p>
                            <p class="text-xs lg:text-sm font-normal text-neutral-400 text-mobile">
                                Masukkan No Hp dan sandi ke Fiqeeh.com, lalu tonton video dan
                                unduh dokumennya. Setelah belajar, Anda bisa bertanya di Grup
                                Pendampingan.
                            </p>
                        </div>
                    </div>
                    <div class="lg:grid grid-cols-10 los mt-10">
                        <div class="hidden md:block col-span-2 lg:col-span-1">
                            <img src="{{ asset('assets/images/icons/landing-page-vector-3.png') }}" class="w-[24px] h-[24px] p-2.5" alt="Icons">
                        </div>
                        <div class="px-1.5 lg:px-0 col-span-7 lg:col-span-8 stem">
                            <p class="text-base lg:text-lg font-semibold text-neutral-500 mb-2">
                                Apa perbedaan ilmu Fiqeeh.com?
                            </p>
                            <p class="text-xs lg:text-sm font-normal text-neutral-400 text-mobile">
                                Kami hanya mengajarkan ilmu pengusaha yang sesuai syariat dan
                                cara praktisi. Kami juga menyediakan iklan untuk member
                                saling membeli / berinvestasi agar bisnis Anda berkembang pesat
                                sembari belajar.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-2 mb-6 lg:mb-0">
                    <img src="{{ asset('assets/images/background/landing-page-faq.png') }}"
                        class="hidden lg:block w-full h-[391px] object-cover" alt="">
                </div>
            </div>
        </div>
    </section>

    <!-- TABLET -->
    <section class="px-6 lg:px-36 pt-10 lg:pt-16 bg-brand-50">
        <div class="container mx-auto">
            <div class="text-center lg:px-32">
                <p class="text-sm lg:text-base text-brand-500 font-semibold uppercase mb-4">
                    MENTORNYA PENGUSAHA
                </p>
                <h2 class="text-2xl lg:text-4xl font-semibold text-neutral-500 mb-2">
                    Kampus Bisnis Syariah
                </h2>
                <h3 class="text-xl lg:text-3xl font-semibold text-brand-500 mb-4">
                    Terlengkap
                </h3>
                <p class="text-sm lg:text-base text-neutral-400 font-normal mb-10 lg:mb-16">
                    Tonton semua kelas berlangganan
                </p>
                <a href="{{ route('register') }}"
                    class="inline-block w-full md:w-auto text-center md:px-6 py-2.5 rounded-lg text-sm lg:text-base text-brand-50 bg-brand-500 border-none mb-12 lg:mb-16">
                    Langganan Sekarang
                </a>
                <img src="{{ asset('assets/images/background/landing-page-tablet.webp') }}" class="w-full object-contain" alt="Image">
            </div>
        </div>
    </section>

@endsection

{{-- @php
    $course = \App\CategoryCourse::where('category_id','!=',1203)->with('course.media', 'category')->get()->toArray();
@endphp --}}
@section('page-js')
<script>
    $( document ).ready(function() {
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
                    url: `{{ env('APP_URL') }}/api/search/course?user_id=0&category_name=${value}`,
                    success: function (data) {
                        $(".programs13list").slick("unslick");
                        $(".programs13list").empty();

                        for (let i = 0; i < data.length; i++) {
                            const element = data[i];
                            var n = element.price;
                            var n2 = element.sale_price;
                            var nFormat = new Intl.NumberFormat();
                            if(element.price == null){
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
                                                    class="text-sm lg:text-base font-semibold text-neutral-500 h-16 lg:h-[72px] mb-3.5 line-clamp-3" style="margin-bottom: 0px">
                                                    ${element.title}
                                                </p>
                                                <p class="text-left text-xs lg:text-lg font-normal mb-1 truncate" style="color: red">
                                                    Rp0
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
                            }else{
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
                                                        class="text-sm lg:text-base font-semibold text-neutral-500 h-16 lg:h-[72px] mb-3.5 line-clamp-3" style="margin-bottom: 0px">
                                                        ${element.title}
                                                    </p> 
                                                    <p class="text-left lg:text-md font-normal text-neutral-400" style="margin-bottom: 0px">
                                                        <del>Rp.${nFormat.format(n)}</del>
                                                    </p>
                                                    <p class="text-left text-xs lg:text-sm font-normal  mb-1 truncate" style="color: red">
                                                    Rp.0
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

        $(".btn13programSemua").click();
    });
</script>
@endsection