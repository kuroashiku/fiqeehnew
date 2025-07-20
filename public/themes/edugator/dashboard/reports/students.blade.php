@extends('layouts.admin')

@section('content')

    @include(theme('dashboard.reports.menu'))

    <div class="profile-settings-wrap">

        <h4 class="mb-3">Laporan Students</h4>

        <form action="" method="get">

            <div class="courses-actions-wrap">

                <div class="row">
                    <div class="col-md-12">
                        <div class="search-filter-form-wrap mb-3">

                            <div class="input-group">
                                <input type="text" class="form-control mr-3" name="q" value="{{request('q')}}" placeholder="student name">
                                <button type="submit" class="btn btn-primary btn-purple mr-3"><i class="la la-search-plus"></i> Filter results</button>
                                <a href="{{route('export_students')}}" class="btn btn-success"><i class="la la-download"></i> Export</a>
                            </div>

                        </div>


                    </div>
                </div>

            </div>
        </form>

        @if($students->count())
            <table class="table table-bordered bg-white">

                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No HP</th>
                    {{-- <th>Daftar</th> --}}
                    <th>Berakhir</th>
                    <th>Action</th>
                </tr>

                @foreach($students as $student)
                    <tr>
                        <td>
                            <p>{{$student->name}}</p>
                        </td>
                        <td>
                            <p>{{$student->email}}</p>
                        </td>
                        <td>
                            <p>{{$student->phone}}</p>
                        </td>
                        {{-- <td>
                            <p>{{date('d F Y', strtotime($student->created_at))}}</p>
                        </td> --}}
                        <td>
                            <p>{{date('d F Y', strtotime($student->expired_package_at))}}</p>
                        </td>
                        <td>
                            <a href="{{route('reports_students', $student->id)}}" class="btn btn-primary"><i class="la la-eye"></i> </a>
                        </td>
                    </tr>

                @endforeach

            </table>
        @else
            {!! no_data(null, null, 'my-5' ) !!}
        @endif
        
        {!! $students->links() !!}


    </div>


@endsection
