@php
    $previous = $content->previous;
    $next = $content->next;
    $is_completed = false;
    if ($auth_user && $content->is_completed){
        $is_completed = true;
    }
    $review = has_review($auth_user->id, $course->id);
@endphp

<div class="lecture-header d-flex">
    <div class="lecture-header-left d-flex">
        <a href="{{route('beranda')}}" class="back-to-curriculum" data-toggle="tooltip" title="Go to beranda">
            <i class="la la-home"></i>
        </a>

        <a href="javascript:;" class="nav-icon-list d-sm-block d-md-none d-lg-none"><i class="la la-list"></i> </a>

        <button class="course-card-add-wish btn btn-link btn-sm p-0" style="position: relative;margin-top: 8px;margin-left: 8px;" data-course-id="{{$course->id}}">
            @if($auth_user && in_array($course->id, $auth_user->get_option('wishlists', []) ))
                <i class="la la-heart"></i>
            @else
                <i class="la la-heart-o"></i>
            @endif
        </button>
        @if($auth_user && $course->completed_percent() == 100 && $course->is_certificate == 1)
            <form action="{{route('course_complete', $course->id)}}" method="post" class="ml-auto">
                @csrf
                <button type="submit" href="javascript:;" @if ($review == null) title="Isi Review Untuk Cetak Sertifikat" disabled @else title="Cetak Sertifikat" @endif  class="nav-icon-complete-course btn btn-success ml-auto" data-toggle="tooltip">
                    <i class="la la-file"></i>
                </button>
            </form>
        @endif
    </div>
    <div class="lecture-header-right d-flex">

        @if($previous)
            <a class="nav-btn" href="{{route('single_'.$previous->item_type, [$course->slug, $previous->id ] )}}" id="lecture_previous_button">

                <span class="nav-text">
                    <i class="la la-arrow-left"></i>
                    Sebelumnya
                </span>
            </a>
        @else
            <a class="nav-btn disabled" id="lecture_previous_button">
                <span class="nav-text"><i class="la la-arrow-left"></i>Sebelumnya</span>
            </a>
        @endif

        @if($next)
            @if($content->item_type === 'lecture')
                <a class="nav-btn" href="{{route('content_complete', $content->id )}}" id="lecture_complete_button">
                    <span class="nav-text">
                        @if($is_completed)
                            Lanjut {{$next ? __t($next->item_type) : ''}}
                        @else
                            Lanjut
                        @endif

                        <i class="la la-arrow-right"></i>
                    </span>
                </a>
            @else
                <a class="nav-btn" href="{{route('single_'.$next->item_type, [$course->slug, $next->id ] )}}" id="lecture_complete_button">
                    <span class="nav-text">{{__t('next')}} {{$next ? __t($next->item_type) : ''}} <i class="la la-arrow-right"></i></span>

                </a>
            @endif
        @else

            @if($content->item_type === 'lecture')
                @if($is_completed)
                    <a class="nav-btn disabled" id="lecture_complete_button">
                        <span class="nav-text">{{__t('complete')}} </span>
                    </a>
                @else
                    <a class="nav-btn" href="{{route('content_complete', $content->id)}}" id="lecture_complete_button">
                        <span class="nav-text"> <i class="la la-check-circle"></i> {{__t('complete')}} </span>
                    </a>
                @endif
            @else
                <a class="nav-btn disabled" id="lecture_complete_button">
                    <span class="nav-text">{{__t('next')}} <i class="la la-arrow-right"></i></span>
                </a>
            @endif

        @endif

    </div>
</div>
