<table class="table table-bordered bg-white">

    <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>No WA</th>
        <th>Status</th>
        <th>Amount</th>
        <th>Tanggal Daftar</th>
        <th>Tanggal Berakhir</th>
        <th>Product</th>
        <th>Province</th>
        <th>Age Range</th>
        <th>Profession</th>
        <th>No Of Employee</th>
        <th>Details</th>
        <th>Kategori</th>
        <th>Title</th>
        <th>Tanggal Akses</th>
        <th>Progress</th>
    </tr>

    @foreach($data['students'] as $student)
        @if (count($student['user_enrolls']) > 0)
            @foreach ($student['user_enrolls'] as $k => $item)
                @if(isset($item['course']))
                    <tr>
                        <td>
                            <p>{{$student['name']}}</p>
                        </td>
                        <td>
                            <p>{{$student['email']}}</p>
                        </td>
                        <td>
                            @if ($student['phone'] == NULL)
                                <p>Empty Phone</p>
                            @else
                                <p>{{ $student['phone'] }}</p>
                            @endif
                        </td>
                        <td>
                            @if (isset($student['payment']->status) && $student['payment']->status == 1)
                                <p>Approved</p>
                            @else
                                <p>Pending</p>
                            @endif
                        </td>
                        <td>
                            @if (isset($student['payment']->amount))
                                <p>{{ $student['payment']->amount }}</p>
                            @else
                                0
                            @endif
                        </td>
                        <td>
                            <p>{{date('m/d/Y', strtotime($student['created_at']))}}</p>
                        </td>
                        <td>
                            <p>{{date('m/d/Y', strtotime($student['expired_package_at']))}}</p>
                        </td>

                        <td>
                            @if ($student['product'] == 'Umum')
                                <p>Kampus Bisnis Syariah</p>
                            @elseif($student['product'] == NULL)
                                <p>Kampus Bisnis Syariah</p>
                            @else
                                <p>{{$student['product']}}</p>
                            @endif
                        </td>
                        <td>
                            @if ($student['city'] == NULL)
                                <p>Empty Province</p>
                            @else
                                <p>{{$student['city']}}</p>
                            @endif
                        </td>
                        <td>
                            @if ($student['age'] == NULL)
                                <p> - </p>
                            @else
                                <p>{{$student['age']}}</p>
                            @endif
                        </td>
                        <td>
                            @if ($student['job_title'] == NULL)
                                <p> - </p>
                            @else
                                <p>{{$student['job_title']}}</p>
                            @endif
                        </td>
                        <td>
                            @if ($student['total_employee'] == NULL)
                                <p> - </p>
                            @else
                                <p>{{$student['total_employee']}}</p>
                            @endif
                        </td>
                        <td>
                            <p>{{$student['about_me']}}</p>
                        </td>
                        @if (isset($item['course']['category'])))
                        <td>{{ $item['course']['category']['category_name'] }}</td>
                        <td>{{ $item['course']['title'] }}</td>
                        <td>{{ date('d/m/Y H:i:s', strtotime($item['enrolled_at'])) }}</td>
                        <td>{{ $item['percentage_report']."%" }}</td>
                        @else
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        @endif
                    </tr>
                @else
                    <tr>
                        <td>
                            <p>{{$student['name']}}</p>
                        </td>
                        <td>
                            <p>{{$student['email']}}</p>
                        </td>
                        <td>
                            @if ($student['phone'] == NULL)
                                <p>Empty Phone</p>
                            @else
                                <p>{{ $student['phone'] }}</p>
                            @endif
                        </td>
                        <td>
                            @if (isset($student['payment']->status) && $student['payment']->status == 1)
                                <p>Approved</p>
                            @else
                                <p>Pending</p>
                            @endif
                        </td>
                        <td>
                            @if (isset($student['payment']->amount))
                                <p>{{ $student['payment']->amount }}</p>
                            @else
                                0
                            @endif
                        </td>
                        <td>
                            <p>{{date('m/d/Y', strtotime($student['created_at']))}}</p>
                        </td>

                        <td>
                            <p>{{date('m/d/Y', strtotime($student['expired_package_at']))}}</p>
                        </td>

                        <td>
                            @if ($student['product'] == 'Umum')
                                <p>Kampus Bisnis Syariah</p>
                            @elseif($student['product'] == NULL)
                                <p>Kampus Bisnis Syariah</p>
                            @else
                                <p>{{$student['product']}}</p>
                            @endif
                        </td>
                        <td>
                            @if ($student['city'] == NULL)
                                <p>Empty Province</p>
                            @else
                                <p>{{$student['city']}}</p>
                            @endif
                        </td>
                        <td>
                            @if ($student['age'] == NULL)
                                <p> - </p>
                            @else
                                <p>{{$student['age']}}</p>
                            @endif
                        </td>
                        <td>
                            @if ($student['job_title'] == NULL)
                                <p> - </p>
                            @else
                                <p>{{$student['job_title']}}</p>
                            @endif
                        </td>

                        <td>
                            @if ($student['total_employee'] == NULL)
                                <p> - </p>
                            @else
                                <p>{{$student['total_employee']}}</p>
                            @endif
                        </td>
                        <td>
                            <p>{{$student['about_me']}}</p>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
        @else
            <tr>
                <td>
                    <p>{{$student['name']}}</p>
                </td>
                <td>
                    <p>{{$student['email']}}</p>
                </td>
                <td>
                    @if ($student['phone'] == NULL)
                        <p>Empty Phone</p>
                    @else
                        <p>{{ $student['phone'] }}</p>
                    @endif
                </td>
                <td>
                    @if (isset($student['payment']->status) && $student['payment']->status == 1)
                        <p>Approved</p>
                    @else
                        <p>Pending</p>
                    @endif
                </td>
                <td>
                    @if (isset($student['payment']->amount))
                        <p>{{ $student['payment']->amount }}</p>
                    @else
                        0
                    @endif
                </td>
                <td>
                    <p>{{date('m/d/Y', strtotime($student['created_at']))}}</p>
                </td>
                <td>
                    <p>{{date('m/d/Y', strtotime($student['expired_package_at']))}}</p>
                </td>
                <td>
                    @if ($student['product'] == 'Umum')
                        <p>Kampus Bisnis Syariah</p>
                    @elseif($student['product'] == NULL)
                        <p>Kampus Bisnis Syariah</p>
                    @else
                        <p>{{$student['product']}}</p>
                    @endif
                </td>
                <td>
                    @if ($student['city'] == NULL)
                        <p>Empty Province</p>
                    @else
                        <p>{{$student['city']}}</p>
                    @endif
                </td>
                <td>
                    @if ($student['age'] == NULL)
                        <p> - </p>
                    @else
                        <p>{{$student['age']}}</p>
                    @endif
                </td>
                <td>
                    @if ($student['job_title'] == NULL)
                        <p> - </p>
                    @else
                        <p>{{$student['job_title']}}</p>
                    @endif
                </td>

                <td>
                    @if ($student['total_employee'] == NULL)
                        <p> - </p>
                    @else
                        <p>{{$student['total_employee']}}</p>
                    @endif
                </td>
                <td>
                    <p>{{$student['about_me']}}</p>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endif
    @endforeach
</table>
