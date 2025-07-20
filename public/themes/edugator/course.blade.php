@extends('layouts.theme')

@section('content')
    @if (Auth::user())
        @php
            $payment = \App\UserPayment::where('user_id', Auth::user()->id)
            ->where('status', 0)
            ->orderBy('id', 'DESC')
            ->first();
            $user = \App\User::where('id', Auth::user()->id)->first();
        @endphp
    @endif

    <section class="px-6 lg:px-36 py-2 bg-brand-500">
        <div class="container mx-auto">
            <div class="text-center lg:flex justify-center">
                <p class="text-sm md:text-base font-normal text-white">
                    Sisa waktu pembayaran
                </p>
                <input type="hidden" name="countdown" id="countdown" value="October 20, 2022 00:00:00">
                <p class="text-base font-semibold text-success-400 lg:ml-6">
                    <span id="hours">00</span> : <span id="minutes">00</span> : <span id="seconds">00</span>
                </p>
            </div>
        </div>
    </section>

    <section class="px-6 lg:px-36 pb-10 lg:pb-0 pt-8 bg-neutral-600 relative">
        <div class="container mx-auto">
            <div class="block lg:hidden rounded-t-lg overflow-hidden mb-5">
                @if($course->video_info())
                    @php
                        $src_youtube = str_replace('https://youtu.be/', 'https://www.youtube.com/embed/',$course->video_info('source_youtube'));
                    @endphp
                    <div class="plyr__video-embed w-full mb-6" id="player">
                        <iframe src="{{ $src_youtube }}"
                        allowfullscreen
                        allowtransparency
                        ></iframe>
                    </div>
                @else
                    <img src="{{media_image_uri($course->thumbnail_id)->image_md}}" class="img-fluid" />
                @endif
            </div>
            <div class="text-xs lg:text-sm w-fit-content font-medium text-brand-500 bg-brand-50 py-1 px-3 rounded-3xl mb-5" style="width: fit-content;">
                {{ $course->category->category_name }}
            </div>
            <div class="lg:grid lg:grid-cols-10 lg:gap-6 ">
                <div class="lg:col-span-7 text-white">
                    <style>
                        .kelasDesc p {
                            font-weight: normal;
                            padding: 15px 0;
                        }
                        .kelasDesc ol {
                            list-style: auto;
                            padding: revert;
                            white-space: normal;
                        }
                        .kelasDesc li {
                            list-style: auto;
                            padding: revert;
                        }
                        .kelasDesc a {
                            color: rgb(0 147 221 / var(--tw-text-opacity));
                            text-decoration: auto;
                        }
                    </style>
                    <div class="mb-8 kelasDesc">
                        <span class="text-sm lg:text-base font-normal mb-3">
                            <i class="fa-regular fa-user mr-2"></i>
                            {{ $course->author }}
                        </span>
                        <h2 class="text-2xl lg:text-4xl font-semibold mb-2">
                            {{ $course->title }}
                        </h2>
                        {!! $course->description !!}
                    </div>
                    <div class="flex items-center text-xs lg:text-sm font-semibold mb-16">
                        <p class="text-warning-500 mr-2">
                            {{ $course->rating_value }}
                        </p>
                        <i class="fa-solid fa-star text-sx text-warning-500 mr-1"></i>
                        <i class="fa-solid fa-star text-sx text-warning-500 mr-1"></i>
                        <i class="fa-solid fa-star text-sx text-warning-500 mr-1"></i>
                        <i class="fa-solid fa-star text-sx text-warning-500 mr-1"></i>
                        <i class="fa-solid fa-star text-sx text-warning-500"></i>
                        <p class="font-normal ml-2">
                            ({{ $course->rating_count }} penilaian)
                        </p>
                    </div>
                    <div class="lg:hidden mb-4">
                        <p class="text-xs font-semibold mb-2">
                            Berlangganan
                        </p>
                        <h5 class="text-xl font-semibold mb-2">
                            Rp50.000/bulan
                        </h5>
                        <p class="text-xs font-normal mb-5">
                            Ribuan orang sudah bergabung untuk belajar ilmu bisnis syariah yang benar. 
                        </p>
                        <a href="{{ route('register_course', $course->slug) }}" class="inline-block w-full text-center text-sm font-normal text-brand-50 py-2.5 bg-brand-500 rounded-lg drop-shadow">
                            Daftar
                        </a>
                    </div>
                </div>
                <div class="hidden lg:block absolute top-8 right-36 w-3/12 pl-6">
                    <div class="rounded-t-lg overflow-hidden">
                        @if($course->video_info())
                            @php
                                $src_youtube = str_replace('https://youtu.be/', 'https://www.youtube.com/embed/',$course->video_info('source_youtube'));
                            @endphp
                            <div class="plyr__video-embed w-full mb-6" id="player2">
                                <iframe src="{{ $src_youtube }}"
                                allowfullscreen
                                allowtransparency
                                ></iframe>
                            </div>
                        @else
                            <img src="{{media_image_uri($course->thumbnail_id)->image_md}}" class="img-fluid" />
                        @endif
                    </div>
                    <div class="rounded-b-lg border border-t-0 border-neutral-100 bg-white ">
                        <div class="px-4 py-6 border-b border-neutral-100">
                            <p class="text-xs font-semibold text-neutral-500 mb-3">
                                Kelas ini berisi
                            </p>
                            <div class="mb-4">
                                <div class="flex items-center text-sm font-normal text-neutral-500 mb-3">
                                    <img src="{{ asset('assets/images/icons/overview-class.png') }}" alt="" class="w-4 mr-3">
                                    <span>Level {{course_levels($course->level)}}</span>
                                </div>
                                @php
                                    $total_time = 0;
                                @endphp
                                @foreach ($course->sections as $section)
                                    @foreach($section->items as $item)
                                        @php
                                            $total_time += $item->runtime_seconds;
                                        @endphp
                                    @endforeach
                                @endforeach
                                @php
                                    $timeTotal = gmdate("H,i", $total_time);
                                    $arrTime = explode(',',$timeTotal);
                                @endphp
                                <div class="flex items-center text-sm font-normal text-neutral-500 mb-3">
                                    <img src="{{ asset('assets/images/icons/overview-video_settings.png') }}" alt="" class="w-4 mr-3">
                                    @if ($arrTime[0] == '00')
                                        <span>{{ $course->video_kelas }} video (Total : {{ $arrTime[1] }} menit)</span>
                                    @else
                                        <span>{{ $course->video_kelas }} video (Total : {{ $arrTime[0] }} jam {{ $arrTime[1] }} menit)</span>
                                    @endif
                                </div>
                                <div class="flex items-center text-sm font-normal text-neutral-500 mb-3">
                                    <img src="{{ asset('assets/images/icons/overview-insert_drive_file.png') }}" alt="" class="w-4 mr-3">
                                    <span>{{ $course->dokumen_pendukung }} dokumen pendukung</span>
                                </div>
                                {{-- <div class="flex items-center text-sm font-normal text-neutral-500 mb-3">
                                    <img src="{{ asset('assets/images/icons/overview-certificate.png') }}" alt="" class="w-4 mr-3">
                                    <span>Bersertifikat</span>
                                </div> --}}
                            </div>
                            <p class="text-xs font-semibold text-neutral-500 mb-3">
                                Anda mendapat bonus
                            </p>
                            <div class="text-sm font-normal text-neutral-500">
                                <p class="mb-2">
                                    @php
                                        $courseCount = \App\Course::where('category_id','!=',1203)->where('category_id','!=',1205)->where('category_id', '!=', 1206)->where('category_id', '!=', 1207)->where('category_id', '!=', 1208)->where('category_id', '!=', 1209)
                                        ->where('status', '=', 1)->count();
                                    @endphp
                                    <i class="fa-solid fa-circle text-brand-500 mr-2" style="font-size: 8px"></i>
                                    {{$courseCount}} Kelas Online
                                </p>
                                <p class="mb-2">
                                    @php
                                    $lectureCount = \App\Content::join('courses', 'courses.id', '=', 'contents.course_id')
                                    ->where('courses.category_id', '!=', 1203)
                                    ->get()
                                    ->count();
                                    @endphp
                                    <i class="fa-solid fa-circle text-brand-500 mr-2" style="font-size: 8px"></i>
                                    {{$lectureCount}} Video & Dokumen
                                </p>
                                <p class="mb-2">
                                    <i class="fa-solid fa-circle text-brand-500 mr-2" style="font-size: 8px"></i>
                                    Gratis kelas baru
                                </p>
                                <p class="mb-2">
                                    <i class="fa-solid fa-circle text-brand-500 mr-2" style="font-size: 8px"></i>
                                    Gratis grup mentoring
                                </p>
                            </div>
                        </div>
                        <div class="px-4 py-6">
                            <p class="text-xs font-semibold mb-4">
                                Berlangganan
                            </p>
                            <h5 class="text-xl font-semibold mb-4">
                                Rp50.000/bulan
                            </h5>
                            <p class="text-sm font-normal mb-6">
                                Ribuan orang sudah bergabung untuk belajar ilmu bisnis syariah yang benar. 
                            </p>
                            <a href="{{ route('register_course', $course->slug) }}" class="inline-block w-full text-center text-sm font-normal text-brand-50 py-2.5 bg-brand-500 rounded-lg drop-shadow">
                                Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="px-6 lg:px-36 pt-8 pb-6 lg:pb-16">
        <div class="container mx-auto">
            <div class="lg:grid lg:grid-cols-10 lg:gap-6 ">
                <div class="lg:col-span-7 text-white" id="overview">
                    <div class="lg:pr-28">
                        <!-- ONLY MOBILE -->
                        <div class="lg:hidden mb-6 pt-4" id="detailtabs">                            
                            <p class="text-base lg:text-lg font-semibold text-neutral-500 mb-2 lg:mb-4">
                                DETAIL KELAS
                            </p>
                            <p class="text-xs font-semibold text-neutral-500 mb-3">
                                Kelas ini berisi
                            </p>
                            <div class="mb-4">
                                <div class="flex items-center text-sm font-normal text-neutral-500 mb-3">
                                    <img src="{{ asset('assets/images/icons/overview-class.png') }}" alt="" class="w-4 mr-3">
                                    <span>Level {{course_levels($course->level)}}</span>
                                </div>
                                @php
                                    $total_time = 0;
                                @endphp
                                @foreach ($course->sections as $section)
                                    @foreach($section->items as $item)
                                        @php
                                            $total_time += $item->runtime_seconds;
                                        @endphp
                                    @endforeach
                                @endforeach
                                @php
                                    $timeTotal = gmdate("H,i", $total_time);
                                    $arrTime = explode(',',$timeTotal);
                                @endphp
                                <div class="flex items-center text-sm font-normal text-neutral-500 mb-3">
                                    <img src="{{ asset('assets/images/icons/overview-video_settings.png') }}" alt="" class="w-4 mr-3">
                                    @if ($arrTime[0] == '00')
                                        <span>{{ $course->video_kelas }} video (Total : {{ $arrTime[1] }} menit)</span>
                                    @else
                                        <span>{{ $course->video_kelas }} video (Total : {{ $arrTime[0] }} jam {{ $arrTime[1] }} menit)</span>
                                    @endif
                                </div>
                                <div class="flex items-center text-sm font-normal text-neutral-500 mb-3">
                                    <img src="{{ asset('assets/images/icons/overview-insert_drive_file.png') }}" alt="" class="w-4 mr-3">
                                    <span>{{ $course->dokumen_pendukung }} dokumen pendukung</span>
                                </div>
                                {{-- <div class="flex items-center text-sm font-normal text-neutral-500 mb-3">
                                    <img src="{{ asset('assets/images/icons/overview-certificate.png') }}" alt="" class="w-4 mr-3">
                                    <span>Bersertifikat</span>
                                </div> --}}
                            </div>
                            <p class="text-xs font-semibold text-neutral-500 mb-3">
                                Anda mendapat bonus
                            </p>
                            <div class="text-sm font-normal text-neutral-500">
                                <p class="mb-2">
                                    @php
                                        $courseCount = \App\Course::where('category_id','!=',1203)->where('category_id','!=',1205)->where('category_id', '!=', 1206)->where('category_id', '!=', 1207)->where('category_id', '!=', 1208)->where('category_id', '!=', 1209)
                                        ->where('status', '=', 1)->count();
                                    @endphp
                                    <i class="fa-solid fa-circle text-brand-500 mr-2" style="font-size: 8px"></i>
                                    {{$courseCount}} Kelas Online
                                </p>
                                <p class="mb-2">
                                    @php
                                    $lectureCount = \App\Content::join('courses', 'courses.id', '=', 'contents.course_id')
                                    ->where('courses.category_id', '!=', 1203)
                                    ->get()
                                    ->count();
                                    @endphp
                                    <i class="fa-solid fa-circle text-brand-500 mr-2" style="font-size: 8px"></i>
                                    {{$lectureCount}} Video & Dokumen
                                </p>
                                <p class="mb-2">
                                    <i class="fa-solid fa-circle text-brand-500 mr-2" style="font-size: 8px"></i>
                                    Gratis kelas baru
                                </p>
                                <p class="mb-2">
                                    <i class="fa-solid fa-circle text-brand-500 mr-2" style="font-size: 8px"></i>
                                    Gratis grup mentoring
                                </p>
                            </div>
                        </div>
                        <!-- END ONLY MOBILE -->

                        <div id="kontentabs" class="mb-6 pt-4">
                            <p class="text-base lg:text-lg font-semibold text-neutral-500 mb-2 lg:mb-4">
                                KONTEN PRAKTISI
                            </p>
                            <div class="border border-brand-100 rounded-lg overflow-hidden listcontents">
                                @foreach ($course->sections as $section)
                                    @foreach($section->items as $item)
                                        <div class="flex items-center justify-between px-4 py-3 border-b border-brand-100">
                                            <div class="text-sm font-normal text-neutral-500">
                                                @if ($item->item_type == 'lecture')
                                                    @if (!empty($item->runtime))
                                                        <i class="fa-regular fa-circle-play"></i>
                                                    @else
                                                        <i class="fa-solid fa-paperclip -rotate-45"></i>
                                                    @endif
                                                @else
                                                    <i class="fa-regular fa-file-lines"></i>
                                                @endif
                                                <span class="ml-2">{{$item->title}}</span>
                                            </div>
                                            <div class="text-sm font-normal text-neutral-400">
                                                @if ($item->item_type == 'lecture' && empty($item->vide_src))
                                                    {{ $item->runtime }}
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                        <div id="ulasantabs" class="pb-4 pt-4">
                            <p class="text-base lg:text-lg font-semibold text-neutral-500 mb-2 lg:mb-4">
                                TENTANG MENTOR
                            </p>
                            <div class="grid grid-cols-4 lg:grid-cols-7">
                                <div class="lg:mb-0 mb-6">
                                    <img class="bg-brand-200 flex h-16 items-center justify-center lg:h-20 lg:mr-4 lg:w-20 mr-2 rounded-full text-brand-500 w-16" src="{{media_image_uri($course->mentor_image_id)->image_md}}" alt="" style="object-fit: cover;">
                                </div>
                                <div class="col-span-3">
                                    <p class="font-semibold lg:mt-4 lg:text-lg mt-2 text-neutral-500">{{ $course->mentor }}</p>
                                    <p class="text-neutral-300">{{ $course->mentor_job }}</p>
                                </div>
                            </div>
                            {{-- <p class="font-semibold lg:mt-4 mb-2 text-base text-neutral-500 text-sx">
                                Tentang Saya
                            </p> --}}
                            <p class="text-neutral-400 text-sm lg:mt-4 mb-2">
                                {{ $course->mentor_desc }}
                            </p>
                        </div>
                        <div id="ulasantabs" class="pt-4">
                            <p class="text-base lg:text-lg font-semibold text-neutral-500 mb-2 lg:mb-4">
                                ULASAN
                            </p>
                            <div class="rounded-lg bg-brand-50 py-8 px-6 lg:px-10 mb-6">
                                <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-x-6">
                                    <div class="mb-6 lg:mb-0">
                                        <div class="mb-1">
                                            <span class="text-5xl font-semibold text-brand-500">
                                                {{ $course->rating_value }}
                                            </span>
                                            <span class="text-sm lg:text-base font-normal text-neutral-500">
                                                / 5.0
                                            </span>
                                        </div>
                                        <p class="text-xs lg:text-sm font-normal text-neutral-400 mb-2 lg:mb-4">
                                            berdasarkan {{ $course->rating_count }} penilaian
                                        </p>
                                        <div class="text-sm text-warning-500">
                                            @if ($course->rating_value >= 1)
                                                <i class="fa-solid fa-star mr-1.5"></i>
                                            @endif
                                            @if ($course->rating_value >= 2)
                                                <i class="fa-solid fa-star mr-1.5"></i>
                                            @endif
                                            @if ($course->rating_value >= 3)
                                                <i class="fa-solid fa-star mr-1.5"></i>
                                            @endif
                                            @if ($course->rating_value >= 4)
                                                <i class="fa-solid fa-star mr-1.5"></i>
                                            @endif
                                            @if ($course->rating_value >= 5)
                                                <i class="fa-solid fa-star"></i>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <div class="grid grid-cols-5 mb-2">
                                            <div class="flex items-center text-xs font-normal text-neutral-400">
                                                5 star
                                            </div>
                                            <div class="col-span-4 flex items-center">
                                                <div class="w-full bg-neutral-100 rounded-full h-1">
                                                    <div class="bg-warning-500 h-1 rounded-full" style="width: 50%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-5 mb-2">
                                            <div class="flex items-center text-xs font-normal text-neutral-400">
                                                4 star
                                            </div>
                                            <div class="col-span-4 flex items-center">
                                                <div class="w-full bg-neutral-100 rounded-full h-1">
                                                    <div class="bg-warning-500 h-1 rounded-full" style="width: 35%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-5 mb-2">
                                            <div class="flex items-center text-xs font-normal text-neutral-400">
                                                3 star
                                            </div>
                                            <div class="col-span-4 flex items-center">
                                                <div class="w-full bg-neutral-100 rounded-full h-1">
                                                    <div class="bg-warning-500 h-1 rounded-full" style="width: 10%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-5 mb-2">
                                            <div class="flex items-center text-xs font-normal text-neutral-400">
                                                2 star
                                            </div>
                                            <div class="col-span-4 flex items-center">
                                                <div class="w-full bg-neutral-100 rounded-full h-1">
                                                    <div class="bg-warning-500 h-1 rounded-full" style="width: 54%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-5 mb-2">
                                            <div class="flex items-center text-xs font-normal text-neutral-400">
                                                1 star
                                            </div>
                                            <div class="col-span-4 flex items-center">
                                                <div class="w-full bg-neutral-100 rounded-full h-1">
                                                    <div class="bg-warning-500 h-1 rounded-full" style="width: 20%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="list-komentar">
                                @foreach ($course->reviews as $review)
                                    @if (!empty($review->review) && !empty($review->user))
                                        <div class="rounded-lg border border-neutral-200 overflow-hidden mb-3 lg:mb-4">
                                            <div class="py-4 px-6 flex items-center bg-brand-50">
                                                <div
                                                    class="flex items-center justify-center w-6 lg:w-8 h-6 lg:h-8 rounded-full bg-brand-200 text-brand-500 mr-2 lg:mr-4">
                                                    <i class="fa-regular fa-user"></i>
                                                </div>
                                                <p class="text-xs lg:text-sm font-normal text-neutral-500">
                                                    {{ $review->user->name }}
                                                </p>
                                                <div class="w-0.5 h-4 bg-brand-300 mx-4 lg:mx-6"></div>
                                                <div class="flex items-center text-sm font-semibold">
                                                    <p class="text-warning-500 mr-2">
                                                        {{ $review->rating }}
                                                    </p>
                                                    @if ($review->rating >= 1)
                                                        <i class="fa-solid fa-star text-sx text-warning-500 mr-1"></i>
                                                    @endif
                                                    @if ($review->rating >= 2)
                                                        <i class="fa-solid fa-star text-sx text-warning-500 mr-1"></i>
                                                    @endif
                                                    @if ($review->rating >= 3)
                                                        <i class="fa-solid fa-star text-sx text-warning-500 mr-1"></i>
                                                    @endif
                                                    @if ($review->rating >= 4)
                                                        <i class="fa-solid fa-star text-sx text-warning-500 mr-1"></i>
                                                    @endif
                                                    @if ($review->rating >= 5)
                                                    <i class="fa-solid fa-star text-sx text-warning-500"></i>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="p-4">
                                                <div class="min-h-full mb-4">
                                                    <p class="text-sm font-normal text-neutral-500">
                                                        {{ $review->review }}
                                                    </p>
                                                </div>
                                                <p class="text-sm font-normal text-neutral-300">
                                                    {{ tgl_indo(date('Y-m-d', strtotime($review->created_at))) }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--  Kelas Populer  -->
    @php
        $counting_popular = \App\Enroll::select('course_id', DB::raw('COUNT(enrolls.id) AS counting'))
                                            ->join('courses', 'courses.id', '=', 'enrolls.course_id')
                                            ->join('users', 'users.id', '=', 'enrolls.user_id')
                                            ->where('courses.status', 1)
                                            ->where('users.expired_package_at', '>=', date('Y-m-d'))
                                            ->where('courses.category_id', $course->category_id)
                                            ->where('courses.id', '!=', $course->id)
                                            ->orderBy('counting', 'DESC')
                                            ->groupBy('course_id')->get()->toArray();
        $featured_courses = [];
        foreach ($counting_popular as $key => $value) {
            $featured_courses[] = \App\Course::with('category')
                                            ->where('id', $value['course_id'])
                                            ->first()->toArray();
        }
    @endphp

    <section class="px-6 lg:px-36 pt-5 lg:pt-16 pb-6 lg:pb-16 img-kelas-serupa-mobile lg:img-kelas-serupa-desktop">
        <div class="container mx-auto">
            <div class="flex justify-between items-end px-1.5 mb-6 lg:mb-8">
                <div>
                    <h3 class="text-xl lg:text-3xl font-semibold text-white mb-2">
                        Kelas Serupa
                    </h3>
                    <p class="text-sm lg:text-base font-normal text-white ">
                        Jelajahi Kelas terbaik sesuai syariat dan ilmu praktisi
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
                                        Program {{$item['category']['category_name']}}
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

@endsection

@section('page-js')
    <script>
        if ($(".listcontents").length) {
            $('.listcontents').btnLoadmore({
                showItem: 10,
                whenClickBtn: 10,
                textBtn: "Lihat lagi",
                classBtnTrigger: "btn-loadmore",
                classBtn: "mt-4 w-full text-sm lg:text-base font-normal hover:text-brand-500 text-neutral-500 bg-white py-2.5 px-4 lg:px-6 text-center rounded-lg border border-neutral-300"
            });
        }
        if ($(".list-komentar").length) {
            $('.list-komentar').btnLoadmore({
                showItem: 3,
                whenClickBtn: 3,
                textBtn: "Lihat lagi",
                classBtnTrigger: "btn-loadmore2",
                classBtn: "w-full text-sm lg:text-base font-normal hover:text-brand-500 text-neutral-500 bg-white py-2.5 px-4 lg:px-6 text-center rounded-lg border border-neutral-300"
            });
        }
        // list-komentar
    </script>
@endsection