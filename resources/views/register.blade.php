<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sign Up</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap 5 JS Bundle (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Font Awesome -->
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
        transition: opacity 0.3s ease;
    }

    #checkbox {
        border: 2px solid mediumpurple;
    }

    .form-check-input:checked {
        background-color: #9a55ff;
    }

    .text {
        font-size: medium;
        font-weight: bold;
        line-height: normal;
        margin: 5px;
    }

    .texts {
        opacity: 60%;
        font-size: small;
    }

    a {
        color: mediumpurple;
    }

    .divider {
        position: relative;
        text-align: center;
        margin: 20px 0;
    }

    .divider::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background-color: #ddd;
        z-index: 1;
    }

    .divider span {
        position: relative;
        z-index: 2;
        background-color: white;
        padding: 0 15px;
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
                                <h4>New here?</h4>
                                <h6 class="texts font-weight-light">Signing up is easy. It only takes a few steps</h6>
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
                            <form id="registerform" method="post">
                                @csrf
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="text" id="username" name="name"
                                        class="form-control input-field form-control-lg texts" placeholder="Username"
                                        value="{{ old('name') }}" required />
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="email" id="email" name="email"
                                        class="form-control input-field form-control-lg texts" placeholder="Email"
                                        value="{{ old('email') }}" required />
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <select class="form-select texts rounded-0" name="country">
                                        <option value="">Country</option>
                                        <option value="United States of America">United States of America</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="India">India</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Argentina">Argentina</option>
                                    </select>

                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="password" id="password"
                                        class="form-control input-field form-control-lg texts" name="password"
                                        placeholder="Password" required />
                                </div>

                                <div class="form-check d-flex justify-content-start mb-4">
                                    <input class="form-check-input me-2" type="checkbox" value="" id="checkbox"
                                        required>
                                    <label class="form-check-label texts" for="termsCheck">
                                        I agree to all Terms & Conditions
                                    </label>
                                </div>

                                <button data-mdb-button-init data-mdb-ripple-init
                                    class="btn gradient btn-primary btn-lg btn-block" type="submit"><span
                                        class="text">SIGN UP</span></button>
                            </form>


                            <div class="font-weight-light text-center mt-4 font-weight-light">
                                <span class="font-weight-light">Already have an account?</span>
                                <a href="{{ route('login') }}">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            $('#registerform').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('store') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            window.location.href = "{{ route('dashboard') }}";
                        } else {
                            alert("Registration failed");
                        }
                    },
                    error: function(xhr) {
                        alert('Registration failed: ' + (xhr.responseJSON?.message ||
                            'Unknown error'));
                        location.reload();
                    }
                });
            });
        });
    </script>
</body>

</html>
