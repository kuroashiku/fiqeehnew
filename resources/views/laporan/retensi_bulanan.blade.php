<table class="table table-bordered bg-white">

    <tr>
        <th>Tanggal Login</th>
        <th>Nama</th>
        <th>Provinsi</th>
        <th>No Hp</th>
        <th>Produk Class</th>
    </tr>
    @foreach($data['retensi'] as $student)
        <tr>
            <td>
                <p>{{$student['last_login']}}</p>
            </td>
            <td>
                <p>{{$student['name']}}</p>
            </td>
            <td>
                <p>{{$student['city']}}</p>
            </td>
            <td>
                <p>{{$student['phone']}}</p>
            </td>
            <td>
                <p>{{$student['product']}}</p>
            </td>
        </tr>
    @endforeach
</table>