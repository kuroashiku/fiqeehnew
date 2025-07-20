@extends('layouts.admin')

@section('content')

@include('admin.reports.menu')

    <div class="profile-settings-wrap">

        <h4 class="mb-3">Laporan Students</h4>

        <form action="" method="get">

            <div class="courses-actions-wrap">

                <div class="row">
                    <div class="col-md-12">
                        <div class="search-filter-form-wrap mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control mr-3" name="q" value="{{request('q')}}" placeholder="student name">
                                <input type="date" name="start_date" class="form-control datepicker" value="{{request('start_date')}}">
                                <div class="input-group-addon">to</div> 
                                <input type="date" name="end_date" class="form-control datepicker mr-1" value="{{request('end_date')}}">
                                <button type="submit" name="filter" value="filter" class="btn btn-primary btn-purple mr-2"><i class="la la-search-plus"></i> Filter results</button>
                            </div>
                            <br>
                            <div class="input-group">
                                <button type="submit" name="filter" value="leads" class="btn btn-success mr-2"><i class="la la-download"></i>Leads Payment</button>
                                <button type="submit" name="filter" value="export" class="btn btn-success mr-2"><i class="la la-download"></i> CRM Class</button>
                                <button type="submit" name="filter" value="export_crm" class="btn btn-success mr-2"><i class="la la-download"></i> CRM Product</button>
                                <button type="submit" name="filter" value="export_student_all" class="btn btn-success mr-2"><i class="la la-download"></i> Active Students</button> 
                                <button type="submit" name="filter" value="export_students_expired_all" class="btn btn-success mr-2"><i class="la la-download"></i> Expired Students</button>
                                <button type="submit" name="filter" value="export_retention" class="btn btn-success mr-2"><i class="la la-download"></i> Retention Summary</button>
                                <button type="submit" name="filter" value="export_retention_detail" class="btn btn-success mr-2"><i class="la la-download"></i> Retention Detail</button>
                            </div>
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
                    <th>Afiliasi</th>
                    <th>Daftar</th>
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
                        <td>
                            @if ($student->afiliasi_id != null)
                                @php
                                    $userAfiliasi = \App\User::where('id', $student->afiliasi_id)->first();
                                @endphp
                                <p>{{$userAfiliasi->name}}</p>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <p>{{date('d F Y', strtotime($student->created_at))}}</p>
                        </td>
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
