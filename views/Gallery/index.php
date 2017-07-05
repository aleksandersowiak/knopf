<?php
if(empty($viewmodel)) :
    echo '<div class="alert alert-info">'.__('no_images').'</div>';
else :
?>
<div class="row">
    <div class='list-group gallery'>
        <?php
        foreach ($viewmodel as $category => $images) : ?>
            <div class="panel panel-default cols">

                <div class="panel-body no-margins">
                    <div class="pictures">
                        <?php foreach ($images as $image) : ?>
                            <img class="img-responsive" alt="" src="<?= $image ?>"/>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="panel-footer"><a
                        href="<?= createUrl('gallery', 'view', $this->getCategoryId($images['category_id'])) ?>"><?= ucfirst($category) ?></a>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</div>
<!--<script>-->
<!--    $(document).ready(function () {-->
<!--        $('.pictures').jMosaic({items_type: "img", min_row_height: 50, margin: 0, is_first_big: false});-->
<!--    })-->
<!--</script>-->
<?php endif; ?>