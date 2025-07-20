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
                Syarat & Ketentuan
            </p>
            <h1 class="text-3xl lg:text-5xl font-semibold text-neutral-500 mb-4 lg:mb-6">
                SYARAT DAN KETENTUAN FIQEEH
            </h1>
            {{-- <h2 class="text-2xl lg:text-4xl font-semibold text-brand-500 mb-6 lg:mb-8">
                Seputar Tanya Jawab
            </h2> --}}
            <p class="text-sm lg:text-base text-neutral-400 font-normal  lg:mb-24 lg:w-2/4 lg:mx-auto">
                Syarat dan Ketentuan ini merupakan perjanjian antara pengguna ("Anda") dan PT Kampusnya Pengusaha Hijrah ("Kami") yaitu sebuah perseroan terbatas yang didirikan dan beroperasi secara sah berdasarkan hukum Negara Republik Indonesia dan berdomisili di Yogyakarta. Indonesia.
            </p>
            <br>
            <p class="text-sm lg:text-base text-neutral-400 font-normal ">
                <b>Dengan membeli, Anda dianggap telah membaca, memahami dan menyetujui semua isi dalam Syarat dan Ketentuan ini.</b>
            </p>
        </div>
    </div>
    </div>
</section>
<section class="text-sm md:px-6 lg:mb-24 lg:w-2/4 lg:mx-auto relative hidden md:block">
        1. Informasi personal yang Anda berikan hanya Kami gunakan untuk personalisasi dan peningkatan layanan kepada Anda. <br> <br>
2. Situs yang Kami sediakan adalah sebagaimana adanya dan Kami tidak menyatakan atau menjamin bahwa keandalan, ketepatan waktu, kualitas, kesesuaian, ketersediaan, akurasi, kelengkapan atau keamanan dari Situs dapat memenuhi kebutuhan dan akan sesuai dengan harapan Anda. Kami dapat memperbaharui Situs dari waktu ke waktu serta mengubah kontennya kapan pun. Meskipun demikian, perlu diketahui bahwa Situs Kami dapat memiliki konten yang tidak diperbarui pada waktu tertentu, dan Kami tidak berkewajiban untuk membaruinya. Kami akan senantiasa berupaya untuk memastikan, namun tidak sepenuhnya menjamin, bahwa Situs Kami beserta konten yang terkandung di dalamnya dapat bebas sepenuhnya dari kesalahan atau kelalaian. <br> <br>
3. Isi konten Kami, termasuk namun tidak terbatas pada, nama, logo, kode program, desain, merek dagang, teknologi, basis data, proses dan model bisnis dilindungi oleh hak cipta, merek, paten dan hak kekayaan intelektual lainnya berdasarkan hukum Republik Indonesia. Setiap penggandaan, distribusi, pembuatan karya turunan, penjualan atau penawaran untuk menjual, penampilan baik sebagian atau seluruhnya, serta penggunaan yang menyimpang dari Syarat dan Ketentuan ini, merupakan pelanggaran terhadap hak kekayaan intelektual Kami. <br> <br>
4. Anda setuju untuk mengakses atau menggunakan Situs, Layanan, Konten Pihak Ketiga, Penawaran atau Metode Pembayaran hanya untuk tujuan yang dibenarkan hukum. Seluruh resiko yang timbul sepenuhnya menjadi tanggung jawab Anda dan Anda setuju untuk membebaskan Kami, termasuk namun tidak terbatas pada, pejabat, direktur, komisaris, karyawan dan agen Kami, dari dari setiap dan semua kewajiban, konsekuensi, kerugian baik materiil atau immateriil, tuntutan, biaya-biaya (termasuk biaya advokat) atau tanggung jawab hukum lainnya yang timbul atau mungkin timbul akibat pelanggaran Anda terhadap Syarat dan Ketentuan. <br> <br>
5. Anda dilarang untuk: <br>
    b. memberi lisensi, mensublisensikan, menjual, menjual ulang, memindahkan, menetapkan, mendistribusikan, atau sebaliknya mengeksploitasi atau membagikan secara komersial atau membuat tersedia kepada pihak lain dengan cara apa pun; <br>
    c. menciptakan ‘tautan’ internet menuju situs web Kami, atau menyadur (frame), atau mengkomputasi (mirror) perangkat lunak mana pun pada server atau perangkat nirkabel atau perangkat lainnya yang terhubung ke internet; <br>
    d. menggunakan secara tidak resmi Situs Kami dengan tujuan untuk (a) membangun produk atau jasa yang kompetitif, (b) membangun produk berdasarkan ide, fitur, fungsi, maupun grafis yang serupa dengan Situs Kami, atau (c) menyalin ide, fitur, fungsi, atau grafis pada Situs Kami; <br>
    e. meluncurkan program atau skrip otomatis termasuk, namun tidak terbatas pada, web spider, web crawler, robot web, web ant, pengindeksan web, bot, virus, worm, atau program apa pun yang dapat meningkatkan permintaan server per detik, atau membuat beban terlalu berat yang mengganggu operasi dan/atau kinerja Situs Kami; <br>
    f. menggunakan Situs pencarian atau pengambilan situs, perangkat manual atau otomatis lain untuk mengambil (scraping), membuat indeks (indexing), menambang data (data mining), survei (surveying), atau dengan cara apa pun menggandakan atau menghindari struktur navigasi atau tampilan Situs Kami maupun isinya; <br>
    g. menerbitkan, mendistribusikan, atau menggandakan dengan cara apa pun materi dengan hak cipta, merek dagang, atau informasi kepemilikan lain yang Kami miliki tanpa sebelumnya memperoleh persetujuan dari Kami atau pemilik hak yang melisensikan hak-haknya kepada Kami; <br>
    h. menghapus pemberitahuan hak cipta, merek dagang, atau hak kepemilikan lainnya yang terkandung dalam Situs Kami. Tidak ada lisensi atau hak yang diberikan kepada Anda secara implisit atau sebaliknya berdasarkan hak kekayaan intelektual yang dimiliki atau dikendalikan oleh kami dan pemberi lisensi kami, kecuali lisensi dan hak yang secara tersurat diberikan dalam Syarat dan Ketentuan ini. Anda tidak boleh menggunakan bagian mana pun dari konten pada Situs Kami untuk tujuan komersial tanpa sebelumnya memperoleh lisensi untuk melakukannya dari Kami. <br> <br>
