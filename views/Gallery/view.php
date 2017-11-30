<script>
    $(document).ready(function () {
        <?php $i = 0 ; foreach ($viewmodel as $image) : ?>
        $('.gal-container').append('<div class="col-md-<?=($i%9) ? '4' : '8' ?> col-sm-<?=($i%9) ? '6' : '12' ?> '+
            'co-xs-12 gal-item <?=($image['type'] == 1) ? '' : 'gal-item-video' ?>">'+
            '<div class="box imagess <?=($image['type'] == 1) ? 'images-box-'.$image['id'] : 'video-box-'.$image['id']?>" style="display: none"></div>');
        App.thumbVideo(<?=$image['id']?>, '<?=$image['image']?>', '<?= $image['image_thumb'] ?>', <?=$image['type']?>);
        <?php $i++; endforeach; ?>
        $('.gal-container').find('div.imagess').each(function (i, el) {
            $(el).fadeIn('slow');
        })
    });
</script>

<section>
    <div class="gal-container container">

    </div>
</section>