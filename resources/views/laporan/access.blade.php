<table class="table table-bordered bg-white">

    <tr>
        <th>Tanggal Akses Kelas</th>
        <th>Jumlah Member Aktif</th>
        <th>Jumlah Member Akses Kelas</th>
    </tr>
    @foreach($data as $i)
        <tr>
            <td>
                <p>{{date('d/m/Y', strtotime($i['date']))}}</p>
            </td>
            <td>
                <p>{{$i['active_user']}}</p>
            </td>
            <td>
                <p>{{$i['access_user']}}</p>
            </td>
        </tr>
    @endforeach
</table>