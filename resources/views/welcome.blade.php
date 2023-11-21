<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exciting Announcement Countdown</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #000;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: #fff;
            overflow: hidden;
        }

        #container {
            text-align: center;
            animation: fadeIn 2s ease-in-out;
        }

        #countdown {
            margin-bottom: 20px;
        }

        #timer {
            font-size: 2.5em;
            margin-bottom: 20px;
            animation: zoomIn 2s ease-in-out;
        }

        #server {
            width: 50px;
            height: 50px;
            background-color: #3498db;
            border-radius: 50%;
            position: absolute;
            top: 20px;
            left: 20px;
            animation: rotateServer 2s linear infinite;
        }

        #content {
            max-width: 600px;
            margin: 0 auto;
        }

        @media (max-width: 600px) {
            #timer {
                font-size: 1.5em;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes zoomIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }

        @keyframes rotateServer {
            to {
                transform: rotate(360deg);
            }
        }

        /* Background image animation */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('background-image.jpg') no-repeat center center fixed;
            background-size: cover;
            z-index: -1;
            animation: slideBackground 20s linear infinite;
        }

        @keyframes slideBackground {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
    </style>
</head>
<body>
    <div id="container">
        <h1 style="font-size: 3em;">Exciting Announcement!</h1>
        <p style="font-size: 1.2em;">Join us for the big reveal!</p>
        <div id="countdown">
            <p style="font-size: 1.2em;">Our page will be live in:</p>
            <div id="timer"></div>
        </div>
    </div>

    <!-- Server graphic -->
    <div id="server"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var countDownDate = new Date().getTime() + 5 * 60 * 60 * 1000;

            var x = setInterval(function () {
                var now = new Date().getTime();
                var distance = countDownDate - now;

                var hours = Math.floor(distance / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById('timer').innerHTML = hours + 'h ' + minutes + 'm ' + seconds + 's ';

                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById('timer').innerHTML = 'EXPIRED';
                }
            }, 1000);
        });
    </script>
</body>
</html>
