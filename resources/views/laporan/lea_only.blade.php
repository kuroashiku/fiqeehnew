<table class="table table-bordered bg-white">

    <tr>
        <th>Tanggal Daftar</th>
        <th>Nama</th>
        <th>Provinsi</th>
        <th>No Hp</th>
        <th>Produk Class</th>
        <th>Produk Ads</th>
    </tr>
    @foreach($data as $student)
        <tr>
            <td>
                <p>{{$student['tanggal_daftar']}}</p>
            </td>
            <td>
                <p>{{$student['nama']}}</p>
            </td>
            <td>
                <p>{{$student['provinsi']}}</p>
            </td>
            <td>
                <p>{{$student['no_telp']}}</p>
            </td>
            <td>
                <p>{{$student['product']}}</p>
            </td>
            <td>
                <p>Belum Ada Product Ads</p>
            </td>
        </tr>
    @endforeach
</table>