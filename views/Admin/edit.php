<?php
$textArea = $dataTitle = '';
$button = __('save_changes');

if (isset($this->dataEdit)) :
    $textArea = $this->dataEdit;
endif;
if (isset($this->dataTitle)) {
    $dataTitle = $this->dataTitle;
} elseif (isset($this->title)) {
    $dataTitle = $this->title;
};
?>
<div class="modal fade primary" id="bs-modal-edit-post" tabindex="-1" role="modal-dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <form class="form-horizontal" role="form" id="form" method="post" action="<?= createUrl('admin', 'save') ?>">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"
                        id="myModalLabel"><?= $button ?> <?= ucfirst($this->dataController . ' ' . $this->dataAction) . ' ' . $dataTitle ?></h4>
                </div>
                <div class="modal-body">
                    <div id="alerts"></div>
                    <textarea id="editor" contenteditable="true" name="description_<?= $this->dataLanguage ?>"
                              style="overflow: auto; display: none"><?= $textArea ?></textarea>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="dataController" value="<?= $this->dataController ?>"/>
                    <input type="hidden" name="dataAction" value="<?= $this->dataAction ?>"/>
                    <input type="hidden" name="language" value="<?= $this->dataLanguage ?>"/>
                    <input type="hidden" name="dataId" value="<?= $this->dataId ?>"/>
                    <input type="hidden" name="action" value="update"/>

                    <?= (isset($this->pin_realization)) ? '<button type="button" class="btn btn-default pin-btn" data-url="pinImages" data-type="realization">' . __('pin_realization') . '</button>' : '' ?>
                    <?= (isset($this->pin_images)) ? '<button type="button" class="btn btn-default pin-btn"  data-url="pinImages" data-type="product_id">' . __('pin_product_id') . '</button>' : '' ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= __('cancel') ?></button>
                    <button type="submit" class="btn btn-primary"><?= $button ?></button>
                </div>
                <div class="pinned"></div>
            </div>

            <script>
                $('.pin-btn').on('click', function () {
                    $.post('<?=createUrl('admin', 'loadViewFile')?>', {controllerData: 'admin', actionData: $(this).attr('data-url'), useController: true, dataType: $(this).attr('data-type') }, function (data) {
                        $('.modal').find('.pinned').html(data);
                    })
                })
            </script>
        </div>
    </form>
</div>