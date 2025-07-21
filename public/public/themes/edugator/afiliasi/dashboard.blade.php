@extends('layouts.afiliasi')

@section('content')
    @php
        $user_id = $auth_user->id;
        
        $userCount = \App\User::where('afiliasi_id', $user_id)->count();
        $userCountThisMonth = \App\User::where('afiliasi_id', $user_id)
            ->where('created_at', 'LIKE', date('Y-m') . '%')->count();
        $userCountThisYear= \App\User::where('afiliasi_id', $user_id)
            ->where('created_at', 'LIKE', date('Y') . '%')->count();
            
        $earning = \App\User::select(\DB::raw('COALESCE(SUM(afiliasi_komisi), 0) as total'))
            ->where('afiliasi_id', $user_id)
            ->where('afiliasi_paid', 3)->first();
        $earningEstimation = \App\User::select(\DB::raw('COALESCE(SUM(afiliasi_komisi), 0) as total'))
            ->where('afiliasi_id', $user_id)
            ->where('afiliasi_paid', '!=', 3)->first();
    @endphp

    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-light">
                <div class="card-icon mr-2">
                    <span><i class="la la-link"></i> </span>
                </div>

                <div class="card-info">
                    <input hidden type="text" value="{{ route('home') .'?reff='. Auth::user()->afiliasi_code }}" id="copyToClipboard">
                    <div class="text-value"><h4><a href="#" onclick="copyToClipboard()">{{Auth::user()->afiliasi_code}}</a></h4></div>
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
                    <span style="font-size: 30px;">Rp</span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{{number_format($earning->total,2,',','.')}}</h4></div>
                    <div>Earning</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-light">
                <div class="card-icon mr-2">
                    <span><i class="la la-chart-line"></i> </span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{{$userCountThisMonth}}</h4></div>
                    <div>Users this Month</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-light">
                <div class="card-icon mr-2">
                    <span><i class="la la-chart-line"></i> </span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{{$userCountThisYear}}</h4></div>
                    <div>Users this Year</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="dashboard-card mb-3 d-flex border p-3 bg-light">
                <div class="card-icon mr-2">
                    <span style="font-size: 30px;">Rp</span>
                </div>

                <div class="card-info">
                    <div class="text-value"><h4>{{number_format($earningEstimation->total,2,',','.')}}</h4></div>
                    <div>Estimation Earning</div>
                </div>
            </div>
        </div>

    </div>

@endsection

