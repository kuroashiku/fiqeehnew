@extends('layouts.admin')

@section('content')

    @include('admin.reports.menu')

    <div class="profile-settings-wrap">

        <h4 class="mb-3">Laporan Article</h4>

        <form action="" method="get">

            <div class="courses-actions-wrap">

                <div class="row">
                    <div class="col-md-12">
                        <div class="search-filter-form-wrap mb-3">

                            <div class="input-group"> 
                                <input type="text" class="form-control mr-3" name="q" value="{{request('q')}}" placeholder="article name">
                                <button type="submit" class="btn btn-primary btn-purple mr-3"><i class="la la-search-plus"></i> Filter results</button>
                                <a href="{{route('export_article')}}" class="btn btn-success mr-3"><i class="la la-download"></i> Export Article</a>
                            </div>

                        </div>


                    </div>
                </div>

            </div>
        </form>

        @if($classes->count())
            <table class="table table-bordered bg-white table-striped">

                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Slug</th>
                </tr>

                @foreach($classes as $class)
                    <tr>
                        <td>
                            <p>{{$class->title}}</p>
                        </td>
                        
                        <td>{{$class->status}}</td>
                        <td>
                            {{$class->slug}}
                        </td>
                        
                        
                    </tr>

                @endforeach

            </table>
        @else
            {!! no_data(null, null, 'my-5' ) !!}
        @endif
        
        {!! $classes->links() !!}


    </div>


@endsection
