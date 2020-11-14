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
                    <?php
                        $top_ad = array_filter($data['ads'], function($item) {
                            $item = $item['position'] == 'top';
                            return $item;
                        })[0];
                        $right_ad = array_filter($data['ads'], function($item) {
                            $item = $item['position'] == 'right';
                            return $item;
                        })[1];
                        $bottom_ad = array_filter($data['ads'], function($item) {
                            $item = $item['position'] == 'bottom';
                            return $item;
                        })[2];
                        $left_ad = array_filter($data['ads'], function($item) {
                            $item = $item['position'] == 'left';
                            return $item;
                        })[3];
                    ?>
                    <div class="form-group">
                        <label><?= trans('modals.top_script') ?></label>
                        <textarea name="top_script" id="top_script" class="form-control" autocomplete="off"><?= html_entity_decode(trim($top_ad['script'])) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label><?= trans('modals.bottom_script') ?></label>
                        <textarea name="bottom_script" id="bottom_script" class="form-control" autocomplete="off"><?= html_entity_decode(trim($bottom_ad['script'])) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label><?= trans('modals.left_script') ?></label>
                        <textarea name=left_script" id="left_script" class="form-control" autocomplete="off"><?= html_entity_decode(trim($left_ad['script'])) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label><?= trans('modals.right_script') ?></label>
                        <textarea name="right_script" id="right_script" class="form-control" autocomplete="off"><?= html_entity_decode(trim($right_ad['script'])) ?></textarea>
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