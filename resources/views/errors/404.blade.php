<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>404 - Page Not Found</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #b266ff;
            /* Purple background */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
            text-align: center;
        }

        .container {
            padding-top: 10%;
        }

        h1 {
            font-size: 10rem;
            margin: 0;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        p {
            font-size: 1.2rem;
        }

        a {
            color: white;
            text-decoration: underline;
            font-weight: bold;
        }

        a:hover {
            color: #ddd;
        }

        footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
            font-size: 0.9rem;
        }

        .display {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 80px;
            margin-bottom: 70px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row flex-grow">
            <div class="col-lg-7 mx-auto text-white">
                <div class="row display align-items-center d-flex flex-row">
                    <div class="col-lg-6 text-lg-right pr-lg-4">
                        <h1 class="display-1 mb-0">404</h1>
                    </div>
                    <div class="col-lg-6 error-page-divider text-lg-left pl-lg-4">
                        <h2>SORRY!</h2>
                        <h3 class="font-weight-light">The page you’re looking for was not found.</h3>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12 text-center mt-xl-2">
                        <a class="text-white font-weight-medium" href="{{ route('login') }}">Back to home</a>
                    </div>
                </div>
                <div class="row mt-5" style="margin-top: 50px;">
                    <div class="col-12 mt-xl-2">
                        <p class="text-white font-weight-medium text-center" style="font-size:larger;">Copyright ©
                    {{ date('Y') }} All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>