<div class="case-study-gallery">
<div class="col-md-12">
    <div class="heading-style3">
        <h2><?= __('menu_product') ?></h2>
    </div>
</div>
<?php
if (empty($viewmodel)) :
    echo '<div class="container"><div class="alert alert-info col-md-12 col-sm-12 col-xs-12 center-block">' . __('no_products') . '</div></div>';
else :
    ?>


        <?php foreach ($viewmodel as $key => $value) : ?>
            <div class="case-study case-study-active col-md-4 col-sm-4 col-xs-12 no-padding" style="background: url(<?= $value['image_thumb'] ?>) no-repeat 50% 50%; background-size:cover;">
                <div class="case-study__overlay case-study__overlay-sets col-md-12 col-sm-12 col-xs-12">
                    <h2 class="case-study__title"><?= $value['title'] ?></h2>
                    <p class="case-study__description"><?= $this->_baseHelper->restrictText($value['description'], 100, true) ?></p>
                    <a class="case-study__link"
                       href="<?= createUrl('products', 'read') ?>/<?= $value['id'] ?>"><?= __('show') ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
