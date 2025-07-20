@extends('layouts.admin')

@section('page-header-right')

    {{-- <a href="{{route('admin_courses', ['filter_by' => 'popular'])}}" class="ml-4"> <i class="la la-bolt"></i> {{__a('popular_courses')}}  </a> --}}
    <a href="{{route('admin_courses', ['filter_by' => 'featured'])}}" class="ml-4"> <i class="la la-bookmark"></i> Recomendation Course </a>

    @if(count(request()->input()))
        <a href="{{route('admin_courses')}}" class="ml-4"> <i class="la la-arrow-circle-left"></i> {{__a('reset_filter')}}  </a>
    @endif
@endsection

@section('content')

    <form action="" method="get">

        <div class="courses-actions-wrap">

            <div class="row">

                <div class="col-md-12">
                    <div class="input-group mb-3">
                        <select name="status" class="mr-3 mt-3">
                            <option value="">{{__a('set_status')}}</option>
                            <option value="1" {{selected('1', request('status'))}} >publish</option>
                            <option value="2" {{selected('2', request('status'))}} >pending</option>
                            <option value="3" {{selected('3', request('status'))}} >block</option>
                            <option value="4" {{selected('4', request('status'))}} >unpublish</option>
                        </select>

                        <button type="submit" name="bulk_action_btn" value="update_status" class="btn btn-primary mt-3 mr-2">
                            <i class="la la-refresh"></i> {{__a('update')}}
                        </button>

                        {{-- <button type="submit" name="bulk_action_btn" value="mark_as_popular" class="btn btn-info mt-3 mr-2">
                            <i class="la la-bolt"></i>{{__a('mark_as_popular')}}
                        </button>

                        <button type="submit" name="bulk_action_btn" value="remove_from_popular" class="btn btn-warning mt-3 mr-2">
                            <i class="la la-bolt"></i> {{__a('remove_from_popular')}}
                        </button> --}}

                        {{-- <button type="submit" name="bulk_action_btn" value="mark_as_feature" class="btn btn-dark mt-3 mr-2">
                            <i class="la la-bookmark"></i> Mark as Recomendation
                        </button>
                        <button type="submit" name="bulk_action_btn" value="remove_from_feature" class="btn btn-warning mt-3 mr-2">
                            <i class="la la-bolt"></i> Remove From Recomendation
                        </button> --}}

                        <button type="submit" name="bulk_action_btn" value="delete" class="btn btn-danger delete_confirm mt-3"> <i class="la la-trash"></i> {{__a('delete')}}</button>

                    </div>
                </div>

                <div class="col-md-12">
                    <div class="search-filter-form-wrap mb-3">
 
                        <div class="input-group">
                            <input type="text" class="form-control mr-3" name="q" value="{{request('q')}}" placeholder="course name">
                            <select name="filter_status" class="mr-3">
                                <option value="">Filter by status</option>
                                <option value="0" {{selected('0', request('filter_status'))}} >draft</option>
                                <option value="1" {{selected('1', request('filter_status'))}} >publish</option>
                                {{-- <option value="2" {{selected('2', request('filter_status'))}} >pending</option>
                                <option value="3" {{selected('3', request('filter_status'))}} >block</option>
                                <option value="4" {{selected('4', request('filter_status'))}} >unpublish</option> --}}
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

        @if($courses->count() > 0)

            <table class="table table-bordered bg-white">

                <tr>
                    <td><input class="bulk_check_all" type="checkbox" /></td>
                    <th>{{__t('thumbnail')}}</th>
                    <th>{{__t('title')}}</th>
                    <th>{{__t('price')}}</th>
                    {{-- <th>#</th> --}}
                </tr>

                @foreach($courses as $course)
                    <tr>
                        <td>
                            <label>
                                <input class="check_bulk_item" name="bulk_ids[]" type="checkbox" value="{{$course->id}}" />
                                <small class="text-muted">#{{$course->id}}</small>
                            </label>
                        </td>
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
                                    $quiz_count = $course->quizzes->count();
                                    $assignments_count = $course->assignments->count();
                                @endphp

                                <span class="course-list-lecture-count">{{$lectures_count}} {{__t('lectures')}}</span>

                                @if($quiz_count)
                                    , <span class="course-list-assignment-count">{{$quiz_count}} {{__t('quizzes')}}</span>
                                @endif
                                @if($assignments_count)
                                    , <span class="course-list-assignment-count">{{$assignments_count}} {{__t('assignments')}}</span>
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

                                <a href="javascript:void(0)" onclick="copyToClip('{{route('course', $course->slug)}}')" class="font-weight-bold mr-3">
                                    <i class="la la-link"></i> Share Overview
                                </a>

                               
                                    <a href="javascript:void(0)" onclick="copyToClip('{{route('get_free_enroll', $course->slug)}}')" class="font-weight-bold mr-3">
                                        <i class="la la-link"></i> Share Kelas
                                    </a>

                                @php do_action('my_courses_list_actions_after', $course); @endphp

                            </div>
                        </td>
                        <td>{!! $course->price_html() !!}</td>

                        {{-- <td>

                            @if($course->status == 1)
                                <a href="{{route('course', $course->slug)}}" class="btn btn-sm btn-primary mt-2" target="_blank"><i class="la la-eye"></i> {{__t('view')}} </a>
                            @else
                                <a href="{{route('course', $course->slug)}}" class="btn btn-sm btn-purple mt-2" target="_blank"><i class="la la-eye"></i> {{__t('preview')}} </a>
                            @endif

                        </td> --}}
                    </tr>

                @endforeach

            </table>

            {!! $courses->appends(['q' => request('q'), 'status'=> request('status'), 'filter_status'=> request('filter_status'), 'filter_category'=> request('filter_category') ])->links() !!}

        @else
            {!! no_data() !!}
        @endif

    </form>


@endsection
