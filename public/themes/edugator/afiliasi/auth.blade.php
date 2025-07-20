<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card auth-card">
                <nav class="nav nav-pills nav-justified">
                    <a class="nav-item nav-link active" id="nav-login-tab" data-toggle="tab" href="#nav-login" role="tab" aria-controls="nav-login" aria-selected="true">LOGIN</a>
                    <a class="nav-item nav-link" id="nav-register-tab" data-toggle="tab" href="#nav-register" role="tab" aria-controls="nav-register" aria-selected="false">REGISTER</a>
                </nav>
                <div class="tab-content mt-4 mb-4" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-login" role="tabpanel" aria-labelledby="nav-login-tab">
                        <p class="mb-4 text-center"style="color: #0F96C7;font-size: 24px;">Isi Form dibawah ini</p>

                        <div class="row">
                            <div class="col-md-12">

                                @include('inc.flash_msg')

                                <form method="POST" action="{{ route('afiliasi-login') }}">
                                    @csrf

                                    <div class="form-group row justify-content-center">
                                        {{-- <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> --}}

                                        <div class="col-md-10">
                                            <input placeholder="Email" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        {{-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> --}}

                                        <div class="col-md-10">
                                            <input placeholder="Password" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- <div class="form-group row">
                                        <div class="col-md-10 offset-md-4">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="form-group row mb-0 justify-content-center">
                                        <div class="col-md-10">
                                            <button type="submit" class="btn btn-primary btn-block btn-lg">
                                                {{ __('Login') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-2 mb-3 justify-content-center">
                                        <div class="col-md-6 text-white">
                                        </div>
                                        <div class="col-md-4 text-right">
                                            <a href="{{ route('forgot_password') }}">
                                                Lupa Password
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-register" role="tabpanel" aria-labelledby="nav-register-tab">
                        <p class="mb-4 text-center"style="color: #0F96C7;font-size: 24px;">Isi Form dibawah ini</p>

                        <div class="row">

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{session('error')}}
                                </div>
                            @endif
                            
                            <div class="col-md-12">
                                <form role="form" method="POST" action="{{ route('afiliasi-register') }}">
                                    @csrf

                                    <div class="form-group row justify-content-center {{ $errors->has('name') ? ' has-error' : '' }}">
                                        {{-- <label for="name" class="col-md-4 control-label">{{__t('name')}}</label> --}}

                                        <div class="col-md-10">
                                            <input id="name" placeholder="Name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center {{ $errors->has('phone') ? ' has-error' : '' }}">
                                        {{-- <label for="phone" class="col-md-4 control-label">{{__t('phone_address')}}</label> --}}

                                        <div class="col-md-10">
                                            <input id="phone" placeholder="No WhatsApp" type="phone" class="form-control" name="phone" value="{{ old('phone') }}" required>

                                            @if ($errors->has('phone'))
                                                <span class="help-block">
                                                        <strong>{{ $errors->first('phone') }}</strong>
                                                    </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center {{ $errors->has('email') ? ' has-error' : '' }}">
                                        {{-- <label for="email" class="col-md-4 control-label">{{__t('email_address')}}</label> --}}

                                        <div class="col-md-10">
                                            <input id="email" placeholder="Email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center {{ $errors->has('password') ? ' has-error' : '' }}">
                                        {{-- <label for="password" class="col-md-4 control-label">{{__t('password')}}</label> --}}

                                        <div class="col-md-10">
                                            <input id="password" placeholder="Password" type="password" class="form-control" name="password" required>

                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        
                                        <div class="col-md-10">
                                            <input id="password-confirm" placeholder="Password Confirmation" type="password" class="form-control" name="password_confirmation" required>
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center {{ $errors->has('password') ? ' has-error' : '' }}">
                                        {{-- <label for="password" class="col-md-4 control-label">{{__t('password')}}</label> --}}

                                        <div class="col-md-10">
                                            <input disabled id="afiliasi_kode" type="text" class="form-control" value="{{$unique_code}}" name="afiliasi_kode" required>
                                            <input hidden  type="text" class="form-control" value="{{$unique_code}}" name="afiliasi_kode" required>

                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        <div class="col-md-10">
                                            <input hidden name="user_as" value="afiliasi">
                                            <button type="submit" class="btn btn-primary btn-block btn-lg"> Registrasi </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if(config('app.is_demo'))
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="demo-credential-box-wrapper">
                    <h4 class="my-4">Demo Login Credential:</h4>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Admin</strong>
                                </div>
                                <div class="card-body">
                                    <p class="m-0">E-Mail: <code>admin@demo.com</code></p>
                                    <p class="m-0">Password: <code>123456</code></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Instructor</strong>
                                </div>
                                <div class="card-body">
                                    <p class="m-0">E-Mail: <code>instructor@demo.com</code></p>
                                    <p class="m-0">Password: <code>123456</code></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Student</strong>
                                </div>
                                <div class="card-body">
                                    <p class="m-0">E-Mail: <code>student@demo.com</code></p>
                                    <p class="m-0">Password: <code>123456</code></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
