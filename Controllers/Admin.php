<?php

defined('IMG_FLIP_HORIZONTAL') or define('IMG_FLIP_HORIZONTAL', 1);
defined('IMG_FLIP_VERTICAL') or define('IMG_FLIP_VERTICAL', 2);
defined('IMG_FLIP_BOTH') or define('IMG_FLIP_BOTH', 3);

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
        params="dataController:%s"><i class="fa fa-plus" data-toggle="tooltip" data-placement="right" title="' . __('add') . '"></i></span>';
        $this->_editButton = '<span class="label label-default" data-id="%d">%s</span> <span class="like-link edit-document" data-url="%s" data-action="%s" data-controller="%s"  data-id="%d"><i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="right" title="' . __('edit') . '"></i> </span>';
        $this->_deleteButton = '<span class="like-link edit-document" data-url="%s" data-action="%s" data-controller="%s" data-id="%d" data-controller="products"> <i class="fa fa-trash" data-toggle="tooltip" data-placement="right" title="' . __('delete') . '"></i> </span><p><i>%s</i></p>';
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
                        $('#body').html(data);
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
                $dataResult = $this->_model->getDataToEdit($controller, $action, $id, $lang);
                $data = $dataResult['description'];
                $this->Add('bottom_set', $dataResult['category_id']);
                if($action == 'contact') {
                    $categories = $this->_model->select('select id,category_' . DEFAULT_LANG . ' from category where category_type = 11');
                    $this->Add('edit_category_type', $categories);
                }
                break;
            case 'products' :
                $this->Add('pin_realization', '');
                $this->Add('pin_images', '');
                $dataResult = $this->_model->getProductToEdit($id, $lang);
                $data = $dataResult['description'];
                $this->Add('dataTitle', $dataResult['title']);
                break;
        }

        if(isset($dataResult['empty_title']) && $dataResult['empty_title'] == "1")  $this->Add('empty_title', 1);
        if(isset($dataResult['empty_description']) && $dataResult['empty_description'] == "1")  $this->Add('empty_description', 1);
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
            if($this->getParam('dataController') == 'category') $this->setParam('dataController', 'gallery');
            $modal = "$('.modal').modal('hide');";
            $reload = '$.post("' . $_SERVER['HTTP_REFERER'] . '", {\'onlyView\': true, \'id\': \'contents\', \'view\': \'' . $this->getParam('dataController') . '\', \'language\': \'' . $_GET['language'] . '\', \'controller\': \'' . $_GET['controller'] . '\', \'action\': \'' . $_GET['action'] . '\' }, function(data){
                $("#body").html(data);
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
            if($this->getParam('dataController') == 'category') $this->setParam('dataController', 'gallery');
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

            case 'category' :
                    $this->Add('language', $_GET['language']);
                    $this->ReturnView('', false, 'add_category');
                break;

            default :
                $this->finish(null, $this->renderMessage(__('no_action_add_element'), 'warning'));
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
                $order = '<span data-url="'.createUrl('admin', 'order').'" contenteditable="true" table="content" data-id="'.$val['id'].'" class="badge order_position">'.$textContent['ordering'].'</span>';
                $warning = ($textContent['empty_description'] == 1) ? '<span class="badge badge-warning" data-toggle="tooltip" data-placement="right" title="' . __('something_is_wrong') . '">!</span>' : '';
                $contentData[$val['controller']][] = $order . sprintf($this->_editButton, $val['id'], __('menu_' . $val['action']),
                        createUrl('admin', 'edit'),
                        $val['action'],
                        $val['controller'],
                        $val['id'])
                    . $warning .
                    sprintf($this->_deleteButton, createUrl('admin', 'delete'), $val['action'], $val['controller'], $val['id'], $this->_baseHelper->restrictText($textContent['description'], 100, true));
            }
        }
        return $contentData;
    }

    private function getproductsView($addButton)
    {
        $contentData = array();
        $content = $this->_model->getContents($this->getParam('view'), $this->getParam('language'));
        $contentData[] = sprintf($this->_addButton, __('products'), 'products', 'products');
        foreach ($content as $key => $val) {
            $textContent = $this->_model->getProductToEdit($val['id'], $this->getParam('language'));

            $warning = ($textContent['empty_title'] == 1 || $textContent['empty_description'] == 1) ? '<span class="badge badge-warning" data-toggle="tooltip" data-placement="right" title="' . __('something_is_wrong') . '">!</span>' : '';

            $contentData[$val['title']][] = sprintf($this->_editButton, $val['id'], $textContent['title'], createUrl('admin', 'edit'), '', 'products', $val['id']) . $warning .
                sprintf($this->_deleteButton, createUrl('admin', 'delete'), '', 'products', $val['id'], $this->_baseHelper->restrictText($textContent['description'], 100, true));

        }
        return ($contentData);
    }

    private function getgalleryView() {
        $contentData = array();
        $content = $this->_model->getContents($this->getParam('view'), $this->getParam('language'));

        $contentData[] = '<a href="'.createUrl('admin','uploadImages').'"><span class="label label-default">'.__('upload_images').'</span></a>';
        $contentData[] = sprintf($this->_addButton, __('category'), 'category', 'category');

        foreach ($content as $key => $val) {
            $count = $this->_model->select('select count(*) as count from gallery where category_id = '. $val['category_id']);
            $deleteButton = ($val['category_id'] != 1 ) ? sprintf($this->_deleteButton, createUrl('admin', 'delete'), 'category', 'category', $val['category_id'], '') : "";
            $warning = (isset($val['empty_category']) && $val['empty_category'] == 1) ? '<span class="badge badge-warning" data-toggle="tooltip" data-placement="right" title="' . __('something_is_wrong') . '">!</span>' : '';
            $contentData[][] =
                sprintf('<span class="category label label-default" data-id="%d">%s</span>
                <span class=" like-link edit-document" data-url="%s" data-action="%s" data-controller="%s" data-id="%d">
                <i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="right" title="' . __('edit') . '"></i> ' . $warning .'
                </span>', $val['category_id'], __($val['category']) . ' (<span class="count">' . $count[0]['count']. '</span>)',createUrl('admin', 'editGallery'), '','',$val['category_id'])
                . $deleteButton
            ;
        }
        return ($contentData);
    }
    protected function uploadImagesAction() {
        $this->ReturnView('',false,'');
    }
    protected function editGalleryAction() {
        $galleryModel = new GalleryModel();
        $content = $galleryModel->getImages(' WHERE category_id = ' . $this->getParam('dataId'), $this->getParam('dataLanguage'));
        $message = $this->renderMessage(__('no_images'), 'warning');
        if(!empty($content)) {
            $message = $this->renderJSGallery($content);
        }
        $this->finish(null, $message);
    }
    protected function pinImages()
    {
        $gallery = new Gallery($this->controller, $this->action, '');
        $this->Add('data_type', $this->getParam('dataType'));
        $this->ReturnView($gallery->getAllImages(' WHERE (1=1) '), false, $this->action);
    }

    protected function assignAction()
    {
        $message = $this->renderMessage(__('image_assign_error'), 'error');
        if ($this->_model->assignImages($this->getParams()) != false) {
            $message = $this->renderMessage(__('image_assign_success'), 'success');
        }
        $this->finish(null, $message);
    }
    protected function importImagesAction($m = true)
    {
        set_time_limit ( 0 );
        $i = 0;
        $dir          = APPLICATION_PATH . '/data/images/upload/';
        $ImagesA = $this->Get_ImagesToFolder($dir);
        foreach ($ImagesA as $image_to_import) {
            $select_category_id = $this->_model->select('Select id from category where ' . ' category_' . $this->getParam('language') . ' = "none_category"');
            $save = array('image' => '/data/images/upload/' . $image_to_import, 'category_id' => $select_category_id[0]['id']);
            if(!file_exists($dir . '/thumb_' . $image_to_import)) {
                $this->make_thumb($dir . $image_to_import, $dir. 'thumb_' . $image_to_import, 400);
                $this->fix_orientation($dir. 'thumb_' . $image_to_import);
                $save = array_merge(array('image_thumb' => '/data/images/upload/thumb_' . $image_to_import), $save);
            }
            $this->_model->insert('gallery', $save);
            $i++;

        }
        if($m = true) {
            $message = $this->renderMessage(sprintf(__('import_complete'), $i), 'success');
            $this->finish(null, $message);
        }
        return true;
    }
    private function Get_ImagesToFolder($dir){
        $listOfImported = array();
        $gallery = new GalleryModel();
        $images = $gallery->getImages(' WHERE (1=1) ');
        foreach ($images as $image) {
            $listOfImported[] = basename($image['image']);
            $listOfImported[] = basename($image['image_thumb']);
        }
        $ImagesArray = [];
        $file_display = [ 'jpg', 'jpeg', 'png', 'gif' ];

        if (file_exists($dir) == false) {
            return ["Directory \'', $dir, '\' not found!"];
        }
        else {
            $dir_contents = scandir($dir);
            foreach ($dir_contents as $file) {
                $file_type = pathinfo(strtolower($file), PATHINFO_EXTENSION);
                if (in_array($file_type, $file_display) == true) {
                    $ext = $this->get_extension($file);
                    if (!in_array($file, $listOfImported)) {
                        rename($dir . $file, $dir . sha1($file) . '.' . $ext);
                        $this->fix_orientation($dir . sha1($file) . '.' . $ext);
                        $ImagesArray[] = sha1($file) . '.' . $ext;
                    }
                }
            }
            return $ImagesArray;
        }
    }
    private function imageflip($resource, $mode) {

        if($mode == IMG_FLIP_VERTICAL || $mode == IMG_FLIP_BOTH)
            $resource = imagerotate($resource, 180, 0);

        if($mode == IMG_FLIP_HORIZONTAL || $mode == IMG_FLIP_BOTH)
            $resource = imagerotate($resource, 90, 0);

        return $resource;

    }
    function fix_orientation($fileandpath) {
        // Does the file exist to start with?
        if(!file_exists($fileandpath))
            return false;
        try {
            @$exif = read_exif_data($fileandpath, 'IFD0');
        }
        catch (Exception $exp) {
            $exif = false;
        }
        // Get all the exif data from the file
        // If we dont get any exif data at all, then we may as well stop now
        if(!$exif || !is_array($exif))
            return false;

        // I hate case juggling, so we're using loweercase throughout just in case
        $exif = array_change_key_case($exif, CASE_LOWER);

        // If theres no orientation key, then we can give up, the camera hasn't told us the
        // orientation of itself when taking the image, and i'm not writing a script to guess at it!
        if(!array_key_exists('orientation', $exif))
            return false;

        // Gets the GD image resource for loaded image
        $img_res = $this->get_image_resource($fileandpath);

        // If it failed to load a resource, give up
        if(is_null($img_res))
            return false;

        // The meat of the script really, the orientation is supplied as an integer,
        // so we just rotate/flip it back to the correct orientation based on what we
        // are told it currently is

        switch($exif['orientation']) {

            // Standard/Normal Orientation (no need to do anything, we'll return true as in theory, it was successful)
            case 1: return true; break;

            // Correct orientation, but flipped on the horizontal axis (might do it at some point in the future)
            case 2:
                $final_img = $this->imageflip($img_res, IMG_FLIP_HORIZONTAL);
                break;

            // Upside-Down
            case 3:
                $final_img = $this->imageflip($img_res, IMG_FLIP_VERTICAL);
                break;

            // Upside-Down & Flipped along horizontal axis
            case 4:
                $final_img = $this->imageflip($img_res, IMG_FLIP_BOTH);
                break;

            // Turned 90 deg to the left and flipped
            case 5:
                $final_img = imagerotate($img_res, -90, 0);
                $final_img = $this->imageflip($img_res, IMG_FLIP_HORIZONTAL);
                break;

            // Turned 90 deg to the left
            case 6:
                $final_img = imagerotate($img_res, -90, 0);
                break;

            // Turned 90 deg to the right and flipped
            case 7:
                $final_img = imagerotate($img_res, 90, 0);
                $final_img = $this->imageflip($img_res,IMG_FLIP_HORIZONTAL);
                break;

            // Turned 90 deg to the right
            case 8:
                $final_img = imagerotate($img_res, 90, 0);
                break;

        }
        if(!isset($final_img))
            return false;
        if (!is_writable($fileandpath)) {
            chmod($fileandpath, 0777);
        }
        unlink($fileandpath);

        // Save it and the return the result (true or false)
        $done = $this->save_image_resource($final_img,$fileandpath);

        return $done;
    }
    private function get_image_resource($file) {

        $img = null;
        $p = explode(".", strtolower($file));
        $ext = array_pop($p);
        switch($ext) {

            case "png":
                $img = imagecreatefrompng($file);
                break;

            case "jpg":
            case "jpeg":
                $img = imagecreatefromjpeg($file);
                break;
            case "gif":
                $img = imagecreatefromgif($file);
                break;

        }

        return $img;

    }
    private function save_image_resource($resource, $location) {

        $success = false;
        $p = explode(".", strtolower($location));
        $ext = array_pop($p);
        switch($ext) {

            case "png":
                $success = imagepng($resource,$location);
                break;

            case "jpg":
            case "jpeg":
                $success = imagejpeg($resource,$location);
                break;
            case "gif":
                $success = imagegif($resource,$location);
                break;

        }

        return $success;

    }
    private function make_thumb($src, $dest, $desired_width) {

        /* read the source image */
        $p = explode(".", strtolower($src));
        $ext = array_pop($p);
        switch($ext) {
            case "png":
                $source_image = imagecreatefrompng($src);
                break;
            case "jpg":
            case "jpeg":
            $source_image = imagecreatefromjpeg($src);
                break;
            case "gif":
                $source_image = imagecreatefromgif($src);
                break;
        }


        $width = imagesx($source_image);
        $height = imagesy($source_image);

        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height * ($desired_width / $width));

        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

        /* copy source image at a resized size */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        /* create the physical thumbnail image to its destination */
        imagejpeg($virtual_image, $dest);
    }
    protected function renderJSGallery($content) {
        $images = '';
        $viewContent= "$('.viewContent').append('<div class=\"viewContentGallery col-md-9 col-sm-9 col-xs-12\"></div>'); ";

        $h3 = "$('.viewContentGallery').append('<div class=\"page-header\"><h3>".__($content[0]['category'])."</h3></div>'); ";
        $h3 .= "$('div.page-header').append('<input style=\"display:none\" class=\"form-control \" type=\"text\" value=\"".__($content[0]['category'])."\" name=\"category_".$this->base_lang."\"/>'); ";
        $h3 .= " $('div.page-header').on('click', function() {
                     $(this).find('h3').css({display: 'none'});
                     $(this).find('input[name=\"category_".$this->base_lang."\"]').css({display: 'block'});
                 });

                 $('input[name=\"category_".$this->base_lang."\"]').change(function() {
                    var params = {
                                category : 'category_".$this->base_lang."',
                                value : $(this).val(),
                                category_id: '".$content[0]['category_id']."'
                            };
                    App.ajaxSend('".createUrl('admin','changeCategoryName')."',params);
                 });
               ";
        if ($content[0]['empty_category'] == 1) { $h3 .= "$('.page-header h3').append('&nbsp;<span class=\"badge badge-warning\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"". __('something_is_wrong') . "\">!</span>')"; }
        $content_categories = $this->_model->getContents('gallery', $this->getParam('language'));

        $categories = '<ul>';
        foreach ($content_categories as $val) {
            $categories .= sprintf('<li data-url=&#34;'.createUrl('admin','assignImageToCategory').'&#34; class=&#34;assign-to-category like-link&#34; data-id=&#34;%d&#34;>%s</li>', $val['category_id'], __($val['category']));
        }
        $categories .= '</ul>';


        foreach ($content as $image) :
            if($image['type'] == 1) {
                $images .= "$('.viewContentGallery').append('<div class=\"images-admin\" style=\"display: none\" > ";
                $images .= "<div class=\"thumbnail\">";
                $images .= "<img target-category-id=\"".$image['category_id']."\" data-id =\"".$image['id']."\" style=\"max-height:150px; min-height:150px;  min-width:150px;  max-width:150px;  overflow: hidden; background: url(".$image['image_thumb'].") no-repeat 50% 50%; background-size:cover;\"/> ";
                $images .= "</div>";
                $images .= "<span class=\"text-content\">";
                $images .= "<span> <i data-toggle=\"popover\" data-placement=\"right\" title=\"".__('change_category_image')."\"  data-html=\"true\" data-content=\"".$categories."\" data-url=\"".createUrl('admin','assignImageToCategory')."\" data-id=\"".$image['id']."\" class=\"chane-category-image fa fa-list\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".__('change_category_image')."\"></i></span>";
                $images .= "<span> <i data-url=\"".createUrl('admin','deleteImage')."\" data-id=\"".$image['id']."\" class=\"delete-image fa fa-times-circle-o\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".__('delete_image')."\"></i></span>";
                $images .= "<a class=\"fancybox\" rel=\"ligthbox\" href=\"".$image['image']."\"> <i class=\"fa fa-expand\"  data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".__('full_size_image')."\"></i></a> ";
                $images .= "</span></div>'); ";
            } else if ($image['type'] == 2) {
                $images .= "$('.viewContentGallery').append('<div class=\"images-admin video-box-" . $image['id'] ."\" style=\"display: none\" ></div>');";
                $images .= "App.thumbVideo(".$image['id'].",'".$image['image']."','',".$image['type'].");";
                $images .= "$('#thumbnail-".$image['id']."').attr('target-category-id','".$image['category_id']."').attr('data-id' ,'".$image['id']."').parent('.fancybox').addClass('thumbnail');";
                $images .= "if($('#thumbnail-".$image['id']."').height() == 0 || $('#thumbnail-".$image['id']."').width() == 0) { $('#thumbnail-".$image['id']."').css({height: 150+'px', width: 150+'px'}); }";
                $images .= "$('.video-box-".$image['id']."').find('.text-content').prepend('<span data-url=\"".createUrl('admin','deleteImage')."\" data-id=\"".$image['id']."\" class=\"delete-image\"> <i class=\"fa fa-times-circle-o\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".__('delete_image')."\"></i></span>');";
                $images .= "$('.video-box-".$image['id']."').find('.text-content').prepend('<span data-toggle=\"popover\" title=\"".__('change_category_image')."\"  data-html=\"true\" data-content=\"".$categories."\" data-url=\"".createUrl('admin','assignImageToCategory')."\" data-id=\"".$image['id']."\" class=\"chane-category-image\"> <i class=\"fa fa-list\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"".__('change_category_image')."\"></i></span>');";
            }
        endforeach;
        $url = createUrl('admin','assignImageToCategory');
        return <<<EOF
        if($('.viewContentGallery').length > 0) {
            $('.viewContentGallery').remove();
        }
	var classes = '.images-admin';
        $viewContent
        $h3
        $(document).ready(function () {

            $images
            $('.viewContentGallery').find('div.images-admin').each(function (i, el) {
                $(el).fadeIn('slow');
            });
            $(classes).draggable({
                cursor: 'move',
                helper: "clone",
                opacity: 0.35
            });
            $('span.label-default').droppable({

                hoverClass: "label-warning",
                drop: function(event, ui) {

                var params = {
                        droppedCategoryId : $(this).attr('data-id'),
                        imageId : $(event.originalEvent.toElement).parents(classes).find('img').attr('data-id')
                    };
                    App.ajaxSend("$url", params);
                    $('img[data-id="'+$(event.originalEvent.toElement).parents(classes).find('img').attr('data-id')+'"]').parents('div' + classes).remove();
                    var count = $(this).find('span.count').text(); $(this).find('span.count').text(parseInt(count)+1);
                    var category = $('span.category[data-id="'+$(event.originalEvent.toElement).parents(classes).find('img').attr('target-category-id')+'"]');
                    var count_target = category.find('span.count').text(); category.find('span.count').text(parseInt(count_target)-1);
                }
            });
        });
         App.waitForElement('[data-toggle="tooltip"]', function () {
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                });
            });
            App.waitForElement('.delete-image', function () {
                 $(document).undelegate('.delete-image').delegate('.delete-image', 'click', function () {
                        App.ajaxSend($(this).attr('data-url'), {
                            'popupModal': true,
                            'dataId': $(this).attr('data-id')
                        });
                    });
            });

                $(function () {
                  $('[data-toggle="popover"]').popover()
                });

            App.waitForElement('.assign-to-category', function () {
                $(document).undelegate('.assign-to-category').delegate('.assign-to-category', 'click', function () {
                    var imageId = $(this).parents(classes).find('img').attr('data-id');
                    var categoryId = $(this).attr('data-id');
                    var params = {
                        'popupModal': true,
                        droppedCategoryId : categoryId,
                        imageId : imageId
                    };
                    App.ajaxSend($(this).attr('data-url'),params);
                    $('img[data-id="'+imageId+'"]').parents('div' + classes).remove();
                    var count = $('span.category[data-id="' + categoryId + '"]').find('span.count').text();
                    $('span.category[data-id="' + categoryId + '"]').find('span.count').text(parseInt(count)+1);
                    var category = $('span.category[data-id="'+$(this).parents(classes).find('img').attr('target-category-id')+'"]');
                    var count_target = category.find('span.count').text();
                    category.find('span.count').text(parseInt(count_target)-1);
                    });
            });
