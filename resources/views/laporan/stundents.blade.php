<table class="table table-bordered bg-white">

    <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>No WA</th>
        <th>Amount</th>
        <th>Afiliasi</th>
        <th>Daftar</th>
        <th>Berakhir</th>
        @foreach ($data['surveys'] as $survey)
            <th>{{$survey['question']}}</th>
        @endforeach
    </tr>
    @foreach($data['students'] as $student)
        <tr>
            <td>
                <p>{{$student['name']}}</p>
            </td>
            <td>
                <p>{{$student['email']}}</p>
            </td>
            <td>
                <p>{{$student['phone']}}</p>
            </td>
            <td>
                <p>{{$student['amount']}}</p>
            </td>
            <td>
                <p>{{$student['afiliasi_id']}}</p>
            </td>
            <td>
                <p>{{date('d F Y', strtotime($student['created_at']))}}</p>
            </td>
            <td>
                <p>{{date('d F Y', strtotime($student['expired_package_at']))}}</p>
            </td>
            @foreach ($student['survey_answer'] as $ss)
                <th>{{$ss['answer']}}</th>
            @endforeach
        </tr>
    @endforeach
</table>