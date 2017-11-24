<div style="clear: both"></div>
</div>
<section id="contact-us-sec" class="pagesection" style="background: #f8f8f8; padding: 40px 0px;">
    <div class="container">
        <div class="row">
            <div class="full-content">
                <div class="funding-detail">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="service-listing">
                            <div class="col-md-3 kd-services">
                                <p></p>

                                <p class="logo"><?= $this->web_title ?> </p>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12 kd-services">
                                <i class="fa fa-phone thbg-color"></i>
                                <h5><?= __('contact') ?>
                                </h5>

                                <p></p>

                                <p>
                                    <?php foreach ($this->edit_bottom_contact['contact_bottom'] as $contact_bottom) : ?>
                                        <?= $contact_bottom ?>
                                    <?php endforeach; ?>
                                </p>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12 kd-services">
                                <i class="fa fa-phone thbg-color"></i>
                                <h5><?= __('phone') ?>
                                </h5>

                                <p></p>

                                <p>
                                    <?php foreach ($this->edit_bottom_contact['phone_bottom'] as $phone_bottom) : ?>
                                        <?= $phone_bottom ?>
                                    <?php endforeach; ?>
                                </p></div>
                            <div class="col-md-3 col-sm-3 col-xs-12 kd-services">
                                <i class="fa fa-envelope-o thbg-color"></i>
                                <h5><?= __('email'); ?>
                                </h5>

                                <p></p>

                                <p> <?php foreach ($this->edit_bottom_contact['email_bottom'] as $email_bottom) : ?>
                                        <?= $email_bottom ?>
                                    <?php endforeach; ?></p>

                                <p></p></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
</div>
<footer class="footer">
    <div class="container">
        <p class="text-muted">ASowiak 2017 v. <?= APP_VER ?> | <a href="#" data-url="<?= createUrl('admin', 'login') ?>"
                                                                  id="pop-upModal"><?= __('admin_footer') ?></a></p>
    </div>
</footer>
</body>