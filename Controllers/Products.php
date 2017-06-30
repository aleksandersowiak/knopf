<?php

class Products extends BaseController
{
    protected $_model;

    public function __init()
    {
        $this->_model = new ProductsModel();
        parent::__init();
    }

    protected function indexAction()
    {
        $products = $this->_model->getProducts('', $this->getParam('language'));

        $this->ReturnView($products, false);
    }

    protected function readAction()
    {
        $product = $this->_model->getProducts('`p`.`id` = ' . $this->getParam('id') . ' AND ', $this->getParam('language'));
        if (empty($product)) $this->_baseHelper->redirect('products', 'index');
        $this->renderValue($product[0]);
        $this->Add('realization', $this->_model->getRealizationProduct($product[0]['id']));
        $gallery = new GalleryModel();
        $this->Add('image', $gallery->getImages('WHERE product_id = ' . $product[0]['id']));
        $this->ReturnView('', false);
    }

    private function renderValue($product)
    {
        foreach ($product as $key => $value) {
            $this->Add($key, $value);
        }
    }
}