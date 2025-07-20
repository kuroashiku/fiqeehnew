
<table class="table table-bordered bg-white table-striped">

    <tr>
        <th>No</th>
        <th>Tanggal register</th>
        <th>Program</th>
        <th>Kelas</th>
        <th>Description</th>
        <th>Link Intro</th>
        <th>Level</th>
        <th>Author</th>
        <th>Free Description</th>
    </tr>
    @php
        $n = 0;
    @endphp
    @foreach ($data['classes'] as $class)
        @foreach($class->sections as $section)
            @foreach($section->items as $item)
                <tr>
                    <td>{{ $n++ }}</td>
                    <td>
                        <p>{{date('d F Y', strtotime($item->created_at))}}</p>
                    </td>
                    <td>
                        <ul>
                            @foreach ($class->category_class as $cc)
                                <li>{{$cc->category->category_name}}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <p>{{ $item->title }}</p>
                    </td>
                    <td>
                        <p>{{$class->description}}</p>
                    </td>
                    @php
                        $src_youtube = $item->video_info('source_youtube');
                    @endphp
                    <td>
                        <p>{{$src_youtube}}</p>
                    </td>
                    <td>
                        <p>{{course_levels($class->level)}}</p>
                    </td>
                    
                    <td>
                        <p>{{$class->author}}</p>
                    </td>

                    <td>{{$class->short_description}}</td>
                </tr>
            @endforeach
        @endforeach
    @endforeach
</table>