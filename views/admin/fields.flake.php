<?= load_layout('admin/layouts/header', null, $page_name) ?>

<div id="app">
    <div class="container-fluid">
        <div class="page-heading d-flex justify-content-between">
            <h1>Entry Types</h1>
            <button type="button" class="btn btn-narrow color-secondary text-white mx-0" data-toggle="modal" data-target="#new-entry-modal">
                <i class="fas fa-plus mr-2"></i>
                Entry Type
            </button>
        </div>
        <div class="table mt-5">
            <?php if(isset($data['cities']) && count($data['cities'])) {
                ?>
                <table class="table table-hover datatable card" id="entries-table">
                    <thead>
                    <tr>
                        <th>Entry ID</th>
                        <th>Entry Type</th>
                        <th>Background Image</th>
                        <th>Added On</th>
                        <th class="actions">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($data['cities'] as $index => $city) { ?>
                        <tr data-id="<?= $city['id'] ?>">
                            <td>#<?= $index + 1 ?></td>
                            <td><?= $city['name'] ?></td>
                            <td><?= $city['name'] ?></td>
                            <td><?= date('d/m/Y', $city['created_at']) ?></td>
                            <td class="actions">
                                <a href="<?= api('/admin/entries/delete?id=') ?>" type="button" class="btn-floating icon-btn delete-entry" data-id="<?= $city['id'] ?>" @click.prevent="deleteEntry">
                                    <i class="fas fa-trash waves-effect" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <div class="text-center" style="display: none">
                    <h4 class="mt-3">No entry found</h4>
                </div>
            <?php } ?>
        </div>

        <div class="page-heading d-flex justify-content-between mt-5">
            <h1>Cities</h1>
            <button type="button" class="btn btn-narrow color-secondary text-white mx-0" data-toggle="modal" data-target="#new-city-modal">
                <i class="fas fa-plus mr-2"></i>
                City
            </button>
        </div>
        <div class="table mt-5">
            <?php if(isset($data['cities']) && count($data['cities'])) {
                ?>
                <table class="table table-hover datatable card" id="cities-table">
                    <thead>
                        <tr>
                            <th>City ID</th>
                            <th>City Name</th>
                            <th>Added By</th>
                            <th>Added On</th>
                            <th class="actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['cities'] as $index => $city) { ?>
                            <tr data-id="<?= $city['id'] ?>">
                                <td>#<?= $index + 1 ?></td>
                                <td><?= $city['name'] ?></td>
                                <td><?= $city['creator']->name ?> (<?= $city['creator']->email ?>)</td>
                                <td><?= date('d/m/Y', $city['created_at']) ?></td>
                                <td class="actions">
                                    <a href="<?= api('/admin/cities/delete?id=') ?>" type="button" class="btn-floating icon-btn delete-city" data-id="<?= $city['id'] ?>" @click.prevent="deleteCity">
                                        <i class="fas fa-trash waves-effect" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <div class="text-center" style="display: none">
                    <h4 class="mt-3">No city found</h4>
                </div>
            <?php } ?>
        </div>
    </div>

    <?= load_layout('admin/layouts/new-entry-modal') ?>
    <?= load_layout('admin/layouts/new-city-modal') ?>
</div>

<?= load_layout('admin/layouts/footer') ?>