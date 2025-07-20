@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12">
            @php
                $komisiKelas = \App\Option::where('option_key', 'komisi_kelas')->first();
                $komisiBuku = \App\Option::where('option_key', 'komisi_buku')->first();
            @endphp
            <form action="" method="post" enctype="multipart/form-data"> @csrf
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Komisi</td>
                            <td>Type</td>
                            <td>Komisi</td>
                            <td>Action</td>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Pendaftaran Kelas</td>
                            <td>Kelas</td>
                            <td>{{ $komisiKelas->option_value }}</td>
                            <td>
                                <a href="#" type="button" class="btn btn-warning" data-toggle="modal" data-target="#komisi_kelas">Edit</a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Pembelian Buku</td>
                            <td>Buku</td>
                            <td>{{ $komisiBuku->option_value }}</td>
                            <td>
                                <a href="#" type="button" class="btn btn-warning" data-toggle="modal" data-target="#komisi_buku">Edit</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>

        </div>

    </div>


    <div class="modal fade" id="komisi_kelas" tabindex="-1" role="dialog" aria-labelledby="komisi_kelasTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content bg-white" style="color: black">
                <form action="{{route('komisi_store')}}" method="post" enctype="multipart/form-data"> @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="komisi_kelasTitle">Komisi Kelas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label" for="komisiKelas">Komisi</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="option_value" required value="{{$komisiKelas->option_value}}" placeholder="Komisi" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <input type="text" hidden name="option_key" value="{{$komisiKelas->option_key}}" placeholder="Komisi" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="komisi_buku" tabindex="-1" role="dialog" aria-labelledby="komisi_bukuTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content bg-white" style="color: black">
                <form action="{{route('komisi_store')}}" method="post" enctype="multipart/form-data"> @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="komisi_bukuTitle">Komisi Buku</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label" for="komisiBuku">Komisi</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="option_value" required value="{{$komisiBuku->option_value}}" placeholder="Komisi" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <input type="text" hidden name="option_key" value="{{$komisiBuku->option_key}}" placeholder="Komisi" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection