<div id="wrapper" class="active">
    <div id="sidebar-wrapper">
        <ul id="sidebar_menu" class="sidebar-nav">
            <li class="sidebar-brand"><a id="menu-toggle" href="#"><?= __('products') ?><span id="main_icon" class="glyphicon glyphicon-align-justify"></span></a></li>
        </ul>
        <ul class="sidebar-nav" id="sidebar">
            <?php foreach ($this->product_list as $element) : ?>
                <li><a class="<?= ($this->title == $element['title']) ? 'active' : '' ?>"
                    href="<?= createUrl('products', 'read') ?>/<?= $element['id'] ?>">
                    <span style="width: 90%; display: inline-block"><?= $element['title'] ?></span>
                    <span style="width: 10%; display: inline-block" class="sub_icon glyphicon glyphicon-chevron-right"></span>
                </a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div id="page-content-wrapper">
        <div class="page-content">

            <div class="col-md-9 col-sm-9 co-sx-12">
                <div class="page-header"><h1><?= $this->title ?></h1></div>
                <p>
                    <?= $this->description ?>
                </p>
            </div>
            <div class="col-md-3 col-sm-3 co-sx-12">
                <section>
                <div class="gal-container">
                    <?php $i = 0 ; foreach ($this->image as $image) : ?>
                        <div
                            class="col-md-<?= ($i % 9) ? '4' : '8' ?> col-sm-<?= ($i % 9) ? '4' : '8' ?> co-xs-12 gal-item-prod <?= ($image['type'] == 1) ? '' : 'gal-item-video' ?>">
                            <div
                                class='box imagess <?= ($image['type'] == 1) ? 'images-box-' . $image['id'] : 'video-box-' . $image['id'] ?>'>
                                <script>
                                    App.thumbVideo(<?=$image['id']?>, '<?=$image['image']?>', '<?= $image['image_thumb'] ?>', <?=$image['type']?>);
                                    $('.<?=($image['type'] == 1) ? 'images-box-'.$image['id'] : 'video-box-'.$image['id']?> img').addClass('smallImageView');
                                </script>
                            </div>
                        </div>
                    <?php $i++; endforeach; ?>
                </div>
                    </section>
                </div>
        </div>
        <div style="clear: both"></div>
        <?php if ($this->realization != NULL) : ?>
        <div class="page-content">
            <div class="page-header">
                <h3><?= __('realization') ?></h3>
            </div>
            <div class="gal-container">
                <?php $i = 0; foreach ($this->realization as $image_realization): ?>
                <div class="col-md-<?=($i%9) ? '2' : '4' ?> col-sm-<?=($i%9) ? '2' : '4' ?> co-xs-12 gal-item-prod">
                    <div class="realization imagess <?=($image_realization['type'] == 1) ? 'images-box-'.$image_realization['id'] : 'video-box-'.$image_realization['id']?>">
                        <script>
                            App.thumbVideo(<?=$image_realization['id']?>,'<?=$image_realization['image']?>','<?=$image_realization['image_thumb'] ?>',<?=$image_realization['type']?>);
                            $('.<?=($image_realization['type'] == 1) ? 'images-box-'.$image_realization['id'] : 'video-box-'.$image_realization['id']?> img').addClass('smallImageView');
                        </script>
                    </div>
                </div>
                <?php $i++; endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>

    #wrapper {
        padding-left: 70px;
        transition: all .4s ease 0s;
        height: 100%
    }

    #sidebar-wrapper {
        margin-left: -270px;
        left: 60px;
        width: 250px;
        background: #222;
        position: fixed;
        height: 100%;
        z-index: 10000;
        transition: all .4s ease 0s;
    }

    .sidebar-nav {
        display: block;
        float: left;
        width: 150px;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    #page-content-wrapper {
        padding-left: 0;
        margin-left: 0;
        width: 100%;
        height: auto;
    }
    #wrapper.active {
        padding-left: 270px;
    }
    #wrapper.active #sidebar-wrapper {
        left: 270px;
    }

    #page-content-wrapper {
        width: 100%;
    }

    #sidebar_menu li a, .sidebar-nav li a {
        color: #999;
        display: block;
        float: left;
        text-decoration: none;
        width: 250px;
        padding: 5px;
        background: #252525;
        border-top: 1px solid #373737;
        border-bottom: 1px solid #1A1A1A;
        -webkit-transition: background .5s;
        -moz-transition: background .5s;
        -o-transition: background .5s;
        -ms-transition: background .5s;
        transition: background .5s;
    }
    .sidebar_name {
        padding-top: 25px;
        color: #fff;
        opacity: .7;
    }
    .sidebar-nav li {
        display: inline-table;
        vertical-align: middle;

        width: 100%;
    }
    .sidebar-nav li a {
        color: #999999;
        display: block;
        text-decoration: none;
    }

    .sidebar-nav li a:hover {
        color: #fff;
        background: rgba(255,255,255,0.2);
        text-decoration: none;
    }

    .sidebar-nav li a:active,
    .sidebar-nav li a:focus {
        text-decoration: none;
    }

    .sidebar-nav > .sidebar-brand {
        height: 65px;
        line-height: 60px;
        font-size: 18px;
    }

    .sidebar-nav > .sidebar-brand a {
        color: #999999;
    }

    .sidebar-nav > .sidebar-brand a:hover {
        color: #fff;
        background: none;
    }

    #main_icon
    {
        float:right;
        width: 10%;
        padding-top:20px;
    }
    .sub_icon
    {
        margin:  auto;
        float:right;
    }
    .content-header {
        height: 65px;
        line-height: 65px;
    }

    .content-header h1 {
        margin: 0;
        margin-left: 20px;
        line-height: 65px;
        display: inline-block;
    }

    @media (max-width:767px) {
        #wrapper {
            padding-left: 70px;
            transition: all .4s ease 0s;
        }
        #sidebar-wrapper {
            left: 70px;
        }
        #wrapper.active {
            padding-left: 150px;
        }
        #wrapper.active #sidebar-wrapper {
            left: 150px;
            width: 150px;
            transition: all .4s ease 0s;
        }
    }

</style>
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active");
    });
</script>
