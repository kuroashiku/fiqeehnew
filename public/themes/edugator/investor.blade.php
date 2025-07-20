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
                    <a class="nav-link btn btn-theme-primary mt-4" href="#"> <i class="la la-phone"></i> WhatsApp</a>
                    {{-- <button type="submit" style="background: rgba(255, 255, 255, 1);" class="btn btn-block"><b>Upload Proposal</b></button> --}}
                    {{-- <img src="assets/img/mac.jpg" alt="" class="img-fluid"> --}}
                </div>
            </div>
            <div class="row juduls justify-content-center mt-sm-5">
                <div class="col-sm-12 text-center mt-sm-5 mb-sm-5">
                    <h3 class="un">INVESTOR</h3>
                    <hr style="height: 1px;background-color: white;width: 25%;">
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12 mt-5">
                    <div class="single-card">
                        <div class="card-icon text-center">
                            <h2 style="padding-top: 10px;">Nama Investor</h2>
                        </div>
                        <div class="card-content">
                            <img class="rounded mx-auto d-block" style="height: 180px;margin-top: 20px;margin-bottom: 20px;" src="{{ asset('assets/images/image-ceo.png') }}" alt="Support services">
                            <h3>Deskripsi Singkat : </h3>
                            <div class="row mt-3">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h4>Usia</h4>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h5>45thn</h5>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h4>Domisili</h4>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h5>-</h5>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h4>Latar Belakang</h4>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h5>-</h5>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h4>Pekerjaan</h4>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h5>-</h5>
                                </div>
                            </div>
                            <br>
                            <button type="submit" style="background: rgba(255, 255, 255, 1);" class="btn btn-block"><b>Upload Proposal</b></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12 mt-5">
                    <div class="single-card">
                        <div class="card-icon text-center">
                            <h2 style="padding-top: 10px;">Nama Investor</h2>
                        </div>
                        <div class="card-content">
                            <img class="rounded mx-auto d-block" style="height: 180px;margin-top: 20px;margin-bottom: 20px;" src="{{ asset('assets/images/image-ceo.png') }}" alt="Support services">
                            <h3>Deskripsi Singkat : </h3>
                            <div class="row mt-3">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h4>Usia</h4>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h5>45thn</h5>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h4>Domisili</h4>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h5>-</h5>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h4>Latar Belakang</h4>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h5>-</h5>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h4>Pekerjaan</h4>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h5>-</h5>
                                </div>
                            </div>
                            <br>
                            <button type="submit" style="background: rgba(255, 255, 255, 1);" class="btn btn-block"><b>Upload Proposal</b></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12 mt-5">
                    <div class="single-card">
                        <div class="card-icon text-center">
                            <h2 style="padding-top: 10px;">Nama Investor</h2>
                        </div>
                        <div class="card-content">
                            <img class="rounded mx-auto d-block" style="height: 180px;margin-top: 20px;margin-bottom: 20px;" src="{{ asset('assets/images/image-ceo.png') }}" alt="Support services">
                            <h3>Deskripsi Singkat : </h3>
                            <div class="row mt-3">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h4>Usia</h4>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h5>45thn</h5>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h4>Domisili</h4>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h5>-</h5>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h4>Latar Belakang</h4>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h5>-</h5>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h4>Pekerjaan</h4>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h5>-</h5>
                                </div>
                            </div>
                            <br>
                            <button type="submit" style="background: rgba(255, 255, 255, 1);" class="btn btn-block"><b>Upload Proposal</b></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12 mt-5">
                    <div class="single-card">
                        <div class="card-icon text-center">
                            <h2 style="padding-top: 10px;">Nama Investor</h2>
                        </div>
                        <div class="card-content">
                            <img class="rounded mx-auto d-block" style="height: 180px;margin-top: 20px;margin-bottom: 20px;" src="{{ asset('assets/images/image-ceo.png') }}" alt="Support services">
                            <h3>Deskripsi Singkat : </h3>
                            <div class="row mt-3">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h4>Usia</h4>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h5>45thn</h5>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h4>Domisili</h4>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h5>-</h5>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h4>Latar Belakang</h4>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h5>-</h5>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h4>Pekerjaan</h4>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h5>-</h5>
                                </div>
                            </div>
                            <br>
                            <button type="submit" style="background: rgba(255, 255, 255, 1);" class="btn btn-block"><b>Upload Proposal</b></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
