@extends('layouts.theme')

<!-- Main Content -->
@section('content')

<div class="container my-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card auth-card">

                <div class="card-body p-5">

                    <h3 class="mb-4 text-center" style="color: #0E9ED2;">Lupa Password?</h3>

                    <p class="mb-4 text-center" style="color: #0E9ED2;">Masukkan email anda. Kamu akan menerima sebuah link untuk membuat password baru via email</p>
                    @include('inc.flash_msg')

                    <form action="" class="form-horizontal" method="POST">
                        @csrf

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            {{-- <label for="phone" class=" control-label">E-Mail Address</label> --}}

                            <input placeholder="phone" id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>

                            @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-lg">
                                Send Password Reset Link
                            </button>
                        </div>
                    </form>


                    <p class="text-white">Belum punya akun? <a href="{{route('register')}}">Daftar</a></p>

                </div>


            </div>
        </div>
    </div>
</div>

@endsection
