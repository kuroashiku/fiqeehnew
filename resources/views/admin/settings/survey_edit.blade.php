@extends('layouts.admin')

@section('content')

    <form action="{{route('survey_update', $survey->id)}}" method="POST" enctype="multipart/form-data"> @csrf

        <div class="row">

            <div class="col-md-12">
                <div class="form-group row {{ $errors->has('question')? 'has-error':'' }} ">
                    <label class="col-sm-3 control-label" for="question">Question</label>
                    <div class="col-sm-7">
                        <input type="text" name="question" value="{{$survey->question}}" placeholder="Question Test" id="question" class="form-control">
                        {!! $errors->has('question')? '<p class="help-block">'.$errors->first('question').'</p>':'' !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('type')? 'has-error':'' }} ">
                    <label class="col-sm-3 control-label" for="type">Type</label>
                    <div class="col-sm-7">
                        <select name="type" id="type" class="form-control select2">
                            <option value="text" {{selected($survey->type, 'text')}}> Text </option>
                            <option value="number" {{selected($survey->type, 'number')}}> Number </option>
                            <option value="select" {{selected($survey->type, 'select')}}> Select </option>
                        </select>

                        {!! $errors->has('type')? '<p class="help-block">'.$errors->first('type').'</p>':'' !!}
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('answer')? 'has-error':'' }}">
                    <label class="col-sm-3 control-label" for="type">Answer</label>
                    <div class="col-sm-7">
                        <textarea name="answer" id="answer" class="form-control" rows="6">{{ old('answer')?old('answer'): $survey->answer }}</textarea>
                        {!! $errors->has('answer')? '<p class="help-block">'.$errors->first('answer').'</p>':'' !!}
                        <span style="color: #dc3545;">Isi answer apabila typenya Radio dan Select. Gunakan tanda koma (,) untuk memisahkannya.</span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="description">Published</label>
                    <div class="col-sm-7">
                        <label><input type="radio" name="publish" value="1" @if ($survey->publish == 1) checked="checked" @endif> {{__a('publish')}}</label> <br />
                        <label><input type="radio" name="publish" value="0" @if ($survey->publish == 0) checked="checked" @endif> {{__a('unpublish')}}</label>
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
