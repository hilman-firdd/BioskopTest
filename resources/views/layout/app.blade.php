<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-color: #242333;
            color: #fff;
            margin: 0;
        }

        * {
            font-family: "Montserrat", sans-serif !important;
            box-sizing: border-box;
        }

        .movie-container {
            margin: 20px 0px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column
        }

        .movie-container select {
            appearance: none;
            -moz-appearance: none;
            -webkit-appearance: none;
            border: 0;
            padding: 5px 15px;
            margin-bottom: 40px;
            font-size: 14px;
            border-radius: 5px;
        }

        .seat {
            background-color: #444451;
            height: 16px;
            width: 20px;
            margin: 5px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .selected {
            background-color: #0081cb;
        }

        .occupied {
            background-color: #fff;
        }

        .seat:nth-of-type(2) {
            margin-right: 18px;
        }

        .seat:nth-last-of-type(2) {
            margin-left: 18px;
        }

        .seat:not(.occupied):hover {
            cursor: pointer;
            transform: scale(1.2);
        }

        .showcase .seat:not(.occupied):hover {
            cursor: default;
            transform: scale(1);
        }

        .showcase {
            display: flex;
            justify-content: space-between;
            list-style-type: none;
            background: rgba(0, 0, 0, 0.1);
            padding: 5px 10px;
            border-radius: 5px;
            color: #777;
        }

        .showcase li {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
        }

        .showcase li small {
            margin-left: 2px;
        }

        .screen {
            background: #fff;
            height: 70px;
            width: 70%;
            margin: 15px auto;
            transform: rotateX(-45deg);
            box-shadow: 0 3px 10px rgba(255, 255, 255, 0.7);
        }

        p.text {
            margin: 40px 0;
        }

        p.text span {
            color: #0081cb;
            font-weight: 600;
            box-sizing: content-box;
        }

        .credits a {
            color: #fff;
        }

        /* lg */
        @media (min-width: 992px) {
            .slide-modal {
                position: fixed;
                bottom: 0;
                left: 0%;
                right: 0%;
                transform: translate(-50%, -50%);
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-danger">
        <div class="container">
            <a class="navbar-brand text-white" href="#">Cinema-</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-white" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-gray" href="#">My Ticket</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        @yield('content')
    </div>
    <footer class="mt-5">
        <p class="text-center text-white">- Bioskop Test 2024 -</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
