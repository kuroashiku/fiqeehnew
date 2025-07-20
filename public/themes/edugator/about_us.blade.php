@extends('layouts.theme')

@section('content')
   
  <!-- TENTANG KAMI -->
    <section class="px-6 lg:px-36 py-12 lg:py-24 relative">
        <img src="{{ asset('assets/images/background/tentang-kami-flower1.webp') }}" alt="background"
            class="absolute top-0 left-2/4 -translate-x-2/4 w-8/12 md:w-5/12 lg:w-3/12">
        <div class="container mx-auto relative">
            <div class="text-center lg:px-32">
                <p class="text-sm lg:text-base text-brand-500 font-semibold uppercase mb-6 lg:mb-8">
                    Tentang Kami
                </p>
                <h1 class="text-3xl lg:text-5xl font-semibold text-neutral-500 mb-4 lg:mb-6">
                    Memberikan Edukasi
                </h1>                
                <h2 class="text-2xl lg:text-4xl font-semibold text-brand-500 mb-6 lg:mb-8">
                    Berbisnis Syariah
                </h2>
                <p class="text-sm lg:text-base text-neutral-400 font-normal mb-16 lg:mb-24 lg:w-2/4 lg:mx-auto">
                    Sesuai Al Qur'an, As Sunnah dan pengalaman kami berbisnis syariah sejak 2015.
                </p>
               	<div id="player" data-plyr-provider="youtube" data-plyr-embed-id="6SM_gs7BBxI"></div>
                </div>
            </div>
        </div>
    </section>
<style>


