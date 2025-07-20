<table class="table table-bordered bg-white">
    <tr>
        <th>Title</th>
        <th>Kategori</th>
        <th>Diambil</th>
    </tr>
    @foreach($data['courses'] as $course)
        <tr>
            <td>
                <p>{{$course['title']}}</p>
            </td>
            <td>
                <p>{{$course['category_name']}}</p>
            </td>
            <td>
                <p>{{date('d F Y', strtotime($course['enrolled_at']))}}</p>
            </td>
        </tr>
    @endforeach
</table>