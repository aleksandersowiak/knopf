<?php
if (empty($viewmodel)) :
    echo '<div class="alert alert-info">' . __('no_images') . '</div>';
else :
    ?>
    <div class="list-group gallery">
    <?php
    foreach ($viewmodel as $category => $images) : ?>
        <?php $attr = array();
        $i = 0;
        $style = $style1 = $style2 = $class = $class1 = $class2 = '';
        $style3 = 'height: 289px';
        foreach ($images as $image) :
            if (file_exists(APPLICATION_PATH . $image) && getimagesize(APPLICATION_PATH . $image)) :
                if ($i <= 1) {
                    $attr[0][] = $image;
                    $class = 'width: 100%; float: left';
                    $style = 'max-width:340px; max-height:290px; min-width:340px; min-height:290px;';
                } else if ($i > 1 && $i <= 3) {
                    $attr[1][] = $image;
                    $class = 'width: 50%; float: left';
                    $style = 'max-width:185px; max-height:290px; min-width:185px; min-height:290px;';
                    $class1 = 'width: 50%; float: left';
                    $style1 = 'max-width:185px; max-height:290px; min-width:185px; min-height:290px;';
                } else if ($i > 3 && $i <= 5) {
                    $attr[2][] = $image;
                    $class = 'width: 50%; float: left';
                    $style = 'max-width:185px; max-height:145px; min-width:185px; min-height:145px;';
                    $class1 = 'width: 50%; float: left';
                    $style1 = 'max-width:185px; max-height:145px; min-width:185px; min-height:145px;';
                    $class2 = 'width: 100%; float: left';
                    $style2 = 'max-width:340px; max-height:145px; min-width:340px; min-height:145px;';
                    $style3 = '';
                }
                $i++;
            endif;
        endforeach; ?>

        <div style="width: 340px; display: block; float: left; margin-right: 10px; border: 1px solid #ccc">
            <div style="<?=$style3?>">
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
            <div style="clear: both"></div>
            <div class="panel-footer"><a
                    href="<?= createUrl('gallery', 'view', $this->getCategoryId($images['category_id'])) ?>"><?= ucfirst($category) ?></a>
            </div>
        </div>
    <?php endforeach; ?>
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

        #tile1 {
            background: rgb(0, 172, 238);
        }

        #tile2 {
            background: rgb(243, 243, 243);
        }

        #tile3 {
            background: rgb(71, 193, 228);
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
    </div>
<?php endif; ?>