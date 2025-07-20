@extends('layouts.theme')


@section('content')

    <!-- Header Kelas -->
    @if ($firstCourse)
        <section class="lg:px-36 lg:py-8">
            <div class="container mx-auto">
                <div class="relative bg-cover bg-center w-full h-[308px] lg:h-[543px] lg:rounded-3xl p-6 lg:p-10 flex items-end"
                    style="background-image: url('{{$firstCourse['course']['thumbnail_url']}}');">
                    <div class="absolute bottom-0 left-0 w-full h-[263px] lg:h-[453px] lg:rounded-b-3xl"
                        style="background: linear-gradient(180deg, rgba(5, 25, 35, 0) 0%, rgba(5, 25, 35, 0.5) 21.35%);">
                    </div>
                    <div class="lg:flex items-end justify-between w-full">
                        <div class="relative mb-4 lg:mb-0">
                            <p class="text-sm lg:text-lg font-normal text-white mb-2 lg:mb-4">
                                {{$firstCourse['course']['category']['category_name']}}
                            </p>
                            <h2 class="text-2xl lg:text-4xl font-semibold text-white">
                                {{$firstCourse['course']['title']}}
                            </h2>
                        </div>
                        <a href="@if (Auth::user() && $firstCourse['course']['continue_url']) {{route('get_free_enroll', $firstCourse['course']['slug'])}} @else {{route('login')}} @endif"
                            class="relative inline-block text-sm lg:text-base font-normal text-brand-50 py-2.5 px-4 lg:px-6 text-center rounded-lg bg-brand-500 border border-brand-500 drop-shadow-md">
                            Lanjut Belajar
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!--  Daftar Kelas Saya  -->
    <section class="px-6 lg:px-36 pb-16 lg:pb-28 pt-12 lg:pt-10">
        <div class="container mx-auto">
            <div class="mb-10 text-center lg:text-left">
                <h3 class="text-xl lg:text-3xl font-semibold text-neutral-500 mb-2">
                    Daftar Kelas Saya
                </h3>
                <p class="text-sm lg:text-base font-normal text-neutral-400">
                    Lanjutkan pembelajaran Anda
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 md:gap-6">
                @foreach ($courses as $course)
                    @if (isset($course['course']['status']) && (int) $course['course']['status'] == 1)
                        <a href="@if (Auth::user() && $course['course']['continue_url']) {{route('get_free_enroll', $course['course']['slug'])}} @else {{route('login')}} @endif">
                            <div class="grid grid-cols-7 md:block border border-brand-100 rounded-lg p-2 mb-6 bg-white">
                                <div class="col-span-3 rounded-lg relative mb-0 md:mb-2 mr-2 md:mr-0">
                                    <img src="{{$course['course']['thumbnail_url']}}"
                                        class="w-full object-cover rounded-lg h-36" alt="">
                                    <div
                                        class="absolute top-1 left-1 text-xs lg:text-sm font-normal text-brand-500 bg-brand-50 py-1 px-2 rounded-3xl">
                                        {{course_levels($course['course']['level'])}}
                                    </div>
                                </div>
                                <div class="col-span-4">
                                    <div>
                                        <p class="text-xs lg:text-sm font-normal text-neutral-400 mb-1 truncate">
                                            {{$course['course']['category']['category_name']}}
                                        </p>
                                        <p
                                            class="text-sm lg:text-base font-semibold text-neutral-500 h-16 lg:h-[72px] mb-3.5 line-clamp-3">
                                            {{$course['course']['title']}}
                                        </p>
                                    </div>
                                    <div class="flex justify-between">
                                        <div class="flex items-center text-warning-500">
                                            <span class="material-icons-outlined">
                                                star
                                            </span>
                                            <p class="text-sm font-semibold text-warning-500 ml-1">
                                                {{ $course['course']['rating_value'] }}
                                                <span class="text-xs font-normal text-neutral-300">/5.0</span>
                                            </p>
                                        </div>
                                        <div
                                            class="flex items-center justify-center rounded-full bg-brand-500 text-white drop-shadow-md w-10 h-10">
                                            <span class="material-icons-outlined">
                                                arrow_right_alt
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
            {!! $courses->links(); !!}
        </div>
    </section>
@endsection
