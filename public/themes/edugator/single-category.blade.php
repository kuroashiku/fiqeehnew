@extends('layouts.theme')


@section('content')

    @php
        $selected = \App\Category::where('slug', '!=', 'developer')->where('step', 2)->get()->toArray();
        $selectedRecomendation = \App\Category::where('step', 2)->where('is_recomendation', 1)->get()->toArray();
    @endphp

    <!-- SEMUA PROGRAM BISNIS -->
    <section class="px-6 lg:px-36 pb-2 pt-8 lg:pt-16 relative bg-neutral-500">
        <div class="text-center mb-10">
            <h3 class="text-xl lg:text-3xl font-semibold text-brand-50 mb-2">
                {{ $category->category_name }}
            </h3>
            <p class="text-sm lg:text-base font-normal text-neutral-200">
                {{ $totalCourse }} Kelas
            </p>
        </div>
    </section>
    <section class="px-6 lg:px-36 pb-16 pt-8 lg:pt-16 relative">
        <img src="{{ asset('assets/images/background/landing-page-section7-flower.png') }}" alt="background"
            class="hidden lg:block absolute top-16 right-0 opacity-90 w-2/12">
        <div class="container mx-auto">
            <div class="slider-tag text-center mb-6 lg:mb-4">
                <div class="pr-3 lg:mx-3 inline-block">
                    <button type="button" data-value=""
                        class="btn13program btn13programSemua flex items-center mb-3 text-sm lg:text-base font-normal text-brand-500 border border-brand-500 bg-brand-50 whitespace-nowrap py-2.5 pl-4 pr-3 md:mb-3 lg:mb-6 rounded-3xl">
                        Semua
                    </button>
                </div>
                @foreach ($selected as $item)
                    <div class="pr-3 lg:mx-3 inline-block">
                        <button type="button" data-value="{{ $item['slug'] }}"
                            class="btn13program btn13program{{ $item['slug'] }} mb-3 text-sm lg:text-base font-normal text-neutral-400 border border-neutral-400 bg-white whitespace-nowrap py-2.5 pl-4 pr-3 md:mb-3 lg:mb-6 rounded-3xl">
                            {{ $item['category_name'] }}
                        </button>
                    </div>
                @endforeach
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

@endsection

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

        console.log("btn13program{{ $category->slug }}");
        $(".btn13program{{ $category->slug }}").click();
    });
</script>
@endsection