@extends('layouts.admin')

@section('page-header-right')
    <a href="{{route('admin_afiliasi_buku_list')}}" class="btn btn-info mr-1" data-toggle="tooltip" title="List Book"> <i class="la la-list"></i> List Buyer Book </a>
    <a href="{{route('admin_afiliasi_create_buku')}}" class="btn btn-success" data-toggle="tooltip" title="Add New Book"> <i class="la la-plus-circle"></i> Add New Book </a>
@endsection

@section('content')

    <form action="" method="get">

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
                            <th>Commision</th>
                            <th>Sample Buku</th>
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
                                        Free Ebook
                                    @else
                                        {{number_format($ebook->price,2,',','.')}}
                                    @endif
                                </td>
                                <td>{{$ebook->published_time}}</td>
                                <td>
                                    {{number_format($ebook->afiliasi_komisi,2,',','.')}}
                                </td>
                                <td>
                                    @php
                                        $image = \App\Media::where('id', $ebook->image)->first()->slug_ext;
                                    @endphp
                                    <a href="{{url('uploads/images/'.$image)}}" class="btn btn-success"><i class="la la-download"></i> </a>
                                </td>
                                <td>
{{--                                    <a href="{{route('ebook', $ebook->slug)}}" class="btn btn-purple"><i class="la la-eye"></i> </a>--}}
                                    <a href="{{route('admin_afiliasi_edit_buku',$ebook->id)}}" class="btn btn-primary">
                                        <i class="la la-edit"></i>
                                    </a>
                                    <a href="{{route('admin_afiliasi_delete_buku', $ebook->id)}}" onclick="alert('Are you sure to delete this ebook?')" class="btn btn-danger"><i class="la la-trash"></i> </a>
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
