<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Enhancing School Safety | Admin - Login</title>
        <link rel="stylesheet" href="{{ asset('css/backend/styles.css') }}">
        <link rel="shortcut icon" href="{{ asset('images/frontend/favicon.png') }}" />
        <script src="{{ asset('js/backend/all.min.js') }}"></script>
        <script src="{{ asset('js/backend/feather.min.js') }}"></script>
        <style>
            body {
                background: url('{{ asset("images/backend/login-bg.png") }}') no-repeat center center fixed;
                background-size: cover;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
            .login-container {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            .login-card {
                width: 100%;
                max-width: 500px; 
            }
            .footer-admin {
                position: absolute;
                bottom: 0;
                width: 100%;
                text-align: center;
                padding: 10px;
                background-color: #343a40;
                color: white;
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <div class="card shadow-lg border-0 rounded-lg login-card">
                <div class="card-header text-center bg-success" style="padding: 0px;">
                    <h3 class="fw-light my-3 text-white">
                        <img src="{{ asset('images/frontend/brand-icon.png') }}" style="width:65px;" alt="logo" />
                        <br><strong>ESS Login</strong></h3>
                </div>
                <div class="card-body">
                    <form method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="small mb-1" for="username">Username</label>
                            <input class="form-control" id="username" type="username" placeholder="e.g admin" />
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="password">Password</label>
                            <input class="form-control" id="password" type="password" placeholder="e.g ******" />
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-4">
                            <button type="submit" class="btn btn-success btn-md btn-block">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/backend/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('js/frontend/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/backend/scripts.js') }}"></script>
        <script>
            $(document).ready(function () {
                $('form').on('submit', function (e) {
                    e.preventDefault();
        
                    $.ajax({
                        url: "{{ route('admin.login') }}",
                        type: "POST",
                        data: {
                            username: $("#username").val(),
                            password: $("#password").val(),
                            _token: "{{ csrf_token() }}"
                        },
                        beforeSend: function () {
                            $(".btn-success").prop("disabled", true).text("Logging in...");
                        },
                        success: function (response) {
                            alert(response.message);
                            if (response.success) {
                                $(".btn-success").prop("disabled", false).text("Login");
                                window.location.href = response.redirect;
                            }
                        },
                        error: function (xhr) {
                            $(".btn-success").prop("disabled", false).text("Login");
                            alert(xhr.responseJSON.message);
                        }
                    });
                });
            });
        </script>
    </body>
</html>
