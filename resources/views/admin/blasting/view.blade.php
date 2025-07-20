@extends('layouts.admin')

@section('page-header-right')
    <a href="{{route('afiliasi')}}" data-toggle="tooltip" title="{{"Afiliasi"}}"> <i class="la la-arrow-circle-left"></i> Afiliasi </a>
@endsection

@section('content')

    <table class="table table-striped table-bordered table-sm">
        @foreach($afiliasi->toArray() as $col_name => $col_value)
            @if(trim($col_value))
                <tr>
                    <th>{{ucwords(str_replace('_', ' ', $col_name))}}</th>
                    <td>
                        @if ($col_name == 'created_at' || $col_name == 'updated_at')
                            {{date('d F Y H:i', strtotime($col_value))}}
                        @else
                            {{$col_value}}
                        @endif
                    </td>
                </tr>
            @endif
        @endforeach
    </table>

    <form action="{{route('admin_afiliasi_update_status', $afiliasi->id)}}" class="form-inline" method="post">
        @csrf
        <div class="status-update-form-wrap d-flex p-3 bg-light">
            <span class="mr-2">Update Payment Status</span>

            <select name="status" class="form-control mr-2">
                <option value="0" {{selected('0', request('filter_status'))}} >pending</option>
                <option value="1" {{selected('1', request('filter_status'))}} >active</option>
                <option value="2" {{selected('2', request('filter_status'))}} >declined</option>
            </select>

            <button type="submit" class="btn btn-info mb-2">{{__a('update_status')}}</button>
        </div>
    </form>

@endsection

