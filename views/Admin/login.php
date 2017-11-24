<div class="modal fade " tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content col-md-6 col-lg-offset-3">
            <form role="form" method="post" action="<?= createUrl('admin', 'setSession') ?>">
                <div class="form-group text-center">
                    <div class="logo">
                        <span class="fa fa-user-circle-o" style="font-size:10em; color : #f8f8f8;"></span>
                    </div>
                </div>
                <div class="modal-body ">
                    <div class="form-group">
                        <input type="text" required="required" class="form-control input-lg" name="userName" id="userid"
                               placeholder="<?= __('username') ?>">
                    </div>
                    <div class="form-group">
                        <input type="password" required="required" class="form-control input-lg" name="userPassword"
                               id="password" placeholder="<?= __('password') ?>">
                    </div>
                    <div class="form-group">
                        <button type="submit" required="required"
                                class="btn btn-default btn-lg btn-block btn-success"><?= __('log_in') ?></button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


