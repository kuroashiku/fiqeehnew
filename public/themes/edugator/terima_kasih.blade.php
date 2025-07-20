@extends('layouts.theme')


@section('content')
<section class="affiliate-sec" id="affiliate">
    <div class="affi-top">
        <div class="jumbotron" style="height: 40rem;">
        </div>
        <div class="affi-title" style="top: 15%;">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 mt-5 text-center">
                        <h2 style="margin-bottom: 0px;"><b>TERIMA KASIH SUDAH MENDAFTAR</b></h2>
                        <h1 style="color: #FFC800;"><b>KELAS Fiqeeh</b></h1>
                        <br>
                        <h3 style="margin-bottom: 0px;"><b>Konfirmasi Pembayaran Anda</b></h3>
                        <br>
                        <a href="https://wa.me/{{ \App\Option::where('option_key', 'site_phone')->first()->option_value }}?text=Bismillah,%20saya%20sudah%20mendaftar%20kelas%20Hijrah%20Academy" class="btn btn-lg" style="background:#FFC800;color: white;">
                            <b>Hubungi CS</b>
                        </a>
                        {{-- <h1>100K <div>/Tahun</div> </h1><span>/Tahun</span> --}}
                        {{-- <h2 class="t1">Make Your Web Traffic Work For You</h2>
                        <span class="t2 text-capitalize">Our Portals Affiliate Network Is Simple:</span>
                        <span class="t3">We pay you for every purchase that originates from your website, blog or SNS Page. You will also find incentives and tools to help you reach your marketing goals.</span> --}}
                    </div>
                    
                    <div class="col-md-6 mx-auto">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
