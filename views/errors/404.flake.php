<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="favicon.gif">
    <title><?= env('APP_NAME') ?> - Page not found!</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= assets('css/theme.css') ?>">
    <style type="text/css">
        * {
            margin: 0;
            color: #41444b;
            font-family: 'Comfortaa', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: antialiased;
            font-weight: 600;
        }
        #app {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 10px;
            box-sizing: border-box;
            background: #ffc93c;
        }
        img {
            max-width: 200px;
            width: 100%;
        }
        h1 {
            font-size: 6em;
            margin-bottom: 30px;
        }
        h3 {
            font-size: 2em;
            margin-bottom: 30px;
        }
        p {
            text-align: center;
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>

<body dir="<?= explode('_', lang())[0] == 'ar' ? 'rtl' : 'ltr' ?>">
    <div id="app">
<!--        class="info-color"-->
        <img src="<?= assets('images/sad-face.svg') ?>" alt="">
        <h1>404</h1>
        <h3>Page Not Found!</h3>
        <p>Oops! Looks like you've entered or followed a broken URL.</p>
    </div>
</body>
</html>