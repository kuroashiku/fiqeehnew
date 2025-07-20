@extends('layouts.theme')


@section('content')

    @php
        $courses = \App\Wishlist::with('course.media')->where('user_id', \Auth::user()->id)->get();
    @endphp

    <div class="categories-course-wrapper my-4 pt-5" style="padding-bottom: 0px!important;">
        <div class="container color-white">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center section-header-wrap">
                        <h2>KELAS FAVORIT</h2>
                    </div>
                </div>
            </div>

            <div class="popular-courses-cards-wrap mt-3">

                <div class="row" style="margin-left: 10px;margin-right: 10px;">
                    <div class="col-md-12">
                        <div class="owl-carousel owl-theme">
                            @foreach ($courses as $course)
                                @if (isset($course['course']['status']) && (int) $course['course']['status'] == 1)
                                    <div class="course-card mt-3 mb-5">
                                        <div class="course-card-img-wrap">
                                            <a href="@if (Auth::user() && $course['course']['continue_url']) {{route('get_free_enroll', $course['course']['slug'])}} @else {{route('login')}} @endif">
                                                <img src="{{$course['course']['thumbnail_url']}}" class="img-fluid">
                                            </a>
                                            <button class="course-card-add-wish btn btn-link btn-sm p-0" data-course-id="{{$course['course']['id']}}">
                                                @if($auth_user && in_array($course['course']['id'], $auth_user->get_option('wishlists', []) ))
                                                    <i class="la la-heart"></i>
                                                @else
                                                    <i class="la la-heart-o"></i>
                                                @endif
                                            </button>
                                        </div>
                                        <div class="course-card-contents">
                                            <a href="@if (Auth::user() && $course['course']['continue_url']) {{route('get_free_enroll', $course['course']['slug'])}} @else {{route('login')}} @endif">
                                                <h4 class="course-card-title mb-3 text-center"><b>{{$course['course']['title']}}</b></h4>
                                                <p class="text-center" style="height: 100px;">{{$course['course']['short_description']}}</p>
                                            </a>
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

@endsection
