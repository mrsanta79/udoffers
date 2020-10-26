<div class="modal fade" id="new-entry-modal" tabindex="-1" role="dialog" aria-labelledby="new-entry-modal"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="new-entry-modal">Create New Entry Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= api('/admin/entries/create') ?>" name="create-entry" method="post" @submit.prevent="createEntry">
                <div class="modal-body">
                    <div class="md-form">
                        <input type="text" id="entry_name" name="name" class="form-control" v-model="entryForm.name" required autocomplete="off">
                        <label for="entry_name">Entry Name</label>
                    </div>
                    <div class="md-form">
                        <input type="text" id="color" name="color" class="form-control" v-model="entryForm.color" required autocomplete="off">
                        <label for="color">Background Color</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-narrow color-secondary text-white" :class="isProcessing ? 'disabled' : ''">
                        <i class="fa fa-spinner fa-spin" v-if="isProcessing"></i>
                        <span class="font-weight-bold" v-if="!isProcessing">Create</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>