6. Apabila Kami mempunyai alasan yang cukup untuk menduga bahwa Anda telah melakukan tindakan yang bertentangan dengan Syarat dan Ketentuan ini dan/atau peraturan perundang-undangan yang berlaku, baik yang dirujuk dalam Syarat dan Ketentuan ini atau tidak, maka Kami berhak untuk dan dapat membekukan Akun, baik sementara atau permanen, atau menghentikan akses Anda terhadap Situs, melakukan pemeriksaan, menuntut ganti kerugian, melaporkan dan bekerjasama dengan pihak berwenang untuk mengambil tindakan hukum. Anda juga dapat memberikan laporan beserta bukti yang jelas bahwa Akun Anda seharusnya tidak dibekukan, dan setelah pemeriksaan Kami akan menentukan untuk mengakhiri atau melanjutkan pembekuan terhadap Akun Anda.  <br> <br>
7. Jika Anda mengetahui atau menduga bahwa Akun Anda diretas, digunakan atau disalahgunakan oleh pihak lain, atau apabila perangkat telepon genggam atau tablet pribadi Anda hilang, dicuri, diretas atau terkena virus, menemukan konten apa pun pada Situs Kami yang Anda yakini melanggar hak cipta apa pun, menyalahi hak lainnya, merusak nama baik, bersifat pornografis atau tidak senonoh, rasis, atau dengan cara-cara lain menyebabkan pelanggaran secara luas, atau yang merupakan peniruan identitas, penyalahgunaan, spam, atau sebaliknya menyalahi Syarat dan Ketentuan serta peraturan yang berlaku lainnya, laporkan hal ini kepada Kami dengan memberikan informasi yang cukup terkait ringkasan fakta dan bukti. Kami akan memverifikasi terlebih dahulu sebelum melakukan tindakan yang diperlukan. <br> <br>
8. Situs Kami dapat diganggu oleh kejadian di luar kewenangan atau kendali Kami ("Keadaan Kahar"), Anda setuju untuk membebaskan Kami dari setiap tuntutan dan tanggung jawab, jika Kami tidak dapat memfasilitasi Layanan, termasuk memenuhi instruksi yang Anda berikan melalui Situs, baik sebagian maupun seluruhnya, karena suatu Keadaan Kahar. <br> <br>
9. Ketentuan ini tetap berlaku bahkan setelah pembekuan sementara, pembekuan permanen, penghapusan Situs atau setelah berakhirnya perjanjian ini antara Anda dan Kami. Jika salah satu dari ketentuan dalam Syarat dan Ketentuan ini tidak dapat diberlakukan, hal tersebut tidak akan memengaruhi ketentuan lainnya. Ketentuan Penggunaan ini diatur berdasarkan hukum Republik Indonesia. Setiap dan seluruh perselisihan yang timbul dari penggunaan Situs atau Layanan tunduk pada yurisdiksi eksklusif Pengadilan Negeri Yogyakarta.
Untuk menghubungi Kami, silahkan mengirim pesan WhatsApp yang terdaftar pada Situs ini atau mengirim surat elektronik ke alamat admin@fiqeeh.com.
</section>

