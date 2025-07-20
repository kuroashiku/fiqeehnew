@extends('layouts.admin')

@section('content')

    <form action="{{route('text_store')}}" method="post" enctype="multipart/form-data"> @csrf

        <div class="row">

            <div class="col-md-12">

                <div class="form-group row ">
                    <label class="col-sm-3 control-label" for="">Title</label>
                    <div class="col-sm-7">
                        <input type="text" name="title" value="" placeholder="Masukkan Title" id="" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="">Text</label>
                    <div class="col-sm-7">
                        {{-- <input type="text" name="text_blast" value="" placeholder="Masukkan Text" id="" class="form-control"> --}}
                        <textarea name="text_blast"></textarea>
                    </div>
                </div>

                <div class="form-group row ">
                    <label class="col-sm-3 control-label" for="">Nomor</label>
                    <div class="col-sm-7">
                        <input type="text" name="label" value="" placeholder="Masukkan Nomor" id="" class="form-control">
                    </div>
                </div>

                <div class="col-md-12">
                    @php
                        $course = \App\BlastingSettings::get();
                    @endphp
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Instance Id</label>
                        <select class="form-control" name="instance_id">
                            <option value="">-- Pilih Instance Id --</option>
                            @foreach ($course as $item)
                                    <option value="{{ $item->instance_id }}">{{ "Nomor Pengirim : ".$item->nomor . " || " . "Instance Id: ".$item->instance_id }}</option>
                            @endforeach
                        </select>
                        <br>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-7 offset-3">
                        <button type="submit" class="btn btn-success btn-xl" data-toggle="tooltip" title="@lang('admin.save')"> <i class="la la-save"></i> {{__a('save')}} </button>
                    </div>
                </div>


            </div>

        </div>

    </form>

@endsection
