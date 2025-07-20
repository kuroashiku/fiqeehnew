@extends('layouts.theme')

@section('content')

    <form action="" id="form-search">
        <!-- Search bar -->
        <section class="px-6 lg:px-36 bg-neutral-500">
            <div class="container mx-auto relative">
                <div class="h-[70px] block lg:hidden"></div>
                <div class="hidden lg:grid lg:grid-cols-3 lg:gap-24">
                    <div>
                        <img src="{{ asset('assets/images/background/search-vector-1.webp') }}" class="w-full" alt="Vector">
                    </div>
                    <div>
                        <img src="{{ asset('assets/images/background/search-vector-2.webp') }}" class="w-full" alt="Vector">
                    </div>
                    <div>
                        <img src="{{ asset('assets/images/background/search-vector-3.webp') }}" class="w-full" alt="Vector">
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-10 lg:gap-6 absolute -bottom-[23px] lg:-bottom-[31px] w-full">
                    <div class="hidden lg:block lg:col-span-2"></div>
                    <div class="lg:col-span-6">
                        <div
                            class="flex items-center py-4 px-6 lg:px-8 rounded-[100px] border border-brand-100 bg-white drop-shadow-md">
                            <div class="relative w-full">
                                <input type="text" name="search" id="search" placeholder="Kata kunci"
                                    class="text-sm lg:text-base text-normal text-neutral-500 placeholder:text-neutral-400 pl-5 pr-3 lg:px-7 w-full border-0 focus:outline-none focus:ring-0 focus:border-0">
                                <label for="search"
                                    class="absolute flex items-center left-0 top-2/4 -translate-y-2/4 text-sm lg:text-base text-neutral-400 cursor-pointer">
                                    <span class="material-icons-outlined">
                                        search
                                    </span>
                                </label>
                                <button type="button" id="resetSearch"
                                    class="absolute flex items-center justify-between right-0 top-2/4 -translate-y-2/4 text-base lg:text-lg text-neutral-400 cursor-pointer">
                                    <span class="material-icons-outlined">
                                        close
                                    </span>
                                </button>
                            </div>
                            <div class="w-0.5 h-6 lg:h-7 bg-neutral-100 mx-2 lg:mx-4"></div>
                            <div>
                                <select name="type" id="type" hidden
                                    class="cursor-pointer text-sm lg:text-base text-normal text-neutral-500 focus:outline-none focus:ring-0 focus:border-0 border-0 w-28 lg:w-32">
                                    <option value="Kelas">Kelas</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="hidden lg:block lg:col-span-2"></div>
                </div>
            </div>
        </section>

        <!--  Program Bisnis  -->
        <section class="px-6 lg:px-36 pb-16 lg:pb-28 pt-10 lg:pt-16">
            <div class="container mx-auto">
                <div class="text-center mb-10">
                    <h3 class="text-xl lg:text-3xl font-semibold text-neutral-500 mb-1 lg:mb-2" id="hasilSearch">
                    </h3>
                    <p class="text-sm lg:text-base font-normal text-neutral-400" id="totalData">
                    </p>
                </div>
                <div class="block md:flex items-center justify-between mb-4 lg:mb-8">
                    <select name="category" id="category"
                        class="cursor-pointer text-sm lg:text-base font-normal text-neutral-500 py-2.5 px-6 bg-white border border-neutral-300 rounded-lg w-full md:w-44 mb-3 md:mb-0">
                        <option value="">All</option>
                        <option value="Populer">Populer</option>
                        {{-- <option value="Terbaru">Terbaru</option> --}}
                    </select>

                    <button type="button"
                        class="flex items-center justify-center text-sm lg:text-base font-normal text-neutral-500 py-2.5 px-6 bg-white border border-neutral-300 rounded-lg w-full md:w-auto"
                        data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example"
                        data-drawer-placement="right" aria-controls="drawer-right-example">
                        <span class="material-icons-outlined mr-2">
                            filter_list
                        </span>
                        Filter
                    </button>
                </div>
                <div class="relative">
                    <div class="programs13list">
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
        </section>

        <!-- Drawer Filter -->
        <div id="drawer-right-example" class="fixed z-40 h-screen p-4 overflow-y-auto bg-white w-80" tabindex="-1"
            aria-labelledby="drawer-right-label">
            <form action="">
                <div class="border-b-2 border-neutral-100 py-[3px] mb-6">
                    <h6 class="text-base font-semibold text-neutral-400">
                        SORTIR
                    </h6>
                </div>
                <div>
                    <p class="text-sm font-semibold text-neutral-500 mb-4">
                        Level pembelajaran
                    </p>
                    <div class="flex items-center mb-4">
                        <input type="checkbox" id="pemula" name="level" value="pemula"
                            class="border border-neutral-200 rounded checked:text-brand-500 checked:border checked:border-brand-500 checked:ring-0 focus:ring-0 cursor-pointer w-4 h-4 m-0">
                        <label for="pemula" class="text-sm font-normal text-neutral-500 cursor-pointer ml-2.5">
                            Pemula
                        </label>
                    </div>
                    <div class="flex items-center mb-4">
                        <input type="checkbox" id="menengah" name="level" value="menengah"
                            class="border border-neutral-200 rounded checked:text-brand-500 checked:border checked:border-brand-500 checked:ring-0 focus:ring-0 cursor-pointer w-4 h-4 m-0">
                        <label for="menengah" class="text-sm font-normal text-neutral-500 cursor-pointer ml-2.5">
                            Menengah
                        </label>
                    </div>
                    <div class="flex items-center mb-6">
                        <input type="checkbox" id="ahli" name="level" value="ahli"
                            class="border border-neutral-200 rounded checked:text-brand-500 checked:border checked:border-brand-500 checked:ring-0 focus:ring-0 cursor-pointer w-4 h-4 m-0">
                        <label for="ahli" class="text-sm font-normal text-neutral-500 cursor-pointer ml-2.5">
                            Ahli
                        </label>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-semibold text-neutral-500 mb-4">
                        Rating
                    </p>
                    <div class="flex items-center mb-4">
                        <input type="checkbox" id="lima" name="rating" value="5"
                            class="border border-neutral-200 rounded checked:text-brand-500 checked:border checked:border-brand-500 checked:ring-0 focus:ring-0 cursor-pointer w-4 h-4 m-0">
                        <label for="lima" class="text-sm font-normal text-neutral-500 cursor-pointer ml-2.5">
                            5
                        </label>
                    </div>
                    <div class="flex items-center mb-4">
                        <input type="checkbox" id="empat" name="rating" value="4"
                            class="border border-neutral-200 rounded checked:text-brand-500 checked:border checked:border-brand-500 checked:ring-0 focus:ring-0 cursor-pointer w-4 h-4 m-0">
                        <label for="empat" class="text-sm font-normal text-neutral-500 cursor-pointer ml-2.5">
                            4
                        </label>
                    </div>
                    <div class="flex items-center mb-4">
                        <input type="checkbox" id="tiga" name="rating" value="3"
                            class="border border-neutral-200 rounded checked:text-brand-500 checked:border checked:border-brand-500 checked:ring-0 focus:ring-0 cursor-pointer w-4 h-4 m-0">
                        <label for="tiga" class="text-sm font-normal text-neutral-500 cursor-pointer ml-2.5">
                            3
                        </label>
                    </div>
                    <div class="flex items-center mb-4">
                        <input type="checkbox" id="dua" name="rating" value="2"
                            class="border border-neutral-200 rounded checked:text-brand-500 checked:border checked:border-brand-500 checked:ring-0 focus:ring-0 cursor-pointer w-4 h-4 m-0">
                        <label for="dua" class="text-sm font-normal text-neutral-500 cursor-pointer ml-2.5">
                            2
                        </label>
                    </div>
                    <div class="flex items-center mb-6">
                        <input type="checkbox" id="satu" name="rating" value="1"
                            class="border border-neutral-200 rounded checked:text-brand-500 checked:border checked:border-brand-500 checked:ring-0 focus:ring-0 cursor-pointer w-4 h-4 m-0">
                        <label for="satu" class="text-sm font-normal text-neutral-500 cursor-pointer ml-2.5">
                            1
                        </label>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-semibold text-neutral-500 mb-4">
                        Program Bisnis
                    </p>
                    @php
                        $category = \App\Category::where('slug', '!=', 'developer')->where('step', 2)->get()->toArray();
                    @endphp
                    {{-- @php
                    $category = \App\CategoryCourse::where('category_id','!=',1203)->with('course.media', 'category')->get()->toArray();
                @endphp --}}
                    @php
                    // $category = \App\Course::with('category')->where('category_id', '!=', 1203)->get()->toArray();
                @endphp
                    @foreach ($category as $item)
                        <div class="flex items-center mb-4">
                            <input type="checkbox" id="{{ $item['slug'] }}" name="program" value="{{ $item['slug'] }}"
                                class="border border-neutral-200 rounded checked:text-brand-500 checked:border checked:border-brand-500 checked:ring-0 focus:ring-0 cursor-pointer w-4 h-4 m-0">
                            <label for="{{ $item['slug'] }}" class="text-sm font-normal text-neutral-500 cursor-pointer ml-2.5">
                                Program {{$item['category_name']}}
                            </label>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
    </form>

