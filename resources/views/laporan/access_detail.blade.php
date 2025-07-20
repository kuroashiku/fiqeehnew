<table class="table table-bordered bg-white">

    <tr>
        <th>Tanggal Akses</th>
        <th>Nama</th>
        <th>No Telp</th>
        <th>Email</th>
        <th>Usia</th>
        <th>Provinsi</th>
        <th>Profesi</th>
        <th>Detail Profesi</th>
        <th>Jumlah Karyawan</th>
        <th>Last Class</th>
    </tr>
    @foreach($data as $i)
        <tr>
            <td>
                <p>{{date('m/d/Y', strtotime($i['access_date']))}}</p>
            </td>
            <td>
                <p>{{$i['user']['name']}}</p>
            </td>
            <td>
                <p>{{$i['user']['phone']}}</p>
            </td>
            <td>
                <p>{{$i['user']['email']}}</p>
            </td>
            <td>
                <p>{{$i['user']['age']}}</p>
            </td>
            <td>
                <p>{{$i['user']['city']}}</p>
            </td>
            <td>
                <p>{{$i['user']['job_title']}}</p>
            </td>
            <td>
                <p>{{$i['user']['about_me']}}</p>
            </td>
            <td>
                <p>{{$i['user']['total_employee']}}</p>
            </td>
            <td>
                <p>{{$i['course']['title']}}</p>
            </td>
        </tr>
    @endforeach
</table>