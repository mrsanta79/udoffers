<!doctype html>
<html lang="<?= explode('_', lang())[0] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="timezone" content="<?= env('APP_TIMEZONE') ?>">
    <title><?= env('APP_NAME') . ' - Dashboard' ?></title>

    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="<?= assets('libs/notifier/css/notifier.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/dashboard.css') ?>">
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
    <div id="app">
        <div class="container-fluid">
            <div class="container p-2 pb-5">
                <div class="d-flex justify-content-between">
                    <h4 id="countdown" data-timeout="<?= strtotime('tomorrow') ?>">{{ currentTime }}</h4>
                    <div class="md-form m-0">
                        <select class="multiselect" name="city" multiple data-live-search="true" @change="getOffersByCity">
                            <?php
                            if(isset($data) && isset($data['cities']) && count($data['cities'])) {
                                foreach ($data['cities'] as $city) {
                                    $city = (object)$city;
                                    $selected = '';
                                    if(count($data['selected_cities'])) {
                                        foreach ($data['selected_cities'] as $selected_city) {
                                            if($city->id == $selected_city->id) {
                                                $selected = 'selected';
                                            }
                                        }
                                    }

                                    ?>
                                    <option value="<?= $city->id ?>" <?= $selected ?> ><?= $city->name ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <button class="btn color-accent text-white btn-narrow ml-2" data-url="<?= api('/participants/update') ?>" id="btn-update-cities" @click="updateCities" :class="isProcessing ? 'disabled' : ''">
                            <i class="fa fa-spinner fa-spin" v-if="isProcessing"></i>
                            <span class="font-weight-bold" v-if="!isProcessing"><?= trans('buttons.update') ?></span>
                        </button>
                    </div>
                </div>
                <?php if(!$data['participations'] || count($data['participations']) < 1) { ?>
                    <div class="d-block">
                        <h1 class="text-center m-5"><?= trans('dashboard.please_select_city') ?></h1>
                    </div>
                <?php } else { ?>
                    <?php if(!$data['offers'] || count($data['offers']) < 1) { ?>
                        <div class="d-block">
                            <h1 class="text-center m-5"><?= trans('dashboard.no_offer_available') ?></h1>
                        </div>
                    <?php
                        } else {
                            foreach ($data['offers'] as $key => $offer) {
                            ?>
                                <div class="card p-5 mt-5" id="offer-card"
                                     style="background-color: <?= $offer['entry_type']->background ?>">
                                    <div class="d-flex justify-content-between">
                                        <h4><?= isset($offer['entry_type']->name) ? $offer['entry_type']->name : '-' ?></h4>
                                        <h4><?= $offer['city']->name ?></h4>
                                    </div>
                                    <div class="d-flex flex-column justify-content-between mt-2">
                                        <h4 class="text-center mt-5">Shop : <?= $offer['shop'] ?></h4>
                                        <h4 class="text-center mt-5">Discount : <?= $offer['discount'] ?></h4>
                                        <h4 class="text-center mt-5"><?= $offer['information'] == '' ? '-' : $offer['information'] ?></h4>
                                    </div>
                                    <div class="d-flex justify-content-between mt-5">
                                        <a href="<?= $offer['map_link'] ?>" class="btn btn-narrow color-secondary text-white ml-0" target="_blank">Google Map</a>
                                        <h5><?= date('d/m/Y', $offer['created_at']) ?></h5>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-5">
                                    <div class="winner-box">
                                        <h6>Winner 1</h6>
                                    </div>
                                    <div class="winner-box">
                                        <h6>Winner 2</h6>
                                    </div>
                                    <div class="winner-box">
                                        <h6>Winner 3</h6>
                                    </div>
                                    <div class="winner-box">
                                        <h6>Winner 4</h6>
                                    </div>
                                </div>
                                <?php if($key != count($data['offers']) - 1) { ?>
                                    <hr class="mt-5">
                                <?php } ?>
                            <?php
                        }
                    }
                    ?>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.12/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.min.js"></script>
    <script src="<?= assets('libs/notifier/js/notifier.js') ?>"></script>
    <script src="<?= assets('js/dashboard.js') ?>"></script>
</body>
</html>
