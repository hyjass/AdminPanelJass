<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>500 - Internal Server Error</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #2196f3;
            /* Blue background */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
            text-align: center;
        }

        .container {
            padding-top: 10%;
        }

        .display {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 130px;
            margin-bottom: 70px;
            flex-wrap: wrap;
        }

        h1 {
            font-size: 10rem;
            margin: 0;
        }

        h2 {
            font-size: 2rem;
            margin: 0;
        }

        h3 {
            font-weight: 300;
            margin-top: 10px;
            font-size: 1.3rem;
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
            margin-top: 50px;
            font-size: 0.9rem;
        }

        .font-weight-light {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="display">
            <div>
                <h1>500</h1>
            </div>

            <div class="col-lg-6 error-page-divider text-lg-left pl-lg-4">
                <h2>SORRY!</h2>
                <h3 class="font-weight-light" style="font-size:larger;">Internal server error!</h3>
            </div>
        </div>
        <div>
            <a href="{{ route('login') }}">Back to home</a>
        </div>
        <div class="row mt-5" style="margin-top: 50px;">
            <div class="col-12 mt-xl-2">
                <p class="text-white font-weight-medium text-center" style="font-size:larger;">Copyright ©
                    {{ date('Y') }} All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>

</html>
