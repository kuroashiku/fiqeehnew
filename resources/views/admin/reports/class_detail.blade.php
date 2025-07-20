@extends('layouts.admin')

@section('content')

@include('admin.reports.menu')

<div class="profile-settings-wrap">

    <h4 class="mb-3">Laporan Module {{$class->title}}</h4>

    @if($class->sections->count())
        <table class="table table-bordered bg-white">
            @foreach($class->sections as $section)
                <tr>
                    <th>Type</th>
                    <th>Module {{$section->section_name}}</th>
                    <th>Student Complete</th>
                </tr>
                @foreach($section->items as $item)
                    <tr>
                        <td>
                            @if ($item->item_type == 'lecture' && $item->video_src == null)
                                Module
                            @elseif ($item->item_type == 'lecture' && $item->video_src != null)
                                Video
                            @else 
                                Quiz
                            @endif
                        </td>
                        <td>
                            <p>{{$item->title}}</p>
                        </td>
                        <td>
                            @php
                                $countCompleteUser = \App\Complete::where('content_id', $item->id)->count();
                            @endphp
                            <p>{{$countCompleteUser}}</p>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </table>
    @endif

    <h4 class="mb-3">Laporan Student {{$class->title}}</h4>

    {{-- <form action="" method="get">

        <div class="courses-actions-wrap">

            <div class="row">
                <div class="col-md-12">
                    <div class="search-filter-form-wrap mb-3">

                        <div class="input-group">
                            <input type="text" class="form-control mr-3" name="q" value="{{request('q')}}" placeholder="class name">
                            <button type="submit" class="btn btn-primary btn-purple"><i class="la la-search-plus"></i> Filter results</button>
                        </div>

                    </div>


                </div>
            </div>

        </div>
    </form> --}}

    @if($enrolls->count())
    <table class="table table-bordered bg-white">

        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Tanggal Akses</th>
            {{-- <th>Status</th> --}}
        </tr>

        @foreach($enrolls as $enroll)
            @if (isset($enroll->user))
                <tr>
                    <td>
                        <p>{{$enroll->user->name}}</p>
                    </td>
                    <td>
                        <p>{{$enroll->user->email}}</p>
                    </td>
                    <td>
                        <p>{{date('d F Y', strtotime($enroll->enrolled_at))}}</p>
                    </td>
                    {{-- <td>
                        <p>{{$complete}}</p>
                    </td> --}}
                    
                </tr>
            @endif  
        @endforeach

    </table>
    @else
    {!! no_data(null, null, 'my-5' ) !!}
    @endif

    {!! $enrolls->links() !!}


</div>


@endsection
