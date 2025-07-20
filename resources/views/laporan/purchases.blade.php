<table class="table table-bordered bg-white">

    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>No HP</th>
        <th>Pembayaran</th>
        <th>Status</th>
    </tr>
    @foreach($data['payments'] as $payment)
        @if ($payment->user)
            <tr>
                <td>
                    <p>{{$payment->user->name}}</p>
                </td>
                <td>
                    <p>{{$payment->user->email}}</p>
                </td>
                <td>
                    <p>{{$payment->user->phone}}</p>
                </td>
                <td>
                    <p>{{date('d F Y', strtotime($payment->created_at))}}</p>
                </td>
                @if($payment->status == 1)
                    <td>
                        <span style="background: #28a745;
                        color: #fff;
                        text-transform: uppercase;
                        padding: 2px 8px;
                        font-size: .8rem;
                        font-weight: 700;"> Sudah Dibayar </span>
                    </td>
                    {{-- <span class="text-success" data-toggle="tooltip" title="{!!$payment->status!!}"><i class="fa fa-check-circle-o"></i> </span> --}}
                @elseif ($payment->status == 0 && $payment->detail_payment)
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
                    {{-- <span class="text-warning" data-toggle="tooltip" title="{!!$payment->status!!}"><i class="fa fa-exclamation-circle"></i> </span> --}}
                @endif
            </tr>
        @endif

    @endforeach

</table>