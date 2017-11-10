<div class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h5 class="modal-title"><?= __('add') ?></h5>
            </div>
            <form role="form" method="post" action="<?= createUrl('admin', 'save') ?>">
                <div class="modal-body">

                    <div class="panel panel-warning">
                        <div class="panel-heading"><h3 class="panel-title"><?= __('are_you_sure') ?></h3></div>
                        <div class="panel-body">
                            <div class="input-group ">
                                <span class="input-group-addon" id="basic-addon3"><?= $_SERVER['SERVER_NAME'] ?>/</span>

                                <div class="input-group-btn">
                                    <div class="form-group">
                                        <input type="hidden" name="action" value="insert"/>
                                        <input type="hidden" name="language" value="<?= $_GET['language'] ?>"/>
                                        <input type="hidden" name="dataController"
                                               value="<?= $this->dataController ?>"/>
                                        <select name="value" required="required" class="form-control add-new-select"
                                                id="sel1">
                                            <option value="" selected><?= __('please_select') ?></option>
                                            <?php foreach ($this->contentAdd as $controller => $action) : ?>
                                                <option
                                                    value="<?= $this->dataController . '/' . $action ?>"><?= __('menu_' . $action) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" required="required"
                                    class="btn btn-success"><?= __('add') ?></button>
                        </div>
                    </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


