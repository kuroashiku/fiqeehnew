@extends('layouts.theme')

@section('content')

    <section class="affiliate-sec" id="affiliate">
        <div class="affi-top">
            <div class="jumbotron">
            </div>
            <div class="affi-title">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-10">
                            <h2 class="t1">Make Your Web Traffic Work For You</h2>
                            <span class="t2 text-capitalize">Our Portals Affiliate Network Is Simple:</span>
                            <span class="t3">We pay you for every purchase that originates from your website, blog or SNS Page. You will also find incentives and tools to help you reach your marketing goals.</span>
                        </div>
                        <div class="col-sm-2">
                            <a href="{{route("afiliasi-login")}}" class="btn btn-primary">sign in</a><br>
                            <a href="{{route("afiliasi-register")}}" class="btn btn-primary">daftar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="container"> -->
            <div class="row justify-content-sm-center mt">
                <div class="col-sm-12">
                    <h3 class="text-center un t1 text-uppercase">HOW IT WORKS.</h3>
                </div>
                <div class="col-sm-3 aff mt-4">
                    <i class="la la-calendar-day"></i>
                    <h4 class="t2">Kelayakan Business Plan</h4>
                    <p class="t3">Bisnis harus memiliki perencanaan yang detail mulai dari pendanaan dan pengeluaran</p>
                </div>
                <div class="col-sm-3 aff mt-4">
                    <i class="la la-balance-scale"></i>
                    <h4 class="t2">Akuisisi Lahan</h4>
                    <p class="t3">Melakukan akuisisi lahan secara aman, dan bijak berdasarkan prosedur hukum yang berlaku</p>
                </div>
                <div class="col-sm-3 aff mt-4">
                    <i class="la la-clipboard-list"></i>
                    <h4 class="t2">Perizinan</h4>
                    <p class="t3">Perizinan yang lengkap dan tepat serta taat pada aturan peraturan pemerintah</p>
                </div>
            </div>
            <div class="row justify-content-sm-center mt">
                <div class="col-sm-12 text-center">
                    <h3 class="t2 un text-capitalize">Why Choose Aliexpress Affiliate Program?</h3>
                </div>
                <div class="col-sm-3 aff">
                    <i class="la la-shopping-bag"></i>
                    <h4 class="t2">Manajemen Keuangan</h4>
                    <p class="t3">Meminimalisir resiko kerugian dan sistem pembukuan yang sesuai standar akuntansi</p></div>
                <div class="col-sm-3 aff">
                    <i class="la la-shopping-cart"></i>
                    <h4 class="t2">Strategi Pemasaran</h4>
                    <p class="t3">Strategi pemasaran yang benar dan tidak melanggar syariat serta memberikan kesan profesional yang menjual</p></div>
                <div class="col-sm-3 aff">
                    <i class="la la-building"></i>
                    <h4 class="t2">Pembangunan yang Efisien</h4>
                    <p class="t3">Pembangunan yang terencana dan sistematis serta mengedepankan mutu yang berkualitas</p></div>
            </div>
            <div class="row justify-content-sm-center mt">
                <div class="col-sm-12 text-center mb-sm-4">
                    <h3 class="t2 un text-uppercase">Testimoni</h3>
                </div>
                <div class="col-sm-2 test-c"><i class="la la-business-time"></i>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus, doloremque.</p>
                    <span class="t2 text-center">Affandi</span>
                    <span class="text-center">Kavling</span>
                </div>
                <div class="col-sm-2 test-c"><i class="la la-business-time"></i>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus, doloremque.</p>
                    <span class="t2 text-center">Affandi</span>
                    <span class="text-center">Kavling</span>
                </div>
                <div class="col-sm-2 test-c"><i class="la la-business-time"></i>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus, doloremque.</p>
                    <span class="t2 text-center">Affandi</span>
                    <span class="text-center">Kavling</span>
                </div>
                <div class="col-sm-2 test-c"><i class="la la-business-time"></i>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus, doloremque.</p>
                    <span class="t2 text-center">Affandi</span>
                    <span class="text-center">Kavling</span>
                </div>
            </div>
        </div>

    </section>
@endsection
