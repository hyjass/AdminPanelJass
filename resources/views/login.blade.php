<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap 5 JS Bundle (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!-- jQuery (required for Bootstrap JS plugins) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
    .btn {
        display: flex;
        width: -webkit-fill-available;
        text-align: center;
        align-items: center;
        justify-content: center;
        height: 50px;
        margin-bottom: 10px;
    }

    .custom {
        display: flex;
        justify-content: left;
        flex-direction: column;
        text-align: left;
        margin-bottom: 30px;
    }


    .brand-logo {
        width: 150px;
        display: flex;
        margin-bottom: 40px;
    }

    h4 {
        font-size: 1.13rem;
    }

    h6 {
        font-size: 0.9375rem;
    }

    .font-weight-light {
        font-family: "ubuntu-light", sans-serif;
    }

    .input-field {
        background: transparent;
        border-radius: 0;
        font-size: 0.9375rem;
        border: 1px solid #ebedf2;
        font-family: "ubuntu-regular", sans-serif;
        box-shadow: none;
    }

    .btn {
        border-radius: 1px;
    }

    .gradient {
        background: linear-gradient(to right, #da8cff, #9a55ff);
        border: 0;
        -webkit-transition: opacity 0.3s ease;
        -moz-transition: opacity 0.3s ease;
        -ms-transition: opacity 0.3s ease;
        -o-transition: opacity 0.3s ease;
        transition: opacity 0.3s ease;
    }

    #checkbox {
        border: 2px solid mediumpurple;
    }

    .text {
        font-size: medium;
        font-weight: bold;
        line-height: normal;
        margin: 5px;

    }

    .form-check-input:checked {
        background-color: #9a55ff;
    }

    .texts {
        opacity: 60%;
        font-size: small;
    }

    a {

        color: mediumpurple;
    }

    .alert {
        border-radius: 1px;
        margin-bottom: 30px;
    }

    .alerts {
        display: flex;
        flex-direction: column;
        text-align: left;
    }
</style>

<body>
    <section class="vh-100" style="background-color: #f2edf3;">
        <div class="container py-5 h-100 mx-auto">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1px;">
                        <div class="card-body p-5 text-center">
                            <div class="brand-logo">
                                <img src="{{ asset('assets/logo.svg') }}" alt="logo" class="imgs">
                            </div>
                            <div class="custom">
                                <h4>Hello! let's get started</h4>
                                <h6 class="texts font-weight-light">Sign in to continue.</h6>
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="alerts">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form id="loginform" method="post">
                                @csrf
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="email" name="email"
                                        class="form-control input-field form-control-lg texts" placeholder="Username"
                                        required />
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="password" name="password"
                                        class="form-control input-field form-control-lg texts" placeholder="Password"
                                        required />
                                </div>

                                <button class="btn gradient btn-primary btn-lg btn-block" type="submit"><span
                                        class="text">SIGN
                                        IN</span></button>
                            </form>
                            <div class="form-check d-flex justify-content-between mb-4">
                                <div>
                                    <input class="form-check-input" type="checkbox" id="checkbox" required>
                                    <span class="texts">Keep me signed in</span> </input>
                                </div>

                                <a href="#">Forgot password?</a>
                            </div>


                            <div class="font-weight-light text-center mt-4 font-weight-light">
                                <span class="font-weight-light">Don't have an account?</span><a
                                    href="{{ route('register') }}">Create</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {


            $('#loginform').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                // console.log(formData);

                $.ajax({
                    url: '{{ route('checkadmin') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            if (response.redirect == 'user') {
                                window.location.href = '{{ route('dashboard') }}';
                            } else if (response.redirect == 'admin') {
                                window.location.href = '{{ route('admin.dashboard') }}';
                            }
                        } else {
                            alert('Login failed: ' + response.message);
                            // window.location.href = '{{ route('login') }}';
                        }

                    },
                    error: function(xhr) {
                        alert('Login faileds: ' + (xhr.responseJSON?.message ||
                            'Unknown error'));
                        // window.location.href = '{{ route('login') }}';
                    }
                });
            });
        });
    </script>

</body>

</html>