.plyr__video-embed iframe {
	top: -50%;
	height: 200%;
}
</style>

    <!-- MITRA -->
    <section class="px-6 lg:px-36 py-10 lg:py-16">
        <div class="container mx-auto text-center">
            <h3 class="text-xl lg:text-3xl font-semibold text-brand-500 mb-12">
                Mitra Kami
            </h3>
            <div class="slider-mitra">
                <div class="cursor-pointer">
                    <img src="{{ asset('assets/images/mitra/mitra-01.png') }}" class="w-16 h-16 lg:w-[72px] lg:h-[72px] mx-auto" alt="Mitra">
                </div>
                <div class="cursor-pointer">
                    <img src="{{ asset('assets/images/mitra/mitra-02.png') }}" class="w-16 h-16 lg:w-[72px] lg:h-[72px] mx-auto" alt="Mitra">
                </div>
                <div class="cursor-pointer">
                    <img src="{{ asset('assets/images/mitra/mitra-03.png') }}" class="w-16 h-16 lg:w-[72px] lg:h-[72px] mx-auto" alt="Mitra">
                </div>
                <div class="cursor-pointer">
                    <img src="{{ asset('assets/images/mitra/mitra-04.png') }}" class="w-16 h-16 lg:w-[72px] lg:h-[72px] mx-auto" alt="Mitra">
                </div>
                <div class="cursor-pointer">
                    <img src="{{ asset('assets/images/mitra/mitra-05.png') }}" class="w-16 h-16 lg:w-[72px] lg:h-[72px] mx-auto" alt="Mitra">
                </div>
                <div class="cursor-pointer">
                    <img src="{{ asset('assets/images/mitra/mitra-06.png') }}" class="w-16 h-16 lg:w-[72px] lg:h-[72px] mx-auto" alt="Mitra">
                </div>
                <div class="cursor-pointer">
                    <img src="{{ asset('assets/images/mitra/mitra-07.png') }}" class="w-16 h-16 lg:w-[72px] lg:h-[72px] mx-auto" alt="Mitra">
                </div>
                <div class="cursor-pointer">
                    <img src="{{ asset('assets/images/mitra/mitra-08.png') }}" class="w-16 h-16 lg:w-[72px] lg:h-[72px] mx-auto" alt="Mitra">
                </div>
                <div class="cursor-pointer">
                    <img src="{{ asset('assets/images/mitra/mitra-09.png') }}" class="w-16 h-16 lg:w-[72px] lg:h-[72px] mx-auto" alt="Mitra">
                </div>
                <div class="cursor-pointer">
                    <img src="{{ asset('assets/images/mitra/mitra-10.png') }}" class="w-16 h-16 lg:w-[72px] lg:h-[72px] mx-auto" alt="Mitra">
                </div>
                <div class="cursor-pointer">
                    <img src="{{ asset('assets/images/mitra/mitra-11.png') }}" class="w-16 h-16 lg:w-[72px] lg:h-[72px] mx-auto" alt="Mitra">
                </div>
            </div>
        </div>
    </section>

    <!-- OWNER -->
    <section class="px-6 lg:px-36 py-10 lg:py-32">
        <div class="container mx-auto">
            <div class="flex flex-col-reverse lg:grid lg:grid-cols-5 lg:gap-6">
                <div class="lg:col-span-3">
                    <p class="text-sm lg:text-base text-brand-500 font-semibold uppercase mb-2 lg:mb-4">
                        Tentang Founder 
                    </p>               
                    <h2 class="text-2xl lg:text-4xl font-semibold text-neutral-500 mb-6 lg:mb-8">
                        Yudha Adhyaksa
                    </h2>
                    <p class="text-justify lg:text-left text-sm lg:text-base text-500-400 font-normal">
                        Adalah mantan bankir Asia yang menjadi Developer Syariah di tahun 2015. <br><br>
                        Tahun 2017, ia bergabung dengan Komunitas XBank Indonesia dan melihat banyak usaha mantan bankir sulit berkembang, padahal dulunya mereka hebat sewaktu bekerja di Bank. Mereka butuh ilmu bisnis yang tepat, sayangnya tidak punya uang untuk membayar pelatihan. Kondisi ini sama seperti dirinya dulu di awal hijrah. <br><br>
                        Ia putuskan untuk menolong mereka melalui Kulwa Bisnis Syariah di tahun 2019. Menariknya, yang ikut kebanyakan pegawai dan pengusaha non-bankir yang ingin berhijrah dari utang riba dan berbisnis syariah. Agar edukasinya bisa dijangkau siapapun dan dimanapun, ia meluncurkan Fiqeeh.com di tahun 2020. <br><br>
                        Hari ini, Fiqeeh.com telah membantu ribuan orang di 7 negara dan bekerjasama dengan Kementrian Perindustrian untuk membimbing Industri Kecil Menengah kembali ke jalan yang benar.
                    </p>
                   
                </div>
                <div class="lg:col-span-2">
                    <img src="{{ asset('assets/images/background/tentang-kami-owner.webp') }}" class=":w-full md:w-2/4 mx-auto lg:w-full mb-10 lg:mb-0" alt="Owner">
                </div>
            </div>
            
        </div>
    </section>
    
    <!-- VISI -->
     <section class="px-6 lg:px-36 py-12 lg:py-20 bg-neutral-600">
        <div class="container mx-auto">
            <div class="lg:grid lg:grid-cols-2 lg:gap-6">
                <div class="lg:flex lg:flex-col lg:justify-center lg:items-start mb-10 lg:mb-0">
                    <div class="mb-6 text-center lg:text-left">
                        <p class="text-sm lg:text-base text-brand-500 font-semibold uppercase mb-4">
                            Visi
                        </p>
                        <h2 class="text-2xl lg:text-4xl font-semibold text-white mb-2">
                            Mensejahterakan
                        </h2>
                        <h2 class="text-2xl lg:text-4xl font-semibold text-white mb-2">
                            Pengusaha Indonesia
                        </h2>
                        <h3 class="text-2xl lg:text-4xl font-semibold text-brand-500 mb-4">
                            Dengan Ilmu Syariah
                        </h3>
                        <p class="text-xs lg:text-sm text-neutral-50 font-normal mb-10 lg:mb-16">
                            Mencetak 10 juta pengusaha baru sesuai standar syariah dan program pemerintah untuk mencetak 4% pengusaha di tahun 2030.
                        </p>
                    </div>
                    <a href="#"
                        class="inline-block w-full lg:w-auto lg:px-6 py-2.5 rounded-lg text-sm text-brand-50 bg-brand-500 border-none text-center">
                        Langganan Sekarang
                    </a>
                </div>
                <div>
                    <img src="{{ asset('assets/images/background/tentang-kami-visi.webp') }}" class="w-full md:h-[250px] lg:h-full h-full object-cover rounded-3xl" alt="Photo">
                </div>
            </div>
        </div>
    </section>
    
    <!-- MENTOR -->
    {{-- <section class="px-6 lg:px-36 py-20 lg:py-28">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 text-center">
                <p class="text-sm lg:text-base text-brand-500 font-semibold uppercase mb-4">
                    Mentor
                </p>
                <h2 class="text-2xl lg:text-4xl font-semibold text-neutral-500 mb-2">
                    Fiqeeh Memberikan
                </h2>
                <h3 class="text-2xl lg:text-4xl font-semibold text-brand-500 mb-10 lg:mb-12">
                    Mentor Terbaik
                </h3>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6 lg:gap-20">
                <div class="text-center lg:text-left mb-10 lg:mb-12">
                    <img src="{{ asset('assets/images/cards/tentang-kami/mentor-1.png') }}" class="rounded-lg w-full h-[200px] md:h-[280px] lg:h-[400px] object-cover bg-top mb-3 lg:mb-6" alt="Mentor">
                    <h4 class="text-lg lg:text-2xl font-semibold text-neutral-500 mb-1 lg:mb-2">
                        Yudha Adhyaksa
                    </h4>
                    <p class="text-xs lg:text-base font-normal text-neutral-400">
                        Developer Syariah & Konsultan
                    </p>
                </div>
                <div class="text-center lg:text-left mb-10 lg:mb-12">
                    <img src="{{ asset('assets/images/cards/tentang-kami/mentor-2.png') }}" class="rounded-lg w-full h-[200px] md:h-[280px] lg:h-[400px] object-cover bg-top mb-3 lg:mb-6" alt="Mentor">
                    <h4 class="text-lg lg:text-2xl font-semibold text-neutral-500 mb-1 lg:mb-2">
                        Nurcahyanto
                    </h4>
                    <p class="text-xs lg:text-base font-normal text-neutral-400">
                        Mantan Manager Bank - Debt Collector
                    </p>
                </div>
                <div class="text-center lg:text-left mb-10 lg:mb-12">
                    <img src="{{ asset('assets/images/cards/tentang-kami/mentor-3.png') }}" class="rounded-lg w-full h-[200px] md:h-[280px] lg:h-[400px] object-cover bg-top mb-3 lg:mb-6" alt="Mentor">
                    <h4 class="text-lg lg:text-2xl font-semibold text-neutral-500 mb-1 lg:mb-2">
                        Ukitrianto
                    </h4>
                    <p class="text-xs lg:text-base font-normal text-neutral-400">
                        Pengusaha Ayam Bacem 
                    </p>
                </div>
                <div class="text-center lg:text-left mb-10 lg:mb-12">
                    <img src="{{ asset('assets/images/cards/tentang-kami/mentor-4.png') }}" class="rounded-lg w-full h-[200px] md:h-[280px] lg:h-[400px] object-cover bg-top mb-3 lg:mb-6" alt="Mentor">
                    <h4 class="text-lg lg:text-2xl font-semibold text-neutral-500 mb-1 lg:mb-2">
                        Asep Suryana
                    </h4>
                    <p class="text-xs lg:text-base font-normal text-neutral-400">
                        Pengusaha Ayam Goreng Syariah
                    </p>
                </div>
                <div class="text-center lg:text-left mb-10 lg:mb-12">
                    <img src="{{ asset('assets/images/cards/tentang-kami/mentor-5.png') }}" class="rounded-lg w-full h-[200px] md:h-[280px] lg:h-[400px] object-cover bg-top mb-3 lg:mb-6" alt="Mentor">
                    <h4 class="text-lg lg:text-2xl font-semibold text-neutral-500 mb-1 lg:mb-2">
                        Sofyan Hadi
                    </h4>
                    <p class="text-xs lg:text-base font-normal text-neutral-400">
                        Pengusaha Mebel Kayu Jati
                    </p>
                </div>
                <div class="text-center lg:text-left mb-10 lg:mb-12">
                    <img src="{{ asset('assets/images/cards/tentang-kami/mentor-6.png') }}" class="rounded-lg w-full h-[200px] md:h-[280px] lg:h-[400px] object-cover bg-top mb-3 lg:mb-6" alt="Mentor">
                    <h4 class="text-lg lg:text-2xl font-semibold text-neutral-500 mb-1 lg:mb-2">
                        Abi
                    </h4>
                    <p class="text-xs lg:text-base font-normal text-neutral-400">
                        Ketua XBank Yogya & Pengusaha Kos
                    </p>
                </div>
            </div>
        </div>
    </section> --}}
    
    <!-- TABLET -->
    <section class="px-6 lg:px-36 pt-10 lg:pt-16 bg-brand-50">
        <div class="container mx-auto">
            <div class="text-center lg:px-32">
                <p class="text-sm lg:text-base text-brand-500 font-semibold uppercase mb-4">
                    Mentornya Pengusaha
                </p>
                <h2 class="text-2xl lg:text-4xl font-semibold text-neutral-500 mb-2">
                    Kampus Bisnis Syariah
                </h2>
                <h3 class="text-xl lg:text-3xl font-semibold text-brand-500 mb-4">
                    Terlengkap
                </h3>
                <p class="text-sm lg:text-base text-neutral-400 font-normal mb-10 lg:mb-16">
                    Tonton semua kelas berlangganan
                </p>
                <a href="daftar.html"
                    class="inline-block w-full md:w-auto text-center md:px-6 py-2.5 rounded-lg text-sm lg:text-base text-brand-50 bg-brand-500 border-none mb-12 lg:mb-16">
                    Langganan Sekarang
                </a>
                <img src="{{ asset('assets/images/background/landing-page-tablet.webp') }}" class="w-full object-contain" alt="Image">
            </div>
        </div>
    </section>
{{-- 
    <div style="background: white;color: black;">
    
        <video
        id="lecture_video"
        class="video-js vjs-fluid vjs-default-skin"
        controls
        data-setup='{ "fluid": true, "techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "https://youtu.be/szlru4h0TG8"}] }'
        >
        </video> --}}

        {{-- <div class="blog-post-page-header py-5">
            <div class="container py-3">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="p-1 mt-1">
                            <h1 class="text-center font-weight-bold mb-4">BISNISKU<br> SURGAKU</h1>
                            <img class="img-fluid" src="{{ asset('assets/images/about_us-1.png') }}" alt="Yudha Adhyaksa">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-1">
                            <h2 class="mt-3">Tentang Founder</h2>
                            <p>Semua dimulai dari visi seorang founder, Yudha Adhyaksa, di ruko sempit di Yogyakarta.</p>
                            <p>Setelah hijrah dari Bank Jepang no. 1 di dunia di tahun 2015 dan berbisnis property syariah, Yudha Adhyaksa mem-pivot
                            bisnisnya menjadi lembaga pendidikan bisnis syariah di tahun 2020. Hal ini dilakukannya karena merasa miris dengan fakta
                            banyak UKM yang sengsara akibat melanggar hukum syariah sehingga menyebabkan keluarga terpecah, ditimpa musibah
                            beruntun, sakit ‘misterius’ hingga bangkrut.</p>
                            <p>Ia pun memantaskan diri menjadi mentor dengan mengikuti banyak pelatihan bisnis syariah di hotel bernilai puluhan juta.
                            Setelah itu ia berencana menuangkan semua pengalamannya ke Fiqeeh. Ia percaya berbisnis secara syariah adalah
                            jalan paling ideal untuk meraih 2 keuntungan ; profit besar di dunia dan masuk surga.</p>
                            <p>Dan hari ini, Fiqeeh telah membantu ribuan orang dari berbagai latar belakang hingga luar Negeri yaitu Jerman,
                            Qatar, Brunei Darussalam dan Perth. Kami ingin membuktikan orang yang berbisnis syariah setelah hijrah akan lebih sukses
                            daripada kerja di Bank riba.</p>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
{{-- 
        <div class="blog-post-page-header py-5">
            <div class="container py-3">
                <h2 class="text-center mb-4 f-roboto-slab">Apa Itu Fiqeeh?</h2>
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <img class="img-fluid" src="{{ asset('assets/images/about_us-2.png') }}" alt="photo1631022638 1.png">
                    </div>
                    <div class="col-sm-6">
                        <img class="img-fluid" src="{{ asset('assets/images/about_us-3.jpg') }}" alt="IMG-20190117-WA0007 1.png">
                    </div>
                </div>
                <p class="text-center mt-3">Adalah Kelas Bisnis Syariah yang didirikan PT. Kampusnya Pengusaha Hijrah tahun 2020 di Yogyakarta (NIB. 1220000560283).
                Kami memberikan edukasi tentang cara berbisnis yang benar untuk mendapat rezeki halal sesuai aturan Islam dan
                berdasarkan pengalaman riil berbisnis syariah sejak 2015. Sangat cocok untuk Anda yang ingin merintis bisnis ataupun
                mengubah bisnis sekarang menjadi syar’i.</p>
            </div>
        </div>
        <div class="blog-post-container-wrap py-5">
            <div class="container">
                <div class="row">
                <div class="col-sm-6 align-self-center">
                    <h2 class="text-end">Tujuan Fiqeeh</h2>
                    <p>Mencetak 1 juta pengusaha baru sesuai standar hukum syariah. Ini selaras dengan cita-cita pemerintah mewujudkan 4%
                    jumlah wiraswasta Indonesia di tahun 2030. Fiqeeh akan menyediakan semua kebutuhan ilmu pengusaha lengkap mulai
                    dari membuka mata hingga wafat, insyaa Allah.</p>
                </div>
                    <div class="col-sm-6">
                        <img class="img-fluid" src="{{ asset('assets/images/about_us-4.png') }}" alt="Laptop">
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- <div class="blog-post-container-wrap py-5">
            <div class="container">
                <h2 class="text-center">Siapa Pematerinya?</h2>
                <p class="text-center">Pematerinya adalah</p>
                <div class="row">
                    <div class="col-sm-6 align-self-center">
                        <img class="img-fluid mb-3" src="{{ asset('assets/images/about_us-5.png') }}" alt="Foto Pembicara">
                    </div>
                    <div class="col-sm-6">
                        <ol class="pl-3">
                            <li>
                                <h6 class="font-weight-bold">Coach Utama: Yudha Adhyaksa</h6>
                                <p>Mantan bankir Asia dan Developer Property Syariah sejak 2015 setelah belajar otodidak dari banyak Asatidz, fatwa MUI
                                serta pengusaha senior. Profesinya sekarang author 2 buku, Konsultan UMKM dan Konsultan Kawasan Property Syariah.</p>
                            </li>
                            <li>
                                <h6 class="font-weight-bold">Tim Internal Fiqeeh</h6>
                                <p>Memiliki latar belakang berbeda-beda dan membawakan materi dibimbing Coach Utama sehingga memenuhi standar hukum
                                syariah.</p>
                            </li>
                            <li>
                                <h6 class="font-weight-bold">Pengusaha UKM</h6>
                                <p>Pengusaha yang telah terbukti berhasil menjalankan usahanya dan dalam membawakan materi sudah sesuai standar hukum
                                syariah.</p>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- <div class="blog-post-container-wrap py-5">
            <div class="container">
                <h2 class="text-center f-roboto-slab">MITRA KAMI</h2>
                <div class="d-flex flex-wrap justify-content-center">
                    <img src="{{ asset('assets/images/partner-1.png') }}" alt="Kementerian Perindustrian" class=" partner-logo">
                    <img src="{{ asset('assets/images/partner-2.png') }}" alt="startup4industry" class=" partner-logo">
                    <img src="{{ asset('assets/images/partner-3.png') }}" alt="khalifa premier logo" class=" partner-logo">
                    <img src="{{ asset('assets/images/partner-4.png') }}" alt="Gussakka Syariah Indonesia" class="partner-logo">
                    <img src="{{ asset('assets/images/partner-5.png') }}" alt="Grand" class=" partner-logo">
                    <img src="{{ asset('assets/images/partner-6.png') }}" alt="An nabil logo" class="partner-logo"> 
                </div>
            </div>
        </div> --}}
    {{-- </div> --}}
@endsection

@section('page-css')
    {{-- <link rel="stylesheet" href="{{asset('assets/plugins/video-js/video-js.min.css')}}"> --}}
@endsection

@section('page-js')
    {{-- <script src="{{asset('assets/plugins/video-js/video.min.js')}}"></script>
    <script src="{{asset('assets/plugins/video-js/Youtube.min.js')}}"></script> --}}
@endsection