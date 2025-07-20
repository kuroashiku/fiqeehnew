@extends('layouts.admin')

@section('content')

    @php
    $reviews = \App\Review::with('course', 'user', 'user.photo_query')->orderBy('created_at', 'desc')->whereNotNull('review')->paginate(20);
    $pagenya = (request()->page) ? request()->page : 1;
    @endphp

    @if($reviews->total())

        <p class="text-muted mb-3"> Showing {{$reviews->count() * $pagenya }} data from {{$reviews->total()}} results </p>


        @foreach($reviews as $review)
            <div class="my-review p-4 mb-3 bg-white border">

                <div class="d-flex mb-3">

                    <div class="reviewed-user-detail">

                        <span class="mb-2 d-block">
                            {!! $review->user->name !!}
                        </span>

                        <div class="d-flex" style="color: #f4c150;">
                            {!! star_rating_generator($review->rating) !!}
                            <span class="ml-2">({{$review->rating}})</span>
                            <a href="{{route('review', $review->id)}}" class="text-muted d-block ml-3" >{{$review->created_at->diffForHumans()}}</a>
                        </div>

                    </div>

                </div>


                @if (isset($review->course->id))
                    <h4><a href="{{route('course', $review->course->slug)}}" class="mb-3 d-block">{{$review->course->title}}</a></h4>
                @endif
                
                @if($review->review)
                    <div class="review-desc mt-3">
                        {!! nl2br($review->review) !!}
                    </div>
                @endif
            </div>
        @endforeach

        {!! $reviews->links(); !!}
    @else
        {!! no_data(null, null, 'my-5' ) !!}
    @endif

@endsection
