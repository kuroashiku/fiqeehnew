
<table class="table table-bordered bg-white table-striped">

    <tr>
        <th>Tanggal register</th>
        <th>Kelas</th>
        <th>Durasi</th>
        <th>Judul Video</th>
        <th>Link Youtube</th>
        <th>Description</th>
        <th>Program</th>
        <th>Level</th>
        <th>Author</th>
    </tr>

    @foreach ($data['classes'] as $class)
        @foreach($class->sections as $section)
            @foreach($section->items as $item)
                <tr>
                    <td>
                        <p>{{date('d F Y', strtotime($item->created_at))}}</p>
                    </td>
                    <td>
                        <p>{{$class->title}}</p>
                    </td>
                    <td>
                        @if ($item->item_type == 'lecture' && $item->video_src == null)
                            Dokumen
                        @elseif ($item->item_type == 'lecture' && $item->video_src != null)
                            {{ $item->runtime }}
                        @else 
                            Quiz
                        @endif
                    </td>
                    <td>
                        <p>{{$item->title}}</p>
                    </td>
                    <td>
                        <p>
                            @if ($item->item_type == 'lecture' && $item->video_src != null)
                                @if($item->video_info())
                                @php
                                    $src_youtube = $item->video_info('source_youtube');
                                @endphp
                                
                                {{ $src_youtube }}
                                @endif
                            @else
                            
                            @endif
                        </p>
                    </td>
                    <td>
                        <p>{{$item->text}}</p>
                    </td>
                    
                    <td>
                        <ul>
                            @foreach ($class->category_class as $cc)
                                <li>{{$cc->category->category_name}}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <p>{{course_levels($class->level)}}</p>
                    </td>
                    
                    <td>
                        <p>{{$class->author}}</p>
                    </td>
                </tr>
            @endforeach
        @endforeach
    @endforeach
</table>