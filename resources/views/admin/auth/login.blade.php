<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Milo | {{ __('login') }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-2"></div>
            <div class="col-lg-6 col-md-8 login-box">
                <div class="col-lg-12 login-key">
                    <i class="fa fa-key" aria-hidden="true"></i>
                </div>
                <div class="col-lg-12 login-title">
                    {{ __('ADMIN PANEL') }}
                </div>

                <div class="col-lg-12 login-form">
                    <div class="col-lg-12 login-form">
                        <form action="{{ route('admin.postLogin') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label class="form-control-label">{{ __('USERNAME') }}</label>
                                <input type="text" value="{{ old('username') }}" name="username"  name="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">{{ __('PASSWORD') }}</label>
                                <input type="password" value="{{ old('password') }}"name="password" class="form-control">
                            </div>

                            <div class="col-lg-12 loginbttm">
                                <div class="col-lg-12 col-md-12 login-btm login-text" style="padding-right:0">
                                   @if(isset($errors) && $errors->any())
                                   <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ __($error) }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                   @endif
                                </div>
                                <div class="col-lg-12 login-btm login-button" style="padding-left:0">
                                    <button type="submit" class=" w-100 btn btn-outline-primary">{{ __('LOGIN') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 col-md-2"></div>
            </div>
        </div>
    </div>
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])

</body>
</html>