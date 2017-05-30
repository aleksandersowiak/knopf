<div class="row">
    <?php foreach ($viewmodel as $key => $value) : ?>

        <div class="col-sm-5 col-md-3">
            <div class="thumbnail">

                <img style="max-height:150px; min-height:150px;  min-width:250px;  max-width:250px;  overflow: hidden; background: url(<?= $value['image'] ?>) no-repeat 50% 50%; background-size:cover;"/>
                <div class="caption">
                    <h4><?= $value['title'] ?></h4>
                    <p><?= $this->_baseHelper->restrictText($value['description'], 125, true) ?></p>
                    <p><a href="<?= createUrl('products', 'read') ?>/<?= $value['id'] ?>" class="btn btn-default"
                          role="button"><?= __('show') ?></a></p>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
</div>