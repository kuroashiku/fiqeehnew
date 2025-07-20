@extends(theme('layout-full'))

@section('content')

    <!-- Kelas -->
    <section class="px-6 pt-4 lg:px-36 lg:pt-10">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-10 md:gap-6">
                <div class="md:col-span-6 lg:col-span-7 mb-16">
                    <div class="video relative mb-6 lg:mb-8">
                        @if($lecture->video_info())
                            @php
                                $src_youtube = $lecture->video_info('source_youtube');
                            @endphp
                            <div class="plyr__video-embed" id="player">
                                <iframe src="{{ $src_youtube }}"
                                allowfullscreen
                                allowtransparency
                                allow="autoplay"
                                ></iframe>
                            </div>
                        @endif
                        
                        @if($lecture->attachments->count())
                            <div class="rounded-2xl bg-brand-50 p-6 lg:px-10 lg:py-14">
                                @foreach($lecture->attachments as $attachment)
                                    @if($attachment->media)
                                        <div class="rounded-2xl bg-white text-center py-8 px-6 lg:p-8" style="padding: 1rem;">
                                            @php
                                                $data = \App\Attachment::whereHashId($attachment->hash_id)->first();
                                                $explodeExt = explode('.', $data->media->name);
                                                $ext = end($explodeExt);
                                                
                                                $source = get_option('default_storage');
                                                $slug_ext = $data->media->slug_ext;
                                            @endphp
                                            @if ($ext == 'pdf')
                                                <iframe src="https://docs.google.com/viewer?url={{ env('APP_URL')."/uploads/{$data->media->slug_ext}&embedded=true" }}" class="mx-auto mb-6" frameborder="0" width="100%" height="400px"></iframe>
                                            @elseif (substr($data->media->mime_type, 0, 5) == 'image')
                                                <img src="{{ env('APP_URL')."/uploads/images/{$data->media->slug_ext}"."#toolbar=0" }}" class="w-32 lg:w-40 mx-auto mb-6" style="width: 100%;" alt="Cover">
                                            @else
                                                <img src="{{ asset('assets/images/dokumen/default.jpg') }}" class="w-32 lg:w-40 mx-auto mb-6" alt="Cover">
                                            @endif
                                            <a href="{{route('attachment_download', $attachment->hash_id)}}" target="_blank" class="inline-block w-full lg:w-auto text-sm lg:text-base font-normal text-brand-50 py-2.5 px-20 rounded-lg bg-brand-500 ">
                                                Download
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        @php
                            $previous = $content->previous;
                        @endphp
                        @if ($content->previous)
                            <a href="{{ route('single_lecture_slug', [$course->slug, $previous->slug]) }}"
                                class="absolute left-0 top-2/4 -translate-y-2/4 bg-white bg-opacity-70 lg:px-1 py-4 lg:py-6 text-sm font-normal text-white">
                                <i class="fa-solid fa-arrow-left p-0.5"></i>
                            </a>
                        @endif
                        {{-- <a href="{{ route('content_complete', $lecture->id) }}"
                            class="absolute right-0 top-2/4 -translate-y-2/4 bg-white bg-opacity-70 lg:px-1 py-4 lg:py-6 text-sm font-normal text-white" style="background: #0093DD;">
                            <i class="fa-solid fa-arrow-right p-0.5"></i>
                        </a> --}}
                    </div>

                    <!-- ONLY MOBILE -->
                    <div class="block md:hidden">
                        @if($auth_user)
                            @php
                                $drip_items = $course->drip_items;
                                $review = has_review($auth_user->id, $course->id);
                                $completed_percent = $course->completed_percent();
                                if ($completed_percent > 100) {
                                    $completed_percent = 100;
                                }
                            @endphp
                            <div class="mb-6">
                                <h4 class="text-lg lg:text-2xl font-semibold font-neutral-500 mb-1">
                                    {{ $course->title }}
                                </h4>
                                <p class="text-xs font-normal text-success-600">
                                    {{$completed_percent}}% selesai
                                </p>
                                @if($completed_percent == 100)
                                    <a href="#" class="text-center d-block write-review-text" data-toggle="modal" data-target="#writeReviewModal">
                                        <i class="la la-comment"></i> {{ $review ? __t('update_review') : __t('write_review')}}
                                    </a>
                                    @php
                                        \App\Complete::updateOrCreate([
                                            'user_id'               => $auth_user->id,
                                            'completed_course_id'   => $course->id
                                        ]);
                                    @endphp
                                @endif
                            </div>
                        @endif
                    </div>

                    <div>
                        <div class="mb-6 border-y-2 border-neutral-50">
                            <ul class="flex flex-wrap -mb-px text-xs lg:text-sm font-medium text-center text-neutral-300"
                                id="tabExample" role="tablist">
                                <li class="md:hidden mr-8 lg:mr-16" role="presentation">
                                    <button
                                        class="inline-block md:hidden py-3 rounded-t-lg border-b-2 border-transparent hover:text-gray-600"
                                        id="deskripsi-tab-header-marketplace" type="button" role="tab"
                                        aria-controls="deskripsi-tab-content" aria-selected="false">
                                        Deskripsi
                                    </button>
                                </li>
                                <li class="mr-8 lg:mr-16" role="presentation">
                                    <button
                                        class="inline-block py-3 rounded-t-lg border-b-2 border-transparent hover:text-gray-600"
                                        id="konten-tab-header" type="button" role="tab"
                                        aria-controls="konten-tab-content" aria-selected="false">
                                        Konten
                                    </button>
                                </li>
                                <li class="mr-8 lg:mr-16" role="presentation">
                                    <button
                                        class="inline-block py-3 rounded-t-lg border-b-2 border-transparent hover:text-gray-600"
                                        id="ulasan-tab-header" type="button" role="tab"
                                        aria-controls="ulasan-tab-content" aria-selected="false">
                                        Ulasan
                                    </button>
                                </li>
                                <li role="presentation">
                                    <button
                                        class="btnKelasTerkait inline-block py-3 rounded-t-lg border-b-2 border-transparent hover:text-gray-600"
                                        id="terkait-tab-header" type="button" role="tab"
                                        aria-controls="terkait-tab-content" aria-selected="false">
                                        Terkait
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div id="tabContent">
                            <div class="hidden" id="deskripsi-tab-content" role="tabpanel"
                                aria-labelledby="deskripsi-tab-header">
                                <p class="text-base lg:text-lg font-semibold text-neutral-500 mb-2 lg:mb-4">
                                    DESKRIPSI
                                </p>
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
                                <div class="text-sm lg:text-base font-normal text-neutral-500 kelasDesc">
                                    {!! $lecture->text !!}
                                </div>
                            </div>

                            <!-- ONLY MOBILE -->
                            <div class="hidden" id="konten-tab-content" role="tabpanel"
                                aria-labelledby="konten-tab-header">
                                @if($course->sections->count())
                                    @foreach($course->sections as $section)
                                        <div class="mb-4">
                                            @if($section->items->count())
                                                <p class="text-xs font-semibold text-neutral-300 uppercase mb-4">
                                                    {{$section->section_name}}
                                                </p>
                                                <div id="course-section-detail-{{$section->id}}" class="border border-brand-100 rounded-lg overflow-hidden">
            
                                                    @foreach($section->items as $item)

                                                        @php
                                                            $is_completed = false;
                                                            if ($auth_user){
                                                                $checkCourse = \App\Complete::where('user_id', $auth_user->id)
                                                                ->where('completed_course_id', $item->course_id)->first();
                                                                if ($checkCourse) {
                                                                    $is_completed = true;
                                                                } else {
                                                                    $checkContent = \App\Complete::where('user_id', $auth_user->id)
                                                                    ->where('content_id', $item->id)->first();
                                                                    if ($checkContent) {
                                                                        $is_completed = true;
                                                                    }
                                                                }
                                                            }
                                                            $runTime = $item->runtime;
                                                        @endphp

                                                        @if ($item->id == $lecture->id)
                                                            <a href="@if($item->item_type == 'lecture')
                                                                {{route('markeplace_view', [$course->slug, $item->slug ] )}}
                                                            @else
                                                                {{route('single_'.$item->item_type, [$course->slug, $item->id ] )}}
                                                            @endif">
                                                                <div
                                                                    class="flex items-center justify-between px-4 py-2.5 border-b border-brand-100 bg-neutral-500">
                                                                    <div class="text-sm font-normal text-white">
                                                                        @if ($item->item_type == 'lecture')
                                                                            @if (!empty($runTime))
                                                                                <i class="fa-regular fa-circle-play"></i>
                                                                            @else
                                                                                <i class="fa-solid fa-paperclip -rotate-45"></i>
                                                                            @endif
                                                                        @else
                                                                            <i class="fa-regular fa-file-lines"></i>
                                                                        @endif
                                                                        <span class="ml-2">{{$item->title}}</span>
                                                                    </div>
                                                                    <div class="text-sm font-normal text-white">
                                                                        @if($is_completed)
                                                                            <i class="fa-solid fa-check text-success-500"></i>
                                                                        @endif
                                                                        @if ($item->item_type == 'lecture' && empty($item->vide_src))
                                                                            {{ $runTime }}
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        @else
                                                            <a href="@if($item->item_type == 'lecture')
                                                                {{route('markeplace_view', [$course->slug, $item->slug ] )}}
                                                            @else
                                                                {{route('single_'.$item->item_type, [$course->slug, $item->id ] )}}
                                                            @endif">
                                                                <div class="flex items-center justify-between px-4 py-2.5 border-b border-brand-100 flex items-center justify-between px-4 py-2.5">
                                                                    <div class="text-sm font-normal text-neutral-300">
                                                                        @if ($item->item_type == 'lecture')
                                                                            @if (!empty($runTime))
                                                                                <i class="fa-regular fa-circle-play"></i>
                                                                            @else
                                                                                <i class="fa-solid fa-paperclip -rotate-45"></i>
                                                                            @endif
                                                                        @else
                                                                            <i class="fa-regular fa-file-lines"></i>
                                                                        @endif
                                                                        <span class="ml-2">{{$item->title}}</span>
                                                                    </div>
                                                                    <div class="text-sm font-normal text-neutral-300">
                                                                        @if($is_completed)
                                                                            <i class="fa-solid fa-check text-success-500"></i>
                                                                        @endif
                                                                        @if ($item->item_type == 'lecture' && empty($item->vide_src))
                                                                            {{ $runTime }}
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <!-- END ONLY MOBILE -->

                            <div class="hidden" id="ulasan-tab-content" role="tabpanel"
                                aria-labelledby="ulasan-tab-header">
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
                                                        <div class="bg-warning-500 h-1 rounded-full" style="width: 50%"></div>
                                                      </div>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-5 mb-2">
                                                <div class="flex items-center text-xs font-normal text-neutral-400">
                                                    4 star
                                                </div>
                                                <div class="col-span-4 flex items-center">
                                                    <div class="w-full bg-neutral-100 rounded-full h-1">
                                                        <div class="bg-warning-500 h-1 rounded-full" style="width: 35%"></div>
                                                      </div>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-5 mb-2">
                                                <div class="flex items-center text-xs font-normal text-neutral-400">
                                                    3 star
                                                </div>
                                                <div class="col-span-4 flex items-center">
                                                    <div class="w-full bg-neutral-100 rounded-full h-1">
                                                        <div class="bg-warning-500 h-1 rounded-full" style="width: 10%"></div>
                                                      </div>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-5 mb-2">
                                                <div class="flex items-center text-xs font-normal text-neutral-400">
                                                    2 star
                                                </div>
                                                <div class="col-span-4 flex items-center">
                                                    <div class="w-full bg-neutral-100 rounded-full h-1">
                                                        <div class="bg-warning-500 h-1 rounded-full" style="width: 54%"></div>
                                                      </div>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-5 mb-2">
                                                <div class="flex items-center text-xs font-normal text-neutral-400">
                                                    1 star
                                                </div>
                                                <div class="col-span-4 flex items-center">
                                                    <div class="w-full bg-neutral-100 rounded-full h-1">
                                                        <div class="bg-warning-500 h-1 rounded-full" style="width: 20%"></div>
                                                      </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rounded-lg border border-neutral-200 p-4 mb-4 lg:mb-6">
                                    <form action="">
                                        <p class="text-base lg:text-lg font-semibold text-brand-500 mb-0.5">
                                            Berikan penilaian
                                        </p>
                                        <p class="text-xs lg:text-sm font-normal text-neutral-400 mb-6">
                                            Penilaian kamu membantu author untuk lebih berkembang!
                                        </p>
                                        <div class="text-2xl mb-2">
                                            <i class="click-rating fa-solid fa-star text-neutral-200 cursor-pointer mr-4"></i>
                                            <i class="click-rating fa-solid fa-star text-neutral-200 cursor-pointer mr-4"></i>
                                            <i class="click-rating fa-solid fa-star text-neutral-200 cursor-pointer mr-4"></i>
                                            <i class="click-rating fa-solid fa-star text-neutral-200 cursor-pointer mr-4"></i>
                                            <i class="click-rating fa-solid fa-star text-neutral-200 cursor-pointer"></i>
                                        </div>
                                        <input type="text" id="jumlahRating" name="jumlahRating" class="hidden" required>
                                        <textarea name="pesan" id="pesan" rows="4" class="text-sm lg:text-base font-normal text-neutral-500 placeholder:text-neutral-300 rounded-lg border border-neutral-300 focus:outline-none focus:border-b-2 focus:ring-0 focus:border-brand-500 focus:ring-brand-500 w-full py-2 px-2.5 mb-6" placeholder="Tulis pesan jika dibutuhkan"></textarea>
                                        <button type="submit" id="submit" name="submit" class="text-sm font-normal text-brand-50 py-2.5 px-4 w-full lg:w-auto bg-brand-500 rounded-lg">
                                            Kirim penilaian
                                        </button>
                                    </form>
                                </div>
                                <div class="list-komentar">
                                    @foreach ($course->reviews as $review)
                                        @if (!empty($review->review) && !empty($review->user))
                                            <div class="rounded-lg border border-neutral-200 overflow-hidden mb-2 lg:mb-4">
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
                                                        added {{ date('d M Y',strtotime($review->created_at)) }}21 January 2022
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="hidden" id="terkait-tab-content" role="tabpanel"
                                aria-labelledby="terkait-tab-header">
                                <p class="text-base lg:text-lg font-semibold text-neutral-500 mb-2 lg:mb-4">
                                    MARKETPLACE TERKAIT
                                </p>
                                <div class="flex justify-center items-center" id="loadingData">
                                    <div role="status">
                                        <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                        </svg>
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div class="relative lg:mx-6" id="dataKelasTerkait">
                                    <div class="kelasTerkait">
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
                        </div>
                    </div>
                </div>

                <!-- ONLY DESKTOP -->
                <div class="hidden md:block md:col-span-4 lg:col-span-3 mb-10">
                    @if($auth_user)
                        @php
                            $drip_items = $course->drip_items;
                            $review = has_review($auth_user->id, $course->id);
                            $completed_percent = $course->completed_percent();
                            if ($completed_percent > 100) {
                                $completed_percent = 100;
                            }
                        @endphp
                        <div class="mb-6">
                            <h4 class="text-2xl font-semibold font-neutral-500 mb-1">
                                {{ $course->title }}
                            </h4>
                            <p class="text-xs font-normal text-success-600">
                                {{$completed_percent}}% selesai
                            </p>
                            @if($completed_percent == 100)
                                <a href="#" class="text-center d-block write-review-text" data-toggle="modal" data-target="#writeReviewModal">
                                    <i class="la la-comment"></i> {{ $review ? __t('update_review') : __t('write_review')}}
                                </a>
                                @php
                                    \App\Complete::updateOrCreate([
                                        'user_id'               => $auth_user->id,
                                        'completed_course_id'   => $course->id
                                    ]);
                                @endphp
                            @endif
                        </div>
                    @endif

                    @if($course->sections->count())
                        @foreach($course->sections as $section)
                            <div class="lecture-sidebar-curriculum-wrap">
                                <div class="mb-4">
                                    @if($section->items->count())

                                        <a data-toggle="collapse" href="#course-section-detail-{{$section->id}}" role="button" aria-expanded="false" aria-controls="course-section-{{$section->id}}">
                                            <p class="text-xs font-semibold text-neutral-300 uppercase mb-4">
                                                {{$section->section_name}}
                                            </p>
                                        </a>
    
                                        <div id="course-section-detail-{{$section->id}}" class="border border-brand-100 rounded-lg overflow-hidden">
    
                                            @foreach($section->items as $item)

                                                @php
                                                    $is_completed = false;
                                                    if ($auth_user){
                                                        $checkCourse = \App\Complete::where('user_id', $auth_user->id)
                                                        ->where('completed_course_id', $item->course_id)->first();
                                                        if ($checkCourse) {
                                                            $is_completed = true;
                                                        } else {
                                                            $checkContent = \App\Complete::where('user_id', $auth_user->id)
                                                            ->where('content_id', $item->id)->first();
                                                            if ($checkContent) {
                                                                $is_completed = true;
                                                            }
                                                        }
                                                    }
                                                    $runTime = $item->runtime;
                                                @endphp

                                                @if ($item->id == $lecture->id)
                                                    <a href="@if($item->item_type == 'lecture')
                                                        {{route('markeplace_view', [$course->slug, $item->slug ] )}}
                                                    @else
                                                        {{route('single_'.$item->item_type, [$course->slug, $item->id ] )}}
                                                    @endif">
                                                        <div
                                                            class="flex items-center justify-between px-4 py-2.5 border-b border-brand-100 bg-neutral-500">
                                                            <div class="text-sm font-normal text-white">
                                                                @if ($item->item_type == 'lecture')
                                                                    @if (!empty($runTime))
                                                                        <i class="fa-regular fa-circle-play"></i>
                                                                    @else
                                                                        <i class="fa-solid fa-paperclip -rotate-45"></i>
                                                                    @endif
                                                                @else
                                                                    <i class="fa-regular fa-file-lines"></i>
                                                                @endif
                                                                <span class="ml-2">{{$item->title}}</span>
                                                            </div>
                                                            <div class="text-sm font-normal text-white">
                                                                @if($is_completed)
                                                                    <i class="fa-solid fa-check text-success-500"></i>
                                                                @endif
                                                                @if ($item->item_type == 'lecture' && empty($item->vide_src))
                                                                    {{ $runTime }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="@if($item->item_type == 'lecture')
                                                        {{route('markeplace_view', [$course->slug, $item->slug ] )}}
                                                    @else
                                                        {{route('single_'.$item->item_type, [$course->slug, $item->id ] )}}
                                                    @endif">
                                                        <div class="flex items-center justify-between px-4 py-2.5 border-b border-brand-100 flex items-center justify-between px-4 py-2.5">
                                                            <div class="text-sm font-normal text-neutral-300">
                                                                @if ($item->item_type == 'lecture')
                                                                    @if (!empty($runTime))
                                                                        <i class="fa-regular fa-circle-play"></i>
                                                                    @else
                                                                        <i class="fa-solid fa-paperclip -rotate-45"></i>
                                                                    @endif
                                                                @else
                                                                    <i class="fa-regular fa-file-lines"></i>
                                                                @endif
                                                                <span class="ml-2">{{$item->title}}</span>
                                                            </div>
                                                            <div class="text-sm font-normal text-neutral-300">
                                                                @if($is_completed)
                                                                    <i class="fa-solid fa-check text-success-500"></i>
                                                                @endif
                                                                @if ($item->item_type == 'lecture' && empty($item->vide_src))
                                                                    {{ $runTime }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection

@section('page-js')
    <script>
        $(document).ajaxSend(function() {
            $("#dataKelasTerkait").addClass("hidden");
            $("#loadingData").removeClass("hidden");
            console.log('ajaxSend')
        });
        if ($(".kelasTerkait").length) {
            $(".btnKelasTerkait").on("click", function (event) {
                $.ajax({
                    type: "GET",
                    url: `{{ env('APP_URL') }}/api/search/course?category_name={{ $course->category->slug }}`,
                    success: function (data) {
                        console.log('ajaxSuccess')
                        $(".kelasTerkait").slick("unslick");
                        $(".kelasTerkait").empty();

                        if(data.length == 0) {
                            $('.prev-program-bisnis').addClass('opacity-0')
                            $('.next-program-bisnis').addClass('opacity-0')
                        } else {
                            $('.prev-program-bisnis').removeClass('opacity-0')
                            $('.next-program-bisnis').removeClass('opacity-0')
                        }

                        for (let i = 0; i < data.length; i++) {
                            const element = data[i];
                            $(".kelasTerkait").append(
                                `<div class="pr-3 pl-0 lg:p-3 slick-slides-program">
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
                        $(".kelasTerkait").slick({
                            infinite: false,
                            slidesPerRow: 4,
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
                            $(".kelasTerkait").slick("slickPrev");
                        });
                        $(".next-program-bisnis").click(function (e) {
                            $(".kelasTerkait").slick("slickNext");
                        });
                        
                        let currentSlide =  $(".kelasTerkait").slick('slickCurrentSlide') + 1
                        let totalSlide = $(".kelasTerkait").slick('getSlick').slideCount  
                        $(".prev-program-bisnis").addClass("slick-disabled");
                        if(currentSlide == totalSlide) {
                            $(".next-program-bisnis").addClass("slick-disabled");
                        }

                        $(".kelasTerkait").on("afterChange", function () {
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
                }).done(function() {
                    console.log('ajaxdone')
                    $("#dataKelasTerkait").removeClass("hidden");
                    $("#loadingData").addClass("hidden");
                });
            });
        }
    </script>
@endsection