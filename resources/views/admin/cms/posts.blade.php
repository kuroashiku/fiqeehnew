@extends('layouts.admin')

@section('page-header-right')
    <a href="{{route('create_post')}}" class="btn btn-success" data-toggle="tooltip" title="{{__a('create_new_post')}}"> <i class="la la-plus-circle"></i> {{__a('create_new_post')}} </a>
@endsection

@section('content')

    <form action="" method="get">
 
        <div class="row mb-4">

            <div class="col-md-12">
                <div class="input-group">
                    <select name="status" class="mr-3">
                        <option value="">{{__a('set_status')}}</option>

                        <option value="1">Publish</option>
                        <option value="2">Unpublish</option>
                    </select>

                    <button type="submit" name="bulk_action_btn" value="update_status" class="btn btn-primary mr-2">
                        <i class="la la-refresh"></i> {{__a('update')}}
                    </button>
                    <button type="submit" name="bulk_action_btn" value="delete" class="btn btn-danger delete_confirm"> <i class="la la-trash"></i> {{__a('delete')}}</button>
                </div>
            </div>

        </div>
        <div class="col-md-12">
            <div class="search-filter-form-wrap mb-3">

                <div class="input-group">
                    <input type="text" class="form-control mr-3" name="q" value="{{request('q')}}" placeholder="course name">
                    <select name="filter_status" class="mr-3">
                        <option value="">Filter by status</option>
                        <option value="0" {{selected('0', request('filter_status'))}} >draft</option>
                        <option value="1" {{selected('1', request('filter_status'))}} >publish</option>
                        <option value="2" {{selected('1', request('filter_status'))}} >unpublish</option>

                        {{-- <option value="2" {{selected('2', request('filter_status'))}} >pending</option>
                        <option value="3" {{selected('3', request('filter_status'))}} >block</option>
                        <option value="4" {{selected('4', request('filter_status'))}} >unpublish</option> --}}
                    </select>


                    <button type="submit" class="btn btn-primary btn-purple"><i class="la la-search-plus"></i> Filter results</button>
                </div>

            </div>


        </div>


        <div class="row">
            <div class="col-sm-12">
                @if($posts->count())

                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th><input class="bulk_check_all" type="checkbox" /></th>
                            <th></th>
                            <th>@lang('admin.title')</th>
                            <th>{{__a('published_time')}}</th>
                            {{-- <th>@lang('admin.actions')</th> --}}
                        </tr>
                        </thead>

                        @foreach($posts as $post)
                            <tr>
                                <td>
                                    <label>
                                        <input class="check_bulk_item" name="bulk_ids[]" type="checkbox" value="{{$post->id}}" />
                                        <small class="text-muted">#{{$post->id}}</small>
                                    </label>
                                </td>
                                <td width="80">
                                    <img src="{{media_image_uri($post->feature_image)->thumbnail}}" class="img-fluid" />
                                </td>
                                <td>{{$post->title}} {!! $post->status_context !!}
                                    <div class="courses-action-links mt-1">
                                        <a href="javascript:void(0)" onclick="copyToClip('https:://fiqeeh.com/{{$post->slug}}')" class="font-weight-bold mr-3">
                                            <i class="la la-link"></i> Share Artikel
                                        </a>
                                        <a href="{{route('edit_post',$post->id)}}" class="font-weight-bold mr-3">
                                            <i class="la la-pencil-square-o"></i> {{__t('edit')}}
                                        </a>
                                        <a href="{{route('post', $post->slug)}}" class="font-weight-bold mr-3" target="_blank"><i class="la la-eye">
                                            </i> {{__t('view')}} 
                                        </a>
                                    </div>
                                </td>
                                <td>{{$post->published_time}}</td>

                                {{-- <td>
                                    <a href="{{route('edit_post',$post->id)}}" class="btn btn-primary">
                                        <i class="la la-edit"></i>
                                    </a>
                                    <a href="{{route('post', $post->slug)}}" class="btn btn-purple"><i class="la la-eye"></i> </a>
                                </td> --}}
                            </tr>
                        @endforeach

                    </table>
                @else
                    {!! $posts->appends(['q' => request('q'), 'filter_status'=> request('filter_status') ])->links() !!}
                @endif

                {!! $posts->links() !!}

            </div>
        </div>

    </form>

@endsection
