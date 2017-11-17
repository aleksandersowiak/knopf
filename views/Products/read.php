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
            <div class='col-md-6 gallery images <?=($image['type'] == 1) ? 'images-box-'.$image['id'] : 'video-box-'.$image['id']?>'>
                <script>App.thumbVideo(<?=$image['id']?>,'<?=$image['image']?>','<?= $image['image_thumb'] ?>',<?=$image['type']?>);
                $('.<?=($image['type'] == 1) ? 'images-box-'.$image['id'] : 'video-box-'.$image['id']?> img').addClass('smallImageView');
                </script>
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
            <div class="col-xs-6 col-md-2 realization images <?=($image_realization['type'] == 1) ? 'images-box-'.$image_realization['id'] : 'video-box-'.$image_realization['id']?>">
                <script>
                    App.thumbVideo(<?=$image_realization['id']?>,'<?=$image_realization['image']?>','<?=$image_realization['image_thumb'] ?>',<?=$image_realization['type']?>);
                    $('.<?=($image_realization['type'] == 1) ? 'images-box-'.$image_realization['id'] : 'video-box-'.$image_realization['id']?> img').addClass('smallImageView');
                </script>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<style>

    span.text-content, span.text-content span{
        width: 90% !important;
        height: 102px !important;
        position: absolute !important;
        left: 5% !important;
        margin: 15% auto !important;
    }
    span.text-content {
        margin: 0 !important;
    }
</style>