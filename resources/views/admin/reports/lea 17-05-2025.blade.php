@extends('layouts.admin')

@section('content')

@include('admin.reports.menu')

    <div class="profile-settings-wrap">

        <h4 class="mb-3">Laporan User Ads</h4>

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
                                    <option value="">Select status...</option>
                                    <option @if ("Active" == @$_GET['status']) selected @endif value="Active">Active</option>
                                    <option @if ("Expired" == @$_GET['status']) selected @endif value="Expired">Expired</option>
                                    <option @if ("Leads" == @$_GET['status']) selected @endif value="Leads">Leads</option>
                                </select>
                                <select name="city" class="form-control mr-1">
                                    <option value="">Select Province...</option>
                                    @foreach ($province as $item)
                                        <option @if ($item->provinsi == @$_GET['city']) selected @endif value="{{ $item->provinsi }}">{{ $item->provinsi }}</option>
                                    @endforeach
                                </select>
                                {{-- <select name="status" class="form-control mr-1">
                                    <option value="">Select Age...</option>
                                    
                                </select>  --}}
                                <button type="submit" class="btn btn-primary mr-2"><i class="la la-search-plus"></i> Submit</button>
                                <button type="submit" name="filter" value="export_lea" class="btn btn-success mr-2"><i class="la la-download"></i> Export Payment</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>

        @php
            $tes = \App\Province::get('provinsi')->whereNotNull('provinsi');
        @endphp
        @if($students->count() > 0)
        <p class="text-muted my-3"> <small>Showing {{$students->count()}} from {{$students->total()}} results</small> </p>

            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            {{-- <th><input class="bulk_check_all" type="checkbox" /></th> --}}
                            <th>{{ trans('admin.name') }}</th>
                            {{-- <th>{{ trans('admin.email') }}</th> --}}
                            {{-- <th>{{__a('type')}}</th> --}}
                            <th>Phone</th>
                            <th>Product Category</th>
                            <th>Product</th>
                            <th>Product Ads</th>
                            <th>Province</th>
                            <th>Usia</th>
                            <th>Profesi</th>
                            <th>Details</th>
                            <th>Last Payment On</th>
                            <th>Expired Class</th>
                            <th>Expired Ads</th>
                            <th>{{__a('status')}}</th>
                        </tr>
                        @if($students['session_id'] == NULL)
                                @foreach($students as $u)
                                    {{-- @if (count($u['user_enrolls']) > 0) --}}
                                        {{-- @foreach ($u['user_enrolls'] as $item) --}}
                                            {{-- @if(isset($item['course'])) --}}
                                                <tr>
                                                    {{-- <td>
                                                        <label>
                                                            <input class="check_bulk_item" name="bulk_ids[]" type="checkbox" value="{{$u->id}}" />
                                                            <small class="text-muted">#{{$u->id}}</small>
                                                        </label>
                                                    </td> --}}
                                                    <td>{{ $u->name }}</td>
                                                    {{-- <td>{{ $u->email }}</td> --}}
                                                    {{-- <td>

                                                        @if($u->isAdmin)
                                                            <span class="badge badge-success">Admin</span>
                                                        @elseif($u->isInstructor)
                                                            <span class="badge badge-info">Instructor</span>
                                                        @else
                                                            <span class="badge badge-dark">Student</span>
                                                        @endif

                                                        @if($u->active_status == 2)
                                                            <span class="badge badge-danger">Blocked</span>
                                                        @endif
                                                    </td> --}}
                                                    <td>{{ $u->phone }}</td>
                                                    <td>
                                                        @if ($u->category_product == NULL)
                                                            Kelas
                                                        @elseif ($u->category_product == 1 )
                                                            Kelas
                                                        @elseif ($u->category_product == 2)
                                                            Member Ads
                                                        @elseif ($u->category_product == 3)
                                                            Fiqeeh Ads
                                                        @endif
                                                    </td>
                                                    @if($u->product == null) 
                                                    <td>{{ $u->product_ads }}</td>
                                                    @else
                                                    <td>{{ $u->product }}</td>
                                                    @endif

                                                    @if($u->product_ads == null) 
                                                    <td>Tidak Ada Ads Product</td>
                                                    @else
                                                    <td>{{ $u->product_ads }}</td>
                                                    @endif
                                                    {{-- <td>{{ $item['course']['title'] }}</td> 
                                                    <td>{{ $item['percentage_report']."%" }}</td> --}}
                                                    <td>{{ $u->city }}</td>
                                                    <td>{{ $u->age }}</td>
                                                    <td>{{ $u->job_title }}</td>
                                                    <td>{{ $u->about_me }}</td>
                                                    {{-- <td>@if ($u->reseller == 1) Ya @else Tidak @endif</td> --}}
                                                    <td>{{ date('m/d/Y', strtotime($u->last_payment)) }}</td>
                                                    <td>{{ date('m/d/Y', strtotime($u->expired_package_at)) }}</td>
                                                    <td>
                                                        @if ($u->expired_ads_at == NULL)
                                                         - 
                                                        @else 
                                                        {{date('m/d/Y', strtotime($u->expired_ads_at))}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($u->expired_package_at > date('Y-m-d H:i:s'))
                                                            Active
                                                        @elseif (in_array($u->id, $dataLeads))
                                                            Leads
                                                        @else
                                                            Expired
                                                        @endif
                                                    </td>
                                                </tr>
                                            {{-- @endif --}}
                                        {{-- @endforeach --}}
                                    {{-- @endif --}}
                                @endforeach
                            @endif
                        </table>


                    {!! $students->appends(request()->input())->links() !!}

    @else
        {!! no_data() !!}
    @endif



    </div>


@endsection
