@extends('layouts.admin')

@section('content')

    <div class="curriculum-top-nav d-flex bg-white mb-5 p-2 border">
        <h4 class="flex-grow-1">{{__t('my_courses')}} </h4>
        <a href="{{route('create_course')}}" class="btn btn-warning">{{__t('create_course')}}</a>
    </div>

    <form action="" method="get">

        <div class="courses-actions-wrap">

            <div class="row">
                <div class="col-md-12">
                    <div class="search-filter-form-wrap mb-3">

                        <div class="input-group">
                            <input type="text" class="form-control mr-3" name="q" value="{{request('q')}}" placeholder="course name">
                            <select name="filter_status" class="mr-3">
                                <option value="">Filter by status</option>
                                <option value="1" {{selected('1', request('filter_status'))}} >publish</option>
                                <option value="2" {{selected('2', request('filter_status'))}} >pending</option>
                                <option value="3" {{selected('3', request('filter_status'))}} >block</option>
                                <option value="4" {{selected('4', request('filter_status'))}} >unpublish</option>
                            </select>
                            <select name="filter_category" class="mr-3">
                                <option value="">Filter by category</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}" {{selected($category->id, request('filter_category'))}} >{{$category->category_name}}</option>
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-primary btn-purple"><i class="la la-search-plus"></i> Filter results</button>
                        </div>

                    </div>


                </div>
            </div>

        </div>
    </form>

    @if($courses->count())
        <table class="table table-bordered bg-white">

            <tr>
                <th>{{__t('thumbnail')}}</th>
                <th>{{__t('title')}}</th>
                <th>{{__t('price')}}</th>
            </tr>

            @foreach($courses as $course)
                <tr>
                    <td>
                        <img src="{{$course->thumbnail_url}}" width="80" />
                    </td>
                    <td>
                        <p class="mb-3">
                            <strong>{{$course->title}}</strong>
                            {!! $course->status_html() !!}
                        </p>

                        <p class="m-0 text-muted">
                            @php
                                $lectures_count = $course->lectures->count();
                                $assignments_count = $course->assignments->count();
                                $quizzes_count = $course->quizzes->count();
                            @endphp

                            <span class="course-list-lecture-count">{{$lectures_count}} {{__t('lectures')}}</span>

                            @if($assignments_count)
                                , <span class="course-list-assignment-count">{{$assignments_count}} {{__t('assignments')}}</span>
                            @endif
                            @if($quizzes_count)
                                , <span class="course-list-quiz-count">{{$quizzes_count}} {{__t('quizzes')}}</span>
                            @endif
                        </p>

                        <div class="courses-action-links mt-1">
                            <a href="{{route('edit_course_information', $course->id)}}" class="font-weight-bold mr-3">
                                <i class="la la-pencil-square-o"></i> {{__t('edit')}}
                            </a>

                            @if($course->status == 1)
                                <a href="{{route('course', $course->slug)}}" class="font-weight-bold mr-3" target="_blank"><i class="la la-eye"></i> {{__t('view')}} </a>
                            @else
                                <a href="{{route('course', $course->slug)}}" class="font-weight-bold mr-3" target="_blank"><i class="la la-eye"></i> {{__t('preview')}} </a>
                            @endif

                            <a href="#" onclick="copyToClip('{{route('course', $course->slug)}}')" class="font-weight-bold mr-3">
                                <i class="la la-link"></i> Share Link
                            </a>

                            @php do_action('my_courses_list_actions_after', $course); @endphp

                        </div>
                    </td>
                    <td>{!! $course->price_html() !!}</td>

                </tr>

            @endforeach

        </table>
    @else
        {!! no_data(null, null, 'my-5' ) !!}
        <div class="no-data-wrap text-center">
            <a href="{{route('create_course')}}" class="btn btn-lg btn-warning">{{__t('create_course')}}</a>
        </div>
    @endif
    
    {!! $courses->links() !!}

@endsection
