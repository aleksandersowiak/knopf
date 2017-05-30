<nav class="navbar">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
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
            <li><a href="<?= createUrl('admin', 'logout') ?>"><i class="glyphicon glyphicon-off"></i> <?=__('logout')?></a></li>

        </ul>
    </div>
</nav>

<?= $this->viewContent ?>

<?php if(isset($_GET['view'])) : ?>
<script>
    $('.nav-tabs').find('li[data-select="<?=$_GET['view']?>"]').addClass('active');
</script>
<?php endif; ?>