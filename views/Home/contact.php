<div class="case-study-gallery">
    <div class="col-md-12">
        <div class="heading-style3">
            <h2><?= __('menu_contact') ?></h2>
        </div>
    </div>
    <div  class="col-md-12 col-sm-12 col-xs-12" >
        <div class="col-md-6 col-sm-6 col-xs-12">
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
        <div class="col-md-6 col-sm-6 col-xs-12">
            <form data-toggle="validator" class="well form-horizontal" action="<?= createUrl('home', 'contactSend'); ?>"
                  method="post" id="contact_form">
                <fieldset>
                    <legend><?= __('ask_us'); ?></legend>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?= __('fist_name'); ?>*</label>

                        <div class="col-md-8 inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input required="required" name="first_name" id="first_name"
                                       placeholder="<?= __('fist_name'); ?>"
                                       class="form-control"
                                       type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?= __('last_name'); ?>*</label>

                        <div class="col-md-8 inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input required="required" name="last_name" id="last_name"
                                       placeholder="<?= __('last_name'); ?>"
                                       class="form-control"
                                       type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?= __('email'); ?>*</label>

                        <div class="col-md-8 inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                                <input required="required" name="email" id="email" placeholder="<?= __('email'); ?>"
                                       class="form-control"
                                       type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?= __('phone'); ?></label>

                        <div class="col-md-8 inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input name="phone" placeholder="(845)555-1212" class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?= __('message'); ?></label>

                        <div class="col-md-8 inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                <textarea class="form-control" name="comment"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>

                        <div class="col-md-3">
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
                                    class="fa fa-paper-plane"></span></button>
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
    </div>
    </div>