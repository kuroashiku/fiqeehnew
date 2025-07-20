@extends('layouts.afiliasi')

@section('content')
    @php
        $user_id = $auth_user->id;
        
        $userCount = \App\User::where('afiliasi_id', $user_id)->count();
        $bookCount = \App\EbookDownload::where('user_afiliasi_id', $user_id)->count();

        $earningEstimation = \App\User::select(\DB::raw('COALESCE(SUM(afiliasi_komisi), 0) as total'))
            ->where('afiliasi_id', $user_id)
            ->where('afiliasi_paid', '!=', 3)->first();
        $earningEstimationBook = \App\EbookDownload::select(\DB::raw('COALESCE(SUM(afiliasi_komisi), 0) as total'))
            ->where('user_afiliasi_id', $user_id)->where('payment_status', '!=', 3)->first();
    @endphp

    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-light">
                <div class="card-icon mr-2">
                    <span><i class="la la-link"></i> </span>
                </div>

                <div class="card-info">
                    @if(Auth::user()->expired_package_at > date('Y-m-d'))
                        <input hidden type="text" value="{{ route('home') .'?reff='. Auth::user()->afiliasi_code }}" id="copyToClipboard">
                        <div class="text-value"><h4><a href="#" onclick="copyToClipboard()">{{Auth::user()->afiliasi_code}}</a></h4></div>
                    @else
                        <div class="text-value"><h4>Inactive User</h4></div>
                    @endif
                    <div>Unique Code</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-light">
                <div class="card-icon mr-2">
                    <span><i class="la la-user"></i> </span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{{$userCount}}</h4></div>
                    <div>Users Affiliate</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-light">
                <div class="card-icon mr-2">
                    <span><i class="la la-book"></i> </span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{{$bookCount}}</h4></div>
                    <div>Books Affiliate</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-light">
                <div class="card-icon mr-2">
                    <span style="font-size: 30px;">Rp</span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{{number_format(Auth::user()->afiliasi_paid,2,',','.')}}</h4></div>
                    <div>Paid</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-light">
                <div class="card-icon mr-2">
                    <span style="font-size: 30px;">Rp</span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{{number_format(Auth::user()->afiliasi_unpaid,2,',','.')}}</h4></div>
                    <div>Earning Unpaid</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-light">
                <div class="card-icon mr-2">
                    <span style="font-size: 30px;">Rp</span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{{number_format($earningEstimation->total + $earningEstimationBook->total,2,',','.')}}</h4></div>
                    <div>Estimation Earning</div>
                </div>
            </div>
        </div>

    </div>

@endsection

