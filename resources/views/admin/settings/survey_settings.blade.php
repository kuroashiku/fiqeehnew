@extends('layouts.admin')

@section('page-header-right')
    <a href="{{route('survey_create')}}" class=" ml-1 btn btn-primary btn-xl" data-toggle="tooltip" title="@lang('admin.category_add')"> <i class="la la-plus"></i> Add New Question </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">

            <form action="" method="post" enctype="multipart/form-data"> @csrf
                @if($surveys->count())
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <td>#</td>
                            <td>Question</td>
                            <td>Type</td>
                            <td>Answer</td>
                            <td>Publish</td>
                            <td>Action</td>
                        </tr>

                        </thead>

                        <tbody>
                        @foreach($surveys as $k => $survey)
                            <tr>
                                <td>{{$k + 1}}</td>
                                <td>{{$survey->question}}</td>
                                <td>{{$survey->type}}</td>
                                <td>{{$survey->answer}}</td>
                                @if ($survey->publish == 1)
                                    <td><span href="#" class="badge badge-success">Publish</span></td>
                                @else 
                                    <td><span href="#" class="badge badge-warning">Unpublish</span></td>
                                @endif
                                <td>
                                    <a href="{{route('survey_edit',$survey->id)}}" class="btn btn-primary">
                                        <i class="la la-edit"></i>
                                    </a>
                                    <a href="{{route('survey_delete',$survey->id)}}" class="btn btn-danger">
                                        <i class="la la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>


                    </table>

                @else

                    {!! no_data() !!}

                @endif

            </form>

            {!! $surveys->links() !!}

        </div>

    </div>


@endsection


@section('page-js')
    <script type="text/javascript">
        $(document).on('click', '.btn_delete', function(e){
            e.preventDefault();

            var checked_values = [];
            $('.category_check:checked').each(function(index){
                checked_values.push(this.value);
            });

            if (checked_values.length){
                if ( ! confirm('@lang('admin.deleting_confirm')')){
                    return false;
                }

                $.ajax({
                    type: 'POST',
                    url: '{{route('delete_category')}}',
                    data: { categories: checked_values, _token: pageData.csrf_token},
                    success: function(data){
                        if (data.success){
                            window.location.reload(true);
                        }
                    }
                });
            }
        });

        $(document).on('change', '#category_check_all', function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        
        function publish(id){
            $.post('{{ route('survey_publish') }}', {_token:'{{ csrf_token() }}', id:id, publish:1}, function(data){
                window.location.reload(true)
            });
        }
        function unpublish(id){
            $.post('{{ route('survey_publish') }}', {_token:'{{ csrf_token() }}', id:id, publish:0}, function(data){
                window.location.reload(true)
            });
        }
    </script>
@endsection
