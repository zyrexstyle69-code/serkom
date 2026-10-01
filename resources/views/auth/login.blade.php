<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login SMKN</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link href="{{ asset('asset/img/favicon.ico') }}" rel="icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('asset/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="{{ url('/') }}">
                                <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>SMKN</h3>
                            </a>
                            <h3>Sign In</h3>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.process') }}">
                            @csrf

                            <div class="form-floating mb-3">
                                <input type="text" name="username" value="{{ old('username') }}"
                                       class="form-control @error('username') is-invalid @enderror"
                                       id="floatingInput" placeholder="Username" required autofocus>
                                <label for="floatingInput">Username</label>
                            </div>

                            <div class="form-floating mb-4">
                                <input type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="floatingPassword" placeholder="Password" required>
                                <label for="floatingPassword">Password</label>
                            </div>

                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('asset/js/main.js') }}"></script>
</body>

</html>