
<div class="lecture-sidebar">

    @php do_action('lecture_single_before_course_title', $course, $content); @endphp

    <h4 class="p-4 lecture-sidebar-course-title"><b>{{$course->title}}</b></h4>

    @php do_action('lecture_single_after_course_title', $course, $content); @endphp

    @if($auth_user)
        @php
            $drip_items = $course->drip_items;
            $review = has_review($auth_user->id, $course->id);
            $completed_percent = $course->completed_percent();
        @endphp

        @php do_action('lecture_single_before_progressbar', $course, $content); @endphp

        <div class="lecture-page-course-progress mb-4 px-4 text-center">
            <div class="progress mb-3">
                <div class="progress-bar bg-info" style="width: {{$completed_percent}}%"></div>
            </div>
            <div class="course-progress-percentage text-info d-flex justify-content-between">
                <p class="m-0">
                <span class="percentage">
                    {{$completed_percent}}%
                </span>
                    {{__t('complete')}}
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
        </div>

        @php do_action('lecture_single_after_progressbar', $course, $content); @endphp

    @endif

    @if($course->sections->count())

        <div class="lecture-sidebar-curriculum-wrap">

            @foreach($course->sections as $section)

                <div id="course-section-{{$section->id}}" class="course-course-section mb-4">

                    <div class="section-header p-2 border-bottom d-flex">
                        <span class="section-name flex-grow-1 ml-2 d-flex">
                            <strong class="flex-grow-1">{{$section->section_name}}</strong>

                            @if($auth_user && in_array($section->id, $drip_items['sections']))
                                <i class="la la-lock pt-1"></i>
                            @endif
                            <a data-toggle="collapse" href="#course-section-detail-{{$section->id}}" role="button" aria-expanded="false" aria-controls="course-section-{{$section->id}}">
                                <i class="lab la-buromobelexperte"></i>
                            </a>
                        </span>
                    </div>

                    <div class="course-section-body collapse show" id="course-section-detail-{{$section->id}}">

                        @if($section->items->count())
                            @foreach($section->items as $item)

                                @php
                                    $is_completed = false;
                                    if ($auth_user && $item->is_completed){
                                        $is_completed = true;
                                    }
                                    $runTime = $item->runtime;
                                @endphp

                                <div class="sidebar-section-item {{$item->id == $content->id? 'active' : ''}} {{$is_completed? 'completed' : ''}}">
                                    <div class="section-item-title border-bottom">

                                        <a href="{{route('single_'.$item->item_type, [$course->slug, $item->id ] )}}" class="p-2 d-flex" @if($is_completed) data-toggle="tooltip" title="{{__t('completed')}}" @endif>
                                            <span class="lecture-status-icon border-right pr-1">
                                                @if($is_completed)
                                                    <i class="la la-check-circle text-success"></i>
                                                @else
                                                    <i class="la la-circle"></i>
                                                @endif
                                            </span>
                                            <div class="title-container pl-2 flex-grow-1 d-flex">
                                                <span class="lecture-icon"> {!! $item->icon_html !!}</span>
                                                <span class="lecture-name flex-grow-1">
                                                {{$item->title}} {!! $runTime ? "<small>($runTime)</small>" : "" !!}
                                                </span>

                                                @if($auth_user)
                                                    @if(in_array($section->id, $drip_items['sections']))
                                                        <span><i class="la la-lock pt-1"></i></span>
                                                    @elseif(in_array($item->id, $drip_items['contents']))
                                                        <span><i class="la la-lock pt-1"></i></span>
                                                    @endif
                                                @endif

                                            </div>
                                        </a>

                                    </div>
                                </div>
                            @endforeach

                        @endif


                    </div>

                </div>
            @endforeach

        </div>

    @endif

</div>



@if($auth_user)
    <div class="modal fade" id="writeReviewModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$course->title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{route('save_review', $course->id)}}" method="post">
                    <div class="modal-body">
                        <div id="review-writing-box" class="course-review-write-box-wrap">
                            @csrf

                            @php
                                $ratingValue = 0;
                                $review_text = '';
                                if ($review){
                                    $ratingValue = $review->rating;
                                    $review_text = $review->review;
                                }
                            @endphp
                            {!! star_rating_field($ratingValue) !!}
                            <div class="form-group">
                                <textarea name="review" class="form-control" id="text-review" rows="4">{!! $review_text !!}</textarea>
                            </div>
                            <span class="btn btn-secondary" style="border-radius: 15px;" onclick="addTextFunction('Video kurang jelas ')">Video kurang jelas</span>
                            <span class="btn btn-secondary" style="border-radius: 15px;"    onclick="addTextFunction('Suara putus-putus ')">Suara putus-putus</span>
                            <span class="btn btn-secondary" style="border-radius: 15px;"    onclick="addTextFunction('Metode presentasi kurang pas ')">Metode presentasi kurang pas</span>
                            <span class="btn btn-secondary" style="border-radius: 15px;"    onclick="addTextFunction('Presenter kurang menguasai ')">Presenter kurang menguasai</span>
                            <span class="btn btn-secondary" style="border-radius: 15px;"    onclick="addTextFunction('Modul kurang menarik ')">Modul kurang menarik </span>
                            <script>
                                function addTextFunction(text) {
                                    console.log(text)
                                    document.getElementById("text-review").value += text
                                }
                            </script>
                        </div>
                    </div>
                    <div class="review-modal-footer">
                        <p class="review-modal-nofity-text">
                            <i class="la la-globe"></i> Your review will be posted publicly. Under <strong>{{$auth_user->name}}</strong>
                        </p>

                        <button type="submit" class="btn btn-theme-primary">
                            <i class="la la-comment"></i>
                            @if($review)
                                {{__t('update_review')}}
                            @else
                                {{"Submit Review"}}
                            @endif
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__t('cancel')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
