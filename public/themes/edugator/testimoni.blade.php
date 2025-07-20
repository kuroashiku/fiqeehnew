@extends('layouts.theme')

@section('content')

    @php
        $ebook = \App\Ebook::where('free', 1)->paginate(6);
    @endphp
    
    @if($ebook->total())
        <div class="py-5" style="background: rgba(0, 35, 38, 1);">
            <div class="container text-center" style="color: rgba(255, 200, 0, 1);">
                <h1><b>Testimoni Member Fiqeeh</b></h1>
                <div class="lecture-video-wrapper video-player-wrapper mt-5">
                    <video
                    id="lecture_video"
                    class="video-js vjs-fluid vjs-default-skin"
                    controls
                    data-setup='{ "fluid": true, "techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "https://youtu.be/T7KFPifZ3wc"}] }'
                    >
                    </video>
                </div>
            </div>
            
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6" style="padding-top: 10px;">
                        <div class="row" style="background: white;color: black;padding: 20px 0px;width: 100%;border-radius: 10px;">
                            <div class="col-sm-12">
                                <p>“Bismillah, terimakasih banyak saya haturkan. Jazakumullahu khayr kepada Pak Yudha dan Tim  yang sangat luar biasa. Penyampaiannya begitu bermanfaat bagi saya pribadi, bisa belajar mendapatkan ilmu unutk tercapainya sukses dunia akhirat. Aamiin ya Rabbal 'alamin"</p>
                            </div>
                            <hr style="background-color: black;width: 100%;">
                            <div class="col-sm-12">
                                <span><b>Dykke</b></span><br>
                                <span>Pengusaha</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" style="padding-top: 10px;">
                        <div class="row" style="background: white;color: black;padding: 20px 0px;width: 100%;border-radius: 10px;">
                            <div class="col-sm-12">
                                <p>Alhamdulillah..Kita semua belajar untuk lebih memahami batasan dan cakupan mana dalam berbisnis syariah yang bisa kita jalankan. Dibimbing oleh coach Yudha yang punya banyak pengalaman yang dibagikan ke kita semua disini."</p>
                            </div>
                            <hr style="background-color: black;width: 100%;">
                            <div class="col-sm-12">
                                <span><b>Rochani</b></span><br>
                                <span>Owner Hotel Grand Dafam</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" style="padding-top: 10px;">
                        <div class="row" style="background: white;color: black;padding: 20px 0px;width: 100%;border-radius: 10px;">
                            <div class="col-sm-12">
                                <p>Terimakasih Pak Yudha juga Tim Fiqeeh, banyak sekali ilmu yang didapat. Sepertinya Allah mmeberikan jawaban langsung kepada saya lewat Fiqeeh ini, karena baru saja saya resign dari lembaga riba. Jazakumullahu khayr semoga menjadi amal jariyah."</p>
                            </div>
                            <hr style="background-color: black;width: 100%;">
                            <div class="col-sm-12">
                                <span><b>Yuni</b></span><br>
                                <span>Ibu Rumah Tangga</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" style="padding-top: 10px;">
                        <div class="row" style="background: white;color: black;padding: 20px 0px;width: 100%;border-radius: 10px;">
                            <div class="col-sm-12">
                                <p>Bagi temen-temen yang ingin berbisnis, dan ingin bisnisnya berkah. Tidak hanya mencari untung tapi juga keberkahan. Saran saya temen-temen ikut join hijrahacademy.com. Ini website bagus banget menurut saya, dan belajar masa depan belajar itu disini, Fiqeeh."</p>
                            </div>
                            <hr style="background-color: black;width: 100%;">
                            <div class="col-sm-12">
                                <span><b>Aryo Diponegoro</b></span><br>
                                <span>Founder "Yuk Bisnis Properti"</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" style="padding-top: 10px;">
                        <div class="row" style="background: white;color: black;padding: 20px 0px;width: 100%;border-radius: 10px;">
                            <div class="col-sm-12">
                                <p>Allah telah mengabulkan do'a-do'a kami, alhamdulillah kami telah dipertemukan dengan Fiqeeh. Banyak uneg-uneg dan permasalahan kami telah terjawab di kelas online ini, walau masih belum bisa mempratikkan semuanya. Jazakumullahu khayr coach Yudha dan Tim."</p>
                            </div>
                            <hr style="background-color: black;width: 100%;">
                            <div class="col-sm-12">
                                <span><b>Ninik</b></span><br>
                                <span>Pengusaha</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
{{--
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row" style="background: rgba(196, 196, 196, 0.5);color: rgba(255, 200, 0, 1);padding: 20px 0px;margin: 0px 5px;">
                            <div class="col-sm-12">
                                <p>“Barang siapa berdagang namun belem memahami agama,
maka dia pasti akan terjerumus dalam riba,kemudian terjerumus
kedalamnya dan terus menerus terjerumus</p>
                            </div>
                            <hr style="background-color: black;width: 100%;">
                            <div class="col-sm-12">
                                <span>Ninik</span><br>
                                <span>Pengusaha</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row" style="background: rgba(196, 196, 196, 0.5);color: rgba(255, 200, 0, 1);padding: 20px 0px;margin: 0px 5px;">
                            <div class="col-sm-12">
                                <p>“Barang siapa berdagang namun belem memahami agama,
maka dia pasti akan terjerumus dalam riba,kemudian terjerumus
kedalamnya dan terus menerus terjerumus</p>
                            </div>
                            <hr style="background-color: black;width: 100%;">
                            <div class="col-sm-12">
                                <span>Ninik</span><br>
                                <span>Pengusaha</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        --}}
    @else
        {!! no_data(); !!}
    @endif
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/plugins/video-js/video-js.min.css')}}">
@endsection

@section('page-js')
    <script src="{{asset('assets/plugins/video-js/video.min.js')}}"></script>
    <script src="{{asset('assets/plugins/video-js/Youtube.min.js')}}"></script>
@endsection