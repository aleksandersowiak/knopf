<?php

class Admin extends BaseController
{
    protected $_model;
    protected $_heleper;
    public $_addButton;
    public $_editButton;
    public $_deleteButton;

    public function __init()
    {
        $this->_model = new AdminModel();
        $this->_addButton = '<span class="label label-primary">%s</span> <span class="like-link" id="pop-upModal" data-url="' . createUrl('admin', 'add') . '" data-controller="%s"
        params="dataController:%s"><i class="glyphicon glyphicon-plus-sign" data-toggle="tooltip" data-placement="right" title="' . __('add') . '"></i></span>';
        $this->_editButton = '<span class="label label-default" data-id="%d">%s</span> <span class="like-link edit-document" data-url="%s" data-action="%s" data-controller="%s"  data-id="%d"><i class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="right" title="' . __('edit') . '"></i> </span>';
        $this->_deleteButton = '<span class="like-link edit-document" data-url="%s" data-action="%s" data-controller="%s" data-id="%d" data-controller="products"> <i class="glyphicon glyphicon-remove" data-toggle="tooltip" data-placement="right" title="' . __('delete') . '"></i> </span><p><i>%s</i></p>';
        parent::__init();
    }

    protected function indexAction()
    {
        $this->checkSession();
        $content = sprintf('<div><div class="alert alert-info">' . __('method_not_exist') . '</div></div>', $this->getParam('view'));

        if ($this->getParam('id') == 'contents') {
            if (method_exists($this, 'get' . $this->getParam('view') . 'View')) {
                $contentData = $this->{'get' . $this->getParam('view') . 'View'}($this->_addButton);
                $content = $this->createList($contentData);
            }
            $this->Add('viewContent', $content);
        }
        $this->ReturnView('', false);
    }

    protected function loginAction()
    {
        if ($this->_session->__isset("user_id")
            && $this->_session->__isset('name')
        ) {
            $this->_baseHelper->redirect('admin', 'index');
        }
        $this->ReturnView('', false);
    }

