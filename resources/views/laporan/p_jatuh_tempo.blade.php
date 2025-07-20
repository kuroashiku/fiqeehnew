<table class="table table-bordered bg-white">

    <tr>
        <th>Nama</th>
        <th>No Hp/WA</th>
        <th>Email</th>
        <th>Provinsi</th>
        <th>Usia</th>
        <th>Profesi</th>
        <th>Detail</th>
        <th>Tanggal Daftar</th>
        <th>Tanggal Jatuh Tempo</th>
        <th>Product</th>
        <th>Kategori</th>
        <th>Tanggal Akses</th>
        <th>Progress</th>
        <th>Tanggal Perpanjangan</th>
    </tr>
    {{-- @foreach($data['retensi'] as $student)
                <tr>
                    <td>
                        <p>{{$student['name']}}</p>
                    </td>
                    <td>
                        <p>{{$student['phone']}}</p>
                    </td>
                    <td>
                        <p>{{$student['email']}}</p>
                    </td>
                    <td>
                        <p>{{$student['city']}}</p>
                    </td>
                    <td>
                        <p>{{$student['age']}}</p>
                    </td>
                    <td>
                        <p>{{$student['job_title']}}</p>
                    </td>
                    <td>
                        <p>{{$student['about_me']}}</p>
                    </td>
                    <td>
                        <p>{{$student['created_at']}}</p>
                    </td>
                    <td>
                        <p>{{$student['expired_package_at']}}</p>
                    </td>
                    <td>
                        <p>{{$student['product']}}</p>
                    </td>
                    <td>
                        <p>{{$student['category_product']}}</p>
                    </td>
                    <td>
                        <p>{{$student['last_login']}}</p>
                    </td>
                    
                    <td>
                        <p>{{ $item['percentage_report']."%" }}</p>
                    </td>
                    
                    <td>
                        <p>{{$student['last_payment']}}</p>
                    </td>
                </tr>
    @endforeach --}}


    @foreach($data['retensi'] as $student)
        @if (count($student['user_enrolls']) > 0)
            @foreach ($student['user_enrolls'] as $k => $item)
                @if(isset($item['course']))
                    <tr>
                    <td>
                        <p>{{$student['name']}}</p>
                    </td>
                    <td>
                        <p>{{$student['phone']}}</p>
                    </td>
                    <td>
                        <p>{{$student['email']}}</p>
                    </td>
                    <td>
                        <p>{{$student['city']}}</p>
                    </td>
                    <td>
                        <p>{{$student['age']}}</p>
                    </td>
                    <td>
                        <p>{{$student['job_title']}}</p>
                    </td>
                    <td>
                        <p>{{$student['about_me']}}</p>
                    </td>
                    <td>
                        <p>{{$student['created_at']}}</p>
                    </td>
                    <td>
                        <p>{{$student['expired_package_at']}}</p>
                    </td>
                    <td>
                        <p>{{$student['product']}}</p>
                    </td>
                    <td>
                        <p>{{$student['category_product']}}</p>
                    </td>
                    <td>
                        <p>{{$student['last_login']}}</p>
                    </td>
                    
                    <td>
                        <p>{{ $item['percentage_report']."%" }}</p>
                    </td>
                    
                    <td>
                        <p>{{$student['last_payment']}}</p>
                    </td>
                </tr>
                @endif
            @endforeach
        @else
            <tr>
                    <td>
                        <p>{{$student['name']}}</p>
                    </td>
                    <td>
                        <p>{{$student['phone']}}</p>
                    </td>
                    <td>
                        <p>{{$student['email']}}</p>
                    </td>
                    <td>
                        <p>{{$student['city']}}</p>
                    </td>
                    <td>
                        <p>{{$student['age']}}</p>
                    </td>
                    <td>
                        <p>{{$student['job_title']}}</p>
                    </td>
                    <td>
                        <p>{{$student['about_me']}}</p>
                    </td>
                    <td>
                        <p>{{$student['created_at']}}</p>
                    </td>
                    <td>
                        <p>{{$student['expired_package_at']}}</p>
                    </td>
                    <td>
                        <p>{{$student['product']}}</p>
                    </td>
                    <td>
                        <p>{{$student['category_product']}}</p>
                    </td>
                    <td>
                        <p>{{$student['last_login']}}</p>
                    </td>
                    
                    <td>
                        <p>tidak ada progress</p>
                    </td>
                    
                    <td>
                        <p>{{$student['last_payment']}}</p>
                    </td>
                        
                    </tr>
        @endif
    @endforeach
</table>