<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>
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
                    <h4 class="card-title">Reset Password</h4>
                    <form>
                        <div class="form-group">
                            <label for="email">E-Mail Address</label>
                            <input id="email" type="email" class="form-control" name="email" required="" autofocus="">
                        </div>

                        <div class="form-group no-margin">
                            <a href="#" class="btn btn-primary btn-block">
                                Send Password Reset Link
                            </a>
                        </div>
                        <div class="text-center mt-3 small">
                            Don't have an account? <a href="{{route('login')}}">Sign Up</a>
                        </div>
                    </form>
                </div>
            </div>
            <footer class="footer mt-3">
                <div class="container-fluid">
                    <div class="footer-content text-center small">
                        <span class="text-muted">© 2019 Graindashboard. All Rights Reserved.</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>

</html>