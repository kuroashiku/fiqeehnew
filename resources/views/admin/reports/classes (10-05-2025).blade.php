@extends('layouts.admin')

@section('content')

    @include('admin.reports.menu')

    <div class="profile-settings-wrap">

        <h4 class="mb-3">Laporan Classes</h4>

        <form action="" method="get">

            <div class="courses-actions-wrap">

                <div class="row">
                    <div class="col-md-12">
                        <div class="search-filter-form-wrap mb-3">

                            <div class="input-group"> 
                                <input type="text" class="form-control mr-3" name="q" value="{{request('q')}}" placeholder="class name">
                                <button type="submit" class="btn btn-primary btn-purple mr-3"><i class="la la-search-plus"></i> Filter results</button>
                                <a href="{{route('export_classes')}}" class="btn btn-success mr-3"><i class="la la-download"></i> Export Class</a>
                                <a href="{{route('export_program')}}" class="btn btn-success"><i class="la la-download"></i> Export Program</a>
                            </div>

                        </div>


                    </div>
                </div>

            </div>
        </form>

        @if($classes->count())
            <table class="table table-bordered bg-white table-striped">

                <tr>
                    <th>Title</th>
                    <th>Kategori</th>
                    <th>Durasi</th>
                    <th>Level</th>
                    <th>Terakhir di Update</th>
                    {{-- <th>Ditayangkan</th> --}}
                    <th>Status</th>
                    <th>Student</th>
                    <th>Source</th>
                    <th>Action</th>
                </tr>

                @foreach($classes as $class)
                    <tr>
                        <td>
                            <p>{{$class->title}}</p>
                        </td>
                        <td>
                            <ul>
                                @foreach ($class->category_class as $cc)
                                    <li>{{$cc->category->category_name}}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{$class->runtime}}</td>
                        <td>
                            <p>{{course_levels($class->level)}}</p>
                        </td>
                        <td>
                            <p>{{date('d F Y', strtotime($class->last_updated_at))}}</p>
                        </td>
                        <td>
                            @if ($class->status == 1)
                                Published
                            @else
                                Unpublish
                            @endif
                        </td>
                        <td>
                            @php
                                $countUser = \App\Enroll::where('course_id', $class->id)->count();
                            @endphp
                            <p>{{$countUser}}</p>
                        </td>
                        {{-- <td>
                            <p>{{date('d F Y', strtotime($class->published_at))}}</p>
                        </td> --}}
                        <td>
                            @if($class->video_info())
                            @php
                                $src_youtube = $class->video_info('source_youtube');
                            @endphp
                            
                            {{ $src_youtube }}
                        @endif
                        </td>
                        
                        <td>
                            <a href="{{route('edit_course_information', $class->id)}}" class="btn btn-warning"><i class="la la-edit"></i> </a>
                            <a href="{{route('reports_detail_classes', $class->id)}}" class="btn btn-primary"><i class="la la-eye"></i> </a>
                            {{-- <a href="{{route('export_classes_detail', $class->id)}}" class="btn btn-success"><i class="la la-download"></i> </a> --}}
                        </td>
                    </tr>

                @endforeach

            </table>
        @else
            {!! no_data(null, null, 'my-5' ) !!}
        @endif
        
        {!! $classes->links() !!}


    </div>


@endsection
