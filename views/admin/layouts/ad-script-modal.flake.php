<div class="modal fade" id="ad-script-modal" tabindex="-1" role="dialog" aria-labelledby="ad-script-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ad-script-modal"><?= trans('modals.update_ad_script') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= api('/admin/ad-script/update') ?>" name="update-ad-script" method="post" @submit.prevent="updateAdScript">
                <div class="modal-body">
                    <div class="form-group">
                        <label><?= trans('modals.script') ?></label>
                        <textarea name="script" class="form-control" autocomplete="off" required><?= html_entity_decode(trim($data['script']['script'])) ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-narrow color-secondary text-white" :class="isProcessing ? 'disabled' : ''">
                        <i class="fa fa-spinner fa-spin" v-if="isProcessing"></i>
                        <span class="font-weight-bold" v-if="!isProcessing"><?= trans('buttons.update') ?></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>