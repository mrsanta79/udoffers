<?= load_layout('app/layouts/header') ?>

    <div id="app">
        <div class="container-fluid">
            <div class="container p-2 pb-5">
                <div class="d-flex justify-content-between">
                    <h4 id="countdown" data-timeout="<?= strtotime('tomorrow') ?>" style="width: 100px;">{{ currentTime }}</h4>
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
                    <div>
                        <a href="<?= url('/logout') ?>" class="btn color-accent text-white btn-narrow mr-0">
                            <?= trans('common.menu.logout') ?>
                        </a>
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
                            <?php if(count((array)$offer['winners'])) { ?>
                                <div class="d-flex justify-content-around mt-5">
                                    <?php foreach($offer['winners'] as $winner) { ?>
                                        <div class="winner-box">
                                            <h6><?= generate_user_id($winner['user']->id) ?></h6>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
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

<?= load_layout('app/layouts/footer') ?>