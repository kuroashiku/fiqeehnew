<table class="table table-bordered bg-white">

    <tr>
        <th>Tanggal Jatuh Tempo</th>
        <th>Jumlah Jatuh Tempo</th>
        <th>Jumlah Perpanjang</th>
    </tr>
    @foreach($data as $i)
        <tr>
            <td>
                <p>{{$i['date']}}</p>
            </td>
            <td>
                <p>{{$i['total_jatuh_tempo']}}</p>
            </td>
            <td>
                <p>{{$i['total_perpanjang']}}</p>
            </td>
        </tr>
    @endforeach
</table>