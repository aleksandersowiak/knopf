<?php
class Products extends BaseController {
    protected $_model;
    public function __init() {
        $this->_model = new HomeModel();
        parent::__init();
    }
    protected function indexAction() {

        $this->ReturnView('', false);
    }
}