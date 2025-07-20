<table class="table table-bordered bg-white">
    @foreach($data['class']->sections as $section)
        <tr>
            <th>Type</th>
            <th>Module {{$section->section_name}}</th>
            <th>Student Complete</th>
        </tr>
        @foreach($section->items as $item)
            <tr>
                <td>
                    @if ($item->item_type == 'lecture' && $item->video_src == null)
                        Module
                    @elseif ($item->item_type == 'lecture' && $item->video_src != null)
                        Video
                    @else 
                        Quiz
                    @endif
                </td>
                <td>
                    <p>{{$item->title}}</p>
                </td>
                <td>
                    @php
                        $countCompleteUser = \App\Complete::where('content_id', $item->id)->count();
                    @endphp
                    <p>{{$countCompleteUser}}</p>
                </td>
            </tr>
        @endforeach
    @endforeach
    <tr></tr>
</table>

<table class="table table-bordered bg-white">

    <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Tanggal Akses</th>
        {{-- <th>Status</th> --}}
    </tr>

    @foreach($data['enrolls'] as $enroll)
        @if (isset($enroll->user))
            <tr>
                <td>
                    <p>{{$enroll->user->name}}</p>
                </td>
                <td>
                    <p>{{$enroll->user->email}}</p>
                </td>
                <td>
                    <p>{{date('d F Y', strtotime($enroll->enrolled_at))}}</p>
                </td>
                {{-- <td>
                    <p>{{$complete}}</p>
                </td> --}}
                
            </tr>
        @endif
    @endforeach

</table>