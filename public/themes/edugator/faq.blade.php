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
                Faq
            </p>
            <h1 class="text-3xl lg:text-5xl font-semibold text-neutral-500 mb-4 lg:mb-6">
                Memberikan Informasi
            </h1>
            <h2 class="text-2xl lg:text-4xl font-semibold text-brand-500 mb-6 lg:mb-8">
                Seputar Tanya Jawab
            </h2>
            <p class="text-sm lg:text-base text-neutral-400 font-normal  lg:mb-24 lg:w-2/4 lg:mx-auto">
                Sesuai Al Qur'an, As Sunnah dan pengalaman kami berbisnis syariah sejak 2015.
            </p>

        </div>
    </div>
    </div>
</section>

<section class="md:px-6 lg:px-36 md:pb-20 lg:pb-32 relative ">
    <div class="absolute w-full h-2 -bottom-[4px] left-0 bg-neutral-500"></div>
    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-10 md:gap-6">
            <div class="px-6 md:px-0 col-span-6 mb-6">

                <div id="accordion-color" data-accordion="collapse"
                    data-active-classes="bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-white">
                    <h2 id="accordion-color-heading-1">
                        <button type="button"
                            class="radius block text-center text-sm lg:text-base font-normal text-brand-50 bg-brand-500 rounded-lg border border-brand-500 py-2.5 mb-2 rounded-t-lg p-8 flex items-center justify-between w-full p-5 font-medium text-left text-white border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800"
                            data-accordion-target="#accordion-color-body-1" aria-expanded="true"
                            aria-controls="accordion-color-body-1" style="color:white">
                            <span>1. Apa itu Fiqeeh?</span>
                            <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-color-body-1" class="hidden" aria-labelledby="accordion-color-heading-1">
                        <div
                            class="p-5 font-light border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                            <p class="text-sm p-4 mb-2 text-gray-500 dark:text-gray-400">Fiqeeh adalah Kampus Bisnis Syariah dan telah bekerjasama dengan Kementerian Perindustrian (Kemenperin) Jakarta untuk
                                mengembangkan Industri Kecil Menengah. Fiqeeh didirikan oleh PT Kampusnya Pengusaha
                                Hijrah, Yogyakarta. </p>
                        </div>
                    </div>
                    <br>
                    <h2 id="accordion-color-heading-2">
                        <button type="button"
                            class="radius block text-center text-sm lg:text-base font-normal text-brand-50 bg-brand-500 rounded-lg border border-brand-500 py-2.5 mb-2 p-8 flex items-center justify-between w-full p-5 font-medium text-left text-white border border-b-0 border-gray-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800"
                            data-accordion-target="#accordion-color-body-2" aria-expanded="false"
                            aria-controls="accordion-color-body-2" style="    color:white">
                            <span>2. Apa masalah yang dipecahkan Fiqeeh?</span>
                            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-color-body-2" class="hidden" aria-labelledby="accordion-color-heading-2">
                        <div class="p-5 font-light border border-b-0 border-gray-200 dark:border-gray-700">
                            <p class="text-sm p-4  mb-2 text-gray-500 dark:text-gray-400">Saat ini ilmu bisnis di pasaran tidak
                                mengajarkan cara syariah, mahal dan tidak lengkap. Akibatnya, sulit mencetak pengusaha
                                baru dan bisnis pengusaha yang ada sulit berkembang, merugi bahkan bangkrut. Karena itu
                                Fiqeeh menyediakan ilmu bisnis syariah terlengkap dengan harga terjangkau. </p>

                        </div>
                    </div>
                    <br>
                   <h2 id="accordion-color-heading-3">
                        <button type="button"
                            class="radius block text-center text-sm lg:text-base font-normal text-brand-50 bg-brand-500 rounded-lg border border-brand-500 py-2.5 mb-2 p-8 flex items-center justify-between w-full p-5 font-medium text-left text-white border border-b-0 border-gray-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800"
                            data-accordion-target="#accordion-color-body-3" aria-expanded="false"
                            aria-controls="accordion-color-body-3" style="color:white">
                            <span>3. Mengapa harus berbisnis syariah?</span>
                            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-color-body-3" class="hidden" aria-labelledby="accordion-color-heading-3">
                        <div class="p-5 font-light border border-t-0 border-gray-200 dark:border-gray-700">
                            <p class="text-sm p-4  mb-2 text-gray-500 dark:text-gray-400">Karena bisnis bukan hanya untung-rugi
                                tapi juga surga-neraka. Dengan berbisnis syariah, Anda tidak diperangi Allah dan
                                RasulNya, terhindar dari jilatan api neraka, harta berkah, hidup tenang dan mendapat
                                pahala jariyah. Semua manfaat itu Anda dapatkan karena menghindari bisnis haram. </p>
                        </div> 
                    </div>
                    <br>
                      <h2 id="accordion-color-heading-4">
                        <button type="button"
                            class="radius block text-center text-sm lg:text-base font-normal text-brand-50 bg-brand-500 rounded-lg border border-brand-500 py-2.5 mb-2 radius block p-8 flex items-center justify-between w-full p-5 font-medium text-left text-white border border-b-0 border-gray-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800"
                            data-accordion-target="#accordion-color-body-4" aria-expanded="false"
                            aria-controls="accordion-color-body-4" style="color:white">
                            <span>4. Apa rujukan ilmu bisnis syariah Fiqeeh?</span>
                            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-color-body-4" class="hidden" aria-labelledby="accordion-color-heading-4">
                        <div class="p-5 font-light border border-t-0 border-gray-200 dark:border-gray-700">
                            <p class="text-sm p-4  mb-2 text-gray-500 dark:text-gray-400">Al Qur’an dan As Sunnah. Rujukan lainnya adalah Ustadz M. Arifin Badri, Ustadz Sufyan Baswedan, Ustadz Khalid Syamhudi, Ustadz Aris Munandar, Ustadz Ammi Nur Baits, Ustadz Musyaffa Ad Dariny, Ustadz Anas Burhanuddin, Ustadz Erwandi Tarmizi, Ustadz M. Abduh Tuasikal, Ustadz M. Rosyid Aziz, AAOIFI, Lajnah Daimah dan MUI. </p>
                        </div> 
                    </div>
                    <br>
                      <h2 id="accordion-color-heading-5">
                        <button type="button"
                            class="radius block text-center text-sm lg:text-base font-normal text-brand-50 bg-brand-500 rounded-lg border border-brand-500 py-2.5 mb-2 p-8 flex items-center justify-between w-full p-5 font-medium text-left text-white border border-b-0 border-gray-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800"
                            data-accordion-target="#accordion-color-body-5" aria-expanded="false"
                            aria-controls="accordion-color-body-5" style="color:white">
                            <span>5. Bagaimana cara belajarnya?</span>
                            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-color-body-5" class="hidden" aria-labelledby="accordion-color-heading-5">
                        <div class="p-5 font-light border border-t-0 border-gray-200 dark:border-gray-700">
                            <p class="text-sm p-4  mb-2 text-gray-500 dark:text-gray-400">Kelasnya online di www.fiqeeh.com, sehingga hemat dan praktis karena Anda bisa belajar kapan pun, dimanapun. Setelah membayar biaya langganan, Anda mendapat password untuk mengakses semua Kelas Bisnis Syariah di member area. Materi nya berupa video dan dokumen siap pakai (bebas unduh). Jika langganan berakhir, Anda membayar lagi untuk memperpanjang masa belajar. </p>
                        </div> 
                    </div>
                    <br>
                      <h2 id="accordion-color-heading-6">
                        <button type="button"
                            class="radius block text-center text-sm lg:text-base font-normal text-brand-50 bg-brand-500 rounded-lg border border-brand-500 py-2.5 mb-2 p-8 flex items-center justify-between w-full p-5 font-medium text-left text-white border border-b-0 border-gray-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800"
                            data-accordion-target="#accordion-color-body-6" aria-expanded="false"
                            aria-controls="accordion-color-body-6" style="color:white">
                            <span>6. Apa yang Anda dapat dengan berlangganan?</span>
                            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-color-body-6" class="hidden" aria-labelledby="accordion-color-heading-6">
                        <div class="p-5 font-light border border-t-0 border-gray-200 dark:border-gray-700">
                            <p class="text-sm p-4  mb-2 text-gray-500 dark:text-gray-400">Anda mendapat: 5 Program Bisnis 100+ Mentor Terbaik 170+ Kelas Bisnis 1000+ Video & Dokumen Kurikulum Bisnis Kelas Baru Gratis.</p>
                        </div> 
                    </div>
                    <br>
                      <h2 id="accordion-color-heading-7">
                        <button type="button"
                            class="radius block text-center text-sm lg:text-base font-normal text-brand-50 bg-brand-500 rounded-lg border border-brand-500 py-2.5 mb-2 p-8 flex items-center justify-between w-full p-5 font-medium text-left text-white border border-b-0 border-gray-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800"
                            data-accordion-target="#accordion-color-body-7" aria-expanded="false"
                            aria-controls="accordion-color-body-7" style="color:white">
                            <span>7. Apa saja 5 Program Bisnis nya?</span>
                            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-color-body-7" class="hidden" aria-labelledby="accordion-color-heading-7">
                        <div class="p-5 font-light border border-t-0 border-gray-200 dark:border-gray-700">
                            <p class="text-sm p-4  mb-2 text-gray-500 dark:text-gray-400">Fiqeeh menyediakan ilmu Pengusaha dari buka mata hingga wafat dalam 5 Program Bisnis lapangan yaitu <br> 1) Mindset.<br> 2) Ide Bisnis. <br>3) Permodalan.<br> 4) Pemasaran.<br> 5) Operasional. </p>
                        </div> 
                    </div>
                    <br>
                      <h2 id="accordion-color-heading-8">
                        <button type="button"
                            class="radius block text-center text-sm lg:text-base font-normal text-brand-50 bg-brand-500 rounded-lg border border-brand-500 py-2.5 mb-2 p-8 rounded-b-lg flex items-center justify-between w-full p-5 font-medium text-left text-white border border-b-0 border-gray-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800"
                            data-accordion-target="#accordion-color-body-8" aria-expanded="false"
                            aria-controls="accordion-color-body-8" style="color:white">
                            <span>8. Setelah bergabung, Anda menjadi apa?</span>
                            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-color-body-8" class="hidden" aria-labelledby="accordion-color-heading-8">
                        <div class="p-5 font-light border border-t-0 border-gray-200 dark:border-gray-700">
                            <p class="text-sm p-4  mb-2 text-gray-500 dark:text-gray-400">Anda mampu merintis dan mengembangkan bisnis sesuai syariat sehingga insyaa Allah untung besar dan meraih surga kelak. Dengan begitu Anda bisa menjadi Pengusaha Muslim yang sukses dan bisnisnya mengglobal. </p>
                        </div> 
                    </div>
                     <div class="border-solid border-2 border-sky-500  rounded-lg mt-10 p-3">
                        <p class="text-sm p-4  mb-2 text-gray-500 dark:text-gray-400">“Apabila untuk ibadah saja Anda begitu berhati-hati memastikan sesuai tuntunan Al Qur’an dan sunnah Nabi, seharusnya Anda melakukan hal sama pada bisnis Anda karena berbisnis menghabiskan 3/4 waktu hidup Anda. Pastikan bisnis Anda halal dari hulu ke hilir sekarang juga!” - Yudha Adhyaksa</p>
                    </div>
                    

                </div>
               



            </div>
            <div class="col-span-4">
                <div class="bg-neutral-500 md:rounded-[32px] md:p-6 p-8">
                    <img src="<?php echo e(asset('assets/images/icons/aktivasi-tawaran-icons-1.png')); ?>"
                        class="w-40 mb-6" alt="Icons">
                    <h5 class="text-xl lg:text-1xl font-semibold text-brand-50 mb-2">
                        Ambil Tawaran Menarik Ini!
                    </h5>
                    <p class="text-base lg:text-lg font-normal text-neutral-50 mb-16">
                        Ilmu pengusaha terlengkap dari buka mata sampai wafat.
                    </p>
                    <a href="{{ route('register') }}"
                        class="radius block text-center text-sm lg:text-base font-normal text-brand-50 bg-brand-500 rounded-lg border border-brand-500 py-2.5 mb-2">
                        Langganan Sekarang
                    </a>
                </div>
            </div>
            
        </div>
         
    </div>
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
