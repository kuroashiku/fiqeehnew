@extends('layouts.admin')

@section('page-header-right')
    <a href="{{route('payments')}}" data-toggle="tooltip" title="{{__a('payments')}}"> <i class="la la-arrow-circle-left"></i> {{__a('back_to_payments')}} </a>
@endsection

@section('content')

    <table class="table table-striped table-bordered table-sm">
        @php
            $verified = 0;
        @endphp
        @foreach($payment->toArray() as $col_name => $col_value)
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
            @if ($col_name == 'status' && $col_value == 1)
                @php
                    $verified = 1;
                @endphp
            @endif
        @endforeach
    </table>

    @if ($verified == 0)
        <form action="{{route('update_statuss', $payment->id)}}" class="form-inline" method="post">
            @csrf
            <div class="status-update-form-wrap d-flex p-3 bg-light">
                <span class="mr-2">Update Payment Status</span>

                <select name="status" class="form-control mr-2">
                    <option value="0" {{selected('0', request('filter_status'))}} >pending</option>
                    <option value="1" {{selected('1', request('filter_status'))}} >success</option>
                    <option value="2" {{selected('2', request('filter_status'))}} >declined</option>
                </select>

                <button type="submit" class="btn btn-info mb-2">{{__a('update_status')}}</button>
            </div>
        </form>
    @endif

@endsection

