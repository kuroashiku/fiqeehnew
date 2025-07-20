@extends('layouts.theme')

@section('content')
    
    <style>
    .single-card{
        background-color: #f8f9fa;
    }
    .card-content{
        padding: 1px 30px 30px;
        text-align: left;
        box-shadow: 0px 0px 4px 0px rgba(0, 0, 0, 0.3);
        background: rgba(196, 196, 196, 1);
    }

    .card-icon {
        width: 100%;
        height: 100%;
        background-color: #f8f9fa;
        color: #333;
    }

    .card-content h3 {
        font-size: 22px;
        color: #333;
        font-weight: 700;
        font-family: 'Open Sans', sans-serif;
    }

    .card-content h4 {
        font-size: 16px;
        color: #333;
        font-weight: 600;
        line-height: 0.9;
        font-family: 'Open Sans', sans-serif;
        padding-top: 7px;
    }

    .card-content h5 {
        color: #333;
        line-height: 0.9;
        font-family: 'Open Sans', sans-serif;
    }
    </style>
    <section class="konsultasi-sec" id="konsultasi">
        <div class="container">
            <div class="row mt-sm-5 konsul-top">
                <div class="col-md-7">
                    <p>Saya telah membuktikan bahwa bisnis properti yaitu <span>Developer bisa dijalankan tanpa Bank.</span> Bagaimana caranya? Dengan menerapkan Standar Perbankan yang terkenal manajemen resikonya. Ingin tahu lebih lanjut? </p>
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('assets/images/image-ceo.png') }}" alt="" style="height: 250px;" class="img-thumbnail mx-auto d-block">
                </div>
            </div>
            <div class="row juduls justify-content-center mt-sm-5">
                <div class="col-sm-12 text-center mt-sm-5 mb-sm-5">
                    <h3 class="un">7 MANFAAT ANDA DAPATKAN</h3>
                    <hr style="height: 1px;background-color: white;width: 25%;">
                </div>
                <div class="col-md-3 kons">
                    <i class="la la-calendar-day"></i>
                    <h5>Kelayakan Business Plan</h5>
                    <span>Bisnis harus memiliki perencanaan yang detail mulai dari pendanaan dan pengeluaran</span>
                </div>
                <div class="col-md-3 kons">
                    <i class="la la-balance-scale"></i>
                    <h5>Akuisisi Lahan</h5>
                    <span>Melakukan akuisisi lahan secara aman, dan bijak berdasarkan prosedur hukum yang berlaku</span>
                </div>
                <div class="col-md-3 kons">
                    <i class="la la-clipboard-list"></i>
                    <h5>Perizinan</h5>
                    <span>Perizinan yang lengkap dan tepat serta taat pada aturan peraturan pemerintah</span>
                </div>
                <div class="col-md-3 kons">
                    <i class="la la-shopping-bag"></i>
                    <h5>Manajemen Keuangan</h5>
                    <span>Meminimalisir resiko kerugian dan sistem pembukuan yang sesuai standar akuntansi</span>
                </div>
                <div class="col-md-3 kons">
                    <i class="la la-shopping-cart"></i>
                    <h5>Strategi Pemasaran</h5>
                    <span>Strategi pemasaran yang benar dan tidak melanggar syariat serta memberikan kesan profesional yang menjual</span>
                </div>
                <div class="col-md-3 kons">
                    <i class="la la-building"></i>
                    <h5>Pembangunan yang Efisien</h5>
                    <span>Pembangunan yang terencana dan sistematis serta mengedepankan mutu yang berkualitas</span>
                </div>
                <div class="col-md-3 kons">
                    <i class="la la-chart-bar"></i>
                    <h5>Operasional Kaizen</h5>
                    <span>Manajemen operasional yang terkontrol agar lebih efektif baik SDM maupun peralatan penunjang lainnya</span>
                </div>
            </div>
        </div>
        {{-- <div class="portfolio">
            <div class="container">
                <div class="row justify-content-sm-center">
                    <div class="col-md-4 img-box">
                        <h2>Lorem, ipsum.</h2>
                        <h4>lorem</h4>
                        <p>Lorem ipsum dolor sit amet consectetur.</p>
                        <img class="rounded mx-auto d-block" style="height: 200px;margin-top: 20px;margin-bottom: 20px;" src="{{ asset('assets/images/image-ceo.png') }}" alt="Support services">
                    </div>
                    <div class="col-md-5">
                        <ul>
                            <li>1. Lorem, ipsum.</li>
                            <li>1. Lorem, ipsum.</li>
                            <li>1. Lorem, ipsum.</li>
                            <li>1. Lorem, ipsum.</li>
                            <li>1. Lorem, ipsum.</li>
                            <li>1. Lorem, ipsum.</li>
                            <li>1. Lorem, ipsum.</li>
                            <li>1. Lorem, ipsum.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="testimoni">
            <div class="container">
                <div class="row juduls text-center mt-sm-5">
                    <div class="col-sm-12">
                        <h4 class="un">TESTIMONI</h4>
                    </div>
                    <div class="col-sm-12 mt-sm-4">
                        <div class="testi">
                            <i class="la la-paperclip"></i>
                            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ab ad, nisi nihil quisquam a velit?</p>
                            <span class="name">Sera</span>
                            <b>Kavling</b>
                        </div>
                        <div class="testi">
                            <i class="la la-paperclip"></i>
                            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ab ad, nisi nihil quisquam a velit?</p>
                            <span class="name">Sera</span>
                            <b>Kavling</b>
                        </div>
                        <div class="testi">
                            <i class="la la-paperclip"></i>
                            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ab ad, nisi nihil quisquam a velit?</p>
                            <span class="name">Sera</span>
                            <b>Kavling</b>
                        </div>
                        <div class="testi">
                            <i class="la la-paperclip"></i>
                            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ab ad, nisi nihil quisquam a velit?</p>
                            <span class="name">Sera</span>
                            <b>Kavling</b>
                        </div>
                    </div>
                </div>
                <div class="row juduls text-center daftar mt-sm-5">
                    <div class="col-sm-12 title-daftar">
                        <h4 class="un">DAFTAR</h4>
                    </div>
                    <div class="col-md-10 m-md-auto">
                        <form>
                            <div class="form-group row">
                                <div class="col-sm">
                                    <input type="text" class="form-c" id="input" placeholder="Nama Lengkap">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm">
                                    <input type="text" class="form-c" id="input" placeholder="Nomor Whatsapp Anda">
                                </div>
                            </div>                            
                            <div class="form-group row">
                                <div class="col-sm">
                                    <input type="text" class="form-c" id="input" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm">
                                    <input type="text" class="form-c" id="input" placeholder="Usia">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm">
                                    <input type="text" class="form-c" id="input" placeholder="Alamat">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm">
                                    <input type="text" class="form-c" id="input" placeholder="Sudah Punya Proyek">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Daftar Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
