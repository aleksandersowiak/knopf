<?php
class Gallery extends BaseController {
    protected $_model;
    public function __init() {
        $this->_model = new GalleryModel();
        parent::__init();
    }
    protected function indexAction() {
        $data = array();
        foreach ($this->_model->getImages() as $cat_img) {
            $data[$cat_img['category']][] = $cat_img['image'];
        }
        $this->ReturnView($data,false);
    }

    protected function viewAction() {
        $this->ReturnView($this->_model->getImages(' WHERE category_id = ' . $this->getParam('id')),false);
    }
    protected function getCategoryId($name) {
        return $this->_model->getCategoryId($name);
    }
}