@endsection

@section('page-js')

<script>
    $('select[name=type]').change(function () {
        $("#form-search").submit()
    })
    $('select[name=category]').change(function () {
        $("#form-search").submit()
    })

    $('input[name = level]').change(function () {
        $("#form-search").submit()
    })

    $('input[name = rating]').change(function () {
        $("#form-search").submit()
    })

    $('input[name = program]').change(function () {
        $("#form-search").submit()
    })

    $('#resetSearch').click(function () {
        $('input[name=search]').val('')
        $("#form-search").submit()
    })

    $("#form-search").submit(function (event) {
        event.preventDefault();

        const searchInput = $('input[name=search]').val()
        const typeInput = $('select[name=type]').val()
        const categoryInput = $('select[name=category]').val()

        const levelArray = []
        $("input[name = level]").each(function (index, item) {
            item.checked && levelArray.push(item.value)
        });
        const levelInput = levelArray.join(",")

        const ratingArray = []
        $("input[name = rating]").each(function (index, item) {
            item.checked && ratingArray.push(item.value)
        });
        const ratingInput = ratingArray.join(",")

        const programArray = []
        $("input[name = program]").each(function (index, item) {
            item.checked && programArray.push(item.value)
        });
        const programInput = programArray.join(",")

        const value = $(this).data("value");

        
        $.ajax({
            type: 'GET',
            url: `{{ env('APP_URL') }}/api/search/course?search=${searchInput}&level=${levelInput}&rating=${ratingInput}&program=${programInput}`,
            success: function (data) {
                (searchInput !== '') ? $('#hasilSearch').text(`"${searchInput}"`) : $('#hasilSearch').text('')
                
                $('#totalData').text(`${data.length} ${typeInput}`)
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
</script>

@endsection
