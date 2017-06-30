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

                    <img data-src="holder.js/auto/auto/#11/" alt=""
                         style="max-width:100%; max-height:250px; min-width:100%; min-height:250px; overflow: hidden; background: url(<?= $element_display['image'] ?>) no-repeat 50% 50%; background-size:cover;"
                         data-holder-rendered="true">

                    <div class="carousel-caption">
                        <h3><?= $element_display['title']; ?></h3>

                        <p><?= $this->_heleper->restrictText($element_display['description'], 100, true) ?></p>
                    </div>
                </div>
                <?php $k++; endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<?php
$message = '';
foreach ($this->indexAction as $k => $value) :
    $message .= '<div data-content="content" data-id="' . $value['id'] . '" data-controller="' . $value['controller'] . '" data-action="' . $value['action'] . '">' . $value['value'] . '</div>';
endforeach;
echo $message;
?>
