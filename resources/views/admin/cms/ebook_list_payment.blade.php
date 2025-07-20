@extends('layouts.admin')

@section('content')

        <div class="row">
            <div class="col-sm-12">

                @if($afiliasi_books->count())

                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Buku</th>
                            <th>Harga</th>
                            <th>Payment</th>
                            <th>No Resi</th>
                            <th>Afiliasi Komisi</th>
                            <th>Afiliasi User</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        @foreach($afiliasi_books as $ebook)
                            <tr>
                                <td>{{$ebook->nama}}</td>
                                <td>{{ ($ebook->ebook) ? $ebook->ebook->title : ''}}</td>
                                <td>{{ ($ebook->ebook) ? $ebook->ebook->price : ''}}</td>
                                <td>
                                    <img src="{{env('APP_URL').$ebook->payment_detail}}" width="80" />
                                </td>
                                <td>{{$ebook->no_resi}}</td>
                                <td>{{number_format($ebook->afiliasi_komisi,2,',','.')}}</td>
                                <td>{{ ($ebook->afiliasi) ? $ebook->afiliasi->name : '' }}</td>
                                <td>
                                    @if($ebook->status == 1)
                                        Requested
                                    @elseif($ebook->status == 2 && empty($ebook->no_resi))
                                        Processed
                                    @elseif($ebook->status == 2 && !empty($ebook->no_resi))
                                        Delivery
                                    @elseif($ebook->status == 3)
                                        Delivered
                                    @endif
                                </td>
                                <td>
                                    @if ($ebook->price != 0)
                                        <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#updateBook{{$ebook->id}}"><i class="la la-truck"></i></button>
                                        <div class="modal fade" id="updateBook{{$ebook->id}}" tabindex="-1" role="dialog" aria-labelledby="updateBook" aria-hidden="true">
                                            <div class="modal-dialog modal-md" role="document">
                                                <form method="POST" action="{{ route('admin_buku_status',$ebook->id) }}">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="blasting">Blasting Message</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        @csrf
                                                        <div class="modal-body row">
                                                            <div class="modal-body">

                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="additional_css" class="control-label">Status</label>
                                                                        <select class="form-control" name="status">
                                                                            <option value="1">Requested</option>
                                                                            <option value="2">Processed</option>
                                                                            <option value="3">Delivered</option>
                                                                            <option value="4">Received</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="additional_css" class="control-label">No Resi</label>
                                                                        <input type="text" class="form-control" name="no_resi" value="{{ $ebook->no_resi }}" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-success"><i class="la la-send"></i> Send</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                </td>

                            </tr>
                        @endforeach

                    </table>

                @else
                    {!! no_data() !!}
                @endif

                {!! $afiliasi_books->links() !!}

            </div>
        </div>

@endsection
