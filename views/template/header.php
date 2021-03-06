<?php
$opts = array();
if ($_GET['id'] == "") {
    $id = "";
} else {
    $id = "/" . $_GET['id'];
}
$controller =  ($this->getParam('controller') == '') ? 'home' : $this->getParam('controller');
$action = ($this->getParam('action') == '') ? 'index' : $this->getParam('action');
$uri = '/' . $controller . '/' . $action . $id;
?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="<?= $this->base_lang ?>">
    <head>
        <title>KNOPF - Serramenti vendita ed installazione</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="Content-Language" content="<?= $this->base_lang ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="/data/js/jquery-3.2.1.js"></script>
        <script src="/data/js/jquery-ui.js"></script>
        <script src="/data/js/bootstrap.js"></script>
        <script src="/data/js/app.js?ver=<?= APP_VER ?>"></script>
        <script src="/data/js/summernote.js"></script>
        <script src="/data/js/lang/summernote-<?= $this->base_lang ?>-<?= strtoupper($this->base_lang) ?>.js"></script>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"
              media="screen">
        <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>

        <link rel="stylesheet" href="/data/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="/data/css/flags16.css">
        <link rel="stylesheet" type="text/css" href="/data/css/site.css?ver=<?= APP_VER ?>">
        <link rel="stylesheet" type="text/css" href="/data/css/summernote.css">
        <link rel="stylesheet" href="/data/fonts/font-awesome/css/font-awesome.min.css">

        <link rel="stylesheet" type="text/css"
              href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css"/>
        <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
        <script>
            window.onload = App.init();
            window.addEventListener("load", function () {
                window.cookieconsent.initialise({
                    "palette": {
                        "popup": {
                            "background": "#edeff5",
                            "text": "#838391"
                        },
                        "button": {
                            "background": "#4b81e8"
                        }
                    },
                    "position": "bottom-right",
                    "content": {
                        "message": "<?=__('coockie_message')?>",
                        "dismiss": "<?=__('got_it')?>",
                        "link": "<?=__('learn_more')?>"
                    }
                })
            });
        </script>
    </head>
<body>
<?php
if ($this->_session->__isset('flash_message')) {
    echo $this->_session->__get('flash_message');
    $this->_session->__unset('flash_message');
}
?>
    <nav class="navbar navbar-default navbar-fixed-top navbar-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= createUrl(); ?>"><?= $this->web_title ?> </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php
                    foreach ($this->top_menu as $element) {
                        $class = ($element['controller'] == $this->getParam('controller') && $element['action'] == $this->getParam('action')) ? ' class="active" ' : '';
                        echo '<li '. $class .'><a href="' . createUrl($element['controller'], $element['action']) . '"> ' . __($element['menu_element']) . '</a></li>';
                        unset($link);
                    }
                    ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
<!--                    <form class="navbar-form navbar-left">-->
<!--                        <div class="form-group">-->
<!--                            <input type="text" class="form-control" placeholder="--><?//= __('search_placeholder') ?><!--">-->
<!--                        </div>-->
<!--                        <button type="submit" class="btn btn-default glyphicon glyphicon-search"></button>-->
<!--                    </form>-->
                    <li class="dropdown f16">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"><span class="lang-display"><?= __('global_header_language'); ?> <?= $this->languagesList[$this->base_lang] ?></span>
                            <span
                                class="flag <?= $this->base_lang ?>"></span> <span class="caret"></span></a>
                        <ul class="dropdown-menu langs">
                            <?php
                            foreach ($this->languagesList as $langK => $langN) {
                                echo '<li><a href="/' . $langK . $uri . '"><p class="flag ' . $langK . '">' . $langN . '</p></a></li>';
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
<div id="body">
<?php if ($this->edit == true) : ?>
    <script>
        function loadEditButton() {
            App.waitForElement('div[data-content="content"]', function () {
                if ($('.edit-bot').length == 0) {
                    $('div[data-content="content"]').each(function (i, e) {
                        var editButton = '<div class="pull-right edit-bot like-link clearfix edit-document" data-url="<?=createUrl('admin','edit')?>" data-action="' + $(e).attr('data-action') + '" data-controller="' + $(e).attr('data-controller') + '"  data-id="' + $(e).attr('data-id') + '">  <span><i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="right" title="<?=__('edit')?>"></i> </span></div><div style="clear:both"></div>';
                        $(e).prepend(editButton);
                    });
                }
            });
        }
    </script>
<?php endif; ?>