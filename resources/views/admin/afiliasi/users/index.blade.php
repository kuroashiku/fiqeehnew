@extends('layouts.afiliasi')

@section('content')
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
                        <th>Details</th>
                        <th>Expired Class</th>
                        <th>Komisi</th>
                        <th>{{__a('status')}}</th>
                        <th>Aksi</th>
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
                                                <td>{{ $u->about_me }}</td>
                                                <td>{{ date('m/d/Y', strtotime($u->expired_package_at)) }}</td>
                                                <td>{{ $u->afiliasi_komisi }}</td>
                                                <td>
                                                    @if ($u->active_status == 0)
                                                        Pending
                                                    @elseif ($u->active_status == 1)
                                                        Success
                                                    @else
                                                        Declined
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $tes = \App\Province::get('*')->whereNotNull('provinsi');
                                                    @endphp
                                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#blasting{{$u->id}}"><i class="la la-comments"></i></button>
                                                    <div class="modal fade" id="blasting{{$u->id}}" tabindex="-1" role="dialog" aria-labelledby="blasting" aria-hidden="true">
                                                        <div class="modal-dialog modal-md" role="document">
                                                            <form method="POST" action="{{ route('blasting-afiliasi') }}">
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
                                                                                    <input type="text" class="form-control" id="text_phone_{{$u->id}}" name="text_phone" value="{{ $u->phone }}" autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="additional_css" class="control-label">Text Message</label>
                                                                                    <textarea name="text_blast" class="form-control" id="text_blast_{{$u->id}}" rows="10"></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                <button type="button" onclick="sendMessage('{{$u->id}}')" class="btn btn-success"><i class="la la-send"></i> Send</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
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
@section('js')
    <script>
        function sendMessage(id) {
            var phone = $('#text_phone_'+id).val();
            var text = $('#text_blast_'+id).val();

            var url = 'https://wa.me/'+phone+'?text='+encodeURIComponent(text);
            window.open(url, '_blank');
        }
    </script>