<table class="table table-bordered bg-white">

    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>No HP/WA</th>
        <th>Email</th>
        <th>Provinsi</th>
        <th>Range Usia</th>
        <th>Profesi</th> 
        <th>Detail</th>
        <th>Pegawai</th>
        <th>Jumlah</th>
        <th>Status</th>
        <th>Tgl Daftar User</th>
        <th>Tgl Expired</th>
        @for($i = 0; $i < $data['ads_payment']; $i++)
            <th>Ads #{{ $i+1 }}</th>
            <th>Jumlah #{{ $i+1 }}</th>
            <th>Status #{{ $i+1 }}</th>
            <th>Delete #{{$i+1}}</th>
            <th>Tanggal Daftar #{{ $i+1 }}</th>
            <th>Expired #{{ $i+1 }}</th>
        @endfor
    </tr>
    @php
        $n = 0;
    @endphp
    @foreach($data['students'] as $key => $student)
        <tr>
            <td>{{ $n++ }}</td>
            <td>{{ $student['name'] }}</td>
            <td>{{ $student['phone'] }}</td>
            <td>{{ $student['email'] }}</td>
            <td>{{ $student['city'] }}</td>
            <td>{{ $student['age'] }}</td>
            <td>{{ $student['job_title'] }}</td>
            <td>{{ $student['about_me'] }}</td>
            <td>{{ $student['total_employee'] }}</td>
            <td>{{ $student['total_payment'] }}</td>
            @if (($student['expired_package_at']) <= date('Y-m-d'))
                <td>Expired</td>
            @else
                <td>Active</td>
            @endif
            <td>{{ date('m/d/Y', strtotime($student['created_at'])) }}</td>
            <td>{{ date('m/d/Y', strtotime($student['expired_package_at'])) }}</td>

            @for($i = 0; $i < $data['ads_payment']; $i++)
                @if (!isset($student['payment_ads'][$i]))
                    @continue
                @endif
                
                @if (empty($student['payment_ads'][$i]->product))
                    <td>Koreksi Expired</td>
                    <td>{{ $student['payment_ads'][$i]->amount }}</td>
                    @if ($student['payment_ads'][$i]->status == 1)
                        <td>Approved</td>
                    @else
                        <td>Pending</td>
                    @endif
                    @if ($student['payment_ads'][$i]->is_delete == 0)
                        <td>Not Deleted</td>
                    @else 
                        <td>Deleted</td>
                    @endif
                    <td>-</td>
                    <td>-</td>
                @else
                    @if ($student['payment_ads'][$i]->product == 'Umum')
                    <td>Kampus Bisnis Syariah</td>
                    @else
                    <td>{{ $student['payment_ads'][$i]->product }}</td>
                    @endif
                    <td>{{ $student['payment_ads'][$i]->amount }}</td>
                    @if ($student['payment_ads'][$i]->status == 1)
                        <td>Approved</td>
                    @else
                        <td>Pending</td>
                    @endif
                    @if ($student['payment_ads'][$i]->is_delete == 0)
                        <td>Not Deleted</td>
                    @else 
                        <td>Deleted</td>
                    @endif
                    <td>{{ date('m/d/Y', strtotime($student['payment_ads'][$i]->started_at)) }}</td>
                    <td>{{ date('m/d/Y', strtotime($student['payment_ads'][$i]->expired_at)) }}</td>
                @endif
            @endfor
        </tr>
    @endforeach
</table>