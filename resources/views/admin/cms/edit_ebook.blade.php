@extends('layouts.admin')

@section('page-header-right')
    <a href="{{route('create_ebook')}}" class="btn btn-success mr-3" data-toggle="tooltip" title="Create New Ebook"> <i class="la la-plus-circle"></i> Create New Ebook </a>

    <a href="{{route('ebooks')}}" class="btn btn-info" data-toggle="tooltip" title="Ebooks"> <i class="la la-list"></i> Ebooks </a>

@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">

            <form action="{{route('edit_ebook', $ebook->id)}}" method="post" enctype="multipart/form-data">
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

                <div class="form-group row {{ $errors->has('physic')? 'has-error':'' }}">
                    <label for="additional_css" class="col-sm-4 control-label">Type Book</label>
                    <div class="col-sm-8">
                        <select name="physic" class="form-control">
                            <option value="0" {{ $ebook->physic == 0? 'selected':'' }}>Digital (Ebook)</option>
                            <option value="1" {{ $ebook->physic == 1? 'selected':'' }}>Physical (Book)</option>
                        </select>
                        {!! $errors->has('physic')? '<p class="help-block">'.$errors->first('physic').'</p>':'' !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="additional_css" class="col-sm-4 control-label">File Ebook</label>
                    <div class="col-sm-8">
                        <input type="file" accept="application/pdf" class="form-control-file" id="file" value="{{ old('file')?old('file'): null }}" name="file" placeholder="{{__a('file')}}">
                        <p class="help-block mb-0">Maximum file size 32000KB or 32MB.</p>
                        {!! $errors->has('file')? '<p class="help-block">'.$errors->first('file').'</p>':'' !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label for="additional_css" class="col-sm-4 control-label">Thumbnail Image</label>
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

                <div class="form-group row {{ $errors->has('author')? 'has-error':'' }}">
                    <label for="additional_css" class="col-sm-4 control-label">Author</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="author" value="{{ old('author')?old('author'): $ebook->author }}" name="author" placeholder="{{__a('author')}}">
                        {!! $errors->has('author')? '<p class="help-block">'.$errors->first('author').'</p>':'' !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary">Update Ebook</button>
                    </div>
                </div>
            </form>

        </div>

    </div>

@endsection

@section('page-js')
    <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace( 'description' );

        // jquery on load document
        $(document).ready(function(){
            $('select[name="physic"]').on('change', function(){
                console.log($(this).val());
                if($(this).val() == 1){
                    $('#ebookFile').hide();
                    $('#file').prop('required', false);
                }else{
                    $('#ebookFile').show();
                    $('#file').prop('required', true);
                }
            });
        });
        // hide and show file input
    </script>
@endsection
