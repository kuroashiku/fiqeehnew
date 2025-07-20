@extends('layouts.admin')

@section('content')

@include('admin.datereport.menu')

    <div class="profile-settings-wrap">

        <h4 class="mb-3">Laporan Payment Only End Date</h4>

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
                <th style="width:20%;">Tanggal Payment Berakhir</th>
                <th>Nama</th>
                <th>No Hp</th>
                <th>Produk</th>
                <th>Nilai</th>
                <th>Province</th>
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
                            {{date('m/d/Y', strtotime($payment->expired_at))}}
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
