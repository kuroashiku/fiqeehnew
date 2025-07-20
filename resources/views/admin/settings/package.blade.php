@extends('layouts.admin')

@section('page-header-right')
    <a href="{{route('create_package')}}" class="btn btn-success" data-toggle="tooltip" title="Add New Package"> <i class="la la-plus-circle"></i> Add New Package </a>
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

                @if($packages->count())

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th><input class="bulk_check_all" type="checkbox" /></th>
                        <th>@lang('admin.title')</th>
                        <th>Price</th>
                        <th>Discount Price</th>
                        <th>Status</th>
                        <th>{{__a('published_time')}}</th>
                        <th>@lang('admin.actions')</th>
                    </tr>
                    </thead>

                    @foreach($packages as $package)
                        <tr>
                            <td>
                                <label>
                                    <input class="check_bulk_item" name="bulk_ids[]" type="checkbox" value="{{$package->id}}" />
                                    <small class="text-muted">#{{$package->id}}</small>
                                </label>
                            </td>
                            <td>{{$package->title}}</td>
                            <td>{{number_format($package->price,2,',','.')}}</td>
                            <td>
                                @if ($package->discount_price == 0)
                                    Tidak Diskon
                                @else
                                    {{number_format($package->discount_price,2,',','.')}}
                                @endif
                            </td>
                            <td>{{$package->published_time}}</td>
                            <td>
                                @if ($package->status == 1)
                                    Acktif
                                @else
                                    Tidak Aktif
                                @endif
                            </td>

                            <td>
                                {{-- <a href="{{route('package', $package->slug)}}" class="btn btn-purple"><i class="la la-eye"></i> </a> --}}
                                <a href="{{route('edit_package',$package->id)}}" class="btn btn-primary">
                                    <i class="la la-edit"></i>
                                </a>
                                <a href="{{route('delete_package', $package->id)}}" onclick="alert('Are you sure to delete this package?')" class="btn btn-danger"><i class="la la-trash"></i> </a>
                            </td>
                        </tr>
                    @endforeach

                </table>

                @else
                    {!! no_data() !!}
                @endif

                {!! $packages->links() !!}

            </div>
        </div>

    </form>

@endsection
