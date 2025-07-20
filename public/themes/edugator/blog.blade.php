@extends('layouts.theme')

@section('content')

    <!--Search Artikel -->
    <section class="px-6 lg:px-36 py-12 lg:py-24 relative">
        <img src="{{ asset('assets/images/background/tentang-kami-flower1.webp') }}" alt="background"
            class="absolute top-0 left-2/4 -translate-x-2/4 w-8/12 md:w-5/12 lg:w-3/12">
        <div class="container mx-auto relative">
            <div class="text-center lg:px-32 mb-2">
                <p class="text-sm lg:text-base text-brand-500 font-semibold uppercase mb-6 lg:mb-8">
                    Artikel
                </p>
                <h1 class="text-3xl lg:text-5xl font-semibold text-neutral-500 mb-4 lg:mb-6">
                    Bacaan Terbaik Untuk
                </h1>                
                <h2 class="text-2xl lg:text-4xl font-semibold text-brand-500 mb-6 lg:mb-8">
                    Pengusaha Syariah
                </h2>
                <form action="">
                    <div class="lg:flex items-center justify-center">
                        <input type="text" class="w-full md:w-[398px] mb-4 md:mb-0 text-sm lg:text-base font-normal text-neutral-500 placeholder-neutral-300 py-2.5 px-5 rounded-lg border border-neutral-100 drop-shadow focus:outline-none focus:border-brand-500 focus:ring-0" name="search" value="{{ isset($_GET['search']) ? $_GET['search'] : "" }}" id="search" placeholder="Masukkan kata kunci">
                        <button type="submit" class="inline-block w-full md:w-auto text-center md:px-6 py-2.5 ml-0 md:ml-4 rounded-lg text-sm lg:text-base text-brand-50 bg-brand-500 border-none">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="px-6 lg:px-36 pb-16 lg:pb-24">
        <div class="container mx-auto">
            <div class="md:grid md:grid-cols-2 md:gap-6">
                <div class="relative lg:h-full mb-8 md:mb-0">
                    <img src="{{$bigPost->thumbnail_url->image_md}}" class="w-full h-[308px] lg:h-[456px] object-cover rounded-2xl" alt="Photo">
                    <div class="absolute -bottom-[50px] md:bottom-0 w-full">
                        <div class="md:mx-6 bg-white rounded-2xl shadow-md py-4 px-6">
                            <a href="{{$bigPost->url}}">
                                <h4 class="text-lg lg:text-2xl font-semibold text-neutral-500 hover:text-brand-500 mb-1">
                                    {{$bigPost->title}}
                                </h4>
                            </a>
                            <p class="text-xs lg:text-sm font-normal text-brand-500 mb-2">
                                {{$bigPost->author}}
                            </p>
                            <p class="text-xs lg:text-sm font-normal text-neutral-500 line-clamp-3">
                                {!! str_limit(($bigPost->post_content), 200) !!}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-20 md:mt-0">
                    @foreach($littlePost as $key=> $post)
                        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                            <div class="lg:col-span-2">
                                <img src="{{$post->thumbnail_url->image_md}}" class="rounded-2xl w-full h-32 lg:h-[168px] object-cover" alt="Thumbnail">
                            </div>
                            <div class="my-auto flex flex-col lg:col-span-3">
                                <a href="{{$post->url}}">
                                    <h5 class="text-sm lg:text-xl font-semibold text-neutral-500 hover:text-brand-500 mb-1 line-clamp-3 lg:line-clamp-2">
                                        {{$post->title}}
                                    </h5>
                                </a>
                                <p class="text-xs lg:text-sm font-normal text-brand-500 mb-2">
                                    {{$post->author}}
                                </p>
                                <p class="hidden text-sm font-normal text-neutral-500 lg:line-clamp-3">
                                    {!! str_limit(strip_tags($post->post_content), 200) !!}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Artikel -->
    {{-- @if($posts->total()) --}}
        <!-- Semua Artikel -->
        <section class="px-6 lg:px-36 pb-16 lg:pb-32">
            <div class="container mx-auto">
                <div class="mb-8 lg:mb-12">
                    <p class="text-sm lg:text-base font-semibold text-brand-500 mb-4 uppercase">
                        Semua Artikel
                    </p>
                    <h2 class="text-2xl lg:text-4xl font-semibold text-neutral-500">
                        Temukan Artikel Menarik!
                    </h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 md:gap-x-10 lg:gap-x-20">
                    @foreach($posts as $post)
                        <div class="cards mb-10 lg:mb-14">
                            <img src="{{$post->thumbnail_url->image_md}}" class="w-full mx:auto object-cover rounded-2xl mb-4 lg:mb-6" alt="Thumbnail">
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
                {{-- {!! $posts->links('pagination_artikel') !!} --}}
            </div>
        </section>
        
    {{-- @else

        {!! no_data() !!}

    @endif --}}


    <!-- TABLET -->
    <section class="px-6 lg:px-36 pt-10 lg:pt-16 bg-brand-50">
        <div class="container mx-auto">
            <div class="text-center lg:px-32">
                <p class="text-sm lg:text-base text-brand-500 font-semibold uppercase mb-4">
                    Berlangganan Sekarang
                </p>
                <h2 class="text-2xl lg:text-4xl font-semibold text-neutral-500 mb-2">
                    Kampus Pengusaha Syariah
                </h2>
                <h3 class="text-xl lg:text-3xl font-semibold text-brand-500 mb-4">
                    Terlengkap
                </h3>
                <p class="text-sm lg:text-base text-neutral-400 font-normal mb-10 lg:mb-16">
                    Dapatkan semua Kelas baru gratis
                </p>
                <a href="{{ route('register') }}"
                    class="inline-block w-full md:w-auto text-center md:px-6 py-2.5 rounded-lg text-sm lg:text-base text-brand-50 bg-brand-500 border-none mb-12 lg:mb-16">
                    Berlangganan Sekarang
                </a>
                <img src="{{ asset('assets/images/background/landing-page-tablet.webp') }}" class="w-full object-contain" alt="Image">
            </div>
        </div>
    </section>

@endsection
