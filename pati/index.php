<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sehati Pati</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #0f172a, #1e3a8a, #0ea5e9);
            overflow-x: hidden;
            padding: 20px;
        }

        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: #38bdf8;
            border-radius: 50%;
            filter: blur(180px);
            top: -150px;
            left: -120px;
            opacity: .35;
        }

        body::after {
            content: '';
            position: absolute;
            width: 450px;
            height: 450px;
            background: #22c55e;
            border-radius: 50%;
            filter: blur(180px);
            bottom: -150px;
            right: -120px;
            opacity: .25;
        }

        .container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 950px;
            text-align: center;
            background: rgba(255, 255, 255, .12);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 30px;
            padding: 50px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .3);
        }

        .logo {
            width: 200px;
            height: 200px;
            margin: auto;
            margin-bottom: 25px;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        h1 {
            color: white;
            font-size: 42px;
            margin-bottom: 10px;
        }

        p {
            color: #e2e8f0;
            margin-bottom: 50px;
            font-size: 18px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        @media (max-width:768px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        .card {
            text-decoration: none;
            background: white;
            border-radius: 20px;
            padding: 30px;
            transition: .35s;
            color: #1e293b;
            box-shadow: 0 15px 30px rgba(0, 0, 0, .15);

            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }

        .card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 25px 50px rgba(0, 0, 0, .25);
        }

        .icon {
            width: 100%;
            margin-bottom: 20px;
        }

        .icon img {
            width: 100%;
            max-width: 180px;
            height: auto;
            object-fit: contain;
        }

        .card h2 {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .card span {
            display: inline-block;
            margin-top: 20px;
            background: #2563eb;
            color: white;
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 600;
            transition: .3s;
        }

        .card:hover span {
            background: #1d4ed8;
        }

        footer {
            margin-top: 40px;
            color: #cbd5e1;
            font-size: 14px;
        }

        @media (max-width:992px) {

            .container {
                width: 95%;
                padding: 45px 35px;
            }

            h1 {
                font-size: 34px;
            }

        }

        @media (max-width:768px) {

            body {
                padding: 20px;
                align-items: flex-start;
            }

            .container {
                margin: 30px 0;
                padding: 30px 20px;
                border-radius: 20px;
            }

            h1 {
                font-size: 28px;
            }

            p {
                font-size: 16px;
                margin-bottom: 30px;
            }

            .logo {
                width: 80px;
                height: 80px;
            }

            .grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .icon img {
                max-width: 150px;
            }

            .card h2 {
                font-size: 24px;
            }

        }

        @media (max-width:480px) {

            h1 {
                font-size: 24px;
            }

            p {
                font-size: 14px;
            }

            .card {
                padding: 25px 20px;
            }

            .icon img {
                max-width: 130px;
            }

            .card h2 {
                font-size: 22px;
            }

            .card span {
                width: 100%;
                text-align: center;
            }

            footer {
                font-size: 12px;
            }

        }
    </style>
</head>

<body>

    <div class="container">

        <div class="logo">
            <img src="logopati.png" alt="Logo Sehati">
        </div>

        <h1>SEHATI PATI</h1>

        <p>
            Silakan pilih wilayah layanan yang ingin Anda akses.
        </p>

        <div class="grid">

            <a class="card" href="https://pati.sehatipati.com">
                <div class="icon">
                    <img src="logopati.png" alt="Pati">
                </div>

                <h2>PATI</h2>

                <div>Apotik Pati</div>

                <span>Masuk Portal</span>
            </a>

            <a class="card" href="https://juwana.sehatipati.com">
                <div class="icon">
                    <img src="logojuwana.png" alt="Juwana">
                </div>

                <h2>JUWANA</h2>

                <div>Apotik Juwana</div>

                <span>Masuk Portal</span>
            </a>

        </div>

        <footer>
            © 2026 Sehati Pati. All Rights Reserved.
        </footer>

    </div>

</body>

</html>