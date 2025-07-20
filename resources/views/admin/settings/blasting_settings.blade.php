@extends('layouts.admin')

@section('page-header-right')
    <a href="{{route('create_nomor')}}" class=" ml-1 btn btn-primary btn-xl" data-toggle="tooltip" title="@lang('Add Nomor')"> <i class="la la-plus"></i> Add Nomor </a>
@endsection

@section('content')



        @if($province->count() > 0)
        <p class="text-muted my-3"> <small>Showing {{$province->count()}}</small> &nbsp; &nbsp; Id 3 Untuk Penerima Notif ( For Receiver Notify Only ) </p>

            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>id</th>
                            <th>Nomor</th>
                            <th>Instance id</th>
                            <th>Aksi</th>
                        </tr>
                                @foreach($province as $u)
                                                <tr>
                                                    <td>#{{ $u->id}}</td>
                                                    <td>{{ $u->nomor }}</td>
                                                    <td>
                                                        {{ $u->instance_id }}
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#link{{$u->id}}"><i class="la la-edit"></i></button>
                                                        <div class="modal fade" id="link{{$u->id}}" tabindex="-1" role="dialog" aria-labelledby="link" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <form method="POST" action="{{ route('edit-blasting', $u->id) }}">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="link">Update Nomor Blasting {{$u->nomor}}</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Nomor:</label>
                                                                                <input type="text" class="form-control" name="nomor" value="{{$u->nomor}}" autocomplete="off">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Instance Id:</label>
                                                                                <input type="text" class="form-control" name="instance_id" value="{{$u->instance_id}}" autocomplete="off">
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
                                            
                                                        
                                                        
                                                        
                                                        
                                                        

                                                        
                                                        
                                                    </td>
                                                </tr>
                                            {{-- @endif --}}
                                        {{-- @endforeach --}}
                                    {{-- @endif --}}
                                @endforeach
                        </table>
                </div>
            </div>

        @else
            {!! no_data() !!}
        @endif
@endsection
