<!doctype html>
<html lang="<?= explode('_', lang())[0] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= env('APP_NAME') . ' - Admin | ' . ucfirst($page_name) ?></title>

    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?= assets('libs/notifier/css/notifier.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/admin.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/admin-rtl.css') ?>">
</head>
<body dir="<?= explode('_', lang())[0] == 'ar' ? 'rtl' : 'ltr' ?>">
    <div id="page-loader">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;background:#fff;display:block;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
            <circle cx="50" cy="50" r="0" fill="none" stroke="#e90c59" stroke-width="2">
                <animate attributeName="r" repeatCount="indefinite" dur="1s" values="0;40" keyTimes="0;1" keySplines="0 0.2 0.8 1" calcMode="spline" begin="-0.5s"></animate>
                <animate attributeName="opacity" repeatCount="indefinite" dur="1s" values="1;0" keyTimes="0;1" keySplines="0.2 0 0.8 1" calcMode="spline" begin="-0.5s"></animate>
            </circle>
            <circle cx="50" cy="50" r="0" fill="none" stroke="#46dff0" stroke-width="2">
                <animate attributeName="r" repeatCount="indefinite" dur="1s" values="0;40" keyTimes="0;1" keySplines="0 0.2 0.8 1" calcMode="spline"></animate>
                <animate attributeName="opacity" repeatCount="indefinite" dur="1s" values="1;0" keyTimes="0;1" keySplines="0.2 0 0.8 1" calcMode="spline"></animate>
            </circle>
        </svg>
    </div>
    <!-- Top Navbar -->
    <nav class="mb-1 navbar navbar-expand-lg navbar-dark color-primary">
        <button class="navbar-toggler" type="button" id="toggle-sidenav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="<?= url('/') ?>">
            UDOffers
        </a>
        <a type="button" href="<?= url('/logout') ?>" class="show-sm text-white mr-3">
            <i class="fas fa-sign-out-alt" style="font-size: 20px;"></i>
        </a>

        <div class="collapse navbar-collapse" id="top-nav">
            <ul class="navbar-nav ml-auto nav-flex-icons">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="top-nav" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?= !empty(user()->avatar) ? user()->avatar : avatar(user()->name) ?>" alt="" class="avatar mr-2">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="top-nav">
                        <a class="dropdown-item" style="vertical-align: middle" data-toggle="modal" data-target="#ad-script-modal"><?= trans('common.menu.ad_script') ?></a>
                        <a class="dropdown-item" style="vertical-align: middle" href="/logout"><?= trans('common.menu.logout') ?></a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!-- Top Navbar -->

    <!-- Side Navbar -->
    <div id="sidenav-backdrop"></div>
    <div class="sidenav color-primary">
        <a class="navbar-brand mr-0 ml-0" href="/">
            <img src="<?= assets('images/logo.jpeg') ?>" alt="" class="w-100" style="max-width: 150px;">
        </a>
        <a class="navbar-brand-sm hidden" href="/">U</a>
        <ul>
            <li class="waves-effect <?= isset($page_name) && $page_name == 'fields' ? 'active' : '' ?>">
                <a href="/admin/fields">
                    <i class="fas fa-columns"></i>
                    <span><?= trans('common.menu.fields') ?></span>
                </a>
            </li>
            <li class="waves-effect <?= isset($page_name) && $page_name == 'offers' ? 'active' : '' ?>">
                <a href="/admin/offers">
                    <i class="fas fa-gifts"></i>
                    <span><?= trans('common.menu.offers') ?></span>
                </a>
            </li>
            <li class="waves-effect <?= isset($page_name) && $page_name == 'users' ? 'active' : '' ?>">
                <a href="/admin/users">
                    <i class="fas fa-users"></i>
                    <span><?= trans('common.menu.users') ?></span>
                </a>
            </li>
        </ul>
    </div>
    <!-- Side Navbar -->
