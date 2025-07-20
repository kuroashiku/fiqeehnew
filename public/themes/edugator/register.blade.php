<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{get_option('enable_rtl')? 'rtl' : 'auto'}}" >

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('assets/images/favicon.ico') }}" name="favicon" rel="shortcut icon" type="image/x-icon">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick/slick-theme.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome-free-6.0.0-web//css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/plyr/plyr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    @yield('page-css')

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-242739152-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-242739152-1');
    </script>

    <title>  @if( ! empty($title)) {{ $title }} | {{get_option('site_title')}}  @else {{get_option('site_title')}} @endif </title>

    <script type="text/javascript">
        /* <![CDATA[ */
        window.pageData = @json(pageJsonData());
        /* ]]> */
    </script>

    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
    n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
    document,'script','https://connect.facebook.net/en_US/fbevents.js');
    // Insert Your Facebook Pixel ID below. 
    fbq('init', '626610628397958');
    fbq('track', 'PageView');
    </script>
    <!-- Insert Your Facebook Pixel ID below. --> 
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=626610628397958&amp;ev=PageView&amp;noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->
</head>
    
<body class="{{get_option('enable_rtl')? 'rtl' : ''}} font-poppins">
    <div class="">
        <div class="flex flex-col-reverse justify-end md-6 lg:gap-4 lg:p-6 lg:col-span-4 items-center ">
            <div class="empty hidden lg:block"></div>
            <div class="lg:col-span-4 flex items-center py-10 lg:py-0 px-6 lg:px-0">
                <form role="form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf
                    <h2 class="text-2xl lg:text-4xl font-semibold text-neutral-500 ">
                        Daftar Akun
                    </h2>
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{session('error')}}
                        </div>
                    @endif
                    <p class="text-sm lg:text-base font-normal text-neutral-400 mb-8 ">
                        <span class="hidden lg:inline-block">Silakan daftarkan diri anda untuk melihat kelas di dalam.</span>
                        <span class="lg:hidden">Daftarkan diri untuk melihat Kelas di dalam.</span>
                    </p>
                    <div class="mb-6 ">
                        <input type="text" name="name" id="nama" placeholder="Nama Lengkap" class="form-input w-full border-0 border-b border-neutral-300 py-2 px-0.5 text-sm lg:text-base font-normal text-neutral-500 placeholder:text-neutral-400 focus:outline-none focus:border-b-2 focus:ring-0 focus:border-brand-500 focus:ring-brand-500 mb-1" required>
                        <div class="error normal-case text-xs lg:text-sm font-normal text-danger-500" data-value="false"></div>
                    </div>
                    <div class="mb-6 ">
                        <input type="email" name="email" id="email" placeholder="Email" class="form-input w-full border-0 border-b border-neutral-300 py-2 px-0.5 text-sm lg:text-base font-normal text-neutral-500 placeholder:text-neutral-400 focus:outline-none focus:border-b-2 focus:ring-0 focus:border-brand-500 focus:ring-brand-500 mb-1" required>
                        <div class="error normal-case text-xs lg:text-sm font-normal text-danger-500" data-value="false"></div>
                    </div>
                    <div class="grid grid-cols-7 lg:grid-cols-10 mb-6 ">
                        <div class="col-span-2 lg:col-span-3">
                            <select name="kode_negara" id="kode_negara" class="form-input w-full border-0 border-b border-neutral-300 py-2 px-0.5 text-sm lg:text-base font-normal text-neutral-500 placeholder:text-neutral-400 focus:outline-none focus:border-b-2 focus:ring-0 focus:border-brand-500 focus:ring-brand-500 mb-1 select2">
                                <option value='62'>ID | +62</option>
                                <option value='93'>AF | +93</option>
                                <option value='355'>AL | +355</option>
                                <option value='213'>DZ | +213</option>
                                <option value='1-684'>AS | +1-684</option>
                                <option value='376'>AD | +376</option>
                                <option value='244'>AO | +244</option>
                                <option value='1-264'>AI | +1-264</option>
                                <option value='672'>AQ | +672</option>
                                <option value='1-268'>AG | +1-268</option>
                                <option value='54'>AR | +54</option>
                                <option value='374'>AM | +374</option>
                                <option value='297'>AW | +297</option>
                                <option value='61'>AU | +61</option>
                                <option value='43'>AT | +43</option>
                                <option value='994'>AZ | +994</option>
                                <option value='1-242'>BS | +1-242</option>
                                <option value='973'>BH | +973</option>
                                <option value='880'>BD | +880</option>
                                <option value='1-246'>BB | +1-246</option>
                                <option value='375'>BY | +375</option>
                                <option value='32'>BE | +32</option>
                                <option value='501'>BZ | +501</option>
                                <option value='229'>BJ | +229</option>
                                <option value='1-441'>BM | +1-441</option>
                                <option value='975'>BT | +975</option>
                                <option value='591'>BO | +591</option>
                                <option value='387'>BA | +387</option>
                                <option value='267'>BW | +267</option>
                                <option value='55'>BR | +55</option>
                                <option value='246'>IO | +246</option>
                                <option value='1-284'>VG | +1-284</option>
                                <option value='673'>BN | +673</option>
                                <option value='359'>BG | +359</option>
                                <option value='226'>BF | +226</option>
                                <option value='257'>BI | +257</option>
                                <option value='855'>KH | +855</option>
                                <option value='237'>CM | +237</option>
                                <option value='1'>CA | +1</option>
                                <option value='238'>CV | +238</option>
                                <option value='1-345'>KY | +1-345</option>
                                <option value='236'>CF | +236</option>
                                <option value='235'>TD | +235</option>
                                <option value='56'>CL | +56</option>
                                <option value='86'>CN | +86</option>
                                <option value='61'>CX | +61</option>
                                <option value='61'>CC | +61</option>
                                <option value='57'>CO | +57</option>
                                <option value='269'>KM | +269</option>
                                <option value='682'>CK | +682</option>
                                <option value='506'>CR | +506</option>
                                <option value='385'>HR | +385</option>
                                <option value='53'>CU | +53</option>
                                <option value='599'>CW | +599</option>
                                <option value='357'>CY | +357</option>
                                <option value='420'>CZ | +420</option>
                                <option value='243'>CD | +243</option>
                                <option value='45'>DK | +45</option>
                                <option value='253'>DJ | +253</option>
                                <option value='1-767'>DM | +1-767</option>
                                <option value='1-809, 1-829, 1-849'>DO | +1-809, 1-829, 1-849</option>
                                <option value='670'>TL | +670</option>
                                <option value='593'>EC | +593</option>
                                <option value='20'>EG | +20</option>
                                <option value='503'>SV | +503</option>
                                <option value='240'>GQ | +240</option>
                                <option value='291'>ER | +291</option>
                                <option value='372'>EE | +372</option>
                                <option value='251'>ET | +251</option>
                                <option value='500'>FK | +500</option>
                                <option value='298'>FO | +298</option>
                                <option value='679'>FJ | +679</option>
                                <option value='358'>FI | +358</option>
                                <option value='33'>FR | +33</option>
                                <option value='689'>PF | +689</option>
                                <option value='241'>GA | +241</option>
                                <option value='220'>GM | +220</option>
                                <option value='995'>GE | +995</option>
                                <option value='49'>DE | +49</option>
                                <option value='233'>GH | +233</option>
                                <option value='350'>GI | +350</option>
                                <option value='30'>GR | +30</option>
                                <option value='299'>GL | +299</option>
                                <option value='1-473'>GD | +1-473</option>
                                <option value='1-671'>GU | +1-671</option>
                                <option value='502'>GT | +502</option>
                                <option value='44-1481'>GG | +44-1481</option>
                                <option value='224'>GN | +224</option>
                                <option value='245'>GW | +245</option>
                                <option value='592'>GY | +592</option>
                                <option value='509'>HT | +509</option>
                                <option value='504'>HN | +504</option>
                                <option value='852'>HK | +852</option>
                                <option value='36'>HU | +36</option>
                                <option value='354'>IS | +354</option>
                                <option value='91'>IN | +91</option>
                                <option value='98'>IR | +98</option>
                                <option value='964'>IQ | +964</option>
                                <option value='353'>IE | +353</option>
                                <option value='44-1624'>IM | +44-1624</option>
                                <option value='972'>IL | +972</option>
                                <option value='39'>IT | +39</option>
                                <option value='225'>CI | +225</option>
                                <option value='1-876'>JM | +1-876</option>
                                <option value='81'>JP | +81</option>
                                <option value='44-1534'>JE | +44-1534</option>
                                <option value='962'>JO | +962</option>
                                <option value='7'>KZ | +7</option>
                                <option value='254'>KE | +254</option>
                                <option value='686'>KI | +686</option>
                                <option value='383'>XK | +383</option>
                                <option value='965'>KW | +965</option>
                                <option value='996'>KG | +996</option>
                                <option value='856'>LA | +856</option>
                                <option value='371'>LV | +371</option>
                                <option value='961'>LB | +961</option>
                                <option value='266'>LS | +266</option>
                                <option value='231'>LR | +231</option>
                                <option value='218'>LY | +218</option>
                                <option value='423'>LI | +423</option>
                                <option value='370'>LT | +370</option>
                                <option value='352'>LU | +352</option>
                                <option value='853'>MO | +853</option>
                                <option value='389'>MK | +389</option>
                                <option value='261'>MG | +261</option>
                                <option value='265'>MW | +265</option>
                                <option value='60'>MY | +60</option>
                                <option value='960'>MV | +960</option>
                                <option value='223'>ML | +223</option>
                                <option value='356'>MT | +356</option>
                                <option value='692'>MH | +692</option>
                                <option value='222'>MR | +222</option>
                                <option value='230'>MU | +230</option>
                                <option value='262'>YT | +262</option>
                                <option value='52'>MX | +52</option>
                                <option value='691'>FM | +691</option>
                                <option value='373'>MD | +373</option>
                                <option value='377'>MC | +377</option>
                                <option value='976'>MN | +976</option>
                                <option value='382'>ME | +382</option>
                                <option value='1-664'>MS | +1-664</option>
                                <option value='212'>MA | +212</option>
                                <option value='258'>MZ | +258</option>
                                <option value='95'>MM | +95</option>
                                <option value='264'>NA | +264</option>
                                <option value='674'>NR | +674</option>
                                <option value='977'>NP | +977</option>
                                <option value='31'>NL | +31</option>
                                <option value='599'>AN | +599</option>
                                <option value='687'>NC | +687</option>
                                <option value='64'>NZ | +64</option>
                                <option value='505'>NI | +505</option>
                                <option value='227'>NE | +227</option>
                                <option value='234'>NG | +234</option>
                                <option value='683'>NU | +683</option>
                                <option value='850'>KP | +850</option>
                                <option value='1-670'>MP | +1-670</option>
                                <option value='47'>NO | +47</option>
                                <option value='968'>OM | +968</option>
                                <option value='92'>PK | +92</option>
                                <option value='680'>PW | +680</option>
                                <option value='970'>PS | +970</option>
                                <option value='507'>PA | +507</option>
                                <option value='675'>PG | +675</option>
                                <option value='595'>PY | +595</option>
                                <option value='51'>PE | +51</option>
                                <option value='63'>PH | +63</option>
                                <option value='64'>PN | +64</option>
                                <option value='48'>PL | +48</option>
                                <option value='351'>PT | +351</option>
                                <option value='1-787, 1-939'>PR | +1-787, 1-939</option>
                                <option value='974'>QA | +974</option>
                                <option value='242'>CG | +242</option>
                                <option value='262'>RE | +262</option>
                                <option value='40'>RO | +40</option>
                                <option value='7'>RU | +7</option>
                                <option value='250'>RW | +250</option>
                                <option value='590'>BL | +590</option>
                                <option value='290'>SH | +290</option>
                                <option value='1-869'>KN | +1-869</option>
                                <option value='1-758'>LC | +1-758</option>
                                <option value='590'>MF | +590</option>
                                <option value='508'>PM | +508</option>
                                <option value='1-784'>VC | +1-784</option>
                                <option value='685'>WS | +685</option>
                                <option value='378'>SM | +378</option>
                                <option value='239'>ST | +239</option>
                                <option value='966'>SA | +966</option>
                                <option value='221'>SN | +221</option>
                                <option value='381'>RS | +381</option>
                                <option value='248'>SC | +248</option>
                                <option value='232'>SL | +232</option>
                                <option value='65'>SG | +65</option>
                                <option value='1-721'>SX | +1-721</option>
                                <option value='421'>SK | +421</option>
                                <option value='386'>SI | +386</option>
                                <option value='677'>SB | +677</option>
                                <option value='252'>SO | +252</option>
                                <option value='27'>ZA | +27</option>
                                <option value='82'>KR | +82</option>
                                <option value='211'>SS | +211</option>
                                <option value='34'>ES | +34</option>
                                <option value='94'>LK | +94</option>
                                <option value='249'>SD | +249</option>
                                <option value='597'>SR | +597</option>
                                <option value='47'>SJ | +47</option>
                                <option value='268'>SZ | +268</option>
                                <option value='46'>SE | +46</option>
                                <option value='41'>CH | +41</option>
                                <option value='963'>SY | +963</option>
                                <option value='886'>TW | +886</option>
                                <option value='992'>TJ | +992</option>
                                <option value='255'>TZ | +255</option>
                                <option value='66'>TH | +66</option>
                                <option value='228'>TG | +228</option>
                                <option value='690'>TK | +690</option>
                                <option value='676'>TO | +676</option>
                                <option value='1-868'>TT | +1-868</option>
                                <option value='216'>TN | +216</option>
                                <option value='90'>TR | +90</option>
                                <option value='993'>TM | +993</option>
                                <option value='1-649'>TC | +1-649</option>
                                <option value='688'>TV | +688</option>
                                <option value='1-340'>VI | +1-340</option>
                                <option value='256'>UG | +256</option>
                                <option value='380'>UA | +380</option>
                                <option value='971'>AE | +971</option>
                                <option value='44'>GB | +44</option>
                                <option value='1'>US | +1</option>
                                <option value='598'>UY | +598</option>
                                <option value='998'>UZ | +998</option>
                                <option value='678'>VU | +678</option>
                                <option value='379'>VA | +379</option>
                                <option value='58'>VE | +58</option>
                                <option value='84'>VN | +84</option>
                                <option value='681'>WF | +681</option>
                                <option value='212'>EH | +212</option>
                                <option value='967'>YE | +967</option>
                                <option value='260'>ZM | +260</option>
                                <option value='263'>ZW | +263</option>
                            </select>
                        </div>
                        <div class="col-span-5 lg:col-span-7">
                            <input type="text" name="phone" id="whatsapp" placeholder="Whatsapp" class="form-input w-full border-0 border-b border-neutral-300 py-2 px-0.5 text-sm lg:text-base font-normal text-neutral-500 placeholder:text-neutral-400 focus:outline-none focus:border-b-2 focus:ring-0 focus:border-brand-500 focus:ring-brand-500 mb-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>
                            <div class="error normal-case text-xs lg:text-sm font-normal text-normal-500" data-value="false">Contoh : 8581234XXX</div>
                        </div>
                    </div>
                    <div class="mb-8 lg:mb-16 relative">
                        <input type="password" name="password" id="sandi" placeholder="Sandi" minlength="6" class="form-input w-full border-0 border-b border-neutral-300 py-2 pr-6 px-0.5 text-sm lg:text-base font-normal text-neutral-500 placeholder:text-neutral-400 focus:outline-none focus:border-b-2 focus:ring-0 focus:border-brand-500 focus:ring-brand-500 mb-1" required>
                        <div class="error normal-case text-xs lg:text-sm font-normal text-neutral-400" data-value="true">&nbsp;Buat Sandi Minimal 6 Karakter.</div>
                        <div class="absolute top-[10px] lg:top-1/4 right-0 cursor-pointer show-pass">
                            <i class="fa-regular fa-eye-slash"></i>
                        </div>
                    </div>
                    <input type="hidden" name="price" value="{{ $unique_price }}">
                    @if (isset($course))
                        <input type="hidden" name="product" value="{{ $course }}">
                    @endif
                    <input type="hidden" name="user_as" value="student">
                    <div class="">
                        <div class="mb-6">
                            <h4 class="text-xl lg:text-2xl font-semibold text-neutral-500 mb-2" >
                                Anda Belajar Semua Kelas 
                            </h4>
                            <div class="lg:grid lg:grid-cols-2 text-md font-normal text-neutral-900">
                                <ul class="list-disc ml-5">
                                    <li>12+ Kelas Bisnis</li>
                                    <li>1000+ Video & Dokumen</li>
                                    <li>300+ Mentor Terbaik</li>
                                </ul>
                                <ul class="list-disc ml-5">
                                    <li>5 Program Bisnis</li>
                                    <li>Gratis Kelas Baru</li>
                                    <li>Gratis Pendampingan Mentor</li>
                                </ul>
                            </div>
                        </div>
    
                        <div>
                            <input type="hidden" name="jenisPaket" id="jenisPaket" value="1">
                            <div class="pilih-paket rounded-lg border-2 border-brand-500 drop-shadow p-4 bg-white cursor-pointer" data-value="1" data-type="Pemula">
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
                            </div>
                            <div class="pilih-paket rounded-lg border-2 border-neutral-100 p-4 bg-white cursor-pointer" data-value="3" data-type="Menengah">
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
                            </div>
                            <div class="pilih-paket rounded-lg border-2 border-neutral-100 p-4 bg-white cursor-pointer" data-value="6" data-type="Ahli">
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
                            </div>
                        </div>
                            <br>
                        <div>
                            <div>
                                <h4 class="text-xl lg:text-2xl font-semibold text-neutral-500 mb-2">
                                    Pembayaran
                                </h4>
                                {{-- <p class="hidden lg:block text-base font-normal text-neutral-400">
                                    Transfer ke rekening Bank untuk melanjutkan proses pembayaran.
                                </p>
                                <p class="lg:hidden text-xs font-normal text-neutral-400">
                                    Transfer ke rekening Bank untuk melanjutkan pembayaran.
                                </p> --}}
                            </div>
                            <div class="h-0.5 w-full bg-brand-100 my-8 lg:my-12"></div>
                            <div class="mb-12">
                                <img src="{{ asset('assets/images/icons/pembayaran-bank-bsi.png') }}" class="h-10 mb-6" alt="Bank">
                                <table  class="text-xs lg:text-sm font-normal text-neutral-400 lg:mb-8">
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
                                <h4 class="text-xl lg:text-2xl font-semibold text-neutral-500 mb-2" >
                                    Lampirkan Bukti Pembayaran
                                </h4>
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
                                    Konfirmasi Pembayaran & Buat Akun
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="empty hidden lg:block"></div>
            <div class="lg:col-span-6 lg:pb-4 bg-cover bg-center lg:rounded-3xl flex flex-col justify-between relative" >

                <form action="{{route('save_payment_detail')}}" id="formPost" method="post" enctype="multipart/form-data">
                        
                        
                </form>
                
                
            </div>
        </div>
    </div>
 
    <script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('assets/vendor/slick/slick.js')}}"></script>
    
    <script src="{{asset('assets/vendor/flowbite/flowbite.js')}}"></script>
    <script src="{{asset('assets/vendor/plyr/plyr.polyfilled.js')}}"></script>
    <script src="{{asset('assets/js/script.js')}}"></script>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        {{ csrf_field() }}
    </form>
    
    @yield('page-js')
    <script>
        
    const player = new Plyr('#player', {});
    
    
    window.player = player;
    
    </script>
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if($('#show_hide_password input').attr("type") == "text"){
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass( "la-eye-slash" );
                    $('#show_hide_password i').removeClass( "la-eye" );
                }else if($('#show_hide_password input').attr("type") == "password"){
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass( "la-eye-slash" );
                    $('#show_hide_password i').addClass( "la-eye" );
                }
            });
        });
    </script>
    
    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
            alert('text copied');
        }
        function copyToClip(text) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(text).select();
            document.execCommand("copy");
            $temp.remove();
            alert('text copied');
        }
    </script>
</body>
</html>
