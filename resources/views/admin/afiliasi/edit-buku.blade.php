@extends('layouts.admin')

@section('page-header-right')
    <a href="{{route('admin_afiliasi_create_buku')}}" class="btn btn-success" data-toggle="tooltip" title="Add New Book"> <i class="la la-plus-circle"></i> Add New Book </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">

            <form action="{{route('admin_afiliasi_edit_buku', $ebook->id)}}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group row {{ $errors->has('title')? 'has-error':'' }}">
                    <label for="additional_css" class="col-sm-4 control-label">Title</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="title" value="{{ old('title')?old('title'): $ebook->title }}" name="title" placeholder="{{__a('title')}}">
                        {!! $errors->has('title')? '<p class="help-block">'.$errors->first('title').'</p>':'' !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('description')? 'has-error':'' }}">
                    <label for="additional_css" class="col-sm-4 control-label">Description</label>
                    <div class="col-sm-8">
                        <textarea name="description" id="description" class="form-control" rows="6">{{ old('description')?old('description'): $ebook->description }}</textarea>
                        {!! $errors->has('description')? '<p class="help-block">'.$errors->first('description').'</p>':'' !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="additional_css" class="col-sm-4 control-label">Sample Book</label>
                    <div class="col-sm-8">
                        {!! image_upload_form('image', $ebook->image) !!}
                    </div>
                </div>
                
                <div class="form-group row {{ $errors->has('price')? 'has-error':'' }}">
                    <label for="additional_css" class="col-sm-4 control-label">Price</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="price" value="{{ old('price')?old('price'): $ebook->price }}" name="price" placeholder="{{__a('price')}}">
                        {!! $errors->has('price')? '<p class="help-block">'.$errors->first('price').'</p>':'' !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('afiliasi_komisi')? 'has-error':'' }}">
                    <label for="additional_css" class="col-sm-4 control-label">Afiliasi Komisi</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="afiliasi_komisi" value="{{ old('afiliasi_komisi')?old('afiliasi_komisi'): $ebook->afiliasi_komisi }}" name="afiliasi_komisi" placeholder="Komisi untuk Afiliasi">
                        {!! $errors->has('afiliasi_komisi')? '<p class="help-block">'.$errors->first('afiliasi_komisi').'</p>':'' !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary">Update Afiliasi Buku</button>
                    </div>
                </div>
            </form>

        </div>

    </div>

@endsection

@section('page-js')
{{--    <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>--}}
{{--    <script>--}}
{{--        // Replace the <textarea id="editor1"> with a CKEditor--}}
{{--        // instance, using default configuration.--}}
{{--        CKEDITOR.replace( 'description' );--}}
{{--    </script>--}}
@endsection
