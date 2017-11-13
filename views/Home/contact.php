<div class="col-md-6">
    <div class="well">
        <fieldset>
            <legend><?= __('contact'); ?></legend>
            <?php
            $message = '';
            foreach ($this->contactAction as $k => $value) :
                $message .= '<div data-content="content" data-id="' . $value['id'] . '" data-controller="' . $value['controller'] . '" data-action="' . $value['action'] . '">' . $value['value'] . '</div>';
            endforeach;
            echo $message;
            ?>
        </fieldset>
    </div>
</div>
<div class="col-md-6">
    <form data-toggle="validator" class="well form-horizontal" action="<?= createUrl('home', 'contactSend'); ?>"
          method="post" id="contact_form">
        <fieldset>

            <!-- Form Name -->
            <legend><?= __('ask_us'); ?></legend>

            <!-- Text input-->

            <div class="form-group">
                <label class="col-md-3 control-label"><?= __('fist_name'); ?>*</label>

                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input required="required" name="first_name" id="first_name" placeholder="<?= __('fist_name'); ?>"
                               class="form-control"
                               type="text">
                    </div>
                </div>
            </div>

            <!-- Text input-->

            <div class="form-group">
                <label class="col-md-3 control-label"><?= __('last_name'); ?>*</label>

                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input required="required" name="last_name" id="last_name" placeholder="<?= __('last_name'); ?>"
                               class="form-control"
                               type="text">
                    </div>
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-3 control-label"><?= __('email'); ?>*</label>

                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input required="required" name="email" id="email" placeholder="<?= __('email'); ?>"
                               class="form-control"
                               type="text">
                    </div>
                </div>
            </div>


            <!-- Text input-->

            <div class="form-group">
                <label class="col-md-3 control-label"><?= __('phone'); ?></label>

                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                        <input name="phone" placeholder="(845)555-1212" class="form-control" type="text">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"><?= __('message'); ?></label>

                <div class="col-md-8 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                        <textarea class="form-control" name="comment"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"></label>

                <div class="col-md-3">
                    <!--                    //= recaptcha_get_html($this->_publickey) ?> -->

                    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                    <div class="g-recaptcha" data-sitekey="<?= $this->_publickey ?>"></div>
                    <noscript>
                        <div>
                            <div style="width: 302px; height: 422px; position: relative;">
                                <div style="width: 302px; height: 422px; position: absolute;">
                                    <iframe
                                        src="https://www.google.com/recaptcha/api/fallback?k=<?= $this->_publickey ?>"
                                        frameborder="0" scrolling="no"
                                        style="width: 302px; height:422px; border-style: none;">
                                    </iframe>
                                </div>
                            </div>
                            <div style="width: 300px; height: 60px; border-style: none;
                   bottom: 12px; left: 25px; margin: 0px; padding: 0px; right: 25px;
                   background: #f9f9f9; border: 1px solid #c1c1c1; border-radius: 3px;">
                                <textarea id="g-recaptcha-response" name="g-recaptcha-response"
                                          class="g-recaptcha-response"
                                          style="width: 250px; height: 40px; border: 1px solid #c1c1c1;
                          margin: 10px 25px; padding: 0px; resize: none;">
                                </textarea>
                            </div>
                        </div>
                    </noscript>
                </div>
            </div>
            <!-- Button -->
            <div class="form-group">
                <label class="col-md-3 control-label"></label>

                <div class="col-md-3">
                    <button type="submit" name="sendContact" value="send" class="btn btn-warning"><?= __('send'); ?>
                        <span
                            class="glyphicon glyphicon-send"></span></button>
                </div>
            </div>
            <p style="font-size: 11px"><?= __('field_is_required') ?></p>
        </fieldset>
    </form>
</div>
<script>
    $(document).ready(function () {
        App.actionClick();
    });
    $('button[type="submit"]').on('click', function (e) {
        if (!App.validateField('first_name')) {
            $("#first_name").attr("data-toggle", "tooltip").attr("data-placement", "top").attr("title", "<?=__("field_required")?>");
            App.init();
            return false;
        }
        if (!App.validateField('last_name')) {
            $("#last_name").attr("data-toggle", "tooltip").attr("data-placement", "top").attr("title", "<?=__("field_required")?>");
            App.init();
            return false;
        }
        if (!App.validateEmail("email")) {
            $("#email").attr("data-toggle", "tooltip").attr("data-placement", "top").attr("title", "<?=__("invalid_email")?>");
            App.init();
            return false;
        }
    });
</script>
