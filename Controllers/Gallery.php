<?php
class Gallery extends BaseController {
    protected $_model;
    public function __init() {
        $this->_model = new GalleryModel();
        parent::__init();
    }
    protected function indexAction() {
        $this->ReturnView($this->_model->getImages(),false);
    }
}