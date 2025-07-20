@extends('layouts.admin')


@section('content')
    @include(theme('dashboard.courses.course_nav'))

    <div class="curriculum-top-nav d-flex bg-white mb-5 p-2 border">
        <h4 class="flex-grow-1"><i class="la la-list-alt"></i> {{__t('curriculum')}} </h4>
        <a href="{{route('new_section', $course->id)}}" class="btn btn-warning">{{__t('new_section')}}</a>
    </div>

    @if($course->sections->count())
        <div class="dashboard-curriculum-wrap">

            <div id="dashboard-curriculum-sections-wrap">
                @foreach($course->sections as $section)
                    <div id="dashboard-section-{{$section->id}}" class="dashboard-course-section bg-white border mb-4">
                        <div class="dashboard-section-header p-3 border-bottom d-flex">
                            <i class="la la-bars section-move-handler"></i>

                            <span class="dashboard-section-name flex-grow-1 ml-2"><strong>{{$section->section_name}}</strong>
                            </span>

                            <button class="section-item-btn-tool btn px-1 py-0 section-edit-btn "><i class="la la-pencil"></i> </button>

                            <button class="section-item-btn-tool btn btn-outline-danger text-danger px-1 py-0 section-delete-btn ml-3" data-section-id="{{$section->id}}"><i class="la la-trash"></i> </button>
                        </div>


                        <!-- Section Edit Form -->
                        <div class="card-body section-edit-form-wrap" style="display: none;">
                            <form action="{{route('update_section', $section->id)}}" method="post" class="section-edit-form">
                                @csrf
                                <div class="form-group">
                                    <label for="section_name">{{__t('section_name')}}</label>
                                    <input type="text" name="section_name" class="form-control" value="{{$section->section_name}}" >
                                </div>
                                <button type="submit" class="btn btn-warning" name="save" value="save">
                                    <i class="la la-save"></i> {{__t('update_section')}}
                                </button>
                            </form>
                        </div>
                        <!-- END #Section Edit Form -->


                        <div class="dashboard-section-body bg-light p-3">
                            @include(theme('dashboard.courses.section-items'))
                        </div>

                        <div class="section-item-form-wrap"></div>

                        <div class="section-add-item-wrap p-3 bg-dark">
                            <a href="javascript:;" class="add-item-lecture mr-3"> <i class="la la-plus-square"></i> {{__t('lecture')}}</a>
                            <a href="javascript:;" class="create-new-quiz mr-3"> <i class="la la-plus-square"></i> {{__t('quiz')}}</a>
                            <a href="javascript:;" class="new-assignment-btn mr-3"> <i class="la la-plus-square"></i> {{__t('assignments')}}</a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!--  New Lecture Hidden Form HTML -->
            <div id="section-lecture-form-html" style="display: none;">
                <div class="section-item-form-html  p-4 border">
                    <div class="new-lecture-form-header d-flex mb-3 pb-3 border-bottom">
                        <h5 class="flex-grow-1">{{__t('add_lecture')}}</h5>
                        <a href="javascript:;" class="btn btn-outline-dark btn-sm btn-cancel-form" ><i class="la la-close"></i> </a>
                    </div>

                    <div class="curriculum-item-edit-tab list-group list-group-horizontal-md mb-3 text-center  ">
                        <a href="javascript:;" data-tab="#lecture-basic" class="list-group-item list-tab-item list-group-item-action list-group-item-secondary active ">
                            <i class="la la-file-text"></i> {{__t('basic')}}
                        </a>
                        <a href="javascript:;" data-tab="#lecture-video" class="list-group-item list-tab-item list-group-item-action list-group-item-secondary ">
                            <i class="la la-video"></i> {{__t('video')}}
                        </a>
                        <a href="javascript:;" data-tab="#dashboard-lecture-attachments" class="list-group-item list-tab-item list-group-item-action list-group-item-secondary ">
                            <i class="la la-paperclip"></i> {{__t('attachments')}}
                        </a>
                    </div>

                    <form class="curriculum-lecture-form" action="{{route('new_lecture', $course->id)}}" method="post">
                        @csrf

                        <div class="lecture-request-response"></div>


                        <div id="lecture-basic" class="section-item-tab-wrap" style="display: block;">

                            <div class="form-group">
                                <label for="title">{{__t('title')}}</label>
                                <input type="text" name="title" class="form-control" id="title">
                            </div>

                            <div class="form-group">
                                <label for="description">{{__t('description')}}</label>
                                <textarea name="description" class="form-control ajaxCkeditor" rows="5"></textarea>
                            </div>

                            <div class="form-group d-flex">
                                <span class="mr-4">{{__t('free_preview')}}</span>
                                <label class="switch">
                                    <input type="checkbox" name="is_preview" value="1">
                                    <span></span>
                                </label>
                            </div>

                        </div>


                        <div id="lecture-video" class="section-item-tab-wrap" style="display: none;">

                            <div class="lecture-video-upload-wrap">

                                <select name="video[source]" class="lecture_video_source form-control mb-2">
                                    <option value="-1">Select Video Source</option>
                                    <option value="html5">HTML5 (mp4)</option>
                                    <option value="external_url">External URL</option>
                                    <option value="youtube">YouTube</option>
                                    <option value="vimeo">Vimeo</option>
                                    <option value="embedded">Embedded</option>
                                </select>

                                <p class="video-file-type-desc">
                                    <small class="text-muted">Select your preferred video type. (.mp4, YouTube, Vimeo etc.) </small>
                                </p>

                                <div class="video-source-input-wrap mb-5" style="display: none;">

                                    <div class="video-source-item video_source_wrap_html5 border bg-white p-4" style="display: none;">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="video-upload-wrap text-center">
                                                    <i class="la la-cloud-upload text-muted"></i>
                                                    <h5>{{__t('upload_video')}}</h5>
                                                    <p class="mb-2">File Format:  .mp4</p>
                                                    {!! media_upload_form('video[html5_video_id]', __t('upload_video'), null) !!}
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="video-poster-upload-wrap text-center">
                                                    <i class="la la-image text-muted"></i>
                                                    <h5>{{__t('video_poster')}}</h5>
                                                    <small class="text-muted mb-3 d-block">Size: 700x430 pixels. Supports: jpg,jpeg, or png</small>

                                                    {!! image_upload_form('video[html5_video_poster_id]') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="video-source-item video_source_wrap_external_url" style="display: none;">
                                        <input type="text" name="video[source_external_url]" class="form-control" value="" placeholder="External Video URL">
                                    </div>
                                    <div class="video-source-item video_source_wrap_youtube" style="display: none;">
                                        <input type="text" name="video[source_youtube]" class="form-control" value="" placeholder="YouTube Video URL">
                                    </div>
                                    <div class="video-source-item video_source_wrap_vimeo" style="display: none;">
                                        <input type="text" name="video[source_vimeo]" class="form-control" value="" placeholder="Vimeo Video URL">
                                    </div>
                                    <div class="video-source-item video_source_wrap_embedded" style="display: none;">
                                        <textarea name="video[source_embedded]" class="form-control" placeholder="Place your embedded code here"></textarea>
                                    </div>

                                    <div class="video-playback-time-wrap mt-4">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    {{__t('video_runtime')}} - &nbsp;<strong>hh:mm:ss</strong></span>
                                            </div>
                                            <input type="text" class="form-control" name="video[runtime][hours]" value="">
                                            <input type="text" class="form-control" name="video[runtime][mins]" value="">
                                            <input type="text" class="form-control" name="video[runtime][secs]" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="dashboard-lecture-attachments" class="section-item-tab-wrap" style="display: none;">


                            <div class="dashboard-attachments-upload-body border bg-white p-4 mb-4">

                                <div class="attachment-upload-forms-wrap d-flex flex-wrap justify-content-between"></div>

                                <div id="upload-attachments-hidden-form" style="display: none">
                                    <div class="single-attachment-form mb-3 border">
                                        <div class="d-flex p-3">
                                            {!! media_upload_form('attachments[]', __t('upload_attachments')) !!}
                                            <a href="javascript:;" class="btn btn-outline-danger btn-sm btn-remove-lecture-attachment-form ml-4"><i class="la la-close"></i> </a>
                                        </div>
                                    </div>
                                </div>

                                <a href="javascript:;" id="add_more_attachment_btn" class="my-4 d-inline-block btn btn-outline-info"> <i class="la la-plus"></i>  {{__t('attachments')}} </a>

                            </div>

                        </div>

                        <div class="form-group text-right">
                            <button type="button" class="btn btn-outline-info btn-cancel-form"> {{__t('cancel')}}</button>
                            <button type="submit" class="btn btn-info btn-edit-lecture"  name="save" value="save_next"> <i class="la la-save"></i> Save Lecture</button>
                        </div>

                    </form>
                </div>
            </div>

            {{-- <div id="section-lecture-form-html" style="display: none;">
                <div class="section-item-form-html  p-4 border">
                    <div class="new-lecture-form-header d-flex mb-3 pb-3 border-bottom">
                        <h5 class="flex-grow-1">{{__t('add_lecture')}}</h5>
                        <a href="javascript:;" class="btn btn-outline-dark btn-sm btn-cancel-form" ><i class="la la-close"></i> </a>
                    </div>

                    <form class="curriculum-lecture-form" action="{{route('new_lecture', $course->id)}}" method="post">

                        <div class="lecture-request-response"></div>

                        @csrf
                        <div class="form-group">
                            <label for="title">{{__t('title')}}</label>
                            <input type="text" name="title" class="form-control"  >
                        </div>

                        <div class="form-group">
                            <label for="description">{{__t('description')}}</label>
                            <textarea name="description" class="form-control ajaxCkeditor" rows="5"></textarea>
                        </div>

                        <div class="form-group d-flex">
                            <span class="mr-4">{{__t('free_preview')}}</span>
                            <label class="switch">
                                <input type="checkbox" name="is_preview" value="1" >
                                <span></span>
                            </label>
                        </div>

                        <div class="form-group text-right">
                            <button type="button" class="btn btn-outline-info btn-cancel-form"> {{__t('cancel')}}</button>
                            <button type="submit" class="btn btn-info btn-add-lecture"  name="save" value="save_next"> <i class="la la-save"></i> {{__t('add_lecture')}}</button>
                        </div>
                    </form>
                </div>
            </div> --}}

            <!--  New Quiz Hidden Form HTML -->
            <div id="section-quiz-form-html" style="display: none;">
                <div class="section-item-form-html p-4 border">
                    <div class="new-quiz-form-header d-flex mb-3 pb-3 border-bottom">
                        <h5 class="flex-grow-1">{{__t('create_quiz')}}</h5>
                        <a href="javascript:;" class="btn btn-outline-dark btn-sm btn-cancel-form" ><i class="la la-close"></i> </a>
                    </div>

                    <form class="curriculum-quiz-form" action="{{route('new_quiz', $course->id)}}" method="post">

                        <div class="quiz-request-response"></div>

                        @csrf
                        <div class="form-group">
                            <label for="title">{{__t('title')}}</label>
                            <input type="text" name="title" class="form-control"  >
                        </div>

                        <div class="form-group">
                            <label for="description">{{__t('description')}}</label>
                            <textarea name="description" class="form-control ajaxCkeditor" rows="5"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-outline-info btn-cancel-form"> {{__t('cancel')}}</button>
                            <button type="submit" class="btn btn-info btn-add-quiz"  name="save" value="save_next"> <i class="la la-save"></i> {{__t('create_new_quiz')}}</button>
                        </div>
                    </form>
                </div>
            </div>


            <!--  New Assignment Hidden Form HTML -->
            <div id="new-assignment-form-html" style="display: none;">
                <div class="section-item-form-html p-4 border">
                    <div class="new-assignment-form-header d-flex mb-3 pb-3 border-bottom">
                        <h5 class="flex-grow-1">{{__t('new_assignment')}}</h5>
                        <a href="javascript:;" class="btn btn-outline-dark btn-sm btn-cancel-form" ><i class="la la-close"></i> </a>
                    </div>

                    <form class="new-assignment-form" action="{{route('new_assignment', $course->id)}}" method="post" enctype="multipart/form-data">

                        <div class="assignment-request-response"></div>

                        @csrf
                        <div class="form-group">
                            <label for="title">{{__t('title')}}</label>
                            <input type="text" name="title" class="form-control"  >
                        </div>

                        <div class="form-group">
                            <label for="description">{{__t('description')}}</label>
                            <textarea name="description" class="form-control ajaxCkeditor" rows="5"></textarea>
                        </div>

                        <div class="form-group border-bottom py-3">

                            <div class="form-row">
                                <div class="col">
                                    <label>{{__t('time_duration')}}</label>
                                    <div class="form-row">
                                        <div class="col">
                                            <input type="number" class="form-control" name="assignment_option[time_duration][time_value]" value="0">
                                        </div>

                                        <div class="col">
                                            <select class="form-control" name="assignment_option[time_duration][time_type]">
                                                <option value="weeks">Weeks</option>
                                                <option value="days">Days</option>
                                                <option value="hours">Hours</option>
                                            </select>
                                        </div>
                                    </div>
                                    <small class="text-muted">Assignment time duration, set 0 for no limit.</small>
                                </div>

                                <div class="col">
                                    <label>{{__t('total_number')}}</label>
                                    <input type="text" name="assignment_option[total_number]" value="10" class="form-control"  >
                                    <small class="text-muted">{{__t('total_number_desc')}}</small>
                                </div>
                                <div class="col">
                                    <label>{{__t('minimum_pass_number')}}</label>
                                    <input type="text" name="assignment_option[pass_number]" value="5" class="form-control"  >
                                    <small class="text-muted">{{__t('minimum_pass_number_desc')}}</small>
                                </div>

                            </div>
                        </div>


                        <div class="form-group py-3">

                            <div class="form-row">

                                <div class="col">
                                    <label>{{__t('upload_attachment_limit')}}</label>
                                    <input type="text" name="assignment_option[upload_attachment_limit]" value="1" class="form-control"  >
                                    <small class="text-muted">
                                        {{__t('max_attach_size_limit')}}
                                    </small>
                                </div>

                                <div class="col">
                                    <label>{{__t('max_attach_size_limit')}}</label>
                                    <input type="text" name="assignment_option[upload_attachment_size_limit]" value="5" class="form-control"  >
                                    <small class="text-muted">
                                        {{__t('max_attach_size_limit_desc')}}
                                    </small>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="dashboard-attachments-upload-body border bg-white p-4 mb-4">

                                <div class="attachment-upload-forms-wrap d-flex flex-wrap justify-content-between"></div>

                                <div id="upload-attachments-hidden-form" style="display: none">
                                    <div class="single-attachment-form mb-3 border">
                                        <div class="d-flex p-3">
                                            {!! media_upload_form('attachments[]', __t('upload_attachments')) !!}
                                            <a href="javascript:;" class="btn btn-outline-danger btn-sm btn-remove-lecture-attachment-form ml-4"><i class="la la-close"></i> </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:;" id="add_more_attachment_btn" class="mt-4 mb-2 d-inline-block btn btn-outline-info"> <i class="la la-plus"></i>  {{__t('attachments')}} </a>

                                <p class="m-0"> <small class="text-muted">{{__t('assignment_resources_desc')}}</small></p>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="button" class="btn btn-outline-info btn-cancel-form"> {{__t('cancel')}}</button>
                            <button type="submit" class="btn btn-info btn-add-assignment"  name="save" value="save_next"> <i class="la la-save"></i> {{__t('new_assignment')}}</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    @else

        <div class="card">
            <div class="card-body">
                {!! no_data(null, null, 'my-5') !!}
                <div class="no-data-wrap text-center my-5">
                    <a href="{{route('new_section', $course->id)}}" class="btn btn-lg btn-warning">{{__t('new_section')}}</a>
                </div>
            </div>
        </div>
    @endif


@endsection

