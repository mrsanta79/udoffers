<?= load_layout('admin/layouts/header', $page_name) ?>

<div id="app">
    <div class="container-fluid">
        <div class="page-heading d-flex justify-content-between">
            <h1>Fields</h1>
            <button type="button" class="btn btn-narrow color-secondary text-white" data-toggle="modal" data-target="#new-field-modal">
                <i class="fas fa-plus mr-2"></i>
                Field
            </button>
        </div>
    </div>

    <?= load_layout('admin/layouts/new-field-modal') ?>
</div>

<?= load_layout('admin/layouts/footer') ?>