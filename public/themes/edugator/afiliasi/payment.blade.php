@extends('layouts.afiliasi')

@section('page-header-right')
    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addPaymentBook"><i class="la la-plus-circle"></i> Request Payment</button>
    <div class="modal fade" id="addPaymentBook" tabindex="-1" role="dialog" aria-labelledby="blasting" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <form method="POST" action="{{ route('payment-afiliasi') }}" enctype="multipart/form-data">
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
                                    <label for="additional_css" class="control-label">Request Payment</label>
                                    <input type="text" class="form-control" name="amount" min="{{$optionMinimumPayment->option_value}}" value="{{Auth::user()->afiliasi_unpaid}}" autocomplete="off" required>
                                    <small>Minimal request pembayaran Rp {{number_format($optionMinimumPayment->option_value,2,',','.')}}</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"><i class="la la-plus"></i> Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('content')

    <form action="" method="get">

        <div class="row">
            <div class="col-sm-12">

                @if($afiliasi_payments->count())

                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Tanggal Pengajuan</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Status</th>
                        </tr>
                        </thead>

                        @foreach($afiliasi_payments as $payment)
                            <tr>
                                <td>{{ date('Y-m-d', strtotime($payment->created_at)) }}</td>
                                <td>{{number_format($payment->amount,2,',','.')}}</td>
                                <td>
                                    <img src="{{env('APP_URL').$payment->detail_payment}}" width="80" />
                                </td>
                                <td>
                                    @if($payment->status == 0)
                                        Requested
                                    @elseif($payment->status == 1)
                                        Done
                                    @elseif($payment->status == 2)
                                        Reject : {{$payment->detail_payment}}
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </table>

                @else
                    {!! no_data() !!}
                @endif

                {!! $afiliasi_payments->links() !!}

            </div>
        </div>

    </form>

@endsection
