@extends('layouts.theme')

@php
$categories = \App\Category::parent()->whereStatus(1)->get();
$categoriesWithCourses = \App\Category::parent()->has('courses')->whereStatus(1)->get();
@endphp

@section('content')
<section class="px-6 lg:px-36 py-12 lg:py-24 relative">
    <img src="{{ asset('assets/images/background/tentang-kami-flower1.webp') }}" alt="background"
        class="absolute top-0 left-2/4 -translate-x-2/4 w-8/12 md:w-5/12 lg:w-3/12">
    <div class="container mx-auto relative">
        <div class="text-center lg:px-32">
            <p class="text-sm lg:text-base text-brand-500 font-semibold uppercase mb-6 lg:mb-8">
               Kebijakan Privasi
            </p>
            <h1 class="text-3xl lg:text-5xl font-semibold text-neutral-500 mb-4 lg:mb-6">
                KEBIJAKAN PRIVASI FIQEEH
            </h1>
            {{-- <h2 class="text-2xl lg:text-4xl font-semibold text-brand-500 mb-6 lg:mb-8">
                Seputar Tanya Jawab
            </h2> --}}
            <p class="text-sm lg:text-base text-neutral-400 font-normal  lg:mb-24 lg:w-2/4 lg:mx-auto">
                Peraturan ini berlaku pada penggunaan ("Anda") pada aplikasi atau situs web PT Kampusnya Pengusaha Hijrah ("Kami" atau “Fiqeeh.com”) yaitu sebuah perseroan terbatas yang didirikan dan beroperasi secara sah berdasarkan hukum Negara Republik Indonesia dan berdomisili di Yogyakarta. Indonesia.            </p>
            <br>
            <p class="text-sm lg:text-base text-neutral-400 font-normal ">
                <b>Dengan membeli, Anda dianggap telah membaca, memahami dan menyetujui semua isi dalam Kebijakan Privasi ini.</b>
            </p>
        </div>
    </div>
    </div>
