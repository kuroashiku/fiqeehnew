@extends('layouts.theme')

@section('content')
    @php
        $payment = \App\UserPayment::where('user_id', Auth::user()->id)
        ->where('status', 0)
        ->orderBy('id', 'DESC')
        ->first();
        $user = \App\User::where('id', Auth::user()->id)->first();
    @endphp

    <section class="px-6 lg:px-36 py-2 bg-neutral-500">
        <div class="container mx-auto">
            <div class="text-center lg:flex justify-center">
                <p class="text-base font-normal text-white">
                    Sisa waktu pembayaran :
                </p>
                <input type="hidden" name="countdown" id="countdown" value="October 20, 2022 00:00:00">
                <p class="text-base font-semibold text-danger-400 lg:ml-6" style="color: #fff">
                    <span id="hours">00</span> : <span id="minutes">00</span> : <span id="seconds">00</span>
                </p>
            </div>
        </div>
    </section>

    <section >
        <form action="{{route('save_payment_detail')}}" id="formPost" method="post" enctype="multipart/form-data">
            <div class="lg:grid lg:grid-cols-2">
                <div class="px-6 lg:px-36 py-10 lg:py-20 bg-brand-50">
                    <h4 class="text-xl lg:text-2xl font-semibold text-neutral-500 mb-4 lg:mb-6" id="titlePilihan">
                        Akun Pemula 1 Bulan
                    </h4>
                    <div class="img-paket flex flex-col items-center justify-center rounded-lg lg:rounded-none h-[278px] lg:h-72 mb-4 lg:mb-6"
                        style="background: linear-gradient(246.18deg, #0398F8 0%, #79D3FE 68.54%);">
                        <img src="{{ asset('assets/images/icons/gold-medal-3.png') }}" class="w-[130px] mb-6" alt="Icons">
                        <p class="text-base font-semibold text-white">
                            Pemula
                        </p>
                        <p class="text-xs font-normal text-white">
                            1 bulan
                        </p>
                    </div>
                    <div class="img-paket hidden flex-col items-center justify-center rounded-lg lg:rounded-none h-[278px] lg:h-72 mb-4 lg:mb-6"
                        style="background: linear-gradient(247.79deg, #2FE0BB 0%, #ADF2E4 77.1%);">
                        <img src="{{ asset('assets/images/icons/gold-medal-2.png') }}" class="w-[130px] mb-6" alt="Icons">
                        <p class="text-base font-semibold text-white">
                            Menengah
                        </p>
                        <p class="text-xs font-normal text-white">
                            6 bulan
                        </p>
                    </div>
                    <div class="img-paket hidden flex-col items-center justify-center rounded-lg lg:rounded-none h-[278px] lg:h-72 mb-4 lg:mb-6"
                        style="background: linear-gradient(246.18deg, #C53541 0%, #FF6774 68.54%);">
                        <img src="{{ asset('assets/images/icons/gold-medal-1.png') }}" class="w-[130px] mb-6" alt="Icons">
                        <p class="text-base font-semibold text-white">
                            Ahli
                        </p>
                        <p class="text-xs font-normal text-white">
                            12 bulan
                        </p>
                    </div>

                    <div class="mb-8">
                        <p class="text-sm font-semibold text-neutral-900 mb-2">
                            Anda mendapat:
                        </p>
                        <div class="lg:grid lg:grid-cols-2 text-sm font-normal text-neutral-900">
                            <ul class="list-disc ml-5">
                                <li>5 Program Bisnis</li>
                                <li>300+ Mentor Terbaik</li>
                                <li>12+ Kelas Bisnis</li>
                            </ul>
                            <ul class="list-disc ml-5">
                                <li>1000+ Video & Dokumen</li>
                                <li>Kurikulum Bisnis</li>
                                <li>Kelas Baru Gratis</li>
                            </ul>
                        </div>
                    </div>

                    <div>
                        <input type="hidden" name="jenisPaket" id="jenisPaket" value="1">
                        <div class="pilih-paket rounded-lg border-2 border-brand-500 drop-shadow p-4 bg-white cursor-pointer mb-4" data-value="1" data-type="Pemula">
                            <div class="flex justify-between mb-2">
                                <div class="flex">
                                    <div class="checked-circle flex items-center justify-center rounded-full w-5 h-5 border border-brand-500 bg-brand-500 mr-2">
                                        <div class="child rounded-full w-2 h-2 bg-white"></div>
                                    </div>
                                    <p class="text-sm lg:text-base font-semibold text-neutral-900">
                                        1 Bulan
                                    </p>
                                </div>
                                <p class="harga-paket text-sm lg:text-base font-normal text-neutral-900" data-harga="50000" data-coret="50000" data-bulan="1">
                                    Rp50.000
                                </p>
                            </div>
                            <p class="text-xs lg:text-sm font-normal text-neutral-400 ml-7">
                                Belajar semua Kelas.
                            </p>
                        </div>
                        <div class="pilih-paket rounded-lg border-2 border-neutral-100 p-4 bg-white cursor-pointer mb-4" data-value="3" data-type="Menengah">
                            <div class="flex justify-between mb-2">
                                <div class="flex">
                                    <div class="checked-circle flex items-center justify-center rounded-full w-5 h-5 border border-neutral-500 bg-white mr-2">
                                        <div class="child hidden rounded-full w-2 h-2 bg-white"></div>
                                    </div>
                                    <p class="text-sm lg:text-base font-semibold text-neutral-900">
                                        6 Bulan
                                    </p>
                                </div>
                                <p class="harga-paket text-sm lg:text-base font-normal text-neutral-900" data-harga="250000" data-coret="300000" data-bulan="6">
                                    <span class="line-through text-danger-500 mr-2">
                                        Rp300.000
                                    </span>
                                    Rp250.000
                                </p>
                            </div>
                            <p class="text-xs lg:text-sm font-normal text-neutral-400 ml-7">
                                Hemat Rp50.000! Belajar semua Kelas.
                            </p>
                        </div>
                        <div class="pilih-paket rounded-lg border-2 border-neutral-100 p-4 bg-white cursor-pointer mb-4" data-value="6" data-type="Ahli">
                            <div class="flex justify-between mb-2"> 
                                <div class="flex">
                                    <div class="checked-circle flex items-center justify-center rounded-full w-5 h-5 border border-neutral-500 bg-white mr-2">
                                        <div class="child hidden rounded-full w-2 h-2 bg-white"></div>
                                    </div>
                                    <p class="text-sm lg:text-base font-semibold text-neutral-900">
                                        12 Bulan
                                    </p>
                                </div>
                                <p class="harga-paket text-sm lg:text-base font-normal text-neutral-900" data-harga="500000" data-coret="600000" data-bulan="12">
                                    <span class="line-through text-danger-500 mr-2">
                                        Rp600.000
                                    </span>
                                    Rp500.000
                                </p>
                            </div>
                            <p class="text-xs lg:text-sm font-normal text-neutral-400 ml-7">
                                Hemat Rp100.000! Belajar semua Kelas.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="px-6 lg:pl-24 lg:pr-64 py-10 lg:py-20 ">
                    <div>
                        <h4 class="text-xl lg:text-2xl font-semibold text-neutral-500 mb-2">
                            Pembayaran
                        </h4>
                        <p class="hidden lg:block text-base font-normal text-neutral-400">
                            Transfer ke rekening Bank untuk <br>melanjutkan proses pembayaran.
                        </p>
                        <p class="lg:hidden text-xs font-normal text-neutral-400">
                            Transfer ke rekening Bank untuk melanjutkan pembayaran.
                        </p>
                    </div>
                    <div class="h-0.5 w-full bg-brand-100 my-8 lg:my-12"></div>
                    <div class="mb-12">
                        <img src="{{ asset('assets/images/icons/pembayaran-bank-bsi.png') }}" class="h-10 mb-8" alt="Bank">
                        <table  class="text-xs lg:text-sm font-normal text-neutral-400 mb-6 lg:mb-8">
                            <tr>
                                <td class="pb-2">No. Rek</td>
                                <td class="pb-2 px-4">:</td>
                                <td class="pb-2 text-neutral-500">5555588897</td>
                            </tr>
                            <tr>
                                <td class="pb-2">Atas nama</td>
                                <td class="pb-2 px-4">:</td>
                                <td class="pb-2 text-neutral-500">PT. Kampusnya Pengusaha Hijrah</td>
                            </tr>
                        </table>
                        <button type="button" onclick="copyClipboard('5555588897')" data-modal-toggle="popup-modal" class="text-center text-sm lg:text-base font-normal text-neutral-500 py-2.5 w-full rounded-lg border border-neutral-200">
                            Salin no rekening
                        </button>
                    </div>
                    
                    <div class="h-0.5 w-full bg-brand-100 my-8 lg:my-12"></div>
                    <div id="nominalPembayaran">
                    </div>
                    <div class="h-0.5 w-full bg-brand-100 my-8 lg:my-12"></div>
                    <div>
                        <p class="text-sm font-semibold text-neutral-600 mb-1">
                            Bukti pembayaran
                        </p>
                        <div class="lg:mb-12">
                            <div class="flex items-center justify-center rounded-lg mb-1 lg:mb-2 bg-neutral-50 border-dashed border-2 border-neutral-200 h-[148px] overflow-hidden relative cursor-pointer" onclick="uploadFile()">
                                <div class="text-center">
                                    <img src="{{ asset('assets/images/icons/payment-upload-icons.png') }}" class="w-10 mx-auto mb-5" alt="">
                                    <p class="text-sm font-semibold text-neutral-400 uppercase mb-2">
                                        UNGGAH BUKTI BAYAR
                                    </p>
                                    <p class="text-sm font-normal text-neutral-400">
                                        Nominal jelas terbaca
                                    </p>
                                </div>
                                <img src="" class="absolute hidden top-0 left-0 w-full h-full object-cover" id="preview-image" alt="">
                            </div>
                            <div class="error text-xs lg:text-sm font-normal text-danger-500 normal-case" id="uploadAlert" hidden>Mohon Upload Bukti Pembayaran.</div>
                        </div>
                        @csrf
                        <input type="file" name="file" placeholder="Upload file" id="uploadbukti" accept=".png, .jpg, .jpeg" class="hidden form-input" onchange="loadFile(event)">
                        <button type="submit" id="submit" class="w-full text-sm lg:text-base font-normal border rounded-lg py-2.5 text-brand-50 bg-brand-500 border-brand-50">
                            Konfirmasi Pembayaran
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 inset-0 h-full">
        <div class="relative p-4 w-full max-w-md h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="popup-modal">
                    <span class="material-icons-outlined text-12">
                        close
                        </span>
                </button>
                <div class="p-4 text-center">
                    <p class="text-sm lg:text-base font-normal text-neutral-400">
                        Nomor rekening berhasil disalin!
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script>
        $( "#formPost" ).submit(function( event ) {
            if( document.getElementById("uploadbukti").files.length == 0 ){
                $("#uploadAlert").show();
                event.preventDefault();
            }
        });
        
        Date.prototype.addHours = function(h) {
            this.setTime(this.getTime() + (h*60*60*1000));
            return this;
        }
        // Set the date we're counting down to
        var countDownDate = new Date('{!! $user->created_at !!}').addHours(6);

        // Update the count down every 1 second
        var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        }, 1000);
    </script>
@endsection