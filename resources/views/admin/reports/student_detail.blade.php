@extends('layouts.admin')

@section('content')

@include('admin.reports.menu')

<div class="profile-settings-wrap">

    <h4 class="mb-3">Laporan Survey {{$student->name}}</h4>
    <form>
        @foreach ($surveys as $survey)
            <div class="form-group row">
                <label  class="col-sm-4 col-form-label">{{$survey->question}}</label>
                <div class="col-sm-8">
                    <input type="name" disabled class="form-control" value="{{$survey->answer}}">
                </div>
            </div>
        @endforeach
    </form>

    <h4 class="mb-3">Laporan Course {{$student->name}}</h4>

    <form action="" method="get">

        <div class="courses-actions-wrap">

            <div class="row">
                <div class="col-md-12">
                    <div class="search-filter-form-wrap mb-3">

                        <div class="input-group">
                            <input type="text" class="form-control mr-3" name="q" value="{{request('q')}}" placeholder="student name">
                            <button type="submit" class="btn btn-primary btn-purple mr-3"><i class="la la-search-plus"></i> Filter results</button>
                            <a href="{{route('export_students_detail', $student->id)}}" class="btn btn-success"><i class="la la-download"></i> Export</a>
                        </div>

                    </div>


                </div>
            </div>

        </div>
    </form>

    @if($courses->count())
    <table class="table table-bordered bg-white">

        <tr>
            <th>Title</th>
            <th>Kategori</th>
            <th>Diambil</th>
            {{-- <th>Completed</th> --}}
        </tr>

        @foreach($courses as $course)
        {{-- @php
            $complete = (new \App\Course)->completed_percent($student);
        @endphp --}}
        <tr>
            <td>
                <p>{{$course->title}}</p>
            </td>
            <td>
                <p>{{$course->category_name}}</p>
            </td>
            <td>
                <p>{{date('d F Y', strtotime($course->enrolled_at))}}</p>
            </td>
            {{-- <td>
                <p>{{$complete}}</p>
            </td> --}}
            
        </tr>

        @endforeach

    </table>
    @else
    {!! no_data(null, null, 'my-5' ) !!}
    @endif

    {!! $courses->links() !!}


</div>


@endsection