EOF;

    }

    protected function deleteImageAction()
    {
        $message = $this->renderMessage(__('image_delete_error'), 'danger');
        $file = $this->_model->select('select image, image_thumb, category_id from `gallery` where id = ' . $this->getParam('dataId'));
        if ($this->_model->delete('gallery', '`id` = ' . $this->getParam('dataId')) != false) {

            $image = APPLICATION_PATH . $file[0]['image'];
            $image_thumb = APPLICATION_PATH . $file[0]['image_thumb'];
            if (!is_writable($image)) {
                chmod($image, 0777);
            }
            if (!is_writable($image_thumb)) {
                chmod($image_thumb, 0777);
            }
            if (is_file($image)) {
                unlink($image);
            }if (is_file($image_thumb)) {
                unlink($image_thumb);
            }

            $message = $this->renderMessage(__('image_delete_success'), 'success');
            $message .= '$(\'img[data-id="' . $this->getParam('dataId') . '"]\').parents(\'div.images\').remove();';
            $message .= 'var count = $(\'span.category[data-id="'.$file[0]['category_id'].'"]\').find(\'.count\').text(); $(\'span.category[data-id="'.$file[0]['category_id'].'"]\').find(\'.count\').text(count-1); ';
        }

        $this->finish(null, $message);
    }
    protected function assignImageToCategoryAction() {
        $message = $this->renderMessage(__('image_assign_error'), 'danger');
        $update = $this->_model->updateDataImage($this->getParams());

        if($update != false) {
            $message = $this->renderMessage(__('success_assign_to_category'), 'success');
        }
        $this->finish(null, $message);
    }

    protected function uploadAction() {
        $target_dir = APPLICATION_PATH . '/data/images/upload/';
        $allowed_ext = array('jpg','jpeg','png');
        $allowed_ext_mov = array( 'mp4', 'wma', 'mov');
        if(array_key_exists('file',$_FILES) && $_FILES['file']['error'] == 0 ){
            $pic = $_FILES['file'];
            if(!in_array($this->get_extension($pic['name']),array_merge($allowed_ext, $allowed_ext_mov))){
                $message = $this->renderMessage(sprintf(__('error_jpeg'),implode(',',array_merge($allowed_ext, $allowed_ext_mov))), 'danger');
                $this->finish(null, $message);
            }
            if(!move_uploaded_file($pic['tmp_name'], $target_dir.$pic['name'])){
                $message = $this->renderMessage(__('file_was_not_upload'), 'danger');
                $this->finish(null, $message);
            }
            if(in_array($this->get_extension($pic['name']),$allowed_ext)){
                if($this->importImagesAction($m = false)) {
                    $message = $this->renderMessage(sprintf(__('file_upload_done'),$pic['name']), 'success');
                    $this->finish(null, $message);
                }
            }else if(in_array($this->get_extension($pic['name']),$allowed_ext_mov)){
                if($this->uploadMovie($pic)) {
                    $message = $this->renderMessage(sprintf(__('file_upload_done'),$pic['name']), 'success');
                    $this->finish(null, $message);
                }
            }
        }
    }
    private  function get_extension($file_name){
        $ext = explode('.', $file_name);
        $ext = array_pop($ext);
        return strtolower($ext);
    }

    public function changeCategoryNameAction() {
        $message = $this->renderMessage(__('error'), 'danger');
        $save = array($this->getParam('category') => $this->getParam('value'));
        $update = $this->_model->update('category', $save, '`id` = ' . $this->getParam('category_id'));
        if ($update) {
            $message = "$('div.page-header').find('h3').css({display: 'block'}).text('".$this->getParam('value')."');
                        $('span.category[data-id=\"".$this->getParam('category_id')."\"]').text('".$this->getParam('value')."');
                        $('span.category[data-id=\"".$this->getParam('category_id')."\"]').parent().find('.badge').remove();
                        $('div.page-header').find('input[name=\"".$this->getParam('category')."\"]').css({display: 'none'});";
        }
        $this->finish(null, $message);
    }

    private function uploadMovie($movie) {
        $dir = APPLICATION_PATH . '/data/images/upload/';
        $gallery = new GalleryModel();
        $images = $gallery->getImages(' WHERE (1=1) ');
        $listOfImported = array();
        foreach ($images as $image) {
            $listOfImported[] = basename($image['image']);
        }
        $file = strtolower($movie['name']);
        $file_display = array('mp4', 'wma', 'mov');
        $ext = $this->get_extension($file);
        $shaFile = sha1($file) . '.' . $ext;

        if (in_array(pathinfo($file, PATHINFO_EXTENSION), $file_display) == true) {
            if (!in_array($shaFile, $listOfImported)) {
                if(!rename($dir . $movie['name'], $dir . $shaFile)) {
                    echo 'Nie można zmienić nazwy';
                }
                $select_category_id = $this->_model->select('Select id from category where ' . ' category_' . $this->getParam('language') . ' = "none_category"');
                $save = array('image' => '/data/images/upload/' . $shaFile, 'category_id' => $select_category_id[0]['id'], 'type' => 2);
                return $this->_model->insert('gallery', $save);
            }
        }
        return false;
    }
    public  function orderAction() {
        $this->_model->update($this->getParam('table'), array('ordering' => (int)$this->getParam('order')), '`id` = ' . $this->getParam('content_id'));
        $this->finish(null, '');
    }
}