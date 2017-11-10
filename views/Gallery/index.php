<?php
if (empty($viewmodel)) :
    echo '<div class="alert alert-info">' . __('no_images') . '</div>';
else :
    ?>
    <div class="row">
        <div class='list-group gallery'>
            <?php
            foreach ($viewmodel as $category => $images) : ?>
                <div class="panel panel-default cols">

                    <div class="panel-body no-margins">
                        <div class="pictures">
                            <?php foreach ($images as $image) :
                                if (file_exists(APPLICATION_PATH . $image) && getimagesize(APPLICATION_PATH . $image)) :
                                    ?>
                                    <img class="img-responsive" alt=""
                                         style="display:inline-block; width: 100px; height: 100px" src="<?= $image ?>"/>
                                <?php endif;
                            endforeach; ?>
                        </div>
                    </div>
                    <div class="panel-footer"><a
                            href="<?= createUrl('gallery', 'view', $this->getCategoryId($images['category_id'])) ?>"><?= ucfirst($category) ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>