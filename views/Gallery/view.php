<div class='list-group gallery'>

</div>

<script>
    $(document).ready(function () {
        <?php foreach ($viewmodel as $image) : ?>
        console.log('<?=json_encode($image)?>');
        $('.gallery').append('<div class="images <?=($image['type'] == 1) ? 'images-box-'.$image['id'] : 'video-box-'.$image['id']?>" " style="display: none"></div>');
        App.thumbVideo(<?=$image['id']?>,'<?=$image['image']?>','<?= $image['image_thumb'] ?>',<?=$image['type']?>);
        <?php endforeach; ?>
        $('.gallery').find('div.images').each(function (i, el) {
            $(el).fadeIn('slow');
        })
    });
</script>

