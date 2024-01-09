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

        .modal-dialog {
            position: fixed;
            bottom: 0;
            left: 0%;
            right: 0%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
@php
    $seatRow = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
@endphp

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
    <div class="container pt-3">
        <h2 class="text-center text-white">List Film</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="d-flex justify-content-center">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Cari Film"
                            aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-danger" type="button" id="button-addon2">Cari</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-wrap justify-content-center">
                    @for ($i = 1; $i <= 12; $i++)
                        <div class="m-1 shadow rounded" style="width: 200px; background-color: #242340;">
                            <div class="p-1 m-1">
                                <img src="https://movie-list.alphacamp.io/posters/3gIO6mCd4Q4PF1tuwcyI3sjFrtI.jpg"
                                    class="img-fluid rounded" alt="...">
                            </div>
                            <div class="p-2">
                                <small>
                                    Lorem ipsum dolor sit amet consectetur
                                </small>
                                <button class="btn btn-danger d-block btn-sm ms-auto">Pesan</button>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
        <div class="d-flex mt-4 mb-2">
            <div class="w-50">
                <div class="p-2">
                    <div class="card-body">
                        <h4 class="text-white text-center">Pilih Kursi</h4>
                        <div class="d-flex justify-content-center">
                            <div class="justify-content-center">
                                <div class="screen"></div>
                                @foreach ($seatRow as $row)
                                    <div class="row">
                                        @for ($i = 1; $i <= 8; $i++)
                                            <div class="seat" id="{{ $row . $i }}">
                                            </div>
                                        @endfor
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-50 px-5">
                <div class="rounded overflow-hidden" style="background-color: #c2d1e5">
                    <div class="bg-danger px-3 pt-2 pb-1">
                        <p>
                            <b>Bioskop Ticket</b>
                        </p>
                    </div>
                    <div class="text-dark px-3 py-2">
                        <div class="row">
                            <div class="col-8">
                                <span class="d-block">Lubang Buaya</span>
                                <small class="text-secondary">film</small>
                                <br>
                                <span class="d-block">Rabu, 20 Oktober 2021</span>
                                <span class="d-block">pukul 13:00</span>
                            </div>
                            <div class="col-4">
                                <span class="d-block">A1, A2, A3, A2, A3, A2, A3</span>
                                <small class="text-secondary">kursi</small>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <span class="d-block">Total</span>
                            <span class="d-block">Rp. 50.000</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-start mt-3">
                    <button class="btn btn-danger me-1">Pesan</button>
                    <button class="btn btn-secondary">Batal</button>
                </div>
            </div>
        </div>

        <footer class="mt-5">
            <p class="text-center text-white">- Bioskop Test 2024 -</p>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>
</body>

</html>
