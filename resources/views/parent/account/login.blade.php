
<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
   <link rel="shortcut icon" href="{{ asset('images/frontend/favicon.png') }}" />
   <script src="{{ asset('js/frontend/color-modes.js') }}"></script>
   <link rel="stylesheet" href="{{ asset('css/frontend/simplebar.min.css') }}">
   <link rel="stylesheet" href="{{ asset('css/frontend/bootstrap-icons.min.css') }}">
   <link rel="stylesheet" href="{{ asset('css/frontend/scrollCue.css') }}">
   <link rel="stylesheet" href="{{ asset('css/frontend/boxicons.min.css') }}">
   <link rel="stylesheet" href="{{ asset('css/frontend/theme.min.css') }}">
   <title>Enhancing School Safety | Login</title>
</head>

<body>
    <main>
        <div class="position-relative h-100">
           <div
              class="container d-flex flex-wrap justify-content-center vh-100 align-items-center w-lg-50 position-lg-absolute">
              <div class="row justify-content-center">
                 <div class="w-100 align-self-end col-12">
                    <div class="text-center mb-7">
                       <a href="javascript:void;">
                        <img src="{{ asset('images/frontend/brand-icon.png') }}" alt="brand" class="mb-3" style="width:80px;"/>
                       </a>
                       <h1 class="mb-1">Welcome Back</h1>
                       <p class="mb-0">
                          Don’t have an account yet?
                          <a href="{{route('parent.register.form')}}" class="text-primary">Register here</a>
                       </p>
                    </div>
                    <form class="needs-validation mb-6" id="loginForm" novalidate>
                        @csrf
                        @if (session('success'))
                        <div class="mb-3">
                           <div class="alert alert-success alert-dismissible fade show" role="alert">
                              {{ session('success') }}
                              {{-- <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button> --}}
                           </div>
                        </div>
                        @endif

                        @if (session('error'))
                        <div class="mb-3">
                           <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              {{ session('error') }}
                              {{-- <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button> --}}
                           </div>
                        </div>
                        @endif

                        <div class="mb-3">
                           <label for="email" class="form-label">
                              Email
                              <span class="text-danger">*</span>
                           </label>
                           <input type="email" class="form-control" id="email" name="email" required placeholder="e.g formative@gmail.com" />
                           <div class="invalid-feedback">Please enter email.</div>
                        </div>
                        <div class="mb-3">
                           <label for="password" class="form-label">Password</label>
                           <div class="password-field position-relative">
                              <input type="password" class="form-control fakePassword" id="password"
                                 required placeholder="******"
                                 name="password"
                                 />
                           </div>
                        </div>

                        <div class="mb-4 d-flex align-items-center justify-content-between">
                           <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="rememberMeCheckbox" />
                              <label class="form-check-label" for="rememberMeCheckbox">Remember me</label>
                           </div>

                           {{-- <div>
                              <a href="javascript:void;" class="text-success">Forgot Password</a>
                           </div> --}}
                        </div>

                        <div class="d-grid">
                           <button class="btn btn-success" id="btn_log" type="submit">Sign In</button>
                        </div>
                     </form>
                    <div class="text-center mt-9">
                        <div class="small mb-3 mb-lg-0 text-body-tertiary">
                           Copyright © {{ date('Y')}} 
                           <span ><a href="javascript:void;" class="text-primary">Formative Academic and Skill Development School</a></span>
                        </div>
                     </div>
                 </div>
              </div>
           </div>
           <div class="position-fixed top-0 end-0 w-50 h-100 d-none d-lg-block vh-100"
              style="background-image: url(images/frontend/banner.png); background-position: center; background-repeat: no-repeat; background-size: cover">
           </div>
        </div>
        @include('parent.account.toggle')
     </main>
   
   <script src="{{ asset('js/backend/jquery-3.6.0.min.js') }}"></script>
   <script src="{{ asset('js/frontend/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ asset('js/frontend/simplebar.min.js') }}"></script>
   <script src="{{ asset('js/frontend/headhesive.min.js') }}"></script>
   <script src="{{ asset('js/frontend/theme.min.js') }}"></script>
   <script src="{{ asset('js/frontend/password.js') }}"></script>
   <script>
      $(document).ready(function () {
         // Automatically hide success and error messages after 5 seconds
         setTimeout(function () {
            $(".alert").fadeOut("slow");
         }, 5000);

         // Close button functionality for dismissing alerts
         $(".alert .close").on("click", function () {
            $(this).closest(".alert").fadeOut("slow");
         });

         $('#loginForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                  url: "{{ route('parent.login') }}",
                  type: "POST",
                  data: $(this).serialize(),
                  dataType: "json",
                  beforeSend: function () {
                     $("#btn_log").prop("disabled", true).text("Logging in...");
                  },
                  success: function(response) {
                     if (response.success) {
                        window.location.href = "{{ route('parent.dashboard') }}";
                     } else {
                        alert(response.message);
                     }
                     $("#btn_log").prop("disabled", false).text("Login");
                  },
                  error: function(xhr) {
                     let errorMessage = "Something went wrong. Please try again.";
                     
                     if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;
                        errorMessage = Object.values(errors).map(error => error[0]).join("\n");
                     } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                     }
                     $("#btn_log").prop("disabled", false).text("Login");
                     alert(errorMessage);
                  }
            });
         });
      });

   </script>
</body>
</html>