@extends('layouts.theme-no-footer')

@section('content')

    <section class="px-6 lg:px-36 py-24 lg:py-46">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-10 lg:gap-6">
                <div class="col-span-2"></div>
                <div class="col-span-6 text-center">
                    <img src="{{ asset('assets/images/icons/checklist-success.png') }}" class="w-[104px] h-[104px] lg:w-[160px] lg:h-[160px] mb-6 lg:mb-7 mx-auto" alt="Loading">
                    <h2 class="text-2xl lg:text-4xl font-semibold text-neutral-500 mb-2 lg:mb-4">
                        Cek WhatsApp Anda
                    </h2>
                    <p class="text-sm lg:text-lg font-normal text-neutral-400 mb-8 lg:mb-16">
                        @if($ebook->physic == 1)
                            Kami akan mengirimkan detail pengiriman buku ke WhatsApp Anda.<br>
                        @else
                            Kami akan mengirimkan link download ebook ke WhatsApp Anda.<br>
                        @endif
                        Daftar menjadi member Fiqeeh untuk mendapatkan akses ke semua kelas Fiqeeh.
                    </p>
                    <a href="{{ route('register') }}" class="bg-brand-500 border border-brand-50 font-normal inline-block lg:py-4 px-16 py-2.5 rounded-lg text-brand-50 text-sm">
                        Daftar Sekarang
                    </a>
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
