<div class="page-header">
    <h1><?= __('menu_about') ?></h1>
</div>
<?php
$message = '';
foreach ($this->aboutAction as $k => $value) :
    $message .= '<div data-content="content" data-id="' . $value['id'] . '" data-controller="' . $value['controller'] . '" data-action="' . $value['action'] . '">' . $value['value'] . '</div>';
endforeach;
echo $message;
?>