<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance</title>
    <style>
    body {
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: rgb(83, 93, 91);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        color: #fff;
        font-family: Arial, sans-serif;
        text-align: center;
    }

    #magicArea {
        position: fixed;
        width: 100%;
        height: 100%;
    }

    .box {
        position: absolute;
        background-color: rgb(158, 235, 71);
        opacity: 0.8;
        width: 10px;
        height: 10px;
    }

    .shooting-star {
        position: absolute;
        width: 5px;
        height: 1px;
        background-color: #FFF;
        transform-origin: 0 50%;
        opacity: 0.8;
    }

    @keyframes twinkle {
        0% {
            opacity: 0;
        }

        50% {
            opacity: 1;
        }

        100% {
            opacity: 0;
        }
    }

    @keyframes shooting {
        0% {
            transform: scaleX(0);
        }

        100% {
            transform: scaleX(1);
        }
    }
    </style>
</head>

<body>
    <div id="magicArea">

    </div>
    <div>
        <h1>Medlinkup Update in Progress</h1>
        <p>We're making improvements to provide you with a better experience.</p>
        <p>Thank you for your patience.</p>
    </div>
    <script src="./main.js"></script>

</body>

</html>