<section class="text-sm md:px-6 lg:mb-24 lg:w-2/4 lg:mx-auto relative md:hidden" style="margin-left: 15px">
        1. Informasi personal yang Anda berikan hanya Kami gunakan untuk personalisasi dan peningkatan layanan kepada Anda. <br> <br>
2. Situs yang Kami sediakan adalah sebagaimana adanya dan Kami tidak menyatakan atau menjamin bahwa keandalan, ketepatan waktu, kualitas, kesesuaian, ketersediaan, akurasi, kelengkapan atau keamanan dari Situs dapat memenuhi kebutuhan dan akan sesuai dengan harapan Anda. Kami dapat memperbaharui Situs dari waktu ke waktu serta mengubah kontennya kapan pun. Meskipun demikian, perlu diketahui bahwa Situs Kami dapat memiliki konten yang tidak diperbarui pada waktu tertentu, dan Kami tidak berkewajiban untuk membaruinya. Kami akan senantiasa berupaya untuk memastikan, namun tidak sepenuhnya menjamin, bahwa Situs Kami beserta konten yang terkandung di dalamnya dapat bebas sepenuhnya dari kesalahan atau kelalaian. <br> <br>
3. Isi konten Kami, termasuk namun tidak terbatas pada, nama, logo, kode program, desain, merek dagang, teknologi, basis data, proses dan model bisnis dilindungi oleh hak cipta, merek, paten dan hak kekayaan intelektual lainnya berdasarkan hukum Republik Indonesia. Setiap penggandaan, distribusi, pembuatan karya turunan, penjualan atau penawaran untuk menjual, penampilan baik sebagian atau seluruhnya, serta penggunaan yang menyimpang dari Syarat dan Ketentuan ini, merupakan pelanggaran terhadap hak kekayaan intelektual Kami. <br> <br>
4. Anda setuju untuk mengakses atau menggunakan Situs, Layanan, Konten Pihak Ketiga, Penawaran atau Metode Pembayaran hanya untuk tujuan yang dibenarkan hukum. Seluruh resiko yang timbul sepenuhnya menjadi tanggung jawab Anda dan Anda setuju untuk membebaskan Kami, termasuk namun tidak terbatas pada, pejabat, direktur, komisaris, karyawan dan agen Kami, dari dari setiap dan semua kewajiban, konsekuensi, kerugian baik materiil atau immateriil, tuntutan, biaya-biaya (termasuk biaya advokat) atau tanggung jawab hukum lainnya yang timbul atau mungkin timbul akibat pelanggaran Anda terhadap Syarat dan Ketentuan. <br> <br>
5. Anda dilarang untuk: <br>
    b. memberi lisensi, mensublisensikan, menjual, menjual ulang, memindahkan, menetapkan, mendistribusikan, atau sebaliknya mengeksploitasi atau membagikan secara komersial atau membuat tersedia kepada pihak lain dengan cara apa pun; <br>
    c. menciptakan ‘tautan’ internet menuju situs web Kami, atau menyadur (frame), atau mengkomputasi (mirror) perangkat lunak mana pun pada server atau perangkat nirkabel atau perangkat lainnya yang terhubung ke internet; <br>
    d. menggunakan secara tidak resmi Situs Kami dengan tujuan untuk (a) membangun produk atau jasa yang kompetitif, (b) membangun produk berdasarkan ide, fitur, fungsi, maupun grafis yang serupa dengan Situs Kami, atau (c) menyalin ide, fitur, fungsi, atau grafis pada Situs Kami; <br>
    e. meluncurkan program atau skrip otomatis termasuk, namun tidak terbatas pada, web spider, web crawler, robot web, web ant, pengindeksan web, bot, virus, worm, atau program apa pun yang dapat meningkatkan permintaan server per detik, atau membuat beban terlalu berat yang mengganggu operasi dan/atau kinerja Situs Kami; <br>
    f. menggunakan Situs pencarian atau pengambilan situs, perangkat manual atau otomatis lain untuk mengambil (scraping), membuat indeks (indexing), menambang data (data mining), survei (surveying), atau dengan cara apa pun menggandakan atau menghindari struktur navigasi atau tampilan Situs Kami maupun isinya; <br>
    g. menerbitkan, mendistribusikan, atau menggandakan dengan cara apa pun materi dengan hak cipta, merek dagang, atau informasi kepemilikan lain yang Kami miliki tanpa sebelumnya memperoleh persetujuan dari Kami atau pemilik hak yang melisensikan hak-haknya kepada Kami; <br>
    h. menghapus pemberitahuan hak cipta, merek dagang, atau hak kepemilikan lainnya yang terkandung dalam Situs Kami. Tidak ada lisensi atau hak yang diberikan kepada Anda secara implisit atau sebaliknya berdasarkan hak kekayaan intelektual yang dimiliki atau dikendalikan oleh kami dan pemberi lisensi kami, kecuali lisensi dan hak yang secara tersurat diberikan dalam Syarat dan Ketentuan ini. Anda tidak boleh menggunakan bagian mana pun dari konten pada Situs Kami untuk tujuan komersial tanpa sebelumnya memperoleh lisensi untuk melakukannya dari Kami. <br> <br>
