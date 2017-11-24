<div class="container container-admin">
<nav class="navbar">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed collapsed-admin" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
        <ul class="nav nav-tabs nav-justified">
            <?php
            $collect = array();
            foreach ($this->top_menu as $element) {
                if (!in_array($element['controller'], $collect)) {
                    $collect[] = $element['controller'];
                    echo '<li data-select="' . $element['controller'] . '">
                        <a href="' . createUrl('admin', 'index', 'contents') . '/view/' . $element['controller'] . '"> ' . __($element['controller']) . '</a>
                    </li>';
                    unset($element);
                }
            }
            ?>
            <li data-select="uploadImages"><a href="<?= createUrl('admin', 'uploadImages') ?>"><i
                        class="fa fa-upload"></i> <?= __('upload_images') ?></a></li>
            <li><a href="#" id="pop-upModal" data-url="<?= createUrl('admin', 'importImages') ?>"><i
                        class="fa fa-cloud-download"></i> <?= __('import_images') ?></a></li>
            <li><a href="<?= createUrl('admin', 'logout') ?>"><i
                        class="fa fa-sign-out"></i> <?= __('logout') ?></a></li>

        </ul>
    </div>
</nav>
<div class="viewContent" >
    <?= $this->viewContent ?>
</div>
<?php if (isset($_GET['view']) || isset($_GET['action'])) :
    $v = '';
    if (isset($_GET['view']) && $_GET['view'] != $_GET['action']) :
        $v = $_GET['view'];
    elseif (isset($_GET['action']) && $_GET['action'] != '') :
        $v = $_GET['action'];
    endif;
    if ($v != '') :
        ?>
        <script>
            $('.nav-tabs').find('li[data-select="<?=$v?>"]').addClass('active');
        </script>
    <?php endif; endif; ?>
</div>