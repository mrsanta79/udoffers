<div class="modal fade" id="new-offer-modal" tabindex="-1" role="dialog" aria-labelledby="new-offer-modal"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="new-offer-modal"><?= trans('modals.create_new_offer') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= api('/admin/offers/create') ?>" name="create-offer" method="post" @submit.prevent="createOffer">
                <div class="modal-body">
                    <div class="md-form mt-0">
                        <input type="text" id="date" name="date" class="form-control datepicker" autocomplete="off" data-date-container='#new-offer-modal' v-model="offerForm.date" required>
                        <label for="date"><?= trans('modals.date') ?></label>
                    </div>
                    <div class="md-form">
                        <select class="browser-default custom-select" name="city" @change="offerForm.city = event.target.value">
                            <option selected disabled><?= trans('modals.city') ?></option>
                            <?php
                                if(isset($data) && isset($data['cities']) && count($data['cities'])) {
                                    foreach ($data['cities'] as $city) {
                                        ?>
                                        <option value="<?= $city['id'] ?>"><?= $city['name'] ?></option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="md-form">
                        <select class="browser-default custom-select" name="entry_type" @change="offerForm.entry_type = event.target.value">
                            <option selected disabled><?= trans('modals.type_of_entry') ?></option>
                            <?php
                            if(isset($data) && isset($data['entries']) && count($data['entries'])) {
                                foreach ($data['entries'] as $entry) {
                                    ?>
                                    <option value="<?= $entry['id'] ?>">
                                        <?= $entry['name'] ?>
                                        (<?= $entry['background'] ?>)
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="md-form">
                        <select class="browser-default custom-select" name="winners_count" @change="offerForm.winners_count = event.target.value">
                            <option selected><?= trans('modals.number_of_winners') ?></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                    <div class="md-form">
                        <input type="text" id="shop" name="shop" class="form-control" v-model="offerForm.shop" required>
                        <label for="shop"><?= trans('modals.shop_name') ?></label>
                    </div>
                    <div class="md-form">
                        <input type="text" id="discount" name="discount" class="form-control" v-model="offerForm.discount" required>
                        <label for="discount"><?= trans('modals.discount_details') ?></label>
                    </div>
                    <div class="md-form">
                        <input type="text" id="information" name="information" class="form-control" v-model="offerForm.information">
                        <label for="information"><?= trans('modals.information') ?></label>
                    </div>
                    <div class="md-form">
                        <input type="text" id="map_link" name="map_link" class="form-control" v-model="offerForm.map_link" required>
                        <label for="map_link"><?= trans('modals.google_map_link') ?></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-narrow color-secondary text-white" :class="isProcessing ? 'disabled' : ''">
                        <i class="fa fa-spinner fa-spin" v-if="isProcessing"></i>
                        <span class="font-weight-bold" v-if="!isProcessing"><?= trans('buttons.create') ?></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>