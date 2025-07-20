@extends('layouts.admin')

@section('content')

    <form action="{{route('nomor_store')}}" method="post" enctype="multipart/form-data"> @csrf

        <div class="row">

            <div class="col-md-12">

                <div class="form-group row ">
                    <label class="col-sm-3 control-label" for="">Nomor</label>
                    <div class="col-sm-7">
                        <input type="text" name="nomor_hp" value="" placeholder="Masukkan Nomor Blasting" id="" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="">Instance id</label>
                    <div class="col-sm-7">
                        <input type="text" name="instance_id" value="" placeholder="Masukkan Intance Id" id="" class="form-control">
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
