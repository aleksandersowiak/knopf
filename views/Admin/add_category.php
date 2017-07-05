<div class="modal fade primary" id="bs-modal-edit-post" tabindex="-1" role="modal-dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <form class="form-horizontal" role="form" id="form" method="post" action="<?= createUrl('admin', 'save') ?>">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?= __('add') ?> </h4>
                </div>
                <div class="modal-body">
                    <p>
                    <div class="form-group"><label class="col-sm-1 control-label" for="title"><?= __('category') ?></label>
                        <div class="col-sm-11">
                            <input type="text" required="required" id="title" name="category_<?= $this->language ?>"
                                   class="form-control" placeholder="<?= __('add') ?> <?= __('category') ?>"/>
                        </div>
                    </div>
                    </p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="dataController" value="category"/>
                    <input type="hidden" name="dataAction" value="<?= $this->dataAction ?>"/>
                    <input type="hidden" name="language" value="<?= $this->language ?>"/>
                    <input type="hidden" name="action" value="insert"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= __('cancel') ?></button>
                    <button type="submit" class="btn btn-primary"><?= __('add') ?></button>
                </div>
            </div>
        </div>
    </form>
</div>