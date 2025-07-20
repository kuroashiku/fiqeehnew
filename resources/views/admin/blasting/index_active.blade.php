@extends('layouts.admin')

@section('page-header-right')
    @if(count(request()->input()))
        <a href="{{route('admin_blasting_ac')}}"> <i class="la la-arrow-circle-left"></i> {{__a('reset_filter')}}  </a>
    @endif
@endsection

@section('content')

    <form method="get">

        <div class="row">

            <div class="col-md-12">

                {{-- <div class="form-group row ">
                    <label for="additional_css" class="col-sm-4 control-label">User yang pernah membeli Produk?</label>
                    <div class="col-sm-8">
                        <select name="product" class="form-control mr-1">
                            <option value="">Select Product...</option>
                            @foreach ($product as $item)
                                <option value="{{ $item->product }}">{{ $item->product }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}
                <div class="form-group row ">
                    <label for="additional_css" class="col-sm-4 control-label">User yang terakhir membeli Produk?</label>
                    <div class="col-sm-8">
                        <select name="last_product" class="form-control mr-1">
                            <option value="">Select Last Product...</option>
                            @foreach ($product as $item)
                                <option @if ($item->product == @$_GET['last_product']) selected @endif value="{{ $item->product }}">{{ $item->product }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="additional_css" class="col-sm-4 control-label">User yang berusia?</label>
                    <div class="col-sm-8">
                        <select name="age" class="form-control mr-1">
                            <option value="">Select Age Range...</option>
                            <option @if ("18 - 24" == @$_GET['age']) selected @endif value="18 - 24">18 - 24</option>
                            <option @if ("25 - 29" == @$_GET['age']) selected @endif value="25 - 29">25 - 29</option>
                            <option @if ("30 - 34" == @$_GET['age']) selected @endif value="30 - 34">30 - 34</option>
                            <option @if ("35 - 39" == @$_GET['age']) selected @endif value="35 - 39">35 - 39</option>
                            <option @if ("40 - 44" == @$_GET['age']) selected @endif value="40 - 44">40 - 44</option>
                            <option @if ("45 - 49" == @$_GET['age']) selected @endif value="45 - 49">45 - 49</option>
                            <option @if ("50 - 54" == @$_GET['age']) selected @endif value="50 - 54">50 - 54</option>
                            <option @if ("> 55" == @$_GET['age']) selected @endif value="> 55">> 55</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="additional_css" class="col-sm-4 control-label">User berada di Provinsi?</label>
                    <div class="col-sm-8">
                        <select name="city" class="form-control mr-1">
                            <option value="">Select Province...</option>
                            @foreach ($province as $item)
                                <option @if ($item->provinsi == @$_GET['city']) selected @endif value="{{ $item->provinsi }}">{{ $item->provinsi }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="recipient-name" class="col-sm-4 control-label">User yang memiliki profesi?</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="job_title" id="job_title">
                            <option value="">Select Profession...</option>
                            <option @if ("Pengusaha" == @$_GET['job_title']) selected @endif value="Pengusaha">Pengusaha</option>
                            <option @if ("Pegawai" == @$_GET['job_title']) selected @endif value="Pegawai">Pegawai</option>
                            <option @if ("Ibu Rumah Tangga" == @$_GET['job_title']) selected @endif value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                            <option @if ("Mahasiswa" == @$_GET['job_title']) selected @endif value="Mahasiswa">Mahasiswa</option>
                            <option @if ("Belum bekerja" == @$_GET['job_title']) selected @endif value="Belum bekerja">Belum bekerja</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="additional_css" class="col-sm-4 control-label">User yang memiliki employee?</label>
                    <div class="col-sm-8">
                        <select name="total_employee" class="form-control mr-1">
                            <option value="">Select No Of Employee Range...</option>
                            <option @if ("Belum Bisnis" == @$_GET['total_employee']) selected @endif value="Belum Bisnis">Belum Bisnis</option>
                            <option @if ("0 - 4" == @$_GET['total_employee']) selected @endif value="0 - 4">0 - 4 Pegawai</option>
                            <option @if ("5 - 19" == @$_GET['total_employee']) selected @endif value="5 - 19">5 - 19 Pegawai</option>
                            <option @if (">20" == @$_GET['total_employee']) selected @endif value=">20">>20 Pegawai</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="additional_css" class="col-sm-4 control-label">User yang memiliki status?</label>
                    <div class="col-sm-8">
                        <select name="status" class="form-control mr-1">
                            <option value="">Select status...</option>
                            <option @if ("Active" == @$_GET['status']) selected @endif value="Active">Active</option>
                            <option @if ("Expired" == @$_GET['status']) selected @endif value="Expired">Expired</option>
                            <option @if ("Leads" == @$_GET['status']) selected @endif value="Leads">Leads</option>
                        </select>
                    </div>
                </div>
{{--                <div class="form-group row ">--}}
{{--                    <label for="additional_css" class="col-sm-4 control-label">User Makes Last Payment On?</label>--}}
{{--                    <div class="col-sm-2">--}}
{{--                        <select name="intervalOption" class="form-control mr-1">--}}
{{--                            <option @if ("-" == @$_GET['intervalOption']) selected @endif value="-">Plus (+)</option>--}}
{{--                            <option @if ("+" == @$_GET['intervalOption']) selected @endif value="+">Minus (-)</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                    <div class="col-sm-2">--}}
{{--                        <input class="form-control" name="intervalValue" value="{{ @$_GET['intervalValue'] }}">--}}
{{--                    </div>--}}
{{--                    <div class="col-sm-2">--}}
{{--                        <select name="intervalType" class="form-control mr-1">--}}
{{--                            <option @if ("days" == @$_GET['intervalType']) selected @endif value="days">days</option>--}}
{{--                            <option @if ("months" == @$_GET['intervalType']) selected @endif value="months">months</option>--}}
{{--                            <option @if ("years" == @$_GET['intervalType']) selected @endif value="years">years</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="form-group row ">
                    <label for="additional_css" class="col-sm-4 control-label">User Will Expire Within?</label>
                    <div class="col-sm-2">
                        <select name="expiredOption" class="form-control mr-1">
                            <option @if ("-" == @$_GET['expiredOption']) selected @endif value="-">Plus (+)</option>
                            <option @if ("+" == @$_GET['expiredOption']) selected @endif value="+">Minus (-)</option>
                            <option @if (">" == @$_GET['expiredOption']) selected @endif value=">">More Than (>)</option>
                            <option @if ("<" == @$_GET['expiredOption']) selected @endif value="<">Less Than (<)</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <input class="form-control" name="expiredValue" value="{{ @$_GET['expiredValue'] }}">
                    </div>
                    <div class="col-sm-2">
                        <select name="expiredType" class="form-control mr-1">
                            <option @if ("days" == @$_GET['expiredType']) selected @endif value="days">days</option>
                            <option @if ("months" == @$_GET['expiredType']) selected @endif value="months">months</option>
                            <option @if ("years" == @$_GET['expiredType']) selected @endif value="years">years</option>
                        </select>
                    </div>
                </div>
                <button type="button" class="btn btn-info float-right ml-2" data-toggle="modal" data-target="#list-auto-blasting"><i class="la la-table"></i> List Auto Blasting</button>
                <button type="button" class="btn btn-success float-right ml-2" data-toggle="modal" data-target="#auto-blasting"><i class="la la-comments"></i> Tambah Auto Blasting</button>
                <button type="button" class="btn btn-success float-right ml-2" data-toggle="modal" data-target="#blasting"><i class="la la-comments"></i> Blasting</button>
                <button type="submit" class="btn btn-primary float-right"><i class="la la-search-plus"></i> Search</button>
            </div>
        </div>
        <div class="modal fade" id="auto-blasting" tabindex="-1" role="dialog" aria-labelledby="auto-blasting" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="auto-blasting">Auto Blasting Message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @csrf
                    <div class="modal-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="additional_css" class="control-label">Title</label>
                                <input name="title" class="form-control"></input>
                                <span class="help-block">Contoh : Blasting User Expired H+1</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="additional_css" class="control-label">Repeat Days</label>
                                <input name="repeat_days" class="form-control"></input>
                                <span class="help-block">Contoh : 1 (Di ulang setiap 1 hari)</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="additional_css" class="control-label">Text Message</label>
                                <textarea name="message" class="form-control" rows="10"></textarea>
                                <span class="help-block">Text Tambahan Dinamis : {name}, {product}, {profesi}, {province}</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="blasting" value="auto_blasting" class="btn btn-success"><i class="la la-send"></i> Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="modal fade" id="blasting" tabindex="-1" role="dialog" aria-labelledby="blasting" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <form method="POST" action="{{ route('admin_blasting_send') }}" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="blasting">Blasting Message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                    @csrf
                    <div class="modal-body row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                @php
                                    $course = \App\BlastingSettings::get();
                                @endphp
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Pengirim:</label>
                                    <select class="form-control" name="text_instance">
                                        <option value="">-- Pilih Instance Id --</option>
                                        @foreach ($course as $item)
                                                <option value="{{ $item->instance_id }}">{{ "Nomor Pengirim : ".$item->nomor . " || " . "Instance Id: ".$item->instance_id }}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <p class="help-block">Pilihlah Salah Satu Nomor Pengirim Di Atas</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="additional_css" class="control-label">Text Message</label>
                                <textarea name="text_blast" class="form-control" rows="10"></textarea>
                                <br>
                                <p class="help-block">Text Tambahan Dinamis : {name}, {product}, {profesi}, {province}</p>
                            </div>
                        </div>
                        <input type="hidden" name="last_product" value="{{@$_GET['last_product']}}">
                        <input type="hidden" name="age" value="{{@$_GET['age']}}">
                        <input type="hidden" name="city" value="{{@$_GET['city']}}">
                        <input type="hidden" name="job_title" value="{{@$_GET['job_title']}}">
                        <input type="hidden" name="total_employee" value="{{@$_GET['total_employee']}}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success"><i class="la la-send"></i> Send</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="list-auto-blasting" tabindex="-1" role="dialog" aria-labelledby="list-auto-blasting" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="{{ route('admin_blasting_text') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="blasting">Blasting Message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Repeat Days</th>
                                        <th style="width: 30%;">Message</th>
                                        <th>Last Execution Date</th>
                                        <th>Next Execution Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($listAutoBlasting as $k => $v)
                                        <tr>
                                            <td>{{$v->title}}</td>
                                            <td>{{$v->repeat_days}}</td>
                                            <td><textarea id="editText{{ $v->id }}" name="text[]" disabled>{{$v->message}}</textarea></td>
                                            <td>{{($v->last_execution_date) ? date('d M Y', strtotime($v->last_execution_date)) : 'Belum di jalankan'}}</td>
                                            <td>{{date('d M Y', strtotime($v->next_call_date))}}</td>
                                            <td>
                                                <input type="hidden" name="id[]" value="{{ $v->id }}">
                                                <button type="button" class="btn btn-warning" onclick="editText({{ $v->id }})"><i class="la la-pencil"></i></button>
                                                <a href="{{route('admin_auto_blasting_delete', $v['id'])}}" class="btn btn-danger"><i class="la la-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success"><i class="la la-send"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if(!empty($users) && $users->count() > 0)
        <p class="text-muted my-3"> <small>Showing {{$users->count()}} from {{$users->total()}} results</small> </p>

        <table class="table table-striped table-bordered">

            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>No WA</th>
                <th>Produk</th>
                <th>Usia</th>
                <th>Provinsi</th>
                <th>Profesi</th>
                <th>Jumlah Employee</th>
                <th>{{__a('status')}}</th>
                <th>Expired Date</th>
            </tr>

            @foreach($users as $user)
                @if ($user)
                    <tr>
                        <td>
                            {{$user->name}}
                        </td>
                        <td>
                            {{$user->email}}
                        </td>
                        <td>
                            {{$user->phone}}
                        </td>
                        <td>
                            {{$user->product}}
                        </td>
                        <td>
                            {{$user->age}}
                        </td>
                        <td>
                            {{$user->city}}
                        </td>
                        <td>
                            {{$user->job_title}}
                        </td>
                        <td>
                            {{$user->total_employee}}
                        </td>
                        <td>
                            @if ($user->expired_package_at > date('Y-m-d H:i:s'))
                                Active
                            @elseif ($user->created_at == $user->updated_at)
                                Leads
                            @else
                                Expired
                            @endif
                        </td>
                        <td>
                            {{ date('Y-m-d', strtotime($user->expired_package_at)) }}
                        </td>
                    </tr>
                @endif
            @endforeach

        </table>

        {!! $users->appends(request()->input())->links() !!}
    @else
        {!! no_data() !!}
    @endif

@endsection

@section('page-js')
    <script>
        function editText(idnya) {
            $('#editText'+idnya).removeAttr("disabled");
        }
    </script>
@endsection