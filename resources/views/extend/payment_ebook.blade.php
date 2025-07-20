@extends('layouts.theme')

@section('content')
    <section >
        <form action="{{route('save_payment_ebook', $ebookDownload->id)}}" id="formPost" method="post" enctype="multipart/form-data">
            <div class="lg:grid lg:grid-cols-2">
                <div class="px-6 lg:px-36 py-10 lg:py-20 bg-brand-50" style="background: #F2F4F7;">
                    <h4 class="text-xl lg:text-2xl font-semibold text-neutral-500 mb-4 lg:mb-6" id="titlePilihan">
                        Pembelian {{$ebook->title}}
                    </h4>
                    @php
                        $image = \App\Media::where('id', $ebook->image)->first()->slug_ext;
                    @endphp
                    <div class="md:col-span-2 md:p-25 md:px-6 p-24 relative">
                        <img src="{{url('uploads/images/'.$image)}}" alt="Image"
                             style="box-shadow: 10px 10px 6px gray;"
                             class="lg:h-[400px] mx-auto">
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
                    <div>
                        <img src="{{ asset('assets/images/icons/pembayaran-bank-mandiri.png') }}" class="h-10 mb-8" alt="Bank">
                        <table  class="text-sm font-normal text-neutral-400 mb-6 lg:mb-8">
                            <tr>
                                <td class="pb-2">No. Rek</td>
                                <td class="pb-2 px-4">:</td>
                                <td class="pb-2 text-neutral-500">1370020258675</td>
                            </tr>
                            <tr>
                                <td class="pb-2">Atas nama</td>
                                <td class="pb-2 px-4">:</td>
                                <td class="pb-2 text-neutral-500">PT. Kampusnya Pengusaha Hijrah</td>
                            </tr>
                        </table>
                        <button type="button" onclick="copyClipboard('1370020258675')" data-modal-toggle="popup-modal" class="text-center text-sm lg:text-base font-normal text-neutral-500 py-2.5 w-full rounded-lg border border-neutral-200">
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
                            <div class="error text-xs lg:text-sm font-normal text-danger-500 normal-case" id="uploadAlert">Mohon Upload Bukti Pembayaran.</div>
                        </div>
                        @csrf
                        <input type="file" name="file" placeholder="Upload file" id="uploadbukti" accept=".png, .jpg, .jpeg" class="hidden form-input" onchange="loadFile(event)">
                        <button type="submit" id="submit" disabled class="w-full text-sm lg:text-base font-normal border rounded-lg py-2.5 text-brand-50 bg-brand-500 border-brand-50">
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
        // on ready document
        $(document).ready(function(){
            harga = {{$ebook->price}};
            randNumb = random_number(20,80);
            packageForm(harga, harga, randNumb, harga + randNumb);

            $("#submit").prop("disabled", true);
            $("#preview-image").change(function(){
                $("#submit").prop("disabled", false);
            });

        });

        // random number
        function random_number(min, max) {
            return Math.floor(Math.random() * (max - min) + min);
        }
    </script>
@endsection