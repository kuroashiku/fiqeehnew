<table class="table table-bordered bg-white">

    <tr>
        <th>Tanggal Payment</th>
        <th>Nama</th>
        <th>No Hp</th>
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
                <p>{{$student['product_perpanjang']}}</p>
            </td>
            <td>
                <p>{{$student['amount_perpanjang']}}</p>
            </td>
        </tr>
    @endforeach
</table>