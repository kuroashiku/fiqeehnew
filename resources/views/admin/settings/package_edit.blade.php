@extends('layouts.admin')

@section('page-header-right')
    <a href="{{route('create_package')}}" class="btn btn-success mr-3" data-toggle="tooltip" title="Create New Package"> <i class="la la-plus-circle"></i> Create New Package </a>

    <a href="{{route('packages')}}" class="btn btn-info" data-toggle="tooltip" title="Packages"> <i class="la la-list"></i> Packages </a>

@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">

            <form action="{{route('edit_package', $package->id)}}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group row {{ $errors->has('title')? 'has-error':'' }}">
                    <label for="additional_css" class="col-sm-4 control-label">Title</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="title" value="{{ old('title')?old('title'): $package->title }}" name="title" placeholder="{{__a('title')}}">
                        {!! $errors->has('title')? '<p class="help-block">'.$errors->first('title').'</p>':'' !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('description')? 'has-error':'' }}">
                    <label for="additional_css" class="col-sm-4 control-label">Description</label>
                    <div class="col-sm-8">
                        <textarea name="description" id="description" class="form-control" rows="6">{{ old('description')?old('description'): $package->description }}</textarea>
                        {!! $errors->has('description')? '<p class="help-block">'.$errors->first('description').'</p>':'' !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('price')? 'has-error':'' }}">
                    <label for="additional_css" class="col-sm-4 control-label">Price</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="price" value="{{ old('price')?old('price'): $package->price }}" name="price" placeholder="{{__a('price')}}">
                        {!! $errors->has('price')? '<p class="help-block">'.$errors->first('price').'</p>':'' !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('discount_price')? 'has-error':'' }}">
                    <label for="additional_css" class="col-sm-4 control-label">Discount Price</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="discount_price" value="{{ old('discount_price')?old('discount_price'): $package->discount_price }}" name="discount_price" placeholder="{{__a('discount_price')}}">
                        {!! $errors->has('discount_price')? '<p class="help-block">'.$errors->first('discount_price').'</p>':'' !!}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 control-label" for="description">Status</label>
                    <div class="col-sm-8">
                        <label><input type="radio" name="status" value="1" @if ($package->status == 1) checked="checked" @endif> Aktif</label> <br />
                        <label><input type="radio" name="status" value="0" @if ($package->status == 0) checked="checked" @endif> Tidak Aktif</label>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary">Update Package</button>
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
    </script>
@endsection
