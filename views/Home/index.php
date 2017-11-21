<?php if (!empty($this->slide)) : ?>
    <div class="carousel slide" id="carousel-example-generic" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php $j = 0;
            foreach ($this->slide as $element) : ?>
                <li data-target="#carousel-example-generic" data-slide-to="<?= $j ?>"
                    class="<?= ($j == 0) ? "active" : "" ?>"></li>
                <?php $j++; endforeach; ?>
        </ol>
        <div class="carousel-inner" role="listbox">
            <?php $k = 0;
            foreach ($this->slide as $element_display) :?>
                <div class="item <?= ($k == 0) ? "active" : "" ?>">

                    <div role="image" data-src="holder.js/auto/auto/#11/" alt=""
                         style="max-width:100%; max-height:350px; min-width:100%; min-height:350px; overflow: hidden; background: url(<?= $element_display['image'] ?>) no-repeat 50% 50%; background-size:cover;"
                         data-holder-rendered="true"></div>

                    <div class="carousel-caption" style="    background-color: rgba(0,0,0, 0.4);">
                        <h3><a href="<?= createUrl('products', 'read') ?>/<?= $element_display['id'] ?>" class="slide-link"><?= $element_display['title']; ?></a></h3>

                        <p><?= $this->_heleper->restrictText($element_display['description'], 100, true) ?></p>
                    </div>
                </div>
                <?php $k++; endforeach; ?>
        </div>
    </div>
<?php endif; ?>
<div class="container">
<?php
$message = '';
foreach ($this->indexAction as $k => $value) :
    $message .= '<div data-content="content" data-id="' . $value['id'] . '" data-controller="' . $value['controller'] . '" data-action="' . $value['action'] . '">' . $value['value'] . '</div>';
endforeach;
echo $message;
?>
</div>
<script>
    var image_element = $('.carousel-inner .item div[role="image"]'),
         image_url;
    $.each(image_element, function(i,e) {
        var image_element_css = $(e).css('background');
        var image;
        image_url = image_element_css.match(/^.*url\("?(.+?)"?\).*$/);
        if (image_url[1]) {
            image_url = image_url[1];
            image = new Image();
            image.src = image_url;
            $(image).on('load', function () {
                $('.carousel-inner').css({width: $('.carousel-inner').width(), border: '1px solid #ccc'})
                if (image.width < $('.carousel-inner').width()) {
                    $(e).css({'max-width': image.width, 'min-width': image.width, display: 'block', margin: 'auto' });

                }
            });
        }
    })

</script>