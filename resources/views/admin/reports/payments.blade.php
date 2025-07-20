@extends('layouts.admin')

@section('content')

@include('admin.reports.menu')

    <div class="profile-settings-wrap">

        <h4 class="mb-3">Laporan Purchases</h4>

        <form action="" method="get">

            <div class="courses-actions-wrap">

                <div class="row">
                    <div class="col-md-12">
                        <div class="search-filter-form-wrap mb-3">

                            <div class="input-group">
                                <input type="text" class="form-control mr-3" name="q" value="{{request('q')}}" placeholder="student name">
                                <button type="submit" class="btn btn-primary btn-purple mr-3"><i class="la la-search-plus"></i> Filter results</button>
                                <a href="{{route('export_purchases')}}" class="btn btn-success"><i class="la la-download"></i> Export</a>
                            </div>

                        </div>


                    </div>
                </div>

            </div>
        </form>

        @if($payments->count())
            <table class="table table-bordered bg-white">

                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

                @foreach($payments as $payment)
                    @if ($payment->user != null)
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
                        {{-- <td>
                            <p>{{date('d F Y', strtotime($payment->expired_package_at))}}</p>
                        </td> --}}
                        <td>
                            <a href="{{route('payment_view', $payment->id)}}" class="btn btn-primary"><i class="la la-eye"></i> </a>
                        </td>
                    </tr>
                    @endif
                @endforeach

            </table>
        @else
            {!! no_data(null, null, 'my-5' ) !!}
        @endif
        
        {!! $payments->links() !!}


    </div>


@endsection
