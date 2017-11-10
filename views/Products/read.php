<div class="page-header">
    <h1><?= $this->title ?></h1>
</div>
<div class="row">
    <div class="col-md-2">
        <div class="list-group">
            <?php foreach ($this->product_list as $element) : ?>
                <a class="list-group-item list-group-item-action <?= ($this->title == $element['title']) ? 'active' : '' ?>"
                   href="<?= createUrl('products', 'read') ?>/<?= $element['id'] ?>"><?= $element['title'] ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-md-7">
        <p>
            <?= $this->description ?>
        </p>
    </div>
    <div class="col-md-3 ">
        <?php foreach ($this->image as $image) : ?>
            <div class='col-md-6'>
                <a class="thumbnail fancybox" rel="ligthbox" href="<?= $image['image'] ?>">
                    <img class="img-responsive" alt="" src="<?= $image['image_thumb'] ?>"/>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php if ($this->realization != NULL) : ?>
    <div class="page-header">
        <h3><?= __('realization') ?></h3>
    </div>
    <div class="row">
        <?php foreach ($this->realization as $image_realization): ?>
            <div class="col-xs-6 col-md-3">
                <a class="thumbnail fancybox" rel="ligthbox" href="<?= $image_realization['image'] ?>">
                    <img
                        style="height: 150px; width: 100%;overflow: hidden; background: url(<?= str_replace(' ' , '%20', $image_realization['image_thumb']) ?>) no-repeat 50% 50%; background-size:cover;"/>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>