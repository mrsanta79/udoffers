<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css">
    <link rel="stylesheet" href="<?= assets('css/auth.css') ?>">
</head>
<body>

    <div class="container">
        <div id="fb-root"></div>
        <div class="card">
            <a href="<?= url('/') ?>" class="logo">
                <img src="<?= assets('images/logo.png') ?>" alt="" style="max-width: 100px;">
            </a>
            <?php if(isset($data) && isset($data['is_new_account']) && $data['is_new_account']) { ?>
                <h1 class="text-center">Welcome to <?= env('APP_NAME') ?></h1>
            <?php } ?>
            <h2 class="text-center">Your One Time Password</h2>
            <h1 class="font-weight-bold text-center"><?= isset($data) && isset($data['password']) ? $data['password'] : '' ?></h1>
        </div>
    </div>
</body>
</html>