<link rel="stylesheet" href="/data/css/jquery.jMosaic.css"/>
<script src="/data/js/jquery.jMosaic.js"></script>
<div class="row">
    <div class='list-group gallery'>
        <?php foreach ($viewmodel as $category => $images) : ?>
        <div class="panel panel-default cols">

            <div class="panel-body">
                <div class="pictures">
                    <?php foreach ($images as $image) : ?>
                        <img class="img-responsive" alt="" src="<?= $image ?>"/>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="panel-footer"><a href="<?=createUrl('gallery','view',$this->getCategoryId($category))?>"><?=ucfirst($category)?></a></div>
        </div>

    <?php endforeach; ?>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.pictures').jMosaic({items_type: "img", min_row_height: 75, margin: 3, is_first_big: false});
    })
</script>
