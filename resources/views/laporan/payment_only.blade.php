<table class="table table-bordered bg-white">

    <tr>
        <th>Tanggal Payment</th>
        <th>Nama</th>
        <th>No Hp</th>
        <th>Email</th>
        <th>Provinsi</th>
        <th>Usia</th>
        <th>Profesi</th>
        <th>Detail</th>
        <th>Tanggal Daftar</th>
        <th>Tanggal Jatuh Tempo</th>
        <th>Produk</th>
        <th>Nilai</th>
    </tr>
    @foreach($data as $student)
        <tr>
            <td>
                <p>{{$student['tanggal_perpanjang']}}</p>
            </td>
            <td>
                <p>{{$student['nama']}}</p>
            </td>
            <td>
                <p>{{$student['no_telp']}}</p>
            </td>
            <td>
                <p>{{$student['email']}}</p>
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
                <p>{{$student['detail_profesi']}}</p>
            </td>
            <td>
                <p>{{$student['tanggal_daftar']}}</p>
            </td>
            <td>
                <p>{{$student['tanggal_expired']}}</p>
            </td>
            <td>
                <p>{{$student['product_perpanjang']}}</p>
            </td>
            <td>
                <p>{{$student['amount_perpanjang']}}</p>
            </td>
        </tr>
    @endforeach
</table>