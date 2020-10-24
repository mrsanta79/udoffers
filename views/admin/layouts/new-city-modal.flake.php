<div class="modal fade" id="new-city-modal" tabindex="-1" role="dialog" aria-labelledby="new-city-modal"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="new-city-modal">Create New City</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= api('/admin/cities/create') ?>" name="create-city" method="post" @submit.prevent="createCity">
                <div class="modal-body">
                    <div class="md-form mt-0">
                        <input type="text" id="name" name="name" class="form-control" autocomplete="off" v-model="cityForm.name" required>
                        <label for="name">City Name</label>
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