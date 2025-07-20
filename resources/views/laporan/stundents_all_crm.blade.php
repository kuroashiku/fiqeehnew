<table style="border: 1px solid black;">
    <tr style="border: 1px solid black;">
        <th style="border: 1px solid black;" colspan="14">
            Detail User
        </th>
        <th style="border: 1px solid black;" colspan="4">
            Detail Kelas
        </th>
        <th style="border: 1px solid black;" colspan="5">
            Detail Pembayaran
        </th>
    </tr> 
    <tr style="border: 1px solid black;">
        <th style="border: 1px solid black;">Nama</th>
        <th style="border: 1px solid black;">Email</th>
        <th style="border: 1px solid black;">No WA</th>
        <th style="border: 1px solid black;">Status</th>
        <th style="border: 1px solid black;">Amount</th>
        <th style="border: 1px solid black;">Tanggal Daftar</th>
        <th style="border: 1px solid black;">Waktu Daftar</th>
        <th style="border: 1px solid black;">Tanggal Berakhir</th>
        <th style="border: 1px solid black;">Waktu Berakhir</th>
        <th style="border: 1px solid black;">Province</th>
        <th style="border: 1px solid black;">Age Range</th>
        <th style="border: 1px solid black;">Profession</th>
        <th style="border: 1px solid black;">No Of Employee</th>
        <th style="border: 1px solid black;">Details</th>
        <th style="border: 1px solid black;">Kategori</th>
        <th style="border: 1px solid black;">Title</th>
        <th style="border: 1px solid black;">Tanggal Akses</th>
        <th style="border: 1px solid black;">Progress</th>
        <th style="border: 1px solid black;">Product</th>
        <th style="border: 1px solid black;">Jumlah</th>
        <th style="border: 1px solid black;">Status</th>
        <th style="border: 1px solid black;">Tanggal Daftar</th>
        <th style="border: 1px solid black;">Expired</th>
    </tr>

    @foreach($data['students'] as $student)
        <tr>
            <td style="border: 1px solid black;" rowspan="{{$student['total_row']}}">
                <p>{{$student['name']}}</p>
            </td>
            <td style="border: 1px solid black;" rowspan="{{$student['total_row']}}">
                <p>{{$student['email']}}</p>
            </td>
            <td style="border: 1px solid black;" rowspan="{{$student['total_row']}}">
                @if ($student['phone'] == NULL)
                    <p>Empty Phone</p>
                @else
                    <p>{{ $student['phone'] }}</p>
                @endif
            </td>
            @if (($student['expired_package_at']) <= date('Y-m-d'))
                <td style="border: 1px solid black;" rowspan="{{$student['total_row']}}">Expired</td>
            @else
                <td style="border: 1px solid black;" rowspan="{{$student['total_row']}}">Active</td>
            @endif
            <td style="border: 1px solid black;" rowspan="{{$student['total_row']}}">
                @if (isset($student['payment']['amount']))
                    <p>{{ $student['payment']['amount'] }}</p>
                @else
                    0
                @endif
            </td>
            <td style="border: 1px solid black;" rowspan="{{$student['total_row']}}">
                <p>{{date('m/d/Y', strtotime($student['created_at']))}}</p>
            </td>
            <td style="border: 1px solid black;" rowspan="{{$student['total_row']}}">
                <p>{{date('H:i', strtotime($student['created_at']))}}</p>
            </td>
            <td style="border: 1px solid black;" rowspan="{{$student['total_row']}}">
                <p>{{date('m/d/Y', strtotime($student['expired_package_at']))}}</p>
            </td>
            <td style="border: 1px solid black;" rowspan="{{$student['total_row']}}">
                <p>{{date('H:i', strtotime($student['expired_package_at']))}}</p>
            </td>
            <td style="border: 1px solid black;" rowspan="{{$student['total_row']}}">
                @if ($student['city'] == NULL)
                    <p>Empty Province</p>
                @else
                    <p>{{$student['city']}}</p>
                @endif
            </td>
            <td style="border: 1px solid black;" rowspan="{{$student['total_row']}}">
                @if ($student['age'] == NULL)
                    <p> - </p>
                @else
                    <p>{{$student['age']}}</p>
                @endif
            </td>
            <td style="border: 1px solid black;" rowspan="{{$student['total_row']}}">
                @if ($student['job_title'] == NULL)
                    <p> - </p>
                @else
                    <p>{{$student['job_title']}}</p>
                @endif
            </td>

            <td style="border: 1px solid black;" rowspan="{{$student['total_row']}}">
                @if ($student['total_employee'] == NULL)
                    <p> - </p>
                @else
                    <p>{{$student['total_employee']}}</p>
                @endif
            </td>
            <td style="border: 1px solid black;" rowspan="{{$student['total_row']}}">
                <p>{{$student['about_me']}}</p>
            </td>

            @if (isset($student['user_enrolls'][0]['course']['category'])))
            <td style="border: 1px solid black;">{{ $student['user_enrolls'][0]['course']['category']['category_name'] }}</td>
            <td style="border: 1px solid black;">{{ $student['user_enrolls'][0]['course']['title'] }}</td>
            <td style="border: 1px solid black;">{{ date('d/m/Y H:i:s', strtotime($student['user_enrolls'][0]['enrolled_at'])) }}</td>
            <td style="border: 1px solid black;">{{ $student['user_enrolls'][0]['percentage_report']."%" }}</td>
            @else
                <td style="border: 1px solid black;"></td>
                <td style="border: 1px solid black;"></td>
                <td style="border: 1px solid black;"></td>
                <td style="border: 1px solid black;"></td>
            @endif

            @if(isset($student['payment'][0]))
                
                    @if ($student['payment'][0]['product'] == 'Umum')
                        <td style="border: 1px solid black;">Kampus Bisnis Syariah</td>
                    @else
                        <td style="border: 1px solid black;">{{ $student['payment'][0]['product'] $student['payment'][0]['product_ads'] }}</td>
                    @endif
                    <td style="border: 1px solid black;">{{ $student['payment'][0]['amount'] }}</td>
                    @if ($student['payment'][0]['status'] == 1)
                        <td style="border: 1px solid black;">Approved</td>
                    @else
                        <td style="border: 1px solid black;">Pending</td>
                    @endif
                    <td style="border: 1px solid black;">{{ date('m/d/Y', strtotime($student['payment'][0]['started_at'])) }}</td>
                    <td style="border: 1px solid black;">{{ date('m/d/Y', strtotime($student['payment'][0]['expired_at'])) }}</td>
            @else
                <td style="border: 1px solid black;"></td>
                <td style="border: 1px solid black;"></td>
                <td style="border: 1px solid black;"></td>
                <td style="border: 1px solid black;"></td>
                <td style="border: 1px solid black;"></td>
            @endif
        </tr>
        @if ($student['total_row'] > 0)
            @for($k = 1; $k < $student['total_row']; $k++)
                <tr>
                    @if (isset($student['user_enrolls'][$k]['course']['category'])))
                        <td style="border: 1px solid black;">{{ $student['user_enrolls'][$k]['course']['category']['category_name'] }}</td>
                        <td style="border: 1px solid black;">{{ $student['user_enrolls'][$k]['course']['title'] }}</td>
                        <td style="border: 1px solid black;">{{ date('d/m/Y H:i:s', strtotime($student['user_enrolls'][$k]['enrolled_at'])) }}</td>
                        <td style="border: 1px solid black;">{{ $student['user_enrolls'][$k]['percentage_report']."%" }}</td>
                    @else
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    @endif

                    @if(isset($student['payment'][$k]))
                        
                            @if ($student['payment'][$k]['product'] == 'Umum')
                                <td style="border: 1px solid black;">Kampus Bisnis Syariah</td>
                            @else
                                <td style="border: 1px solid black;">{{ $student['payment'][$k]['product'] $student['payment'][$k]['product'] }}</td>
                            @endif
                            <td style="border: 1px solid black;">{{ $student['payment'][$k]['amount'] }}</td>
                            @if ($student['payment'][$k]['status'] == 1)
                                <td style="border: 1px solid black;">Approved</td>
                            @else
                                <td style="border: 1px solid black;">Pending</td>
                            @endif
                            <td style="border: 1px solid black;">{{ date('m/d/Y', strtotime($student['payment'][$k]['started_at'])) }}</td>
                            <td style="border: 1px solid black;">{{ date('m/d/Y', strtotime($student['payment'][$k]['expired_at'])) }}</td>
                    @else
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    @endif
                </tr>
            @endfor
        @endif
    @endforeach
</table>