    protected function setSessionAction()
    {
        $message = '';
        if (($this->getParam('userName') != '' && $this->getParam('userPassword') != '' && ($_SERVER['REQUEST_METHOD'] == 'POST'))) {
            $userName = $this->getParam('userName');
            $userPassword = $this->getParam('userPassword');
            if ($this->_model->checkUser($userName) == 1) {
                if ($this->_model->checkPassword($userName, $userPassword) != false) {
                    $data = $this->_model->getUser($this->_model->checkPassword($userName, $userPassword));
                    $this->_session->__set('user_id', $data[0]['id']);
                    $this->_session->__set('name', $data[0]['name'] . ' ' . $data[0]['surname']);
                    $reload = "$.post('" . createUrl('admin', 'loadViewFile') . "', {controllerData: 'admin', actionData: 'index' }, function(data){
                        $('#body').find('.container').html(data);
                    });
                     window.history.pushState('object or string', 'Title', '" . createUrl('admin', 'index') . "');
                    ";
                    $modal = "$('.modal').modal('hide');";
                    $message = $this->renderMessage(__('login_success'), 'success') . $modal . $reload;
                } else {
                    $message = $this->renderMessage(__('login_incorrect'), 'danger');
                }
            } else {
                $message = $this->renderMessage(__('login_incorrect'), 'danger');
            }
        }
        $this->finish(null, $message);
    }

    protected function logoutAction()
    {
        $this->checkSession();
        $this->_session->destroy();
        $this->_session->__set('flash_message', $this->renderMessage(__('logout_success'), 'success'));
        $this->_baseHelper->redirect('home', 'index');
    }

    protected function editAction()
    {

        $controller = $this->getParam('dataController');
        $action = $this->getParam('dataAction');
        $id = $this->getParam('dataId');
        $lang = $this->getParam('dataLanguage');

        $this->Add('dataController', $controller);
        $this->Add('dataAction', $action);
        $this->Add('dataId', $id);
        $this->Add('dataLanguage', $lang);

        switch ($controller) {
            case 'home' :
                $data = $this->_model->getDataToEdit($controller, $action, $id, $lang);
                break;
            case 'products' :
                $this->Add('pin_realization', '');
                $this->Add('pin_images', '');
                $dataResult = $this->_model->getProductToEdit($id, $lang);
                $data = $dataResult['description'];
                $this->Add('dataTitle', $dataResult['title']);
                break;
        }

        if ($data != false) {
            $this->Add('dataEdit', $data);
        }
        $this->ReturnView('', false);

    }

    protected function saveAction()
    {
        $message = $this->renderMessage(__('edit_error'), 'danger');
        $save = $this->_model->{$this->getParam('action') . 'Data'}($this->getParams());
        if ($save != false) {
            $modal = "$('.modal').modal('hide');";
            $reload = '$.post("' . $_SERVER['HTTP_REFERER'] . '", {\'onlyView\': true, \'id\': \'contents\', \'view\': \'' . $this->getParam('dataController') . '\', \'language\': \'' . $_GET['language'] . '\', \'controller\': \'' . $_GET['controller'] . '\', \'action\': \'' . $_GET['action'] . '\' }, function(data){
                $("#body").find(\'.container\').html(data);
            });';
            $message = $this->renderMessage(__('edit_success'), 'success') . $modal . $reload;
        }
        $this->finish(null, $message);
    }

    protected function deleteAction()
    {
        if ($this->_model->delete($this->getParam('dataController'), ' `id` = ' . $this->getParam('dataId')) == false) {
            $message = $this->renderMessage(__('delete_error'), 'error');
        } else {
            $modal = "$('.modal').modal('hide');";
            $reload = '$.post("' . $_SERVER['HTTP_REFERER'] . '", {\'onlyView\': true, \'id\': \'contents\', \'view\': \'' . $this->getParam('dataController') . '\', \'language\': \'' . $_GET['language'] . '\', \'controller\': \'' . $_GET['controller'] . '\', \'action\': \'' . $_GET['action'] . '\' }, function(data){
                    $("#body").find(\'.container\').html(data);
                });';
            $message = $this->renderMessage(__('delete_success'), 'success') . $modal . $reload;
        }
        $this->finish(null, $message);
    }

    private function createList($arr)
    {
        $html = '<ul>';

        foreach ($arr as $item) {

            if (is_array($item)) {
                $html .= $this->createList($item); // <<< here is the recursion
            } else {
                $html .= '<li>' . $item . '</li>';
            }
        }

        $html .= '</ul>';
        return $html;
    }

    protected function addAction()
    {
        switch ($this->getParam('dataController')) {
            case 'home':
                $content = $this->_model->getContents($this->getParam('dataController'));
                $contentData = array();
                foreach ($content as $key => $val) {
                    $contentData[$val['controller']][] = $val['action'];
                }

                $dataController = $contentData;
                $return = (!empty($dataController)) ? array_unique($dataController[$this->getParam('dataController')]) : $dataController;
                $this->Add('dataController', $this->getParam('dataController'));
                $this->Add('contentAdd', $return);
                $this->ReturnView('', false);
                break;

            case 'products' :
                $this->Add('language', $_GET['language']);
                $this->ReturnView('', false, 'add_product');
                break;
        }


    }

    public function gethomeView($addButton)
    {
        $contentData = array();
        $content = $this->_model->getContents($this->getParam('view'));
        foreach ($content as $key => $val) {

            if ($val['controller'] != NULL && $val['action'] != NULL && $val['id'] != NULL) {
                $textContent = $this->_model->getDataToEdit($val['controller'], $val['action'], $val['id'], $this->getParam('language'));

                if (!array_key_exists($val['controller'], $contentData)) {
                    $contentData[] = sprintf($addButton, $val['controller'], $val['controller'], $val['controller']);
                }
                $contentData[$val['controller']][] = sprintf($this->_editButton, $val['id'], __('menu_' . $val['action']),
                        createUrl('admin', 'edit'),
                        $val['action'],
                        $val['controller'],
                        $val['id'])
                    .
                    sprintf($this->_deleteButton, createUrl('admin', 'delete'), $val['action'], $val['controller'], $val['id'], $this->_baseHelper->restrictText($textContent, 100, true));
            }
        }
        return $contentData;
    }

    private function getproductsView($addButton)
    {
        $contentData = array();
        $content = $this->_model->getContents($this->getParam('view'), $this->getParam('language'));
        $contentData[] = sprintf($this->_addButton, __('products'), __('products'), __('products'));
        foreach ($content as $key => $val) {
            $textContent = $this->_model->getProductToEdit($val['id'], $this->getParam('language'));
            $contentData[$val['title']][] = sprintf($this->_editButton, $val['id'], $val['title'], createUrl('admin', 'edit'), '', 'products', $val['id']) .
                sprintf($this->_deleteButton, createUrl('admin', 'delete'), '', 'products', $val['id'], $this->_baseHelper->restrictText($textContent['description'], 100, true));

        }
        return ($contentData);
    }

    private function getgalleryView() {
        $contentData = array();
        $content = $this->_model->getContents($this->getParam('view'), $this->getParam('language'));
        $contentData[] = sprintf($this->_addButton, __('category'), __('category'), __('category'));

        foreach ($content as $key => $val) {
            $count = $this->_model->select('select count(*) as count from gallery where category_id = '. $val['category_id']);
            $contentData[][] =
                sprintf('<span class="label label-default" data-id="%d">%s</span>
                <span class="like-link edit-document" data-url="%s" data-action="%s" data-controller="%s" data-id="%d">
                <i class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="right" title="' . __('edit') . '"></i>
                </span>', $val['category_id'],$val['category'] . ' (' . $count[0]['count']. ')',createUrl('admin', 'editGallery'), '','',$val['category_id']);
        }
        return ($contentData);
    }

    protected function editGalleryAction() {
        $galleryModel = new GalleryModel();
        $content = $galleryModel->getImages(' WHERE category_id = ' . $this->getParam('dataId'));

        $message = $this->renderJSGallery($content);
        $this->finish(null, $message);
    }
    protected function pinImages()
    {
        $gallery = new Gallery($this->controller, $this->action, '');
        $this->Add('data_type', $this->getParam('dataType'));
        $this->ReturnView($gallery->getAllImages(), false, $this->action);
    }

    protected function assignAction()
    {
        $message = $this->renderMessage(__('image_assign_error'), 'error');
        if ($this->_model->assignImages($this->getParams()) != false) {
            $message = $this->renderMessage(__('image_assign_success'), 'success');
        }
        $this->finish(null, $message);
    }
    protected function importImagesAction()
    {
        $listOfImported = array();
        $gallery = new GalleryModel();
        $images = $gallery->getImages();
        $i = 0;
        foreach ($images as $image) {
            $listOfImported[] = basename($image['image']);
        }
        $dir          = APPLICATION_PATH . '/data/images/upload/';
        $ImagesA = $this->Get_ImagesToFolder($dir);
        foreach ($ImagesA as $image_to_import) {
            if(!in_array($image_to_import, $listOfImported)) {
                $this->_model->insert('gallery', array('image' => '/data/images/upload/' . $image_to_import, 'category_'.$this->getParam('language') => 'None', 'category_id' => 0));
                $i++;
            }
        }
        $message = $this->renderMessage(sprintf(__('import_complete'), $i), 'success');
        $this->finish(null, $message);
    }
    private function Get_ImagesToFolder($dir){
        $ImagesArray = [];
        $file_display = [ 'jpg', 'jpeg', 'png', 'gif' ];

        if (file_exists($dir) == false) {
            return ["Directory \'', $dir, '\' not found!"];
        }
        else {
            $dir_contents = scandir($dir);
            foreach ($dir_contents as $file) {
                $file_type = pathinfo($file, PATHINFO_EXTENSION);
                if (in_array($file_type, $file_display) == true) {
                    $ImagesArray[] = $file;
                }
            }
            return $ImagesArray;
        }
    }
    protected function renderJSGallery($content) {
        $images = '';
        $viewContent= "$('.viewContent').append('<div class=\"viewContentGallery\"></div>'); ";
        $h3 = "$('.viewContentGallery').append('<div class=\"page-header\"><h3>".$content[0]['category']."</h3></div>'); ";
        foreach ($content as $image) :
            $images .= "$('.viewContentGallery').append('<div class=\"images\" style=\"display: none\" > ";
            $images .= "<a class=\"fancybox thumbnail\" rel=\"ligthbox\" href=\"".$image['image']."\"> ";
            $images .= "<img data-id =\"".$image['id']."\" style=\"max-height:150px; min-height:150px;  min-width:150px;  max-width:150px;  overflow: hidden; background: url(".$image['image'].") no-repeat 50% 50%; background-size:cover;\"/> ";
            $images .= "</a> ";
            $images .= "</div>'); ";
        endforeach;
        $url = createUrl('admin','assignImageToCategory');
        return <<<EOF
        if($('.viewContentGallery').length > 0) {
            $('.viewContentGallery').remove();
        }
        $viewContent
        $h3
        $(document).ready(function () {
            $images
            $('.viewContentGallery').find('div').each(function (i, el) {
                $(el).fadeIn('slow');
            });
            $('.images').draggable({
                cursor: 'move',
                helper: "clone",
                opacity: 0.35
            });
            $('span.label-default').droppable({

                hoverClass: "label-warning",
                drop: function(event, ui) {

                var params = {
                        droppedCategoryId : $(this).attr('data-id'),
                        imageId : $(event.originalEvent.toElement).attr('data-id')
                    };
                    App.ajaxSend("$url", params);
                    $('img[data-id="'+$(event.originalEvent.toElement).attr('data-id')+'"]').parents('div.images').remove();
                    console.log($(this).attr('data-id'),$(event.originalEvent.toElement).attr('data-id'));
                }
            });
        });
EOF;

    }

    protected function assignImageToCategoryAction() {
        $message = $this->renderMessage(__('image_assign_error'), 'error');
        $update = $this->_model->updateDataImage($this->getParams());

        if($update != false) {
            $message = $this->renderMessage(__('success'), 'success');
        }
        $this->finish(null, $message);
    }
}