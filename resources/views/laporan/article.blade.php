
<table class="table table-bordered bg-white table-striped">

    <tr>
        <th>Tanggal register</th>
        <th>Judul Artikel</th>
        <th>Link Artikel</th>
        <th>Deskripsi</th>
        <th>Meta Deskripsi</th>
        <th>Author</th>
    </tr>

    @foreach ($data['article'] as $class)
                <tr>
                    <td>
                        <p>{{date('d F Y', strtotime($class->created_at))}}</p>
                    </td>
                    <td>
                        <p>{{$class->title}}</p>
                    </td>
                    <td>
                        <p>https://fiqeeh.com/{{$class->slug}}</p>
                    </td>
                    <td>
                        <p>{{$class->post_content}}</p>
                    </td>
                    <td>
                        <p>{{$class->meta_description}}</p>
                    </td>
                    <td>
                        <p>{{$class->author}}</p>
                    </td>
                </tr>
    @endforeach
</table>