<div class="case-study-gallery">
    <div class="col-md-12">
        <div class="heading-style3">
            <h2><?= __('menu_about') ?></h2>
        </div>
    </div>
    <div class="container">
<?php
$message = '';
foreach ($this->aboutAction as $k => $value) :
    $message .= '<div data-content="content" data-id="' . $value['id'] . '" data-controller="' . $value['controller'] . '" data-action="' . $value['action'] . '">' . $value['value'] . '</div>';
endforeach;
echo $message;
?>
</div>
</div>