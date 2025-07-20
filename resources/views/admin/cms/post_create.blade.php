@extends('layouts.admin')


@section('page-header-right')
    <a href="{{route('posts')}}" class="btn btn-info" data-toggle="tooltip" title="{{__a('all_posts')}}"> <i class="la la-list"></i> {{__a('all_posts')}} </a>
@endsection


@section('content')

    <div class="row">
        <div class="col-sm-12">

            <form action="" method="post" id="createPostForm" enctype="multipart/form-data">
                @csrf

                <div class="form-group row {{ $errors->has('title')? 'has-error':'' }}">
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="title" value="{{ old('title') }}" name="title" placeholder="{{__a('title')}}">
                        {!! $errors->has('title')? '<p class="help-block">'.$errors->first('title').'</p>':'' !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('author')? 'has-error':'' }}">
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="author" value="{{ old('author') }}" name="author" placeholder="Author">
                        {!! $errors->has('author')? '<p class="help-block">'.$errors->first('author').'</p>':'' !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('post_content')? 'has-error':'' }}">
                    <div class="col-sm-12">
                        <textarea name="post_content" id="post_content" class="form-control" rows="6">{{ old('post_content') }}</textarea>
                        {!! $errors->has('post_content')? '<p class="help-block">'.$errors->first('post_content').'</p>':'' !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('meta_description')? 'has-error':'' }}">
                    <div class="col-sm-12">
                        <textarea type="text" class="form-control" id="meta_description" name="meta_description" rows="4" maxlength="160" placeholder="Meta Description Box : Max 160 character">{{ old('meta_description') }}</textarea>
                        {!! $errors->has('meta_description')? '<p class="help-block">'.$errors->first('meta_description').'</p>':'' !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <h4>{{__a('feature_image')}}</h4>
                        {!! image_upload_form('feature_image', null, [1000,563]) !!}
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary">{{__a('create_new_post')}}</button>
                    </div>
                </div>
            </form>

        </div>

    </div>


@endsection

@section('page-js')
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('post_content', {
            filebrowserUploadUrl: "{{route('post_media_upload_editor', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endsection
