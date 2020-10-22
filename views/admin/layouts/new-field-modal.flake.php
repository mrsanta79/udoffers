<div class="modal fade" id="new-field-modal" tabindex="-1" role="dialog" aria-labelledby="new-field-modal"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="new-field-modal">Create New Field</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= api('/admin/field') ?>" name="create-field" method="post" @submit.prevent="createField">
                <div class="modal-body">
                    ...
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