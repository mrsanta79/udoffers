<?= load_layout('admin/layouts/header', null, $page_name) ?>

<div id="app">
    <div class="container-fluid">
        <div class="page-heading d-flex justify-content-between">
            <h1><?= trans('common.menu.entry_types') ?></h1>
            <button type="button" class="btn btn-narrow color-secondary text-white mx-0" data-toggle="modal" data-target="#new-entry-modal">
                <i class="fas fa-plus mr-2"></i>
                <?= trans('common.menu.entry_type') ?>
            </button>
        </div>
        <div class="table mt-5">
            <?php if(isset($data['cities']) && count($data['cities'])) {
                ?>
                <table class="table table-hover datatable card" id="entries-table">
                    <thead>
                        <tr>
                            <th><?= trans('pages.fields.entry_name') ?></th>
                            <th><?= trans('pages.fields.background') ?></th>
                            <th><?= trans('pages.fields.added_by') ?></th>
                            <th><?= trans('pages.fields.added_on') ?></th>
                            <th class="actions"><?= trans('common.actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['entries'] as $index => $entry) { ?>
                            <tr data-id="<?= $entry['id'] ?>">
                                <td><?= $entry['name'] ?></td>
                                <td style="text-transform: uppercase">
                                    <div class="d-flex flex-row">
                                        <span style="width: 20px; height: 20px; border-radius: 100%; background: <?= $entry['background'] ?>"
                                              class="d-inline-block mr-2">
                                        </span>
                                        <?= $entry['background'] ?>
                                    </div>
                                </td>
                                <td><?= $entry['creator']->name ?> (<?= $entry['creator']->email ?>)</td>
                                <td><?= date('d/m/Y', $entry['created_at']) ?></td>
                                <td class="actions">
                                    <a href="<?= api('/admin/entries/delete?id=') ?>" type="button" class="btn-floating icon-btn delete-entry" data-id="<?= $entry['id'] ?>" @click.prevent="deleteEntry">
                                        <i class="fas fa-trash waves-effect" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <div class="text-center" style="display: none">
                    <h4 class="mt-3"><?= trans('pages.fields.no_entry_found') ?></h4>
                </div>
            <?php } ?>
        </div>

        <div class="page-heading d-flex justify-content-between mt-5">
            <h1><?= trans('common.menu.cities') ?></h1>
            <button type="button" class="btn btn-narrow color-secondary text-white mx-0" data-toggle="modal" data-target="#new-city-modal">
                <i class="fas fa-plus mr-2"></i>
                <?= trans('common.menu.city') ?>
            </button>
        </div>
        <div class="table mt-5">
            <?php if(isset($data['cities']) && count($data['cities'])) {
                ?>
                <table class="table table-hover datatable card" id="cities-table">
                    <thead>
                        <tr>
                            <th><?= trans('pages.fields.city_name') ?></th>
                            <th><?= trans('pages.fields.added_by') ?></th>
                            <th><?= trans('pages.fields.added_on') ?></th>
                            <th class="actions"><?= trans('common.actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['cities'] as $index => $city) { ?>
                            <tr data-id="<?= $city['id'] ?>">
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
                    <h4 class="mt-3"><?= trans('pages.fields.no_city_found') ?></h4>
                </div>
            <?php } ?>
        </div>
    </div>

    <?= load_layout('admin/layouts/new-entry-modal') ?>
    <?= load_layout('admin/layouts/new-city-modal') ?>
</div>

<?= load_layout('admin/layouts/footer') ?>