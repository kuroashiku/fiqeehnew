<table class="table table-bordered bg-white">

    <tr>
        <th>Tanggal Jatuh Tempo</th>
        <th>Nama</th>
        <th>Email</th>
        <th>No WA</th>
        <th>Tanggal Daftar</th>
        <th>Product</th>
        <th>Province</th>
        <th>Age Range</th>
        <th>Profession</th>
        <th>No Of Employee</th>
        <th>Details</th>
        <th>Kategori</th>
        <th>Title</th>
        <th>Tanggal Akses</th>
        <th>Progress</th>
        <th>Tanggal Perpanjang</th>
        <th>Amount Perpanjang</th>
        <th>Product Perpanjang</th>
    </tr>
    @foreach($data as $student)
        @if (count($student['user_enrolls']) > 0)
            @foreach ($student['user_enrolls'] as $k => $item)
                @if(isset($item['course']))
                    <tr>
                        <td>
                            <p>{{$student['date']}}</p>
                        </td>
                        <td>
                            <p>{{$student['nama']}}</p>
                        </td>
                        <td>
                            <p>{{$student['email']}}</p>
                        </td>
                        <td>
                            <p>{{$student['no_telp']}}</p>
                        </td>
                        <td>
                            <p>{{$student['tanggal_daftar']}}</p>
                        </td>
                        <td>
                            <p>{{$student['product']}}</p>
                        </td>
                        <td>
                            <p>{{$student['provinsi']}}</p>
                        </td>
                        <td>
                            <p>{{$student['usia']}}</p>
                        </td>
                        <td>
                            <p>{{$student['profesi']}}</p>
                        </td>
                        <td>
                            <p>{{$student['jumlah_karyawan']}}</p>
                        </td>
                        <td>
                            <p>{{$student['detail_profesi']}}</p>
                        </td>
                        @if (isset($item['course']['category'])))
                        <td>{{ $item['course']['category']['category_name'] }}</td>
                        <td>{{ $item['course']['title'] }}</td>
                        <td>{{ date('d/m/Y H:i:s', strtotime($item['enrolled_at'])) }}</td>
                        <td>{{ $item['percentage_report']."%" }}</td>
                        @else
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        @endif
                        <td>
                            <p>{{$student['tanggal_perpanjang']}}</p>
                        </td>
                        <td>
                            <p>{{$student['amount_perpanjang']}}</p>
                        </td>
                        <td>
                            <p>{{$student['product_perpanjang']}}</p>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>
                            <p>{{$student['date']}}</p>
                        </td>
                        <td>
                            <p>{{$student['nama']}}</p>
                        </td>
                        <td>
                            <p>{{$student['email']}}</p>
                        </td>
                        <td>
                            <p>{{$student['no_telp']}}</p>
                        </td>
                        <td>
                            <p>{{$student['tanggal_daftar']}}</p>
                        </td>
                        <td>
                            <p>{{$student['product']}}</p>
                        </td>
                        <td>
                            <p>{{$student['provinsi']}}</p>
                        </td>
                        <td>
                            <p>{{$student['usia']}}</p>
                        </td>
                        <td>
                            <p>{{$student['profesi']}}</p>
                        </td>
                        <td>
                            <p>{{$student['jumlah_karyawan']}}</p>
                        </td>
                        <td>
                            <p>{{$student['detail_profesi']}}</p>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <p>{{$student['tanggal_perpanjang']}}</p>
                        </td>
                        <td>
                            <p>{{$student['amount_perpanjang']}}</p>
                        </td>
                        <td>
                            <p>{{$student['product_perpanjang']}}</p>
                        </td>
                    </tr>
                @endif
            @endforeach
        @else
        <tr>
            <td>
                <p>{{$student['date']}}</p>
            </td>
            <td>
                <p>{{$student['nama']}}</p>
            </td>
            <td>
                <p>{{$student['email']}}</p>
            </td>
            <td>
                <p>{{$student['no_telp']}}</p>
            </td>
            <td>
                <p>{{$student['tanggal_daftar']}}</p>
            </td>
            <td>
                <p>{{$student['product']}}</p>
            </td>
            <td>
                <p>{{$student['provinsi']}}</p>
            </td>
            <td>
                <p>{{$student['usia']}}</p>
            </td>
            <td>
                <p>{{$student['profesi']}}</p>
            </td>
            <td>
                <p>{{$student['jumlah_karyawan']}}</p>
            </td>
            <td>
                <p>{{$student['detail_profesi']}}</p>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                <p>{{$student['tanggal_perpanjang']}}</p>
            </td>
            <td>
                <p>{{$student['amount_perpanjang']}}</p>
            </td>
            <td>
                <p>{{$student['product_perpanjang']}}</p>
            </td>
        </tr>
        @endif
    @endforeach
</table>