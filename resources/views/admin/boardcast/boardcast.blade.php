@extends('layouts.admin')

@section('content')

@include('admin.boardcast.menu')  

        <div class="row">

            <div class="col-md-12">

                <form method="get">
                    
                    <div class="search-filter-form-wrap mb-3">
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

                                <select class="form-control mr-1" name="age" id="age">
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
                            <input type="text" class="form-control mr-1" name="pembayaran" value="{{request('pembayaran')}}" placeholder="Filter by Payment Count">
                            <input type="text" class="form-control mr-3" name="q" value="{{request('q')}}" placeholder="Filter by Name, E-Mail, Phone">
                            
                            <button type="submit" class="btn btn-primary btn-purple"><i class="la la-search-plus"></i> Filter results</button>
                        </div>
                    </div>

                </form>
        
            </div>

        </div>

        @php
            $tes = \App\Province::get('provinsi')->whereNotNull('provinsi');
        @endphp
        @if($students->count() > 0)
        <p class="text-muted my-3"> <small>Showing {{$students->count()}} from {{$students->total()}} results</small> </p>

            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>#</th>
                            <th>{{ trans('admin.name') }}</th>
                            <th>Phone</th>
                            <th>Product Category</th>
                            <th>Product</th>
                            <th>Province</th>
                            <th>Usia</th>
                            <th>Profesi</th>
                            <th>Details</th>
                            <th>Last Payment On</th>
                            <th>Expired Class</th>
                            <th>Amount</th>
                            <th>{{__a('status')}}</th>
                        </tr>
                        @if($students['session_id'] == NULL)
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
                            {{$payment->user->name}}
                        </td>
                        <td>
                            {{$payment->user->phone}}
                        </td>
                        <td>
                                                        @if ($payment->user->category_product == NULL)
                                                            Kelas
                                                        @elseif ($payment->user->category_product == 1 )
                                                            Kelas
                                                        @elseif ($payment->user->category_product == 2)
                                                            Member Ads
                                                        @elseif ($payment->user->category_product == 3)
                                                            Fiqeeh Ads
                                                        @elseif ($payment->user->category_product == 1185)
                                                            Mindset 
                                                        @elseif ($payment->user->category_product == 1186)
                                                            Produk
                                                        @elseif ($payment->user->category_product == 1188)
                                                            Permodalan
                                                        @elseif ($payment->user->category_product == 1190)
                                                            Pemasaran
                                                        @elseif ($payment->user->category_product == 1191)
                                                            Operasional
                                                        @elseif ($payment->user->category_product == 1203)
                                                            Member Jual Produk
                                                        @elseif ($payment->user->category_product == 1205)
                                                            Member Cari Mitra
                                                        @elseif ($payment->user->category_product == 1206)
                                                            Member Cari Investor
                                                        @elseif ($payment->user->category_product == 1207)
                                                            Fiqeeh Buku
                                                        @elseif ($payment->user->category_product == 1208)
                                                            Fiqeeh Workshop
                                                        @elseif ($payment->user->category_product == 1209)
                                                            Fiqeeh Konsultan
                                                        @elseif ($payment->user->category_product == 1210)
                                                            Fiqeeh Ads
                                                        @endif
                                                    </td>
                       <td>{{ $payment->user->product }}</td>
                        <td>
                            {{$payment->user->city}}
                        </td>
                        <td>
                            {{$payment->user->age}}
                        </td>
                        <td>
                            {{$payment->user->job_title}}
                        </td>
                        <td>{{ $payment->user->about_me }}</td>
                        {{-- <td>@if ($u->reseller == 1) Ya @else Tidak @endif</td> --}}
                        <td>{{ date('m/d/Y', strtotime($payment->user->last_payment)) }}</td>
                        <td>{{ date('m/d/Y', strtotime($payment->user->expired_package_at)) }}</td>
                        <td>{!!price_format($payment->amount)!!}</td>
                        <td>
                            @if ($payment->user->expired_package_at > date('Y-m-d H:i:s'))
                                Active
                            @elseif (in_array($payment->user->id, $dataLeads))
                                Leads
                            @else
                                Expired
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
                            @endif
                        </table>


                    {!! $students->appends(request()->input())->links() !!}

                </div>
            </div>

        @else
            {!! no_data() !!}
        @endif
@endsection


<script>
    function changeFormat(sel, id)
    {
        console.log("message-text-"+id)
        $.post("{{route('followUpFormat')}}", {_token: "{{ csrf_token() }}", id_payment: id, folow_up: sel.value}, function( data ) {
            $("textarea#message-text-" + id).val(data.text);
            link = "https://api.whatsapp.com/send?phone="+data.phone+"&text="+data.message
            $("a#link-text-" + id).attr("href", link) 
        });
    }
</script>
