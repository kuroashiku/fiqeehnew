@extends('layouts.admin')

@section('page-header-right')
    @if(count(request()->input()))
        <a href="{{route('admin_afiliasi')}}"> <i class="la la-arrow-circle-left"></i> {{__a('reset_filter')}}  </a>
    @endif
@endsection

@section('content')
 
    <form method="get">

        <div class="row">

            <div class="col-md-3">
                <button type="button" class="btn btn-success text-right" data-toggle="modal" data-target="#settingAfiliasi"><i class="la la-gear"></i> Setting Afiliasi</button>
{{--                <a href="{{ route('admin_afiliasi_buku') }}" class="btn btn-success text-right"><i class="la la-book"></i> Book</a>--}}
            </div>

            <div class="col-md-9">

                <div class="search-filter-form-wrap mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control mr-1" name="q" value="{{request('q')}}" placeholder="Search by Name, E-Mail">
                        <select name="status" class="form-control mr-1">
                            <option value="">Filter by status</option>
                            <option value="0" {{selected('0', request('status'))}} >pending</option>
                            <option value="1" {{selected('1', request('status'))}} >success</option>
                            <option value="2" {{selected('2', request('status'))}} >declined</option>
                        </select>
                        <input type="date" name="start_date" class="form-control datepicker" value="{{request('start_date')}}">
                        <div class="input-group-addon">to</div>
                        <input type="date" name="end_date" class="form-control datepicker mr-1" value="{{request('end_date')}}">
                        <button type="submit" class="btn btn-primary"><i class="la la-search-plus"></i> Submit</button>
                    </div>
                </div>
            </div>

        </div>
    </form>
    <div class="modal fade" id="settingAfiliasi" tabindex="-1" role="dialog" aria-labelledby="settingAfiliasi" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="{{ route('admin_afiliasi_option') }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="settingAfiliasi">Setting Afiliasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @csrf
                    <div class="modal-body row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nominal Komisi Kelas per User:</label>
                                <input type="number" class="form-control" required name="komisi_kelas" autocomplete="off" value="{{ $komisiKelas->option_value }}">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nominal Komisi Buku per User:</label>
                                <input type="number" class="form-control" required name="komisi_buku" autocomplete="off" value="{{ $komisiBuku->option_value }}">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Minimum Request Payment:</label>
                                <input type="number" class="form-control" required name="minimal_pengajuan_afiliasi" autocomplete="off" value="{{ $minimalPengajuanAfiliasi->option_value }}">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Term and Condition:</label>
                                <textarea class="form-control" required name="peraturan_afiliasi" autocomplete="off" rows="10">{{ $peraturanAfiliasi->option_value }}</textarea>
                            </div>
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
    @if($afiliasi->count() > 0)



        <p class="text-muted my-3"> <small>Showing {{$afiliasi->count()}} from {{$afiliasi->total()}} results</small> </p>

        <table class="table table-striped table-bordered">

            <tr>
                <th><input class="bulk_check_all" type="checkbox" /></th>
                <th style="width:20%;">User Detail</th>
                {{-- <th>{{__a('amount')}}</th> --}}
                {{-- <th>Verifikasi</th> --}}
                <th>{{__a('time')}}</th>
                <th>{{__a('status')}}</th>
                <th>#</th>
            </tr>

            @foreach($afiliasi as $afiliasi)
                @if ($afiliasi)
                    <tr>
                        <td>
                            <label>
                                <input class="check_bulk_item" name="bulk_ids[]" type="checkbox" value="{{$afiliasi->id}}" />
                                <small class="text-muted">#{{$afiliasi->id}}</small>
                            </label>
                        </td>
                        <td>
                            <ul>
                                <li>{{$afiliasi->name}}</li>
                                <li>{{$afiliasi->email}}</li>
                                <li>{{$afiliasi->phone}}</li>
                            </ul>
                        </td>

                        {{-- <td>
                            {!!price_format($afiliasi->amount)!!}
                        </td> --}}

                        {{-- <td>
                            @if ($afiliasi->status == 1)
                                <small>
                                    {!!date('d/m/Y', strtotime($afiliasi->verified_at))!!} <br />
                                    {!!date('H:i', strtotime($afiliasi->verified_at))!!}
                                </small>
                            @else
                                -
                            @endif
                        </td> --}}

