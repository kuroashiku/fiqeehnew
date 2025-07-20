@extends('layouts.admin')

@section('content')

    @php
        $purchases = \App\UserPayment::where('user_id', \Auth::user()->id)->paginate(50);
        // dd($purchases);
    @endphp

    @if($purchases->count() > 0)
        <p class="text-muted my-3"> <small>Showing {{$purchases->count()}} from {{$purchases->total()}} results</small> </p>

        <table class="table table-striped table-bordered">

            <tr>
                <th>#</th>
                <th>{{__a('amount')}}</th>
                {{-- <th>{{__a('method')}}</th> --}}
                <th>{{__a('time')}}</th>
                <th>{{__a('status')}}</th>
                {{-- <th>#</th> --}}
            </tr>

            @foreach($purchases as $purchase)
                <tr>
                    <td>
                        <small class="text-muted">#{{$purchase->id}}</small>
                    </td>
                    <td>
                        {!!price_format($purchase->amount)!!}
                    </td>
                    {{-- <td>{!!ucwords(str_replace('_', ' ', $purchase->payment_method))!!}</td> --}}

                    <td>
                        <small>
                            {!!$purchase->created_at->format(get_option('date_format'))!!} 
                            {!!$purchase->created_at->format(get_option('time_format'))!!}
                        </small>
                    </td>

                        @if($purchase->status == 1)
                            <td>
                                <span style="background: #28a745;
                                color: #fff;
                                text-transform: uppercase;
                                padding: 2px 8px;
                                font-size: .8rem;
                                font-weight: 700;"> Sudah Dibayar </span>
                            </td>
                            {{-- <span class="text-success" data-toggle="tooltip" title="{!!$purchase->status!!}"><i class="fa fa-check-circle-o"></i> </span> --}}
                        @elseif ($purchase->status == 0 && $purchase->detail_payment)
                            <td>
                                <span style="background: #ffc107;
                                color: #fff;
                                text-transform: uppercase;
                                padding: 2px 8px;
                                font-size: .8rem;
                                font-weight: 700;"> Sedang Diverifikasi </span>
                            </td>
                        @else
                            <td>
                                <span style="background: #dc3545;
                                color: #fff;
                                text-transform: uppercase;
                                padding: 2px 8px;
                                font-size: .8rem;
                                font-weight: 700;"> Belum Dibayar </span>
                            </td>
                            {{-- <span class="text-warning" data-toggle="tooltip" title="{!!$purchase->status!!}"><i class="fa fa-exclamation-circle"></i> </span> --}}
                        @endif

                    {{-- <td>
                        <a href="{!!route('purchase_view', $purchase->id)!!}" class="btn btn-info"><i class="la la-eye"></i> </a>
                    </td> --}}

                </tr>
            @endforeach

        </table>

        {!! $purchases->appends(request()->input())->links() !!}

    @else
        {!! no_data() !!}
    @endif




@endsection
