@extends('layouts.theme')


@section('content')

    <!-- JUMBOTRON -->
    <section class="px-6 lg:px-36 relative">
        <img src="{{ asset('assets/images/background/landing-page-header-background.webp') }}" alt="background" class="hidden lg:block absolute top-0 left-0 opacity-30 w-5/12">
        <div class="">
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
                            <p class="text-sm font-normal text-neutral-400">Program Bisnis</p>
                        </div>
                        <div class="mb-8 md:pr-4 md:mr-4 lg:pr-8 lg:mr-8 md:border-r border-neutral-100">
                            <h3 class="text-2xl lg:text-3xl font-semibold text-neutral-500 mb-2">100+</h3>
                            <p class="text-sm font-normal text-neutral-400">Mentor Online</p>
                        </div>
                        
                        @php
                            $courseCount = \App\Course::where('category_id','!=',1203)->where('category_id','!=',1205)->where('category_id', '!=', 1206)->where('category_id', '!=', 1207)->where('category_id', '!=', 1208)->where('category_id', '!=', 1209)
                            ->where('status', '=', 1)->count();
                        @endphp
                        <div class="mb-8 md:pr-4 md:mr-4 lg:pr-8 lg:mr-8 md:border-r border-neutral-100">
                            <h3 class="text-2xl lg:text-3xl font-semibold text-neutral-500 mb-2">{{ $courseCount }}</h3>
                            <p class="text-sm font-normal text-neutral-400">Kelas Online</p>
                        </div>
                        <div class="mb-8">
                            <h3 class="text-2xl lg:text-3xl font-semibold text-neutral-500 mb-2">1.000+</h3>
                            <p class="text-sm font-normal text-neutral-400">Materi Online</p>
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

    <!--  Kelas Populer  -->

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