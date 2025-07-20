<?php
$gridClass = $grid_class ? $grid_class : 'col-md-3';
?>

<div class="{{$gridClass}} course-card-grid-wrap ">
    <div class="course-card mb-5">

        <div class="course-card-img-wrap">
            <a href="{{route('course', $course->slug)}}">
                <img src="{{$course->thumbnail_url}}" class="img-fluid" />
            </a>

            <button class="course-card-add-wish btn btn-link btn-sm p-0" data-course-id="{{$course->id}}">
                @if($auth_user && in_array($course->id, $auth_user->get_option('wishlists', []) ))
                    <i class="la la-heart"></i>
                @else
                    <i class="la la-heart-o"></i>
                @endif
            </button>
        </div>

    </div>
</div>
