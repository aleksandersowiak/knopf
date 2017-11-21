<div class="case-study-gallery">
<div class="col-md-12">
    <!--// Content Information //-->
    <div class="heading-style3">
        <h2><?= __('gallery')?></h2>
    </div>
</div>
<?php
if (empty($viewmodel)) :
    echo '<div class="alert alert-info">' . __('no_images') . '</div>';
else :
    ?>
<!--    <div class="list-group gallery">-->

    <?php
    $j = 1;
    foreach ($viewmodel as $category => $images) : ?>
        <?php $attr = array();
        $i = 0;
        $style = $style1 = $style2 = $class = $class1 = $class2 = '';
        $style3 = 'height: 289px';
        foreach ($images as $image) :
            if (file_exists(APPLICATION_PATH . $image) && @getimagesize(APPLICATION_PATH . $image)) :
                if ($i <= 1) {
                    $attr[0][] = $image;
                    $class = 'width: 100%; float: left';
                    $style = 'width:100%; max-height:290px;  min-height:290px;';
                } else if ($i > 1 && $i <= 3) {
                    $attr[1][] = $image;
                    $class = 'width: 50%; float: left';
                    $style = ' max-height:290px; min-height:290px;';
                    $class1 = 'width: 50%; float: left';
                    $style1 = 'width:100%; max-height:290px;min-height:290px;';
                } else if ($i > 3 && $i <= 5) {
                    $attr[2][] = $image;
                    $class = 'width: 50%; float: left';
                    $style = 'width:100%; max-height:145px; min-height:145px;';
                    $class1 = 'width: 50%; float: left';
                    $style1 = 'width:100%; max-height:145px;  min-height:145px;';
                    $class2 = 'width: 100%; float: left';
                    $style2 = 'width:100%; max-height:145px;  min-height:145px;';
                    $style3 = '';
                }
                $i++;
            endif;
        endforeach; ?>
            <div class="case-study col-md-4 col-sm-4 col-xs-12">
                <div>
                    <?php if (!empty($attr[0])) : ?>
                        <div style="<?= $class ?>">
                            <div id="tile1" class="tile">
                                <div class="carousel slide" data-ride="carousel">
                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner">
                                        <?php $i = 0;
                                        foreach ($attr[0] as $img) : ?>
                                            <div class="item <?= ($i == 0) ? 'active' : '' ?>">
                                                <div
                                                    style="<?= $style ?> overflow: hidden; background: url(<?= $img ?>) no-repeat 50% 50%; background-size:cover;"
                                                    class="img-responsive"></div>
                                            </div>
                                            <?php $i++; endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif;
                    if (!empty($attr[1])) : ?>
                        <div style="<?= $class1 ?>">
                            <div id="tile2" class="tile">

                                <div class="carousel slide" data-ride="carousel">
                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner">
                                        <?php $i = 0;
                                        foreach ($attr[1] as $img) : ?>
                                            <div class="item <?= ($i == 0) ? 'active' : '' ?>">
                                                <div
                                                    style="<?= $style1 ?> overflow: hidden; background: url(<?= $img ?>) no-repeat 50% 50%; background-size:cover;"
                                                    class="img-responsive"></div>
                                            </div>
                                            <?php $i++; endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($attr[2])) : ?>
                    <div>
                        <div style="<?= $class2 ?>">
                            <div id="tile3" class="tile">

                                <div class="carousel slide" data-ride="carousel">
                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner">
                                        <?php $i = 0;
                                        foreach ($attr[2] as $img) : ?>
                                            <div class="item <?= ($i == 0) ? 'active' : '' ?>">
                                                <div
                                                    style="<?= $style2 ?> overflow: hidden; background: url(<?= $img ?>) no-repeat 50% 50%; background-size:cover;"
                                                    class="img-responsive"></div>
                                            </div>
                                            <?php $i++; endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="case-study__overlay col-md-12 col-sm-12 col-xs-12">
                    <h2 class="case-study__title"><?= ucfirst($category) ?></h2>
                    <a class="case-study__link" href="<?= createUrl('gallery', 'view', $this->getCategoryId($images['category_id'])) ?>"><?= __('show_all') ?></a>
                </div>
            </div>

    <?php $j++; endforeach; ?>
    </div>
    <style>
        .dynamicTile .col-sm-2.col-xs-4 {
            padding: 5px;
        }

        .dynamicTile .col-sm-4.col-xs-8 {
            padding: 5px;
        }

        .tile {
            height: 145px;
        }
        .tilecaption {
            position: relative;
            top: 50%;
            transform: translateY(-50%);
            -webkit-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            margin: 0 !important;
            text-align: center;
            color: white;
            font-family: Segoe UI;
            font-weight: lighter;
        }
    </style>

<?php endif; ?>
</div>

