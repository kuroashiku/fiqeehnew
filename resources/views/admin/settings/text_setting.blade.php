@extends('layouts.admin')

@section('page-header-right')
    <a href="{{route('create_text')}}" class=" ml-1 btn btn-primary btn-xl" data-toggle="tooltip" title="@lang('Add Nomor')"> <i class="la la-plus"></i> Add Text </a>
@endsection

@section('content')



        @if($province->count() > 0)
        <p class="text-muted my-3"> <small>Showing {{$province->count()}}</small> </p>

            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Text</th>
                            <th>Nomor</th>
                            <th>Isntance Id</th>
                            <th>Aksi</th>
                        </tr>
                                @foreach($province as $u)
                                                <tr>
                                                    <td>#{{ $u->id}}</td>
                                                    <td>{{ $u->title }}</td>
                                                    <td>
                                                        {{ $u->text }}
                                                    </td>
                                                    <td>
                                                        {{$u->label}}
                                                    </td>
                                                    <td>
                                                        {{$u->instance_id}}
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#link{{$u->id}}"><i class="la la-edit"></i></button>
                                                        <div class="modal fade" id="link{{$u->id}}" tabindex="-1" role="dialog" aria-labelledby="link" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <form method="POST" action="{{ route('edit-text', $u->id) }}">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="link">Update Text Blasting {{$u->title}}</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Title:</label>
                                                                                <input type="text" class="form-control" name="title" value="{{$u->title}}" autocomplete="off">
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Text:</label>
                                                                                <textarea type="text" class="form-control" name="text_blast" value="{{$u->text}}" autocomplete="off"> {{$u->text}} </textarea>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Nomor:</label>
                                                                                <input type="text" class="form-control" name="label" value="{{$u->label}}" autocomplete="off">
                                                                            </div>
                                                                            
                                                                            @php
                                                                                $course = \App\BlastingSettings::get();
                                                                            @endphp
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="col-form-label">Instance Id</label>
                                                                                <select class="form-control" name="instance_id">
                                                                                    <option value="{{ $u->instance_id }}">{{"Instance Id: ".$u->instance_id }}</option>
                                                                                    @foreach ($course as $item)
                                                                                            <option value="{{ $item->instance_id }}">{{ "Nomor Pengirim : ".$item->nomor . " || " . "Instance Id: ".$item->instance_id }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <br>
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
