@extends('layouts.theme-no-footer')

@section('content')
    
    <section class="px-6 lg:px-36 py-24 lg:py-46">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-10 lg:gap-6">
                <div class="col-span-2"></div>
                <div class="col-span-6 text-center">
                    <img src="{{ asset('assets/images/icons/payment-loading-icons.png') }}" class="w-[104px] h-[104px] lg:w-[160px] lg:h-[160px] mb-6 lg:mb-7 mx-auto" alt="Loading">
                    <h2 class="text-2xl lg:text-4xl font-semibold text-neutral-500 mb-2 lg:mb-4">
                        Mohon Menunggu
                    </h2>
                    <p class="text-sm lg:text-lg font-normal text-neutral-400 mb-8 lg:mb-16">
                        Pembayaran Anda sedang kami proses, silahkan tunggu 1x24 jam (kecuali Minggu dan Hari Libur Nasional) untuk mendapat akses Kelas via Whatsapp. Jazakumullahu khairan.
                    </p>
                    {{-- <a href="{{ route('beranda') }}" class="inline-block text-sm font-normal text-brand-50 bg-brand-500 border-brand-50 py-2.5 px-16 border rounded-lg">
                        Beranda
                    </a> --}}
                </div>
                <div class="col-span-2"></div>
            </div>
        </div>
    </section>

@endsection

<script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('assets/vendor/slick/slick.js')}}"></script>

<script src="{{asset('assets/vendor/flowbite/flowbite.js')}}"></script>
<script src="{{asset('assets/vendor/plyr/plyr.polyfilled.js')}}"></script>
<script src="{{asset('assets/js/script.js')}}"></script>
