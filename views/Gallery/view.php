
    <div class='list-group gallery'>

    </div>

<script>
    $(document).ready(function () {
<?php foreach ($viewmodel as $image) : ?>
    $('.gallery').append('<div class="images" style="display: none">' +
        '<a class="fancybox thumbnail" rel="ligthbox" href="<?=$image['image']?>">' +
        '<img style="max-height:150px; min-height:150px;  min-width:150px;  max-width:150px;  overflow: hidden; background: url(<?= $image['image'] ?>) no-repeat 50% 50%; background-size:cover;"/>'+
        '</a>'+
        '</div>');
<?php endforeach; ?>
        $('.gallery').find('div').each(function(i,el) {
            $(el).fadeIn('slow');
        })
    })
</script>