</section>
<section class="text-sm md:px-6 lg:mb-24 lg:w-2/4 lg:mx-auto relative hidden md:block">
    1. Ketentuan Umum <br>
    Perlindungan Data Pribadi adalah hal terpenting bagi Kami untuk melindungi dan menghormati privasi Anda saat menggunakan aplikasi dan situs web “Fiqeeh.com”. Kebijakan Privasi mengatur landasan dasar cara Kami mengumpulkan, menyimpan, menggunakan, mengolah, menguasai, mentransfer, mengungkapkan dan melindungi Data Pribadi Anda. Jika Anda berusia di bawah 18 (delapan belas) tahun, mohon memberitahukan Kebijakan Privasi ini dengan orang tua atau wali Anda. Dengan menggunakan layanan, Anda dan/atau orang tua, wali atau pengampu Anda menyetujui cara dalam Kebijakan Privasi ini. <br> <br>
    2. Data Pribadi yang dapat Kami Kumpulkan <br>
    Kami mengumpulkan informasi untuk mengidentifikasi Anda ketika mendaftar atau menggunakan layanan untuk tujuan yang diizinkan berdasarkan peraturan perundang-undangan yang berlaku melalui data pribadi, informasi teknis, informasi tentang kunjungan Anda, data nilai Anda dan informasi yang Kami terima dari sumber lain. Kami akan mengambil langkah-langkah dalam batas kewajaran untuk memverifikasi informasi sesuai dengan Peraturan yang Berlaku. <br><br>
    3. Penggunaan Data Pribadi <br>
    Kami dapat menggunakan dan/atau mengolah Data Pribadi Anda untuk tujuan berikut: <br>
        a. Mengidentifikasi dan mendaftarkan Anda sebagai pengguna Aplikasi, serta untuk mengadministrasikan, memverifikasi, menghapus, atau mengelola Akun Anda <br>

        b. Membantu Kami menyediakan layanan tertentu pada Aplikasi yang Anda ingin gunakan<br>

        c. Memverifikasi pentautan (pembuatan link) Akun Fiqeeh Anda untuk mengolah dan memfasilitasi pembayaran yang Anda lakukan<br>
    
        d. Menjalankan kewajiban Kami dalam menyediakan informasi, produk, dan jasa kepada Anda<br>
    
        e. Menyediakan informasi terkait produk dan jasa lain Kami atau mengizinkan pihak ketiga untuk menyediakan Anda informasi tentang produk dan jasa yang Kami anggap dapat menarik minat Anda. Kami dapat menghubungi Anda melalui telepon, pesan teks, email atau cara lain dengan informasi tentang produk dan jasa Kami<br>
    
        f. Memberitahukan Anda tentang perubahan pada produk, jasa atau layanan Kami<br>
    
        g. Memastikan bahwa konten dari Aplikasi Kami disajikan dengan cara yang paling efektif bagi Anda<br>
    
        h. Mengelola dan memproses segala bentuk poin atau hadiah yang Anda terima saat menggunakan Aplikasi<br>
    
        i. Menganalisa aktivitas, perilaku, dan data demografis pengguna termasuk kebiasaan Anda guna mempersonalisasikan layanan.<br>
    
        j. Memproses pembayaran terkait penggunaan layanan Kami<br>
    
        k. Menyediakan laporan terkait aktivitas, perilaku, dan data demografis pengguna termasuk kebiasaan Anda agar Kami dapat mempersonalisasikan layanan <br>
    
        l. Melakukan pencarian sumber masalah (troubleshooting), analisis data, pengujian, penelitian, serta tujuan statistik dan survei lainnya<br>
    
        m. Memperbaiki layanan Kami sehingga konten disajikan dengan cara paling efektif untuk Anda<br>
    
        n. Memungkinkan Anda berpartisipasi dalam fitur layanan interaktif Kami, ketika Anda inginkan<br>
    
        o. Sebagai bagian dari usaha memastikan keselamatan dan keamanan aplikasi dan situs web Kami<br>
    
        p. Mengukur dan memahami efektivitas periklanan yang Kami lakukan kepada Anda dan pihak lain, serta menyajikan iklan produk dan jasa yang relevan bagi Anda <br><br>
        4. Pengungkapan Data Pribadi <br>
        Kami dapat mengungkapkan Data Pribadi Anda melalui aplikasi, situs web dan/atau akun media sosial Kami untuk tujuan pengumuman, hasil kompetisi dan/atau aktivitas lainnya yang Kami selenggarakan.
            a. Kami juga dapat membagi atau mengungkapkan Data Pribadi Anda dengan anggota kelompok usaha Kami sesuai dengan ketentuan peraturan perundang-undangan yang berlaku. <br>
            b. Kami dapat membagi Data Pribadi Anda dengan pihak ketiga untuk tujuan yang diizinkan peraturan perundang-undangan yang berlaku, termasuk aksi korporasi yang terjadi pada perusahaan Kami: <br>
        Dalam hal pembagian Data Pribadi Anda dengan pihak ketiga, kami memastikan bahwa pihak ketiga dan Afiliasi kami menjaga Data Pribadi Anda sesuai dengan peraturan perundang-undangan yang berlaku. <br> <br>
        5. Penyimpanan Data Pribadi <br>
Seluruh informasi Pribadi yang Anda berikan kepada Kami disimpan di jaringan yang aman dan Anda menyetujui pengalihan, penyimpanan, serta pengolahan yang terjadi pada aplikasi atau situs web Kami dan Kami mengambil langkah-langkah dalam batas kewajaran Peraturan yang Berlaku. <br> <br>
6. Keamanan Data Pribadi Anda <br>
Kerahasiaan Data Pribadi merupakan prioritas bagi Kami dan Afiliasi Kami. Kami akan senantiasa mengambil tindakan hukum yang layak, tindakan organisasi dan teknis yang layak untuk memastikan bahwa Data Pribadi Anda aman dan terlindungi. Setiap pemrosesan Data Pribadi Anda hanya akan dilakukan sesuai dengan Kebijakan Privasi ini dan ketentuan perundang-undangan yang berlaku.
Anda bertanggung jawab untuk menjaga kerahasiaan akun Anda, termasuk kata sandi dan rincian pembayaran, terhadap siapapun dan menjaga dan memastikan keamanan perangkat Anda yang digunakan untuk mengakses dan menggunakan Aplikasi. <br> <br>
7. Hak Anda <br>
Anda dapat memohon untuk penghapusan atau mengkoreksi Data Pribadi Anda pada Aplikasi atau menarik persetujuan Anda untuk setiap atau segala pengumpulan, penggunaan atau pengungkapan Data Pribadi Anda dengan memberikan kepada kami pemberitahuan yang wajar secara tertulis melalui detail kontak yang tercantum pada Kebijakan Privasi ini.  <br> <br>
8. Kebijakan Cookies <br>
Ketika Anda menggunakan Aplikasi, Kami dapat menempatkan sejumlah cookies pada browser Anda untuk tujuan pengoperasian aplikasi atau situs web Kami, mengaktifkan fungsi tertentu, memberikan analisis, menyimpan preferensi Anda; dan memungkinkan pengiriman iklan dan pengiklanan berdasarkan perilaku guna mempersonalisasi konten dan meningkatkan layanan. <br> <br>
9. Pengakuan dan Persetujuan <br>
Anda mengerti dan setuju bahwa Kebijakan Privasi ini merupakan perjanjian dalam bentuk elektronik. Dengan membeli, Anda dan/atau orang tua, wali atau pengampu Anda (dalam hal Anda berusia di bawah 18 (delapan belas) tahun) telah menyetujui Kebijakan Privasi berikut perubahannya sehingga keberlakuan Kebijakan Privasi adalah sah dan mengikat secara hukum sesuai peraturan berlaku. Jika Anda memiliki pertanyaan terkait Kebijakan Privasi atau Anda ingin mengkoreksi Data Pribadi Anda, silahkan menghubungi Kami melalui admin@fiqeeh.com.
</section>

