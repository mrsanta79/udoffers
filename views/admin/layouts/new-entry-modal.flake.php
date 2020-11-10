<div class="modal fade" id="new-entry-modal" tabindex="-1" role="dialog" aria-labelledby="new-entry-modal"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="new-entry-modal"><?= trans('modals.create_new_entry_type') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= api('/admin/entries/create') ?>" name="create-entry" method="post" @submit.prevent="createEntry">
                <div class="modal-body">
                    <div class="md-form mt-0">
                        <input type="text" id="entry_name" name="name" class="form-control" v-model="entryForm.name" required autocomplete="off">
                        <label for="entry_name"><?= trans('modals.entry_name') ?></label>
                    </div>
                    <div class="md-form">
                        <span class="d-block"><?= trans('modals.background') ?></span>
                        <div class="d-flex flex-row mt-2">
                            <input type="color" id="background" name="background" class="d-block w-100" v-model="entryForm.background">
                            <span class="ml-2 text-right" style="text-transform: uppercase; width: 100px;">
                                {{ entryForm.background }}
                            </span>
                        </div>
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