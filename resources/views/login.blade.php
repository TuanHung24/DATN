<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="{{ asset('custom.css') }}" rel="stylesheet">
    <link href="{{ asset('style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/graindashboard.css')}}">
</head>
<body>
<div class="row justify-content-md-center">
    <div class="card-wrapper col-12 col-md-4 mt-5">
        <div class="brand text-center mb-3">
            <a href="/"><img src="{{asset('img/logo.png')}}"></a>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Login</h4>
                <form method="POST" action="{{route('hd-login')}}">
                    @csrf
                    <div class="form-group">
                        <label for="email">E-Mail Address</label>
                        <input id="email" type="email" class="form-control" name="email" >
                    </div>

                    <div class="form-group">
                        <label for="password">Password
                        </label>
                        <input id="password" type="password" class="form-control" name="password">
                        <div class="text-right">
                            <a href="{{ route('password-reset')}}" class="small">
                                Forgot Your Password?
                            </a>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check position-relative mb-2">
                            <input type="checkbox" class="form-check-input d-none" id="remember" name="remember">
                            <label class="checkbox checkbox-xxs form-check-label ml-1" for="remember">Remember Me</label>
                        </div>
                    </div>

                    <div class="form-group no-margin">
                        <button type="submit" class="btn btn-primary btn-block">
                            Sign In
                        </button>
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

