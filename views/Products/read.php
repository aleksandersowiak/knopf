<div class="page-header">
    <h1><?= $this->title ?></h1>
</div>
<div class="row">
    <div class="col-md-8">
        <p>
            <?= $this->description ?>
        </p>
    </div>
    <div class="col-md-3 ">
        <?php foreach ($this->image as $image) : ?>
            <div class='col-md-12'>
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
                        style="height: 150px; width: 100%;overflow: hidden; background: url(<?= $image_realization['image_thumb'] ?>) no-repeat 50% 50%; background-size:cover;"/>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>