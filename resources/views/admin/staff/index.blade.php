@extends('layouts.admin')

@section('page-header-right')
    @if(count(request()->input()))
        <a href="{{route('admin_staff')}}"> <i class="la la-arrow-circle-left"></i> {{__a('reset_filter')}}  </a>
    @endif
@endsection

@section('content')

        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-success text-right" data-toggle="modal" data-target="#addStaff"><i class="la la-plus"></i> Add Staff</button>
                <div class="modal fade" id="addStaff" tabindex="-1" role="dialog" aria-labelledby="addStaff" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form method="POST" action="{{ route('admin_staff_add') }}">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addStaff">Add Staff</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Nama Staff:</label>
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Email Staff:</label>
                                        <input type="email" class="form-control" name="email" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Password Staff:</label>
                                        <input type="password" class="form-control" name="password" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Role:</label>
                                        <br>
                                        <label class="mr-2">
                                            <input type="radio" name="user_type" value="admin"> Admin
                                        </label>
                                        <label class="mr-2">
                                            <input type="radio" name="user_type" value="instructor"> Instructor
                                        </label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-purple"><i class="la la-save"></i>Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    @if($staff->count() > 0)



        <p class="text-muted my-3"> <small>Showing {{$staff->count()}} from {{$staff->total()}} results</small> </p>

        <table class="table table-striped table-bordered">

            <tr>
                <th style="width:20%;">User Detail</th>
                {{-- <th>{{__a('amount')}}</th> --}}
                {{-- <th>Verifikasi</th> --}}
                <th>{{__a('time')}}</th>
                <th>{{__a('status')}}</th>
                <th>#</th>
            </tr>

            @foreach($staff as $item)
                @if ($item)
                    <tr>
                        <td>
                            <ul>
                                <li>{{$item->name}}</li>
                                <li>{{$item->email}}</li>
                                <li>{{$item->phone}}</li>
                            </ul>
                        </td>

                        {{-- <td>
                            {!!price_format($item->amount)!!}
                        </td> --}}

                        {{-- <td>
                            @if ($item->status == 1)
                                <small>
                                    {!!date('d/m/Y', strtotime($item->verified_at))!!} <br />
                                    {!!date('H:i', strtotime($item->verified_at))!!}
                                </small>
                            @else
                                -
                            @endif
                        </td> --}}

                        <td>
                            <small>
                                {{ date('d M Y', strtotime($item->created_at)) }}
                            </small>
                        </td>

                        <td>
                            @if ($item->active_status == 0)
                                Pending
                            @elseif ($item->active_status == 1)
                                Success
                            @else
                                Declined
                            @endif
                        </td>
                        <td><a href="{!!route('admin_staff_delete', $item->id)!!}" class="btn btn-md btn-danger delete_confirm"><i class="la la-trash"></i> </a>
                        </td>

                    </tr>
                @endif
            @endforeach

        </table>

        {{-- {!! $staff->appends(['q' => request('q'), 'status'=> request('status'), 'start_date'=> request('start_date'), 'end_date'=> request('end_date')])->links() !!} --}}

    @else
        {!! no_data() !!}
    @endif


@endsection