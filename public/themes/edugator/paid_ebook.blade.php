@extends('layouts.theme')

@section('content')

    <div class="ebook-banner py-3">

        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8" style="padding: 20px 0;">

                    <div class="hero-left-wrap text-center color-white">
                        <h2 class="hero-title mb-6">Beli Ebook Fiqeeh</h2>
                        <br><br>
                        <p class="hero-subtitle  mb-6">
                            Fiqeeh memiliki banyak ebook dan tulisan yang dapat Anda beli untuk melengkapi
                            referensi mengenai keuangan Anda
                        </p>
                        {{-- <a href="{{route('categories')}}" class="btn btn-theme-primary btn-lg">Browse Course</a> --}}
                    </div>

                </div>
                <div class="col-md-2"></div>

                {{-- <div class="col-md-12 col-lg-6 hero-right-col">
                    <div class="hero-right-wrap">
                        <img src="{{theme_url('images/hero-image.png')}}" class="img-fluid" />
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

    @php
        $ebook = \App\Ebook::where('free', 0)->paginate(6);
    @endphp
    
    @if($ebook->total())
        <div class="blog-post-container-wrap py-5" style="margin-top: 80px;">
            <div class="container">
                <div class="row">
                    @foreach ($ebook as $eb)
                        @php
                            $image = \App\Media::where('id', $eb->image)->first()->slug_ext;
                        @endphp
                        <div class="col-md-4 text-center">
                            <div class="post-feature-image-wrap mb-5" style="background-color: #D7F3FB;padding: 20px 0px;margin: 0px 40px;">
                                <img style="width: 220px;height: 310px;" src="{{url('uploads/images/'.$image)}}" alt="{{$eb->slug}}" class="img-fluid">
                                <br><br><a href="{{route('ebook', $eb->slug)}}" class="btn btn-warning" style="width: 50%;border-radius: 50px;">Download</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        {!! no_data(); !!}
    @endif
@endsection