<section class="text-sm md:px-6 lg:mb-24 lg:w-2/4 lg:mx-auto relative md:hidden" style="margin-left: 15px">
    1. Ketentuan Umum <br>
    Perlindungan Data Pribadi adalah hal terpenting bagi Kami untuk melindungi dan menghormati privasi Anda saat menggunakan aplikasi dan situs web “Fiqeeh.com”. Kebijakan Privasi mengatur landasan dasar cara Kami mengumpulkan, menyimpan, menggunakan, mengolah, menguasai, mentransfer, mengungkapkan dan melindungi Data Pribadi Anda. Jika Anda berusia di bawah 18 (delapan belas) tahun, mohon memberitahukan Kebijakan Privasi ini dengan orang tua atau wali Anda. Dengan menggunakan layanan, Anda dan/atau orang tua, wali atau pengampu Anda menyetujui cara dalam Kebijakan Privasi ini. <br> <br>
    2. Data Pribadi yang dapat Kami Kumpulkan <br>
    Kami mengumpulkan informasi untuk mengidentifikasi Anda ketika mendaftar atau menggunakan layanan untuk tujuan yang diizinkan berdasarkan peraturan perundang-undangan yang berlaku melalui data pribadi, informasi teknis, informasi tentang kunjungan Anda, data nilai Anda dan informasi yang Kami terima dari sumber lain. Kami akan mengambil langkah-langkah dalam batas kewajaran untuk memverifikasi informasi sesuai dengan Peraturan yang Berlaku. <br><br>
    3. Penggunaan Data Pribadi <br>
    Kami dapat menggunakan dan/atau mengolah Data Pribadi Anda untuk tujuan berikut: <br>
        a. Mengidentifikasi dan mendaftarkan Anda sebagai pengguna Aplikasi, serta untuk mengadministrasikan, memverifikasi, menghapus, atau mengelola Akun Anda <br>

        b. Membantu Kami menyediakan layanan tertentu pada Aplikasi yang Anda ingin gunakan<br>

        c. Memverifikasi pentautan (pembuatan link) Akun Fiqeeh Anda untuk mengolah dan memfasilitasi pembayaran yang Anda lakukan<br>
    
        d. Menjalankan kewajiban Kami dalam menyediakan informasi, produk, dan jasa kepada Anda<br>
    
        e. Menyediakan informasi terkait produk dan jasa lain Kami atau mengizinkan pihak ketiga untuk menyediakan Anda informasi tentang produk dan jasa yang Kami anggap dapat menarik minat Anda. Kami dapat menghubungi Anda melalui telepon, pesan teks, email atau cara lain dengan informasi tentang produk dan jasa Kami<br>
    
        f. Memberitahukan Anda tentang perubahan pada produk, jasa atau layanan Kami<br>
    
        g. Memastikan bahwa konten dari Aplikasi Kami disajikan dengan cara yang paling efektif bagi Anda<br>
    
        h. Mengelola dan memproses segala bentuk poin atau hadiah yang Anda terima saat menggunakan Aplikasi<br>
    
        i. Menganalisa aktivitas, perilaku, dan data demografis pengguna termasuk kebiasaan Anda guna mempersonalisasikan layanan.<br>
    
        j. Memproses pembayaran terkait penggunaan layanan Kami<br>
    
        k. Menyediakan laporan terkait aktivitas, perilaku, dan data demografis pengguna termasuk kebiasaan Anda agar Kami dapat mempersonalisasikan layanan <br>
    
        l. Melakukan pencarian sumber masalah (troubleshooting), analisis data, pengujian, penelitian, serta tujuan statistik dan survei lainnya<br>
    
        m. Memperbaiki layanan Kami sehingga konten disajikan dengan cara paling efektif untuk Anda<br>
    
        n. Memungkinkan Anda berpartisipasi dalam fitur layanan interaktif Kami, ketika Anda inginkan<br>
    
        o. Sebagai bagian dari usaha memastikan keselamatan dan keamanan aplikasi dan situs web Kami<br>
    
        p. Mengukur dan memahami efektivitas periklanan yang Kami lakukan kepada Anda dan pihak lain, serta menyajikan iklan produk dan jasa yang relevan bagi Anda <br><br>
        4. Pengungkapan Data Pribadi <br>
        Kami dapat mengungkapkan Data Pribadi Anda melalui aplikasi, situs web dan/atau akun media sosial Kami untuk tujuan pengumuman, hasil kompetisi dan/atau aktivitas lainnya yang Kami selenggarakan.
            a. Kami juga dapat membagi atau mengungkapkan Data Pribadi Anda dengan anggota kelompok usaha Kami sesuai dengan ketentuan peraturan perundang-undangan yang berlaku. <br>
            b. Kami dapat membagi Data Pribadi Anda dengan pihak ketiga untuk tujuan yang diizinkan peraturan perundang-undangan yang berlaku, termasuk aksi korporasi yang terjadi pada perusahaan Kami: <br>
        Dalam hal pembagian Data Pribadi Anda dengan pihak ketiga, kami memastikan bahwa pihak ketiga dan Afiliasi kami menjaga Data Pribadi Anda sesuai dengan peraturan perundang-undangan yang berlaku. <br> <br>
        5. Penyimpanan Data Pribadi <br>