{{--                        <td>--}}
{{--                            <small>--}}
{{--                                {!!$afiliasi->created_at->format(get_option('date_format'))!!} <br />--}}
{{--                                {!!$afiliasi->created_at->format(get_option('time_format'))!!}--}}
{{--                            </small>--}}
{{--                        </td>--}}

                        <td>{{ date('m/d/Y', strtotime($afiliasi->expired_package_at)) }}</td>

                        <td>
                            @if ($afiliasi->active_status == 0)
                                Pending
                            @elseif ($afiliasi->active_status == 1)
                                Success
                            @else
                                Declined
                            @endif
                        </td>
                        <td>
                            <a href="{!!route('admin_afiliasi_view', $afiliasi->id)!!}" class="btn btn-md btn-info" data-toggle="tooltip" title="Verifikasi Afiliasi"><i class="la la-eye"></i> </a>
                            <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#addExpired{{$afiliasi->id}}"><i class="la la-donate"></i></button>
                            <div class="modal fade" id="addExpired{{$afiliasi->id}}" tabindex="-1" role="dialog" aria-labelledby="addExpired" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="POST" action="{{ route('admin_afiliasi_add_expired', $afiliasi->id) }}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addExpired">Tambah Masa Aktif User {{$afiliasi->name}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Nama User:</label>
                                                    <input type="text" class="form-control" value="{{$afiliasi->name}}" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label for="recipient-name" class="col-form-label">Add Expired Afiliasi (mounthly):</label>
                                                    <input type="number" class="form-control" required name="expired" autocomplete="off">
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

                            <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#blasting{{$afiliasi->id}}"><i class="la la-comments"></i></button>
                            <div class="modal fade" id="blasting{{$afiliasi->id}}" tabindex="-1" role="dialog" aria-labelledby="blasting" aria-hidden="true">
                                <div class="modal-dialog modal-md" role="document">
                                    <form method="POST" action="{{ route('admin_afiliasi_blasting') }}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="blasting">Blasting Message</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            @csrf
                                            <div class="modal-body row">
                                                <div class="modal-body">

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="additional_css" class="control-label">Penerima</label>
                                                            <input type="text" class="form-control" name="text_phone" value="{{ $afiliasi->phone }}" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        @php
                                                            $course = \App\BlastingSettings::get();
                                                        @endphp
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Pengirim:</label>
                                                            <select class="form-control" name="text_instance">
                                                                <option value="">-- Pilih Instance Id --</option>
                                                                @foreach ($course as $item)
                                                                    <option value="{{ $item->instance_id }}">{{ "Nomor Pengirim : ".$item->nomor . " || " . "Instance Id: ".$item->instance_id }}</option>
                                                                @endforeach
                                                            </select>
                                                            <br>
                                                            <p class="help-block">Pilihlah Salah Satu Nomor Pengirim Di Atas</a></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="additional_css" class="control-label">Text Message</label>
                                                            <textarea name="text_blast" class="form-control" rows="10"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success"><i class="la la-send"></i> Send</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <a href="{!!route('admin_afiliasi_delete', $afiliasi->id)!!}" class="btn btn-md btn-danger delete_confirm"><i class="la la-trash"></i> </a>
                        </td>

                    </tr>
                @endif
            @endforeach

        </table>

        {{-- {!! $afiliasi->appends(['q' => request('q'), 'status'=> request('status'), 'start_date'=> request('start_date'), 'end_date'=> request('end_date')])->links() !!} --}}

    @else
        {!! no_data() !!}
    @endif


@endsection