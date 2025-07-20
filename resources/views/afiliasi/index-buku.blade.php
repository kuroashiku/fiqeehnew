@extends('layouts.afiliasi')

@section('page-header-right')
    <a href="{{route('book-list-afiliasi')}}" class="btn btn-info mr-1" data-toggle="tooltip" title="List Book"> <i class="la la-list"></i> List Book </a>
    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addPaymentBook"><i class="la la-plus-circle"></i> Add Payment Book</button>
    <div class="modal fade" id="addPaymentBook" tabindex="-1" role="dialog" aria-labelledby="blasting" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <form method="POST" action="{{ route('book-afiliasi') }}" enctype="multipart/form-data">
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
                                    <label for="additional_css" class="control-label">Nama</label>
                                    <input type="text" class="form-control" name="nama" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="additional_css" class="control-label">Buku</label>
                                    <select class="form-control" name="ebook_id" required>
                                        <option value="">Pilih Buku</option>
                                        @foreach($books as $book)
                                            <option value="{{$book->id}}">{{$book->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="additional_css" class="control-label">Email</label>
                                    <input type="text" class="form-control" name="email" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="additional_css" class="control-label">Ho HP/WA</label>
                                    <input type="text" class="form-control" name="no_hp" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="additional_css" class="control-label">Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="additional_css" class="control-label">Bukti Pembayaran</label>
                                    <input type="file" class="form-control" name="payment_photo" accept="image/*" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"><i class="la la-plus"></i> Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('content')

    <form action="" method="get">

        <div class="row">
            <div class="col-sm-12">

                @if($afiliasi_books->count())

                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Buku</th>
                            <th>Komisi</th>
                            <th>Payment</th>
                            <th>Status</th>
                        </tr>
                        </thead>

                        @foreach($afiliasi_books as $ebook)
                            <tr>
                                <td>{{$ebook->nama}}</td>
                                <td>{{$ebook->ebook->title}}</td>
                                <td>{{number_format($ebook->afiliasi_komisi,2,',','.')}}</td>
                                <td>
                                    <img src="{{env('APP_URL').$ebook->payment_photo}}" width="80" />
                                </td>
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
                            </tr>
                        @endforeach

                    </table>

                @else
                    {!! no_data() !!}
                @endif

                {!! $afiliasi_books->links() !!}

            </div>
        </div>

    </form>

@endsection
