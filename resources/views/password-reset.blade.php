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
                <a href="/"><img src="{{asset($logoUrl->img_url)}}" id='logo-password-reset'></a>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Khôi phục mật khẩu</h4>
                    <form method="POST" action="{{route('hd-password-reset')}}">
                    @csrf 
                        <div class="form-group">
                            <label for="email">Nhập Email cần lấy lại mật khẩu:</label>
                            <input id="email" type="email" class="form-control" name="email" required="" autofocus="">
                        </div>

                        <div class="form-group no-margin">
                            <button type="submit" class="btn btn-primary btn-block">
                                Gửi Email
                            </button>
                        </div>
                        
                    </form>
                    <div class="text-center mt-3 small">
                            Đã có tài khoản? <a href="{{route('login')}}">Đăng nhập</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>