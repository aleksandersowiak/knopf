
<?php
if(empty($viewmodel)) :
    echo '<div class="alert alert-info col-md-6 col-sm-6 col-mx-6">'.__('no_products').'</div>';
else :
?>
    <div class="col-md-12">
        <div class="heading-style3">
            <h2><?= __('products')?></h2>
        </div>
    </div>
    <div class="case-study-gallery">
    <?php foreach ($viewmodel as $key => $value) :  ?>
    <div class="case-study case-study-active col-md-4 col-sm-4 col-xs-12">
            <img class="col-md-12 col-sm-12 col-xs-12" style=" max-height:290px;  min-height:290px; background: url(<?= $value['image_thumb'] ?>) no-repeat 50% 50%; background-size:cover;"/>
        <div class="case-study__overlay case-study__overlay-sets col-md-12 col-sm-12 col-xs-12">
            <h2 class="case-study__title"><?= $value['title'] ?></h2>
            <p class="case-study__description"><?= $this->_baseHelper->restrictText($value['description'], 100, true) ?></p>
            <a class="case-study__link" href="<?= createUrl('products', 'read') ?>/<?= $value['id'] ?>"><?= __('show') ?></a>
        </div>
</div>

    <?php endforeach; ?>
</div>
<?php endif; ?>