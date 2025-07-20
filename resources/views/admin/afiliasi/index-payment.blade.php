@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-sm-12">

            @if($payments->count())

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <th>Amount</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    @foreach($payments as $payment)
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
                            <td>
                                @if($payment->status == 0)
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#updatePaymentRequest"><i class="la la-dollar"></i></button>
                                    <div class="modal fade" id="updatePaymentRequest" tabindex="-1" role="dialog" aria-labelledby="blasting" aria-hidden="true">
                                        <div class="modal-dialog modal-md" role="document">
                                            <form method="POST" action="{{ route('admin_afiliasi_payment') }}" enctype="multipart/form-data">
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
                                                                    <label for="additional_css" class="control-label">Status Pembayaran</label>
                                                                    <select class="form-control" name="status" required>
                                                                        <option value="0">Requested</option>
                                                                        <option value="1">Done</option>
                                                                        <option value="2">Reject</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="additional_css" class="control-label">Bukti Pembayaran</label>
                                                                    <input type="file" class="form-control" name="detail_payment" accept="image/*" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="additional_css" class="control-label">Alasan Pembayaran (Jika di reject)</label>
                                                                    <textarea class="form-control" name="detail_payment_reason"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="id" value="{{$payment->id}}">
                                                                <input type="hidden" name="user_id" value="{{$payment->user_afiliasi_id}}">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-success"><i class="la la-plus"></i> Add</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </table>

            @else
                {!! no_data() !!}
            @endif

            {!! $payments->links() !!}

        </div>
    </div>

@endsection
