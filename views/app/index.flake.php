<?= load_layout('app/layouts/header') ?>

    <div id="app">
        <div class="container-fluid" style="padding-top: 50px !important;">
            <?php
                $top_ad = array_filter($data['ads'], function($item) {
                    $item = $item['position'] == 'top';
                    return $item;
                })[0];
                $right_ad = array_filter($data['ads'], function($item) {
                    $item = $item['position'] == 'right';
                    return $item;
                })[1];
                $bottom_ad = array_filter($data['ads'], function($item) {
                    $item = $item['position'] == 'bottom';
                    return $item;
                })[2];
                $left_ad = array_filter($data['ads'], function($item) {
                    $item = $item['position'] == 'left';
                    return $item;
                })[3];
            ?>
            <div class="container p-2 pb-2">
                <div class="row mb-4">
                    <div class="col-md-4 text-left">
                        <a class="navbar-brand" href="<?= url('/') ?>">
                            <img src="<?= assets('images/logo.png') ?>" alt="" class="w-100" style="max-width: 100px;">
                        </a>
                    </div>
                    <div class="col-md-8 text-right ad-container">
                        <?= $top_ad['script'] ?>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
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
                            <span class="font-weight-bold" v-if="!isProcessing">
                                <i class="fas fa-save" style="font-size: 16px;"></i>
                            </span>
                        </button>
                    </div>
                    <h4 id="countdown" data-timeout="<?= strtotime('tomorrow') ?>" style="width: 100px;">{{ currentTime }}</h4>
                    <div>
                        <a class="dropdown-toggle d-block p-1 pr-3 icon-btn color-accent text-white waves-light" id="dashboard-avatar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 100px">
                            <img src="<?= !empty(user()->avatar) ? user()->avatar : avatar(user()->name) ?>" alt="" class="avatar mr-1" style="width: 25px; height: 25px;">
                            <span class="font-weight-bold" style="font-size: 14px;">
                                <?= generate_user_id(user()) ?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="#dashboard-avatar">
                            <?php if(is_admin()) { ?>
                                <a href="<?= url('/admin') ?>" class="dropdown-item" style="vertical-align: middle">
                                    <?= trans('common.menu.admin_panel') ?>
                                </a>
                            <?php } ?>
                            <a href="<?= url('/logout') ?>" class="dropdown-item" style="vertical-align: middle">
                                <?= trans('common.menu.logout') ?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row py-5">
                    <div class="col-md-2 text-center ad-container">
                        <?= $left_ad['script'] ?>
                    </div>
                    <div class="col-md-8">
                        <?php if(!$data['participations'] || count($data['participations']) < 1) { ?>
                            <div class="d-block">
                                <h1 class="text-center m-5"><?= trans('dashboard.please_select_city') ?></h1>
                            </div>
                        <?php } else { ?>
                            <?php if(!$data['offers'] || count($data['offers']) < 1) { ?>
                                <div class="d-block">
                                    <h4 class="text-center m-5"><?= trans('dashboard.no_offer_available') ?></h4>
                                </div>
                                <?php
                            } else {
                                foreach ($data['offers'] as $key => $offer) {
                                    if(isset($offer['entry_type']) && isset($offer['entry_type']->background)) {
                                        $card_bg = validate_hex($offer['entry_type']->background) ? $offer['entry_type']->background : 'url(' . url($offer['entry_type']->background) . ')';
                                    } else {
                                        $card_bg = '#fff';
                                    }
                                    ?>
                                    <div class="card p-5 <?= $key != 0 ? 'mt-5' : '' ?>" id="offer-card" style="background: <?= $card_bg ?>; background-size: cover">
                                        <div class="d-flex justify-content-between">
                                            <h6><?= isset($offer['entry_type']->name) ? $offer['entry_type']->name : '-' ?></h6>
                                            <h6><?= $offer['city']->name ?></h6>
                                        </div>
                                        <div class="d-flex flex-column justify-content-between mt-1">
                                            <h6 class="text-center mt-3">
                                                <?= trans('modals.shop') ?> : <?= $offer['shop'] ?>
                                            </h6>
                                            <h6 class="text-center mt-3">
                                                <?= trans('modals.discount') ?> : <?= $offer['discount'] ?>
                                            </h6>
                                            <h6 class="text-center mt-3"><?= $offer['information'] == '' ? '-' : $offer['information'] ?></h6>
                                        </div>
                                        <div class="d-flex justify-content-between mt-3">
                                            <a href="<?= $offer['map_link'] ?>" class="btn btn-narrow color-secondary text-white ml-0" target="_blank">
                                                <?= trans('dashboard.google_map') ?>
                                            </a>
                                            <h6><?= date('d/m/Y', $offer['created_at']) ?></h6>
                                        </div>
                                    </div>
                                    <?php if(count((array)$offer['winners'])) { ?>
                                        <div class="d-flex justify-content-around mt-3 pb-3" id="winner-box-container" style="border-bottom: 1px solid #ddd">
                                            <?php foreach($offer['winners'] as $winner) { ?>
                                                <div class="winner-box">
                                                    <h6><?= generate_user_id($winner['user']) ?></h6>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php }
                                }
                            }
                        } ?>
                    </div>
                    <div class="col-md-2 text-center ad-container">
                        <?= $right_ad['script'] ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-1 text-center ad-container">
                        <?= $bottom_ad['script'] ?>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6 mt-2 text-left">
                        <h5>
                            <?= trans('dashboard.total_visits') ?>:
                            <?= $data['visits']['total'] ?>
                        </h5>
                    </div>
                    <div class="col-md-6 mt-2 text-right">
                        <h5>
                            <?= trans('dashboard.today_visits') ?>:
                            <?= $data['visits']['today'] ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= load_layout('app/layouts/footer') ?>