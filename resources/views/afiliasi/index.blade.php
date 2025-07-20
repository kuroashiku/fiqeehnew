@extends('layouts.admin')

@section('page-header-right')
    @if(count(request()->input()))
        <a href="{{route('afiliasi')}}"> <i class="la la-arrow-circle-left"></i> {{__a('reset_filter')}}  </a>
    @endif
@endsection

@section('content')

    <form method="get">

        <div class="row">

            <div class="col-md-3">
                <div class="input-group">
                    <select name="status" class="mr-1">
                        <option value="">{{__a('set_status')}}</option>

                        <option value="0">pending</option>
                        <option value="1">success</option>
                        <option value="2">declined</option>
                    </select>

                    <button type="submit" name="bulk_action_btn" value="update_status" class="btn btn-primary mr-1">{{__a('update')}}</button>
                    {{-- <button type="submit" name="bulk_action_btn" value="delete" class="btn btn-danger delete_confirm"> <i class="la la-trash"></i> {{__a('delete')}}</button> --}}
                </div>
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

    @if($afiliasi->count() > 0)



        <p class="text-muted my-3"> <small>Showing {{$afiliasi->count()}} from {{$afiliasi->total()}} results</small> </p>

        <table class="table table-striped table-bordered">

            <tr>
                <th><input class="bulk_check_all" type="checkbox" /></th>
                <th style="width:20%;">User Detail</th>
                <th>{{__a('amount')}}</th>
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

                        <td>
                            {!!price_format($afiliasi->amount)!!}
                        </td>

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

                        <td>
                            <small>
                                {!!$afiliasi->created_at->format(get_option('date_format'))!!} <br />
                                {!!$afiliasi->created_at->format(get_option('time_format'))!!}
                            </small>
                        </td>

                        <td>
                            @if ($afiliasi->status == 0)
                                Pending
                            @elseif ($afiliasi->status == 1)
                                Success
                            @else
                                Declined
                            @endif
                        </td>
                        <td>
                            <a href="{!!route('afiliasi_view', $afiliasi->id)!!}" class="btn btn-md btn-info" data-toggle="tooltip" title="Verifikasi Pembayaran"><i class="la la-eye"></i> </a>
                            <a href="{!!route('afiliasi_delete', $afiliasi->id)!!}" class="btn btn-md btn-danger delete_confirm"><i class="la la-trash"></i> </a>
                            @if ($afiliasi->status == 0)
                                @foreach ($followUp as $fu)
                                    <button type="button" class="btn btn-md btn-success" data-toggle="modal" data-target="#followUp{{$afiliasi->id}}{{$fu->title}}"><span style="font-size: 11px;">{{$fu->title}}</span></button>
                                    <div class="modal fade" id="followUp{{$afiliasi->id}}{{$fu->title}}" tabindex="-1" role="dialog" aria-labelledby="followUpLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="followUpLabel">Follow Up User {{$afiliasi->name}}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">Nama User:</label>
                                                        <input type="text" class="form-control" value="{{$afiliasi->name}}" disabled>
                                                    </div>
                                                    {{-- <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">Follow Up Terakhir:</label>
                                                        <input type="text" class="form-control" value="{{$afiliasi->followup}}" disabled>
                                                    </div> --}}
                                                    {{-- <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">Action Follow Up:</label>
                                                        <select class="form-control" onchange="changeFormat(this, {{$afiliasi->id}})">
                                                            @foreach ($followUp as $fu)
                                                                <option value="{{$fu->title}}">{{$fu->title}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div> --}}
                                                    <div class="form-group">
                                                        <label for="message-text" class="col-form-label">Message:</label>
                                                        <textarea class="form-control" name="message" rows="6" id="message-text-{{$afiliasi->id}}">{{str_replace(['username', 'usernominal'], [$afiliasi->name, price_format($afiliasi->amount)], $fu['text'])}}</textarea>
                                                    </div>
                                                    <input type="hidden" name="phone" value="{{$afiliasi->phone}}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <a id="link-text-{{$afiliasi->id}}" target="_blank" href="https://api.whatsapp.com/send?phone={{$afiliasi->phone}}&text={{urlencode($fu['text'])}}" class="btn btn-success">Follow Up</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </td>

                    </tr>
                @endif
            @endforeach

        </table>

        {!! $afiliasi->appends(['q' => request('q'), 'status'=> request('status'), 'start_date'=> request('start_date'), 'end_date'=> request('end_date')])->links() !!}

    @else
        {!! no_data() !!}
    @endif


@endsection
<script>
function changeFormat(sel, id)
{
    console.log("message-text-"+id)
    $.post("{{route('followUpFormat')}}", {_token: "{{ csrf_token() }}", id_afiliasi: id, folow_up: sel.value}, function( data ) {
        $("textarea#message-text-" + id).val(data.text);
        link = "https://api.whatsapp.com/send?phone="+data.phone+"&text="+data.message
        $("a#link-text-" + id).attr("href", link)
    });
}
</script>
