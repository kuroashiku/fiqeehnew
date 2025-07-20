@extends('layouts.theme')

@section('content')

    <section class="lg:px-36 relative" style="background: #FCFCFC;">
        <div class="container mx-auto pt-0 relative">
            <div class="lg:px-8 md:gap-4 md:grid md:grid-cols-4 md:text-left text-center">
                <div class="lg:pb-4 lg:pt-10 lg:py-20 md:col-span-2 p-6">
                    <div>
                        <div class="mb-2 w-fit-content">
                            <span class="bg-white font-semibold lg:mb-8 mb-4 md:mb-6 p-0.5 pr-2 rounded-2xl text-brand-500 text-sm">
                                Buku
                            </span>
{{--                            <span class="font-semibold lg:mb-8 mb-4 md:mb-6 ml-2 mr-2 text-brand-500 text-sm">--}}
{{--                                Download Gratis--}}
{{--                            </span>--}}
                        </div>
                        <h1 class="font-semibold lg:text-5xl text-3xl text-left text-neutral-500">
                            Kumpulan Buku
                        </h1>
                        <h1 class="font-semibold lg:mb-6 lg:text-5xl mb-2 md:mb-4 text-3xl text-left text-neutral-500">
                            Fiqeeh
                        </h1>
                        <p class="font-normal lg:mb-16 lg:pr-12 lg:text-base mb-12 md:w-auto text-left text-neutral-400 text-sm w-3/4">
                            Membantu anda mempelajari seluruh ilmu dari penjuru dunia
                        </p>
                        <div class="flex flex-col-reverse md:gap-4 md:grid md:grid-cols-2">
                            <a href="{{ route('register') }}"
                               class="bg-white border border-brand-200 font-normal inline-block lg:text-base mb-2 md:w-auto py-2.5 rounded-lg text-center text-neutral-500 text-sm w-full">
                                Jadi member
                            </a>
                            <a href="{{ route('free_ebook') }}"
                               class="bg-brand-500 font-normal inline-block lg:text-base mb-2 md:w-auto py-2.5 rounded-lg text-brand-50 text-center text-sm w-full">
                                Termukan Buku
                            </a>
                        </div>
                    </div>
                </div>
                <div class="md:col-span-2 relative">
                    <img src="{{ asset('assets/images/background/background-book.png') }}" class="lg:h-[453px]" alt="Image">
                </div>
            </div>
        </div>
    </section>
    <section class="md:px-6 lg:px-36 md:pb-20 lg:pb-32 relative">
        <div class="absolute w-full h-2 -bottom-[4px] left-0 bg-neutral-500" style="background:white"></div>
        <div class="container lg:mt-6 mx-auto">
            <h2 class="font-semibold lg:p-8 lg:py-2 lg:text-4xl lg:text-left text-2xl text-center text-neutral-500">
                Buku Fisik
            </h2>
            <div class="justify-content-center row text-align-center">
                <div class="gap-8 grid grid-cols-2 lg:pt-5 md:grid-cols-5 p-6 pt-16">
                    @php
                        $ebook = \App\Ebook::where('free', 0)->where('physic', 1)->get();
                    @endphp
                    @foreach ($ebook as $eb)
                        @php
                            $image = \App\Media::where('id', $eb->image)->first()->slug_ext;
                        @endphp
                        <div class="text-center">
                            <a href="{{route('ebook', $eb->slug)}}">
                                <img class="h-[200px] m-6 mb-3 mx-auto w-32" src="{{url('uploads/images/'.$image)}}" class="" alt=""
                                     style="box-shadow: 5px 5px 6px gray;">
                            </a>
                            <p style="line-height: 15px;font-weight: bold;" class="pt-2 text-neutral-500 text-sm">
                                {{$eb->title}}
                            </p>
                            <p class="pt-2 text-neutral-500 text-sm">Rp. {{number_format($eb->price,2,',','.')}}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <h2 class="font-semibold lg:p-8 lg:py-2 lg:text-4xl lg:text-left text-2xl text-center text-neutral-500">
                Buku Digital Berbayar
            </h2>
            <div class="justify-content-center row text-align-center">
                <div class="gap-8 grid grid-cols-2 lg:pt-5 md:grid-cols-5 p-6 pt-16">
                    @php
                        $ebook = \App\Ebook::where('free', 0)->where('physic', 0)->get();
                    @endphp
                    @foreach ($ebook as $eb)
                        @php
                            $image = \App\Media::where('id', $eb->image)->first()->slug_ext;
                        @endphp
                        <div class="text-center">
                            <a href="{{route('ebook', $eb->slug)}}">
                                <img class="h-[200px] m-6 mb-3 mx-auto w-32" src="{{url('uploads/images/'.$image)}}" class="" alt=""
                                     style="box-shadow: 5px 5px 6px gray;">
                            </a>
                            <p style="line-height: 15px;font-weight: bold;" class="pt-2 text-neutral-500 text-sm">
                                {{$eb->title}}
                            </p>
                            <p class="pt-2 text-neutral-500 text-sm">Rp. {{number_format($eb->price,2,',','.')}}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <h2 class="font-semibold lg:p-8 lg:py-2 lg:text-4xl lg:text-left text-2xl text-center text-neutral-500">
                Buku Digital Gratis
            </h2>
            <div class="justify-content-center row text-align-center">
                <div class="gap-8 grid grid-cols-2 lg:pt-5 md:grid-cols-5 p-6 pt-16">
                    @php
                        $ebook = \App\Ebook::where('free', 1)->where('physic', 0)->get();
                    @endphp
                    @foreach ($ebook as $eb)
                        @php
                            $image = \App\Media::where('id', $eb->image)->first()->slug_ext;
                        @endphp
                        <div class="text-center">
                            <a href="{{route('ebook', $eb->slug)}}">
                                <img class="h-[200px] m-6 mb-3 mx-auto w-32" src="{{url('uploads/images/'.$image)}}" class="" alt=""
                                     style="box-shadow: 5px 5px 6px gray;">
                            </a>
                            <p style="line-height: 15px;font-weight: bold;" class="pt-2 text-neutral-500 text-sm">
                                {{$eb->title}}
                            </p>
                            <p class="pt-2 text-neutral-500 text-sm">Gratis</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