6. Apabila Kami mempunyai alasan yang cukup untuk menduga bahwa Anda telah melakukan tindakan yang bertentangan dengan Syarat dan Ketentuan ini dan/atau peraturan perundang-undangan yang berlaku, baik yang dirujuk dalam Syarat dan Ketentuan ini atau tidak, maka Kami berhak untuk dan dapat membekukan Akun, baik sementara atau permanen, atau menghentikan akses Anda terhadap Situs, melakukan pemeriksaan, menuntut ganti kerugian, melaporkan dan bekerjasama dengan pihak berwenang untuk mengambil tindakan hukum. Anda juga dapat memberikan laporan beserta bukti yang jelas bahwa Akun Anda seharusnya tidak dibekukan, dan setelah pemeriksaan Kami akan menentukan untuk mengakhiri atau melanjutkan pembekuan terhadap Akun Anda.  <br> <br>
7. Jika Anda mengetahui atau menduga bahwa Akun Anda diretas, digunakan atau disalahgunakan oleh pihak lain, atau apabila perangkat telepon genggam atau tablet pribadi Anda hilang, dicuri, diretas atau terkena virus, menemukan konten apa pun pada Situs Kami yang Anda yakini melanggar hak cipta apa pun, menyalahi hak lainnya, merusak nama baik, bersifat pornografis atau tidak senonoh, rasis, atau dengan cara-cara lain menyebabkan pelanggaran secara luas, atau yang merupakan peniruan identitas, penyalahgunaan, spam, atau sebaliknya menyalahi Syarat dan Ketentuan serta peraturan yang berlaku lainnya, laporkan hal ini kepada Kami dengan memberikan informasi yang cukup terkait ringkasan fakta dan bukti. Kami akan memverifikasi terlebih dahulu sebelum melakukan tindakan yang diperlukan. <br> <br>
8. Situs Kami dapat diganggu oleh kejadian di luar kewenangan atau kendali Kami ("Keadaan Kahar"), Anda setuju untuk membebaskan Kami dari setiap tuntutan dan tanggung jawab, jika Kami tidak dapat memfasilitasi Layanan, termasuk memenuhi instruksi yang Anda berikan melalui Situs, baik sebagian maupun seluruhnya, karena suatu Keadaan Kahar. <br> <br>
9. Ketentuan ini tetap berlaku bahkan setelah pembekuan sementara, pembekuan permanen, penghapusan Situs atau setelah berakhirnya perjanjian ini antara Anda dan Kami. Jika salah satu dari ketentuan dalam Syarat dan Ketentuan ini tidak dapat diberlakukan, hal tersebut tidak akan memengaruhi ketentuan lainnya. Ketentuan Penggunaan ini diatur berdasarkan hukum Republik Indonesia. Setiap dan seluruh perselisihan yang timbul dari penggunaan Situs atau Layanan tunduk pada yurisdiksi eksklusif Pengadilan Negeri Yogyakarta.
Untuk menghubungi Kami, silahkan mengirim pesan WhatsApp yang terdaftar pada Situs ini atau mengirim surat elektronik ke alamat admin@fiqeeh.com.
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
