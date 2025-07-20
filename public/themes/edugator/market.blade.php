@extends('layouts.theme')



@section('content')

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
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 md:gap-6">
                @foreach ($marketplace as $item)
                    <div class="px-2 lg:px-3">
                        <div class="rounded-lg border border-brand-100 p-2 bg-white mb-6">
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

@endsection
