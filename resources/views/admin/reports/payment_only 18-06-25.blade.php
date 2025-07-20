@extends('layouts.admin')

@section('content')

@include('admin.reports.menu')

    <div class="profile-settings-wrap">

        <h4 class="mb-3">Laporan Payment Tanggal Daftar</h4>

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
                            </div>
                            <br>
                            <div class="input-group">
                                <select name="status" class="form-control mr-1">
                                    <option value="">Filter by status</option>
                                    <option value="0" {{selected('0', request('status'))}} >pending</option>
                                    <option value="1" {{selected('1', request('status'))}} >success</option> 
                                    <option value="2" {{selected('2', request('status'))}} >declined</option>
                                </select>
                                <select name="city" class="form-control mr-1">
                                    <option value="">Select Province...</option>
                                    @foreach ($province as $item)
                                        <option @if ($item->provinsi == @$_GET['city']) selected @endif value="{{ $item->provinsi }}">{{ $item->provinsi }}</option>
                                    @endforeach
                                </select>

                                <select class="form-control mr-1"" name="age" id="age">
                                    <option  value="">Select Age Range...</option>
                                    <option  value="18 - 24" {{selected('18 - 24', request('age'))}}>18 - 24</option>
                                    <option  value="25 - 29" {{selected('25 - 29', request('age'))}}>25 - 29</option>
                                    <option  value="30 - 34" {{selected('30 - 34', request('age'))}}>30 - 34</option>
                                    <option  value="35 - 39" {{selected('35 - 39', request('age'))}}>35 - 39</option>
                                    <option  value="40 - 44" {{selected('40 - 44', request('age'))}}>40 - 44</option>
                                    <option  value="45 - 49" {{selected('45 - 49', request('age'))}}>45 - 49</option>
                                    <option  value="50 - 54" {{selected('50 - 54', request('age'))}}>50 - 54</option>
                                    <option  value="> 55" {{selected('> 55', request('age'))}}>> 55</option>
                                </select>

                                <select class="form-control mr-1" name="job_title" id="job_title">
                                    <option value="">Select Profession...</option>
                                    <option  value="Pengusaha" {{selected('Pengusaha', request('job_title'))}}>Pengusaha</option>
                                    <option  value="Pegawai" {{selected('Pegawai', request('job_title'))}}>Pegawai</option>
                                    <option  value="Ibu Rumah Tangga" {{selected('Ibu Rumah Tangga', request('job_title'))}}>Ibu Rumah Tangga</option>
                                    <option  value="Mahasiswa" {{selected('Mahasiswa', request('job_title'))}}>Mahasiswa</option>
                                    <option  value="Belum bekerja" {{selected('Belum bekerja', request('job_title'))}}>Belum bekerja</option>
                                </select>

                                <select class="form-control mr-1" name="product">
                                    <option value="">Select Product...</option>
                                    <option value="Kampus Bisnis Syariah">Kampus Bisnis Syariah</option>
                                    @foreach ($cours as $item)
                                        <option @if ($item->title == @$_GET['product']) selected @endif value="{{ $item->title }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>

                                {{-- <select name="status" class="form-control mr-1">
                                    <option value="">Select Age...</option>
                                    
                                </select>  --}}
                                <button type="submit" class="btn btn-primary mr-2"><i class="la la-search-plus"></i> Submit</button>
                                <button type="submit" name="filter" value="export_payment_only" class="btn btn-success mr-2"><i class="la la-download"></i> Export Payment</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>

        @if($students->count() > 0)



        <p class="text-muted my-3"> <small>Showing {{$students->count()}} from {{$students->total()}} results</small> </p>

        <table class="table table-striped table-bordered">

            <tr>
                <th><input class="bulk_check_all" type="checkbox" /></th>
                <th style="width:20%;">Tanggal Daftar</th>
                <th>Nama</th>
                <th>No Hp</th>
                <th>Produk</th>
                <th>Nilai</th>
                <th>Province</th>
                <th>Umur</th>
                <th>Profesi</th>
                <th>Status</th>
            </tr>

            @foreach($students as $payment)
                @if ($payment->user)
                    <tr>
                        <td>
                            <label> 
                                @if ($payment->status == 0)
                                    <input class="check_bulk_item" name="bulk_ids[]" type="checkbox" value="{{$payment->id}}" />
                                @endif
                                <small class="text-muted">#{{$payment->id}}</small>
                            </label>
                        </td>
                        <td>
                            {{date('m/d/Y', strtotime($payment->created_at))}}
                        </td>
                        <td>
                            {{$payment->user->name}}
                        </td>
                        <td>
                            {{$payment->user->phone}}
                        </td>
                        <td>
                            @if ($payment->product == NULL)
                                {{$payment->product_ads}}
                            @else
                                {{$payment->product}}
                            @endif
                        </td>
                        <td>
                            {!!price_format($payment->amount)!!}
                        </td>
                        <td>
                            {{$payment->user->city}}
                        </td>
                        <td>
                            {{$payment->user->age}}
                        </td>
                        <td>
                            {{$payment->user->job_title}}
                        </td>
                        <td>
                            @if ($payment->status == 0)
                                Pending
                            @elseif ($payment->status == 1)
                                Success
                            @else 
                                Declined
                            @endif
                        </td>
                        

                    </tr>
                @endif
            @endforeach

        </table>

        {!! $students->appends(['q' => request('q'), 'status'=> request('status'), 'start_date'=> request('start_date'), 'end_date'=> request('end_date')])->links() !!}

    @else
        {!! no_data() !!}
    @endif



    </div>


@endsection
