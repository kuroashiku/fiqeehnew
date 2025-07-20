@extends('layouts.admin')

@section('content')



        @if($province->count() > 0)
        <p class="text-muted my-3"> <small>Showing {{$province->count()}}</small> </p>

            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Province</th>
                            <th>Link Whatsapp</th>
                            <th>Aksi</th>
                        </tr>
                                @foreach($province as $u)
                                                <tr>
                                                    <td>{{ $u->provinsi }}</td>
                                                    <td>
                                                        {{ $u->link }}
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#link{{$u->id}}"><i class="la la-edit"></i></button>
                                                        <div class="modal fade" id="link{{$u->id}}" tabindex="-1" role="dialog" aria-labelledby="link" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <form method="POST" action="{{ route('edit-link', $u->id) }}">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="link">Update Link Whatsapp {{$u->provinsi}}</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Provinsi:</label>
                                                                                <input type="text" class="form-control" name="provinsi" value="{{$u->provinsi}}" autocomplete="off" disabled>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Link Whatsapp:</label>
                                                                                <input type="text" class="form-control" name="link" value="{{$u->link}}" autocomplete="off">
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