Seluruh informasi Pribadi yang Anda berikan kepada Kami disimpan di jaringan yang aman dan Anda menyetujui pengalihan, penyimpanan, serta pengolahan yang terjadi pada aplikasi atau situs web Kami dan Kami mengambil langkah-langkah dalam batas kewajaran Peraturan yang Berlaku. <br> <br>
6. Keamanan Data Pribadi Anda <br>
Kerahasiaan Data Pribadi merupakan prioritas bagi Kami dan Afiliasi Kami. Kami akan senantiasa mengambil tindakan hukum yang layak, tindakan organisasi dan teknis yang layak untuk memastikan bahwa Data Pribadi Anda aman dan terlindungi. Setiap pemrosesan Data Pribadi Anda hanya akan dilakukan sesuai dengan Kebijakan Privasi ini dan ketentuan perundang-undangan yang berlaku.
Anda bertanggung jawab untuk menjaga kerahasiaan akun Anda, termasuk kata sandi dan rincian pembayaran, terhadap siapapun dan menjaga dan memastikan keamanan perangkat Anda yang digunakan untuk mengakses dan menggunakan Aplikasi. <br> <br>
7. Hak Anda <br>
Anda dapat memohon untuk penghapusan atau mengkoreksi Data Pribadi Anda pada Aplikasi atau menarik persetujuan Anda untuk setiap atau segala pengumpulan, penggunaan atau pengungkapan Data Pribadi Anda dengan memberikan kepada kami pemberitahuan yang wajar secara tertulis melalui detail kontak yang tercantum pada Kebijakan Privasi ini.  <br> <br>
8. Kebijakan Cookies <br>
Ketika Anda menggunakan Aplikasi, Kami dapat menempatkan sejumlah cookies pada browser Anda untuk tujuan pengoperasian aplikasi atau situs web Kami, mengaktifkan fungsi tertentu, memberikan analisis, menyimpan preferensi Anda; dan memungkinkan pengiriman iklan dan pengiklanan berdasarkan perilaku guna mempersonalisasi konten dan meningkatkan layanan. <br> <br>
9. Pengakuan dan Persetujuan <br>
Anda mengerti dan setuju bahwa Kebijakan Privasi ini merupakan perjanjian dalam bentuk elektronik. Dengan membeli, Anda dan/atau orang tua, wali atau pengampu Anda (dalam hal Anda berusia di bawah 18 (delapan belas) tahun) telah menyetujui Kebijakan Privasi berikut perubahannya sehingga keberlakuan Kebijakan Privasi adalah sah dan mengikat secara hukum sesuai peraturan berlaku. Jika Anda memiliki pertanyaan terkait Kebijakan Privasi atau Anda ingin mengkoreksi Data Pribadi Anda, silahkan menghubungi Kami melalui admin@fiqeeh.com.
</section>

<style>
    .border-sky-500{
        border-color: rgb(14 165 233);
    }
    .mx-80{
        margin-left: 20rem; /* 320px */
margin-right: 20rem; /* 320px */
    }
</style>
@endsection