@extends('layouts.admin')

@section('page-header-right')
    <a href="{{route('create_ebook')}}" class="btn btn-success" data-toggle="tooltip" title="Add New Book"> <i class="la la-plus-circle"></i> Add New Book </a>
@endsection

@section('content')

    <form action="" method="get">

        {{-- <div class="row mb-4">

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

        </div> --}}


        <div class="row">
            <div class="col-sm-12">

                @if($ebooks->count())

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th><input class="bulk_check_all" type="checkbox" /></th>
                        <th>@lang('admin.title')</th>
                        <th>Price</th>
                        <th>{{__a('published_time')}}</th>
                        <th>Author</th>
                        <th>@lang('admin.actions')</th>
                    </tr>
                    </thead>

                    @foreach($ebooks as $ebook)
                        <tr>
                            <td>
                                <label>
                                    <input class="check_bulk_item" name="bulk_ids[]" type="checkbox" value="{{$ebook->id}}" />
                                    <small class="text-muted">#{{$ebook->id}}</small>
                                </label>
                            </td>
                            <td>{{$ebook->title}}</td>
                            <td>
                                @if ($ebook->free == 1)
                                    Free Book
                                @else
                                    {{number_format($ebook->price,2,',','.')}}
                                @endif
                            </td>
                            <td>{{$ebook->published_time}}</td>
                            <td>{{$ebook->author}}</td>
                            <td>
                                <a href="{{route('ebook', $ebook->slug)}}" class="btn btn-purple"><i class="la la-eye"></i> </a>
                                <a href="{{route('edit_ebook',$ebook->id)}}" class="btn btn-primary">
                                    <i class="la la-edit"></i>
                                </a>
                                <a href="{{route('delete_ebook', $ebook->id)}}" onclick="alert('Are you sure to delete this ebook?')" class="btn btn-danger"><i class="la la-trash"></i> </a>
                            </td>
                        </tr>
                    @endforeach

                </table>

                @else
                    {!! no_data() !!}
                @endif

                {!! $ebooks->links() !!}

            </div>
        </div>

    </form>

@endsection
