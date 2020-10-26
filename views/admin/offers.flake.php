<?= load_layout('admin/layouts/header', null, $page_name) ?>

    <div id="app">
        <div class="container-fluid">
            <div class="page-heading d-flex justify-content-between">
                <h1>Offers</h1>
                <button type="button" class="btn btn-narrow color-secondary text-white mx-0" data-toggle="modal" data-target="#new-offer-modal">
                    <i class="fas fa-plus mr-2"></i>
                    Offer
                </button>
            </div>

            <div class="table mt-5">
                <div class="text-center" :class="!isFetchingData ? 'd-none' : ''">
                    <i class="fa fa-spinner fa-spin" style="font-size: 40px;"></i>
                    <br>
                    <h4 class="mt-3">Loading data...</h4>
                </div>
                <table class="table table-hover card" id="offers-table" style="display: none" :class="!isFetchingData ? 'd-table' : ''" v-if="offers" data-offers-url="<?= api('/admin/offers') ?>">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>City</th>
                            <th>Entry Type</th>
                            <th>No. of winners</th>
                            <th>Shop</th>
                            <th>Information</th>
                            <th>Map</th>
                            <th>Author</th>
                            <th>Added On</th>
                            <th class="actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(offer, index) in offers" :data-id="offer.id">
                            <td>{{ offer.date }}</td>
                            <td>{{ offer.city.name }}</td>
                            <td>
                                <div class="d-flex flex-row">
                                    <span style="width: 20px; height: 20px; border-radius: 100%;" :style="{ background: offer.entry_type.background }"
                                          class="d-inline-block mr-2">
                                    </span>
                                    {{ offer.entry_type.name }}
                                    ({{ offer.entry_type.background }})
                                </div>
                            </td>
                            <td>{{ offer.winners_count }}</td>
                            <td>{{ offer.shop }}</td>
                            <td>{{ offer.information || '-' }}</td>
                            <td>
                                <a :href="offer.map_link" class="text-primary" target="_blank">
                                    Open Map
                                </a>
                            </td>
                            <td>{{ offer.creator.name }} ({{ offer.creator.email }})</td>
                            <td>{{ dateFormat(offer.created_at) }}</td>
                            <td class="actions">
                                <a href="<?= api('/admin/offers/delete?id=') ?>" type="button" class="btn-floating icon-btn delete-offer" :data-id="offer.id" @click.prevent="deleteOffer">
                                    <i class="fas fa-trash waves-effect" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center" style="display: none" :class="isFetchingData ? 'd-none' : 'd-block'" v-if="!offers">
                    <h4 class="mt-3">No offer found</h4>
                </div>
            </div>
        </div>

        <?= load_layout('admin/layouts/new-offer-modal', $data) ?>
    </div>

<?= load_layout('admin/layouts/footer') ?>