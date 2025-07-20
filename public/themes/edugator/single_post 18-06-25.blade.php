@extends('layouts.theme')

@section('content')
    <section class="px-6 lg:px-36 pt-12 lg:pt-24 relative">
        <img src="{{ asset('assets/images/background/tentang-kami-flower1.webp') }}" alt="background"
            class="absolute top-0 left-2/4 -translate-x-2/4 w-8/12 md:w-5/12 lg:w-3/12">
        <div class="container mx-auto relative">
            <div class="text-center lg:w-2/4 mx-auto mb-16 lg:mb-12">
                <p class="text-sm lg:text-base text-brand-500 font-semibold uppercase mb-6 lg:mb-4">
                    Artikel
                </p>             
                <h1 class="text-2xl lg:text-4xl font-semibold text-neutral-500 mb-6 lg:mb-12">
                    {{$title}}
                </h1>
                <div class="flex items-center justify-center"><div class="text-center">
                        <p class="text-xs lg:text-sm font-semibold text-neutral-500 mb-1">
                            {{$post->author}}
                        </p>
                        <p class="text-xs lg:text-sm font-normal text-neutral-400">
                            {{date('d M Y', strtotime($post->created_at))}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($post->feature_image)
        <section class="lg:px-36">
            <div class="container mx-auto relative">
                <div class="mb-16 lg:mb-12">
                    <img src="{{$post->thumbnail_url->image_lg}}" class="w-fit-content lg:rounded-2xl object-cover mx-auto" alt="Cover">
                </div>
            </div>
        </section>
    @endif

    <section class="px-6 lg:px-36 pb-12 lg:pb-24">
        <div class="container mx-auto relative">
            <div class="relative mb-12">
                <style>
                    .kelasDesc p {
                        margin: 10px;
                        font-weight: normal;
                    }
                    .kelasDesc ol {
                        list-style: auto;
                        margin: auto;
                        padding: revert;
                    }
                    .kelasDesc h2 {
                        font-size: large;
                        font-weight: bold;
                    }
                    .kelasDesc h1 {
                        font-size: revert;
                        font-weight: bold;
                    }
                    .kelasDesc a {
                        color: #0093DD;
                        text-decoration: auto;
                    }
                </style>
                <div class="prose md:prose-md text-sm mx-auto kelasDesc">
                    {!! str_replace('<img', '<img style="max-width:100%;height:auto;"', $post->post_content) !!}
                </div>
                <div class="lg:absolute lg:top-0 lg:right-0 mt-10 lg:mt-0">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->full()) }}" class="text-2xl text-neutral-300 hover:text-brand-400 lg:block mr-8 lg:mr-0 lg:mb-6" target="_blank">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->full()) }}" class="text-2xl text-neutral-300 hover:text-brand-400 lg:block mr-8 lg:mr-0 lg:mb-6" target="_blank">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle/?mini=true&url={{ urlencode(url()->full()) }}&source=Linkedin" class="text-2xl text-neutral-300 hover:text-brand-400 lg:block mr-8 lg:mr-0 lg:mb-6" target="_blank">
                        <i class="fa-brands fa-linkedin"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send/?text={{ urlencode(url()->full()) }}&type=custom_url&app_absent=0" class="text-2xl text-neutral-300 hover:text-brand-400 lg:block mr-8 lg:mr-0 lg:mb-6" target="_blank">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Artikel Terkait -->

    @if($posts->total())
        <!-- Semua Artikel -->
        <section class="px-6 lg:px-36 pb-16 lg:pb-32">
            <div class="container mx-auto">
                <div class="lg:text-center lg:w-2/4 mx-auto mb-7 lg:mb-12">
                    <p class="text-sm lg:text-base text-brand-500 font-semibold uppercase mb-4">
                        Artikel
                    </p>             
                    <h2 class="text-2xl lg:text-4xl font-semibold text-neutral-500">
                        Baca Artikel Lainnya
                    </h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 md:gap-x-10 lg:gap-x-20">
                    @foreach($posts as $post)
                        <div class="cards mb-10 lg:mb-14">
                            <img src="{{$post->thumbnail_url->image_md}}" class="w-full h-[194px] md:h-[150px] lg:h-[194px] object-cover rounded-2xl mb-4 lg:mb-6" alt="Thumbnail">
                            <a href="{{$post->url}}">
                                <h5 class="text-lg lg:text-xl font-semibold text-neutral-500 hover:text-brand-500 mb-4 line-clamp-2">
                                    {{$post->title}}
                                </h5>
                            </a>
                            <p class="text-xs md:text-sm font-normal text-neutral-400 h-12 md:h-16 lg:h-20 line-clamp-3 lg:line-clamp-4 mb-6 lg:mb-10">
                                {!! str_limit(strip_tags($post->post_content), 200) !!}
                            </p>
                            <div class="flex justify-between">
                                <p class="text-xs lg:text-sm font-normal text-brand-500">
                                    {{$post->author}}
                                </p>
                                <p class="text-xs lg:text-sm font-normal text-neutral-400">
                                    {{date('d M Y', strtotime($post->created_at))}}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                {!! $posts->links('pagination_artikel') !!}
            </div>
        </section>
        
    @else

        {!! no_data() !!}

    @endif
    {{-- <section class="px-6 lg:px-36">
        <div class="container mx-auto pb-12 lg:py-24 md:border-t md:border-brand-50">
            <div class="lg:text-center lg:w-2/4 mx-auto mb-7 lg:mb-12">
                <p class="text-sm lg:text-base text-brand-500 font-semibold uppercase mb-4">
                    Artikel
                </p>             
                <h2 class="text-2xl lg:text-4xl font-semibold text-neutral-500">
                    Baca Artikel Lainnya
                </h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 md:gap-x-10 lg:gap-x-20">
                <div class="cards mb-10 lg:mb-14">
                    <img src="{{ asset('assets/images/artikel/thumbnail-4.png') }}" class="w-full h-[194px] md:h-[150px] lg:h-[194px] object-cover rounded-2xl mb-4 lg:mb-6" alt="Thumbnail">
                    <a href="artikel-detail.html">
                        <h5 class="text-xl font-semibold text-neutral-500 hover:text-brand-500 mb-4 line-clamp-2">
                            Bisnis Online di Bidang IT yang Menjanjikan
                        </h5>
                    </a>
                    <p class="text-xs md:text-sm font-normal text-neutral-400 h-12 md:h-16 lg:h-20 line-clamp-3 lg:line-clamp-4 mb-6 lg:mb-10">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quo, veniam quos! Nesciunt eligendi, reiciendis dicta perspiciatis, officia non error blanditiis ipsa exercitationem modi quod corrupti?
                    </p>
                    <div class="flex justify-between">
                        <p class="text-xs lg:text-sm font-normal text-brand-500">
                            Fiqeeh
                        </p>
                        <p class="text-xs lg:text-sm font-normal text-neutral-400">
                            24 Jan 2022
                        </p>
                    </div>
                </div>
                <div class="cards mb-10 lg:mb-14">
                    <img src="{{ asset('assets/images/artikel/thumbnail-5.png') }}" class="w-full h-[194px] md:h-[150px] lg:h-[194px] object-cover rounded-2xl mb-4 lg:mb-6" alt="Thumbnail">
                    <a href="artikel-detail.html">
                        <h5 class="text-xl font-semibold text-neutral-500 hover:text-brand-500 mb-4 line-clamp-2">
                            Bisnis Online di Bidang IT yang Menjanjikan
                        </h5>
                    </a>
                    <p class="text-xs md:text-sm font-normal text-neutral-400 h-12 md:h-16 lg:h-20 line-clamp-3 lg:line-clamp-4 mb-6 lg:mb-10">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quo, veniam quos! Nesciunt eligendi, reiciendis dicta perspiciatis, officia non error blanditiis ipsa exercitationem modi quod corrupti?
                    </p>
                    <div class="flex justify-between">
                        <p class="text-xs lg:text-sm font-normal text-brand-500">
                            Fiqeeh
                        </p>
                        <p class="text-xs lg:text-sm font-normal text-neutral-400">
                            24 Jan 2022
                        </p>
                    </div>
                </div>
                <div class="cards mb-10 lg:mb-14">
                    <img src="{{ asset('assets/images/artikel/thumbnail-6.png') }}" class="w-full h-[194px] md:h-[150px] lg:h-[194px] object-cover rounded-2xl mb-4 lg:mb-6" alt="Thumbnail">
                    <a href="artikel-detail.html">
                        <h5 class="text-xl font-semibold text-neutral-500 hover:text-brand-500 mb-4 line-clamp-2">
                            Bisnis Online di Bidang IT yang Menjanjikan
                        </h5>
                    </a>
                    <p class="text-xs md:text-sm font-normal text-neutral-400 h-12 md:h-16 lg:h-20 line-clamp-3 lg:line-clamp-4 mb-6 lg:mb-10">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quo, veniam quos! Nesciunt eligendi, reiciendis dicta perspiciatis, officia non error blanditiis ipsa exercitationem modi quod corrupti?
                    </p>
                    <div class="flex justify-between">
                        <p class="text-xs lg:text-sm font-normal text-brand-500">
                            Fiqeeh
                        </p>
                        <p class="text-xs lg:text-sm font-normal text-neutral-400">
                            24 Jan 2022
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    
    <!-- TABLET -->
    <section class="px-6 lg:px-36 pt-10 lg:pt-16 bg-brand-50">
        <div class="container mx-auto">
            <div class="text-center lg:px-32">
                <p class="text-sm lg:text-base text-brand-500 font-semibold uppercase mb-4">
                    Daftar Sekarang
                </p>
                <h2 class="text-2xl lg:text-4xl font-semibold text-neutral-500 mb-2">
                    Ilmu Pengusaha Syariah
                </h2>
                <h3 class="text-xl lg:text-3xl font-semibold text-brand-500 mb-4">
                    Terlengkap
                </h3>
                <p class="text-sm lg:text-base text-neutral-400 font-normal mb-10 lg:mb-16">
                    Dapatkan semua Kelas baru gratis<br>
                    dengan berlangganan
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
