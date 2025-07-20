@extends('layouts.admin')

@section('content')

@include('admin.users.menu')  

        <div class="row">

            <div class="col-md-5">
                <button type="button" class="btn btn-success text-right" data-toggle="modal" data-target="#addUser"><i class="la la-plus"></i> Add User</button>
                <button type="button" class="btn btn-info text-right" data-toggle="modal" data-target="#uploadUser"><i class="la la-upload"></i> Bulk Update</button>
                <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#followUpSetting">Setting Text</button>
                <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUser" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        
                        <form method="POST" action="{{ route('admin_user_add') }}">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addUser">Add User Class</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @csrf
                                <div class="modal-body row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Nama User:</label>
                                            <input type="text" class="form-control" required name="name" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Email User:</label>
                                            <input type="email" class="form-control" required name="email" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Password User:</label>
                                            <input type="text" class="form-control" required name="password" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Amount:</label>
                                            <input type="number" class="form-control" required name="amount" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Expired Package (monthly):</label>
                                            <input type="number" class="form-control" required name="expired" autocomplete="off">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Status:</label>
                                            <br>
                                            <label class="mr-2">
                                                <input type="radio" name="active_status" checked required value="1"> Active
                                            </label>
                                            <label class="mr-2">
                                                <input type="radio" name="active_status" required value="0"> Pending
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Reseller:</label>
                                            <br>
                                            <label class="mr-2">
                                                <input type="radio" name="reseller" required value="1"> Ya
                                            </label>
                                            <label class="mr-2">
                                                <input type="radio" name="reseller" checked required value="0"> Tidak
                                            </label>
                                        </div>
                                        <input type="hidden" name="type" required value="partial">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">No Whatsapp:</label>
                                            <input list="kode_negara" type="text" class="form-control" required name="phone" autocomplete="off">
                                                <datalist id="kode_negara" name="kode_negara" >
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
                                                </datalist>
                                            
                                        </div>
                                        @php
                                            $tes = \App\Province::get('provinsi')->whereNotNull('provinsi');
                                        @endphp
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Province:</label>
                                            <select class="form-control"  name="city">
                                                <option value="">Select Province...</option>
                                                @foreach ($tes as $item)
                                                    <option value="{{ $item->provinsi }}">{{ $item->provinsi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Product Category :</label>
                                            <select class="form-control" name="category_product" id="kategori">
                                                <option value="" hidden>Select Kategori</option>
                                                <option value="1">Class</option>
                                                <option value="2">Member Ads</option>
                                                <option value="3">Fiqeeh Ads</option>
                                            </select>
                                        </div>
                                        @php
                                            $tanggal = date('Y-m-d H:i:s',strtotime('now'));
                                        @endphp
                                        <div class="form-group" hidden>
                                            <input type="text" name="last_payment" value="{{$tanggal}}"/></td>
                                        </div>
                                        
                                        @php
                                            $cours = \App\Course::where('category_id', '!=', 1205)->where('category_id', '!=', 1203)->orderBy('title','asc')->get();
                                        @endphp 
                                        <div class="form-group" id="classcat">
                                            <label for="recipient-name" class="col-form-label">Product Class:</label>
                                            <select class="form-control" name="product" id="product">
                                                <option value="" selected hidden>Pilih Product</option>
                                                <option value="Kampus Bisnis Syariah">Kampus Bisnis Syariah</option>
                                                @foreach ($cours as $item)
                                                    <option value="{{ $item->title }}">{{ $item->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @php
                                            $courrrs = \App\Course::where('category_id', '!=', 1185)->where('category_id','!=',1186)->where('category_id','!=',1188)->where('category_id','!=',1190)->where('category_id','!=',1191)->orderBy('title','asc')->get();
                                        @endphp 
                                        <div class="form-group" id="adscat">
                                            <label for="recipient-name" class="col-form-label">Product Ads:</label>
                                            <select class="form-control" name="product_ads" id="product">
                                                <option value="" selected hidden>Pilih Product</option>
                                                <option value="Kampus Bisnis Syariah">Kampus Bisnis Syariah</option>
                                                @foreach ($courrrs as $item)
                                                    <option value="{{ $item->title }}">{{ $item->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Age Range:</label>
                                            <select class="form-control" name="age" id="age">
                                                <option value="">Select Age Range...</option>
                                                <option value="18 - 24">18 - 24</option>
                                                <option value="25 - 29">25 - 29</option>
                                                <option value="30 - 34">30 - 34</option>
                                                <option value="35 - 39">35 - 39</option>
                                                <option value="40 - 44">40 - 44</option>
                                                <option value="45 - 49">45 - 49</option>
                                                <option value="50 - 54">50 - 54</option>
                                                <option value="> 55">> 55</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Profession:</label>
                                            <select class="form-control" name="job_title" id="job_title">
                                                <option value="">Select Profession...</option>
                                                <option value="Pengusaha">Pengusaha</option>
                                                <option value="Pegawai">Pegawai</option>
                                                <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                                <option value="Mahasiswa">Mahasiswa</option>
                                                <option value="Belum bekerja">Belum bekerja</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">No Of Employee:</label>
                                            <select class="form-control" name="total_employee" id="total_employee">
                                                <option value="">Select No Of Employee Range...</option>
                                                <option value="Belum Bisnis">Belum Bisnis</option>
                                                <option value="0 - 4">0 - 4 Pegawai</option>
                                                <option value="5 - 19">5 - 19 Pegawai</option>
                                                <option value=">20">>20 Pegawai</option>
                                            </select>
                                        </div>
                                        <div class="form-group" >
                                            <label for="recipient-name" class="col-form-label">Details:</label>
                                            <textarea name="about_me" id="about_me" class="form-control" cols="30" rows="3"></textarea>
                                        </div>
                                        @php
                                            $textset = \App\TextSettings::where('id',1)->get();
                                        @endphp
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Text</label>
                                            @foreach ($textset as $item)
                                                <textarea name="text_blast" id="text_blast" class="form-control" cols="30" rows="3">{{$item->text}}</textarea>
                                            @endforeach
                                           
                                        </div>
                                        
                                    </div>
                                    <input type="hidden" name="user_type" required value="student">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-purple"><i class="la la-save"></i>Save</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>

                <div class="modal fade" id="uploadUser" tabindex="-1" role="dialog" aria-labelledby="uploadUser" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <form method="POST" action="{{ route('admin_user_add') }}" enctype="multipart/form-data">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadUser">Bulk Upload User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @csrf
                                <div class="modal-body row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="additional_css" class="col-sm-4 control-label">File User CRM</label>
                                            <div class="col-sm-8">
                                                <input type="file" accept=".xls,.xlsx" class="form-control-file" id="file" value="{{ old('file') }}" name="file" placeholder="{{__a('file')}}">
                                                <p class="help-block">Sample File : <a href="{{ asset('assets/files/Sample File CRM Update.xlsx') }}" target="_blank" rel="noopener noreferrer">.xlsx</a></p>
                                                {!! $errors->has('file')? '<p class="help-block">'.$errors->first('file').'</p>':'' !!}
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="user_type" required value="student">
                                    <input type="hidden" name="type" required value="bulk">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-purple"><i class="la la-save"></i>Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- <div class="input-group">
                    <select name="status" class="mr-3">
                        <option value="">{{__a('set_status')}}</option>

                        <option value="1">Active</option>
                        <option value="2">Block</option>
                    </select>

                    <button type="submit" name="bulk_action_btn" value="update_status" class="btn btn-primary mr-2">{{__a('update')}}</button>
                    <button type="submit" name="bulk_action_btn" value="delete" class="btn btn-danger delete_confirm"> <i class="la la-trash"></i> {{__a('delete')}}</button>
                </div> --}}
            </div>

            <div class="col-md-7">

                <form method="get">
                    
                    <div class="search-filter-form-wrap mb-3">
                        <div class="input-group">
                                <select name="status" class="form-control mr-1">
                                    <option value="">Select status...</option>
                                    <option @if ("Active" == @$_GET['status']) selected @endif value="Active">Active</option>
                                    <option @if ("Expired" == @$_GET['status']) selected @endif value="Expired">Expired</option>
                                    <option @if ("Leads" == @$_GET['status']) selected @endif value="Leads">Leads</option>
                                </select>
                                <select name="filter_data" class="form-control mr-1">
                                    <option value="">Filter by data null</option>
                                    <option value="last_payment" {{selected('last_payment', request('filter_data'))}}>Last Payment</option>
                                    {{-- <option value="monthly" {{selected('monthly', request('filter_data'))}}>Monthly</option>
                                    <option value="expired" {{selected('expired', request('filter_data'))}}>Expired At</option> --}}
                                </select>
                            <input type="text" class="form-control mr-3" name="q" value="{{request('q')}}" placeholder="Filter by Name, E-Mail, Phone">
                            
                            <button type="submit" class="btn btn-primary btn-purple"><i class="la la-search-plus"></i> Filter results</button>
                        </div>
                    </div>

                </form>
        
            </div>

        </div>
        <div class="modal fade" id="followUpSetting" tabindex="-1" role="dialog" aria-labelledby="followUpLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <form action="{{route('save_edit_text')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="followUpLabel">Setting Text Blasting</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @foreach ($followUp as $fu)
                            <div class="modal-body">
                                <label for="massage-text">Helper : {name},{product},{product_ads},{now},{expired},{phone},{link},{city}</label>
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">{{ $fu['title'] }} Template Text:</label>
                                    <textarea class="form-control" rows="3" type="text" name="{{ $fu['id'] }}[text]">{{ $fu['text'] }}</textarea>
                                </div>
                            </div>
                        @endforeach
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @php
            $tes = \App\Province::get('provinsi')->whereNotNull('provinsi');
        @endphp
        @if($users->count() > 0)
        <p class="text-muted my-3"> <small>Showing {{$users->count()}} from {{$users->total()}} results</small> </p>

            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            {{-- <th><input class="bulk_check_all" type="checkbox" /></th> --}}
                            <th>{{ trans('admin.name') }}</th>
                            {{-- <th>{{ trans('admin.email') }}</th> --}}
                            {{-- <th>{{__a('type')}}</th> --}}
                            <th>Phone</th>
                            <th>Product Category</th>
                            <th>Product</th>
                            <th>Province</th>
                            <th>Usia</th>
                            <th>Profesi</th>
                            <th>Details</th>
                            <th>Last Payment On</th>
                            <th>Expired Class</th>
                            <th>Expired Ads</th>
                            <th>{{__a('status')}}</th>
                        </tr>
                        @if($users['session_id'] == NULL)
                                @foreach($users as $u)
                                    {{-- @if (count($u['user_enrolls']) > 0) --}}
                                        {{-- @foreach ($u['user_enrolls'] as $item) --}}
                                            {{-- @if(isset($item['course'])) --}}
                                                <tr>
                                                    {{-- <td>
                                                        <label>
                                                            <input class="check_bulk_item" name="bulk_ids[]" type="checkbox" value="{{$u->id}}" />
                                                            <small class="text-muted">#{{$u->id}}</small>
                                                        </label>
                                                    </td> --}}
                                                    <td>{{ $u->name }}</td>
                                                    {{-- <td>{{ $u->email }}</td> --}}
                                                    {{-- <td>

                                                        @if($u->isAdmin)
                                                            <span class="badge badge-success">Admin</span>
                                                        @elseif($u->isInstructor)
                                                            <span class="badge badge-info">Instructor</span>
                                                        @else
                                                            <span class="badge badge-dark">Student</span>
                                                        @endif

                                                        @if($u->active_status == 2)
                                                            <span class="badge badge-danger">Blocked</span>
                                                        @endif
                                                    </td> --}}
                                                    <td>{{ $u->phone }}</td>
                                                    <td>
                                                        @if ($u->category_product == NULL)
                                                            Kelas
                                                        @elseif ($u->category_product == 1 )
                                                            Kelas
                                                        @elseif ($u->category_product == 2)
                                                            Member Ads
                                                        @elseif ($u->category_product == 3)
                                                            Fiqeeh Ads
                                                        @endif
                                                    </td>
                                                    @if($u->product == null) 
                                                    <td>{{ $u->product_ads }}</td>
                                                    @else
                                                    <td>{{ $u->product }}</td>
                                                    @endif
                                                    {{-- <td>{{ $item['course']['title'] }}</td> 
                                                    <td>{{ $item['percentage_report']."%" }}</td> --}}
                                                    <td>{{ $u->city }}</td>
                                                    <td>{{ $u->age }}</td>
                                                    <td>{{ $u->job_title }}</td>
                                                    <td>{{ $u->about_me }}</td>
                                                    {{-- <td>@if ($u->reseller == 1) Ya @else Tidak @endif</td> --}}
                                                    <td>{{ date('m/d/Y', strtotime($u->last_payment)) }}</td>
                                                    <td>{{ date('m/d/Y', strtotime($u->expired_package_at)) }}</td>
                                                    <td>
                                                        @if ($u->expired_ads_at == NULL)
                                                         - 
                                                        @else 
                                                        {{date('m/d/Y', strtotime($u->expired_ads_at))}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($u->expired_package_at > date('Y-m-d H:i:s'))
                                                            Active
                                                        @elseif (in_array($u->id, $dataLeads))
                                                            Leads
                                                        @else
                                                            Expired
                                                        @endif
                                                    </td>
                                                    <td>
                                                        

                                            
                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addExpired{{$u->id}}"><i class="la la-donate"></i></button>
                                                        <div class="modal fade" id="addExpired{{$u->id}}" tabindex="-1" role="dialog" aria-labelledby="addExpired" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <form method="POST" action="{{ route('add-exp-user', $u->id) }}">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="addExpired">Tambah Masa Aktif User {{$u->name}}</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Username:</label>
                                                                                <input type="text" class="form-control" required name="username" value="{{$u->name}}" autocomplete="off">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Email User:</label>
                                                                                <input type="text" class="form-control" value="{{$u->email}}" disabled>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">No Whatsapp:</label>
                                                                                <input type="text" class="form-control" name="phone" value="{{$u->phone}}" autocomplete="off">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Province:</label>
                                                                                <select class="form-control" name="city">
                                                                                    <option value="{{ $u->city }}" selected>{{ $u->city }}</option>
                                                                                    @foreach ($tes as $item)
                                                                                        <option value="{{ $item->provinsi }}">{{ $item->provinsi }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Produk Kategori :</label>
                                                                                <select class="form-control" name="category_products" id="kategoriexp">
                                                                                    <option value="" hidden>Select Kategori</option>
                                                                                    <option value="1">Class</option>
                                                                                    <option value="2">Member Ads</option>
                                                                                    <option value="3">Fiqeeh Ads</option>
                                                                                </select>
                                                                            </div>
                                                                            @php
                                                                                $cours = \App\Course::where('category_id', '!=', 1205)->where('category_id', '!=', 1203)->orderBy('title','asc')->get();
                                                                            @endphp 
                                                                            <div class="form-group" id="classcatexp">
                                                                                <label for="recipient-name" class="col-form-label">Product Class:</label>
                                                                                <select class="form-control" name="products" id="product">
                                                                                    <option value="" selected hidden>Pilih Product</option>
                                                                                    <option value="Kampus Bisnis Syariah">Kampus Bisnis Syariah</option>
                                                                                    @foreach ($cours as $item)
                                                                                        <option value="{{ $item->title }}">{{ $item->title }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            @php
                                                                                $courrrs = \App\Course::where('category_id', '!=', 1185)->where('category_id','!=',1186)->where('category_id','!=',1188)->where('category_id','!=',1190)->where('category_id','!=',1191)->orderBy('title','asc')->get();
                                                                            @endphp 
                                                                            <div class="form-group" id="adscatexp">
                                                                                <label for="recipient-name" class="col-form-label">Product Ads:</label>
                                                                                <select class="form-control" name="products_ads" id="product">
                                                                                    <option value="" selected hidden>Pilih Product</option>
                                                                                    <option value="Kampus Bisnis Syariah">Kampus Bisnis Syariah</option>
                                                                                    @foreach ($courrrs as $item)
                                                                                        <option value="{{ $item->title }}">{{ $item->title }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Age Range:</label>
                                                                                <select class="form-control" name="age" id="age">
                                                                                    <option value="">Select Age Range...</option>
                                                                                    <option @if ($u->age == "18 - 24") selected @endif value="18 - 24">18 - 24</option>
                                                                                    <option @if ($u->age == "25 - 29") selected @endif value="25 - 29">25 - 29</option>
                                                                                    <option @if ($u->age == "30 - 34") selected @endif value="30 - 34">30 - 34</option>
                                                                                    <option @if ($u->age == "35 - 39") selected @endif value="35 - 39">35 - 39</option>
                                                                                    <option @if ($u->age == "40 - 44") selected @endif value="40 - 44">40 - 44</option>
                                                                                    <option @if ($u->age == "45 - 49") selected @endif value="45 - 49">45 - 49</option>
                                                                                    <option @if ($u->age == "50 - 54") selected @endif value="50 - 54">50 - 54</option>
                                                                                    <option @if ($u->age == "> 55") selected @endif value="> 55">> 55</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Profession:</label>
                                                                                <select class="form-control" name="job_title" id="job_title">
                                                                                    <option value="">Select Profession...</option>
                                                                                    <option @if ($u->job_title == "Pengusaha") selected @endif value="Pengusaha">Pengusaha</option>
                                                                                    <option @if ($u->job_title == "Pegawai") selected @endif value="Pegawai">Pegawai</option>
                                                                                    <option @if ($u->job_title == "Ibu Rumah Tangga") selected @endif value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                                                                    <option @if ($u->job_title == "Mahasiswa") selected @endif value="Mahasiswa">Mahasiswa</option>
                                                                                    <option @if ($u->job_title == "Belum bekerja") selected @endif value="Belum bekerja">Belum bekerja</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">No Of Employee:</label>
                                                                                <select class="form-control" name="total_employee" id="total_employee">
                                                                                    <option value="">Select No Of Employee Range...</option>
                                                                                    <option @if ($u->total_employee == "Belum Bisnis") selected @endif value="Belum Bisnis">Belum Bisnis</option>
                                                                                    <option @if ($u->total_employee == "0 - 4") selected @endif value="0 - 4">0 - 4 Pegawai</option>
                                                                                    <option @if ($u->total_employee == "5 - 19") selected @endif value="5 - 19">5 - 19 Pegawai</option>
                                                                                    <option @if ($u->total_employee == ">20") selected @endif value=">20">>20 Pegawai</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Details:</label>
                                                                                <textarea name="about_me" id="about_me" class="form-control" cols="30" rows="3">{{ $u->about_me }}</textarea>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Amount:</label>
                                                                                <input type="number" class="form-control" required name="amount" autocomplete="off">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Expired Package (mounthly):</label>
                                                                                <input type="number" class="form-control" required name="expired" autocomplete="off">
                                                                            </div>
                                                                                @php
                                                                                    $course = \App\TextSettings::where('id',1)->get();
                                                                                @endphp
                                                                                <div class="form-group">
                                                                                    <label for="recipient-name" class="col-form-label">Pengirim:</label>
                                                                                    <select class="form-control" name="text_instance">
                                                                                        @foreach ($course as $item)
                                                                                                <option value="{{ $item->instance_id }}">{{ "Nomor Pengirim : ".$item->label . " || " . "Instance Id: ".$item->instance_id }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    <br>
                                                                                    <p class="help-block">Pilihlah Salah Satu Nomor Pengirim Di Atas</a></p>
                                                                                </div>
                                                                            @php
                                                                                $textset = \App\TextSettings::where('id',7)->get();
                                                                            @endphp
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Text</label>
                                                                                @foreach ($textset as $item)
                                                                                    <textarea name="text_blast" id="text_blast" class="form-control" cols="30" rows="3">{{$item->text}}</textarea>
                                                                                @endforeach
                                                                            
                                                                            </div>
                                                                            <input type="hidden" name="last_product" value="{{@$_GET['last_product']}}">
                                                                            <input type="hidden" name="age" value="{{@$_GET['age']}}">
                                                                            <input type="hidden" name="city" value="{{@$_GET['city']}}">
                                                                            <input type="hidden" name="job_title" value="{{@$_GET['job_title']}}">
                                                                            <input type="hidden" name="total_employee" value="{{@$_GET['total_employee']}}">
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-purple"><i class="la la-save"></i>Save</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#updateDetail{{$u->id}}"><i class="la la-edit"></i></button>
                                                        <div class="modal fade" id="updateDetail{{$u->id}}" tabindex="-1" role="dialog" aria-labelledby="updateDetail" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <form method="POST" action="{{ route('edit-user', $u->id) }}">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="updateDetail">Update Detail User {{$u->name}}</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Nama User:</label>
                                                                                <input type="text" class="form-control" name="name" value="{{$u->name}}" autocomplete="off">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Email User:</label>
                                                                                <input type="text" class="form-control" name="email" value="{{$u->email}}" autocomplete="off">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">No Whatsapp:</label>
                                                                                <input type="text" class="form-control" name="phone" value="{{$u->phone}}" autocomplete="off">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Expired Package At:</label>
                                                                                <input type="date" class="form-control datepicker" name="expired_package_at" value="{{date('Y-m-d', strtotime($u->expired_package_at))}}" autocomplete="off">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Start Date:</label>
                                                                                <input type="date" class="form-control datepicker" name="created_at" value="{{date('Y-m-d', strtotime($u->created_at))}}" autocomplete="off">
                                                                            </div>
                                                                            {{-- <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Update At:</label>
                                                                                <input type="date" class="form-control datepicker" name="updated_at" value="{{date('Y-m-d', strtotime($u->updated_at))}}" autocomplete="off" disabled>
                                                                            </div> --}}
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Province:</label>
                                                                                <select class="form-control" name="city">
                                                                                    
                                                                                    <option value="{{ $u->city }}" selected>{{ $u->city }}</option>
                                                                                    @foreach ($tes as $item)
                                                                                        <option value="{{ $item->provinsi }}">{{ $item->provinsi }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            @php
                                                                                $cours = \App\Course::where('category_id', '!=', 1205)->where('category_id', '!=', 1203)->orderBy('title','asc')->get();
                                                                                $courrrs = \App\Course::where('category_id', '!=', 1185)->where('category_id','!=',1186)->where('category_id','!=',1188)->where('category_id','!=',1190)->where('category_id','!=',1191)->orderBy('title','asc')->get();
                                                                            @endphp 
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Product Category :</label>
                                                                                <select class="form-control" name="category_product" id="kategoriexp" disabled>
                                                                                    <option value="" hidden>Select Category</option>
                                                                                        @if ($u->category_product == 1)
                                                                                            <option value="1" selected hidden>Class</option>
                                                                                        @elseif($u->category_product == 2)
                                                                                            <option value="2" selected hidden>Ads</option>
                                                                                        @endif
                                                                                        <option value="1">Class</option>
                                                                                        <option value="2">Ads</option>
                                                                                        <option value="3">Fiqeeh Product</option>
                                                                                        <option value="4">Ads Member</option>
                                                                                </select>
                                                                            </div>
                                                                            @if($u->category_product == 1)
                                                                            <div>

                                                                            </div>
                                                                            @else
                                                                            <div class="form-group" id="adscatexp">
                                                                                <label for="recipient-name" class="col-form-label">Product Ads:</label>
                                                                                <select class="form-control" name="product_ads" id="product">
                                                                                    <option value="" selected hidden>Pilih Product</option>
                                                                                    <option value="Kampus Bisnis Syariah">Kampus Bisnis Syariah</option>
                                                                                    @foreach ($courrrs as $item)
                                                                                        @if ($u->product_ads == $item->title)
                                                                                            <option value="{{ $item->title }}" selected>{{ $item->title }}</option>
                                                                                        @else
                                                                                            <option value="{{ $item->title }}">{{ $item->title }}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            @endif
                                                                            @if($u->category_product == 2)
                                                                            <div>
                                                                            
                                                                            </div>
                                                                            @else
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Product Class:</label>
                                                                                <select class="form-control" name="product">
                                                                                    <option value="Kampus Bisnis Syariah">Kampus Bisnis Syariah</option>
                                                                                    @foreach ($cours as $item)
                                                                                        @if ($u->product == $item->title)
                                                                                            <option value="{{ $item->title }}" selected>{{ $item->title }}</option>
                                                                                        @else
                                                                                            <option value="{{ $item->title }}">{{ $item->title }}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                                {{-- <input type="text" class="form-control" name="product" value="{{$u->product}}" autocomplete="off"> --}}
                                                                            </div>
                                                                            @endif
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Age Range:</label>
                                                                                <select class="form-control" name="age" id="age">
                                                                                    <option value="">Select Age Range...</option>
                                                                                    <option @if ($u->age == "18 - 24") selected @endif value="18 - 24">18 - 24</option>
                                                                                    <option @if ($u->age == "25 - 29") selected @endif value="25 - 29">25 - 29</option>
                                                                                    <option @if ($u->age == "30 - 34") selected @endif value="30 - 34">30 - 34</option>
                                                                                    <option @if ($u->age == "35 - 39") selected @endif value="35 - 39">35 - 39</option>
                                                                                    <option @if ($u->age == "40 - 44") selected @endif value="40 - 44">40 - 44</option>
                                                                                    <option @if ($u->age == "45 - 49") selected @endif value="45 - 49">45 - 49</option>
                                                                                    <option @if ($u->age == "50 - 54") selected @endif value="50 - 54">50 - 54</option>
                                                                                    <option @if ($u->age == "> 55") selected @endif value="> 55">> 55</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Profession:</label>
                                                                                <select class="form-control" name="job_title" id="job_title">
                                                                                    <option value="">Select Profession...</option>
                                                                                    <option @if ($u->job_title == "Pengusaha") selected @endif value="Pengusaha">Pengusaha</option>
                                                                                    <option @if ($u->job_title == "Pegawai") selected @endif value="Pegawai">Pegawai</option>
                                                                                    <option @if ($u->job_title == "Ibu Rumah Tangga") selected @endif value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                                                                    <option @if ($u->job_title == "Mahasiswa") selected @endif value="Mahasiswa">Mahasiswa</option>
                                                                                    <option @if ($u->job_title == "Belum bekerja") selected @endif value="Belum bekerja">Belum bekerja</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">No Of Employee:</label>
                                                                                <select class="form-control" name="total_employee" id="total_employee">
                                                                                    <option value="">Select No Of Employee Range...</option>
                                                                                    <option @if ($u->total_employee == "Belum Bisnis") selected @endif value="Belum Bisnis">Belum Bisnis</option>
                                                                                    <option @if ($u->total_employee == "0 - 4") selected @endif value="0 - 4">0 - 4 Pegawai</option>
                                                                                    <option @if ($u->total_employee == "5 - 19") selected @endif value="5 - 19">5 - 19 Pegawai</option>
                                                                                    <option @if ($u->total_employee == ">20") selected @endif value=">20">>20 Pegawai</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Details:</label>
                                                                                <textarea name="about_me" id="about_me" class="form-control" cols="30" rows="3">{{ $u->about_me }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-purple"><i class="la la-save"></i>Save</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <button type="submit"> <a href="{!!route('user_delete', $u->id)!!}" class="btn btn-md btn-danger delete_confirm"><i class="la la-trash"></i> </a> </button>
                                                            
                                                        </div>

                                                        
                                                        
                                                    </td>
                                                </tr>
                                            {{-- @endif --}}
                                        {{-- @endforeach --}}
                                    {{-- @endif --}}
                                @endforeach
                            @endif
                        </table>


                    {!! $users->appends(request()->input())->links() !!}

                </div>
            </div>

        @else
            {!! no_data() !!}
        @endif
@endsection

<script>
    function changeFormat(sel, id)
    {
        console.log("message-text-"+id)
        $.post("{{route('followUpFormat')}}", {_token: "{{ csrf_token() }}", id_payment: id, folow_up: sel.value}, function( data ) {
            $("textarea#message-text-" + id).val(data.text);
            link = "https://api.whatsapp.com/send?phone="+data.phone+"&text="+data.message
            $("a#link-text-" + id).attr("href", link) 
        });
    }
    </script>
