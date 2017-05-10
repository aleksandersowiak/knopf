<?php
class Products extends BaseController {
    protected $_model;
    public function __init() {
        $this->_model = new ProductsModel();
        parent::__init();
    }
    protected function indexAction() {
        $products = $this->_model->getProducts();
        $this->ReturnView($products, false);
    }
    protected function readAction() {
       $product = $this->_model->getProducts('`id` = ' . $this->getParam('id') .' AND ');
       $this->renderValue($product[0]);
        $this->ReturnView('', false);
    }
    private function renderValue($product) {
        foreach ($product as $key => $value) {
            $this->Add($key,$value);
        }
    }
}