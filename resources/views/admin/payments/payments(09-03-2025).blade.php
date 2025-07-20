@extends('layouts.admin')

@section('page-header-right')
    @if(count(request()->input()))
        <a href="{{route('payments')}}"> <i class="la la-arrow-circle-left"></i> {{__a('reset_filter')}}  </a>
    @endif
@endsection

@section('content')

@include('admin.payments.menu')
    <form method="get">

        <div class="row">

            <div class="col-md-4">
                <div class="input-group">
                    <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#followUpSetting">Setting Text</button>
                    <select name="status" class="mr-1">
                        <option value="">{{__a('set_status')}}</option>

                        <option value="0">pending</option>
                        <option value="1">success</option>
                        <option value="2">declined</option>
                    </select>

                    <button type="submit" name="bulk_action_btn" value="update_status" class="btn btn-primary mr-1">{{__a('update')}}</button>
                    {{-- <button type="submit" name="bulk_action_btn" value="delete" class="btn btn-danger delete_confirm"> <i class="la la-trash"></i> {{__a('delete')}}</button> --}}
                </div>
            </div>

            <div class="col-md-8">

                <div class="search-filter-form-wrap mb-3"> 
                    <div class="input-group">
                        <input type="text" class="form-control mr-1" name="q" value="{{request('q')}}" placeholder="Search by Name, E-Mail">
                        <select name="status" class="form-control mr-1">
                            <option value="">Filter by status</option>
                            <option value="0" {{selected('0', request('status'))}} >pending</option>
                            <option value="1" {{selected('1', request('status'))}} >success</option> 
                            <option value="2" {{selected('2', request('status'))}} >declined</option>
                        </select>
                        <select name="filter_data" class="form-control mr-1">
                            <option value="">Filter by data null</option>
                            <option value="category_product" {{selected('category_product', request('filter_data'))}}>Category Product</option>
                            <option value="monthly" {{selected('monthly', request('filter_data'))}}>Monthly</option>
                            <option value="expired" {{selected('expired', request('filter_data'))}}>Expired At</option>
                        </select>
                        <input type="date" name="start_date" class="form-control datepicker" value="{{request('start_date')}}">
                        <div class="input-group-addon">to</div>
                        <input type="date" name="end_date" class="form-control datepicker mr-1" value="{{request('end_date')}}">
                        <button type="submit" class="btn btn-primary"><i class="la la-search-plus"></i> Submit</button>
                    </div>
                </div>
            </div>
            

        </div>
        
    </form>

    <div class="modal fade" id="followUpSetting" tabindex="-1" role="dialog" aria-labelledby="followUpLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <form action="{{route('follow_up_text')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="followUpLabel">Setting FollowUp Text</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @foreach ($followUp as $fu)
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">{{ $fu['title'] }} Qontak Template ID:</label>
                                <textarea class="form-control" rows="3" type="text" name="{{ $fu['id'] }}[text]">{{ $fu['text'] }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">{{ $fu['title'] }} Follow Up Days:</label>
                                <input class="form-control" type="number" name="{{ $fu['id'] }}[days]" placeholder="1 Hari Setelah Daftar" value="{{ $fu['days'] }}"></input>
                            </div>
                        </div>
                    @endforeach
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if($payments->count() > 0)



        <p class="text-muted my-3"> <small>Showing {{$payments->count()}} from {{$payments->total()}} results</small> </p>

        <table class="table table-striped table-bordered">

            <tr>
                <th><input class="bulk_check_all" type="checkbox" /></th>
                <th style="width:20%;">User Detail</th>
                <th>Kategori Payment</th>
                <th>Produk</th>
                <th>Provinsi</th>
                <th>{{__a('amount')}}</th>
                <th>Lampiran</th>
                <th>Created at</th>
                <th>Expired Package</th>
                <th>{{__a('status')}}</th>
                <th>#</th>
            </tr>

            @foreach($payments as $payment)
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
                            <ul>
                                <li>{{$payment->user->name}}</li>
                                <li>{{$payment->user->email}}</li>
                                <li>{{$payment->user->phone}}</li>
                            </ul>
                        </td>
                        <td>
                            @if ($payment->category_product == NULL)
                                Kelas
                            @elseif ($payment->category_product == 1 )
                                Kelas
                            @elseif ($payment->category_product == 2)
                                Member Ads
                            @elseif ($payment->category_product == 3)
                                Fiqeeh Ads
                            @endif
                        </td>
                        <td>
                            @if ($payment->product == NULL)
                                {{$payment->product_ads}}
                            @else
                                {{$payment->product}}
                            @endif
                        </td>
                        <td>{{ $payment->user->city }}</td>
                        <td>
                            {!!price_format($payment->amount)!!}
                        </td>

                        <td>
                            <a href="{{$payment->file_payment}}" target="_blank"><img src="{{$payment->file_payment}}" style="max-width: 100px;" alt=""></a>
                        </td>

                        <td>
                                {{date('m/d/Y', strtotime($payment->created_at))}}
                        </td>
                        <td>
                            {{date('m/d/Y', strtotime($payment->expired_at))}} 
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
                        
                        <td>
                            <a href="{!!route('payment_view', $payment->id)!!}" class="btn btn-md btn-info" data-toggle="tooltip" title="Verifikasi Pembayaran"><i class="la la-eye"></i> </a>
                            <button type="submit"> <a href="{!!route('payment_delete', $payment->id)!!}" class="btn btn-md btn-danger delete_confirm"><i class="la la-trash"></i> </a> </button>
                            @if ($payment->status == 0)
                                @foreach ($followUp as $fu)
                                    <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#followUp{{$payment->id}}{{$fu->title}}"><span style="font-size: 11px;">{{$fu->title}}</span></button>
                                    <div class="modal fade" id="followUp{{$payment->id}}{{$fu->title}}" tabindex="-1" role="dialog" aria-labelledby="followUpLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="followUpLabel">Follow Up User {{$payment->user->name}}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">Nama User:</label>
                                                        <input type="text" class="form-control" value="{{$payment->user->name}}" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="message-text" class="col-form-label">Message:</label>
                                                        <textarea class="form-control" name="message" rows="6" id="message-text-{{$payment->id}}">{{str_replace(['username', 'usernominal'], [$payment->user->name, price_format($payment->amount)], $fu['text'])}}</textarea>
                                                    </div>
                                                    <input type="hidden" name="phone" value="{{$payment->user->phone}}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <a id="link-text-{{$payment->id}}" target="_blank" href="{{ env('WOONOTIF_URL_API') }}/api/send.php?type=text&message={{urlencode(str_replace(['username', 'usernominal'], [$payment->user->name, price_format($payment->amount)], $fu['text']))}}&number={{$payment->user->phone}}&instance_id={{ env('WOONOTIF_INSTANCE_ID') }}&access_token={{ env('WOONOTIF_ACCESS_TOKEN') }}" class="btn btn-success">Follow Up</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#updateDetail{{$payment->id}}"><i class="la la-edit"></i></button>
                                    <div class="modal fade" id="updateDetail{{$payment->id}}" tabindex="-1" role="dialog" aria-labelledby="updateDetail" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form method="POST" action="{{ route('edit-payment', $payment->id) }}">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="updateDetail">Update Detail Product Payment {{$payment->user->name}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Nama User:</label>
                                                            <input type="text" class="form-control" name="name" value="{{$payment->user->name}}" autocomplete="off" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Email User:</label>
                                                            <input type="text" class="form-control" name="email" value="{{$payment->user->email}}" autocomplete="off" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">No Whatsapp:</label>
                                                            <input type="text" class="form-control" name="phone" value="{{$payment->user->phone}}" autocomplete="off" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Amount:</label>
                                                            <input type="number" class="form-control" value="{{$payment->amount}}" name="amount" autocomplete="off">
                                                        </div>
                                                        @php
                                                            $cours = \App\Course::where('category_id', '!=', 1205)->where('category_id', '!=', 1203)->orderBy('title','asc')->get();
                                                            $courrrs = \App\Course::where('category_id', '!=', 1185)->where('category_id','!=',1186)->where('category_id','!=',1188)->where('category_id','!=',1190)->where('category_id','!=',1191)->orderBy('title','asc')->get();
                                                        @endphp 
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Product Category :</label>
                                                            <select class="form-control" name="category_product" id="kategoriexp">
                                                                <option value="" hidden>Select Category</option>
                                                                    @if ($payment->category_product == 1)
                                                                        <option value="1" selected hidden>Class</option>
                                                                    @elseif($payment->category_product == 2)
                                                                        <option value="2" selected hidden>Ads</option>
                                                                    @elseif($payment->category_product == 3)
                                                                        <option value="3" selected hidden>Fiqeeh Ads</option>
                                                                    @endif
                                                                    <option value="1">Class</option>
                                                                    <option value="2">Member Ads</option>
                                                                    <option value="3">Fiqeeh Ads</option>
                                                            </select>
                                                        </div>
                                                        @if($payment->category_product == null)
                                                        <p class="help-block">Data User Category Product Sebelumnya Kosong!!</a></p>
                                                        <div class="form-group" id="classcatexp">
                                                            <label for="recipient-name" class="col-form-label">Product Class:</label>
                                                            <select class="form-control" name="product">
                                                                <option value="Kampus Bisnis Syariah">Kampus Bisnis Syariah</option>
                                                                @foreach ($cours as $item)
                                                                    @if ($payment->product == $item->title)
                                                                        <option value="{{ $item->title }}" selected>{{ $item->title }}</option>
                                                                    @else
                                                                        <option value="{{ $item->title }}">{{ $item->title }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            {{-- <input type="text" class="form-control" name="product" value="{{$u->product}}" autocomplete="off"> --}}
                                                        </div>

                                                        <div class="form-group" id="adscatexp">
                                                            <label for="recipient-name" class="col-form-label">Product Ads:</label>
                                                            <select class="form-control" name="product_ads" id="product">
                                                                <option value="" selected hidden>Pilih Product</option>
                                                                <option value="Kampus Bisnis Syariah">Kampus Bisnis Syariah</option>
                                                                @foreach ($courrrs as $item)
                                                                    @if ($payment->product_ads == $item->title)
                                                                        <option value="{{ $item->title }}" selected>{{ $item->title }}</option>
                                                                    @else
                                                                        <option value="{{ $item->title }}">{{ $item->title }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @endif
                                                        @if($payment->category_product == 1)
                                                            <div class="form-group" id="classcatexp">
                                                                <label for="recipient-name" class="col-form-label">Product Class:</label>
                                                                <select class="form-control" name="product">
                                                                    <option value="Kampus Bisnis Syariah">Kampus Bisnis Syariah</option>
                                                                    @foreach ($cours as $item)
                                                                        @if ($payment->product == $item->title)
                                                                            <option value="{{ $item->title }}" selected>{{ $item->title }}</option>
                                                                        @else
                                                                            <option value="{{ $item->title }}">{{ $item->title }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                                {{-- <input type="text" class="form-control" name="product" value="{{$u->product}}" autocomplete="off"> --}}
                                                            </div>
                                                        @else
                                                        <div></div>
                                                        @endif
                                                        @if($payment->category_product == 2)
                                                            <div class="form-group" id="">
                                                                <label for="recipient-name" class="col-form-label">Product Ads:</label>
                                                                <select class="form-control" name="product_ads" id="product">
                                                                    <option value="" selected hidden>Pilih Product</option>
                                                                    <option value="Kampus Bisnis Syariah">Kampus Bisnis Syariah</option>
                                                                    @foreach ($courrrs as $item)
                                                                        @if ($payment->product_ads == $item->title)
                                                                            <option value="{{ $item->title }}" selected>{{ $item->title }}</option>
                                                                        @else
                                                                            <option value="{{ $item->title }}">{{ $item->title }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        @else
                                                        <div></div>
                                                        @endif
                                                        @if($payment->category_product == 3)
                                                            <div class="form-group" id="">
                                                                <label for="recipient-name" class="col-form-label">Product Fiqeeh Ads:</label>
                                                                <select class="form-control" name="product_ads" id="product">
                                                                    <option value="" selected hidden>Pilih Product</option>
                                                                    <option value="Kampus Bisnis Syariah">Kampus Bisnis Syariah</option>
                                                                    @foreach ($courrrs as $item)
                                                                        @if ($payment->product_ads == $item->title)
                                                                            <option value="{{ $item->title }}" selected>{{ $item->title }}</option>
                                                                        @else
                                                                            <option value="{{ $item->title }}">{{ $item->title }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        @else
                                                        <div></div>
                                                        @endif
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Expired Package (mounthly):</label>
                                                            <input type="number" class="form-control" value="{{$payment->monthly}}" name="monthly" autocomplete="off">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Start Date Product:</label>
                                                            <input type="date" class="form-control datepicker" name="started_at" value="{{date('Y-m-d', strtotime($payment->started_at))}}" autocomplete="off">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Expired Product At:</label>
                                                            <input type="date" class="form-control datepicker" name="expired_at" value="{{date('Y-m-d', strtotime($payment->expired_at))}}" autocomplete="off">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Payment Created:</label>
                                                            <input type="date" class="form-control datepicker" name="created_at" value="{{date('Y-m-d', strtotime($payment->created_at))}}" autocomplete="off" disabled>
                                                        </div>
                                                        
                                                        
                                                        {{-- <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Update At:</label>
                                                            <input type="date" class="form-control datepicker" name="updated_at" value="{{date('Y-m-d', strtotime($u->updated_at))}}" autocomplete="off" disabled>
                                                        </div> --}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-purple"><i class="la la-save"></i>Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @php
                                        $tes = \App\Province::get('*')->whereNotNull('provinsi');
                                    @endphp
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#blasting{{$payment->id}}"><i class="la la-comments"></i></button>
                                                        <div class="modal fade" id="blasting{{$payment->id}}" tabindex="-1" role="dialog" aria-labelledby="blasting" aria-hidden="true">
                                                            <div class="modal-dialog modal-md" role="document">
                                                                <form method="POST" action="{{ route('blasting') }}">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="blasting">Blasting Message</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        @csrf
                                                                        <div class="modal-body row">
                                                                            <div class="modal-body">
                                                                                
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="additional_css" class="control-label">Penerima</label>
                                                                                    <input type="text" class="form-control" name="text_phone" value="{{ $payment->user->phone }}" autocomplete="off">
                                                                                </div>
                                                                            </div>
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
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="additional_css" class="control-label">Text Message</label>
                                                                                    <textarea name="text_blast" class="form-control" rows="10">
Selamat belajar! 

Perkenalkan nama saya Ayu Admin Fiqeeh 🙏🏻☺, kakak telah membeli kelas online 

1. NAMA MEMBER: {{$payment->user->name}}

2. KELAS ONLINE: {{$payment->product}} 

3. MASA BELAJAR: {{date('d M Y', strtotime($payment->created_at))}} - {{date('d M Y', strtotime($payment->created_at))}}

4. CARA BELAJAR: 
- Buka: Fiqeeh.com 
- Masuk: {{$payment->user->phone}} & sandi: 123456 
- Klik: Mulai Belajar 
Boleh belajar sekarang kak? Jika kendala, bisa tanya saya 

5. BERTANYA DI GRUP: 
FIQEEH Grup Provinsi {{$payment->user->city}} :

                                                                                    </textarea>
                                                                                </div>
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="additional_css" class="control-label">Link Group</label>
                                                                                        <select class="form-control" name="text_blast2">
                                                                                            @foreach ($tes as $item)
                                                                                                <option value="{{ $item->link }}">{{ $item->provinsi }}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    <textarea name="text_blast3" class="form-control" rows="1" hidden>
                                                                                        Ayu Admin 
                                                                                        Fiqeeh | Pelatihan Bisnis Syariah 
                                                                                    </textarea>
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
                        </td>

                    </tr>
                @endif
            @endforeach

        </table>

        {!! $payments->appends(['q' => request('q'), 'status'=> request('status'), 'start_date'=> request('start_date'), 'end_date'=> request('end_date')])->links() !!}

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
