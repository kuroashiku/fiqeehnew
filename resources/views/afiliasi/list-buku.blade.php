@extends('layouts.afiliasi')

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
                            <th>Description</th>
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
                                    {{$ebook->description}}
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
