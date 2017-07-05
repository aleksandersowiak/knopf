<?php

class Gallery extends BaseController
{
    protected $_model;

    public function __init()
    {
        $this->_model = new GalleryModel();
        parent::__init();
    }

    protected function indexAction($fix = false)
    {
        $data = array();
        foreach ($this->_model->getImages(' WHERE category_id != 1 ', $this->getParam('language')) as $cat_img) {
            $data[$cat_img['category']][] = $cat_img['image'];
            $data[$cat_img['category']]['category_id'] = $cat_img['category_id'];
        }
        $this->ReturnView($data, false, $fix);
    }

    protected function viewAction()
    {
        $this->ReturnView($this->_model->getImages(' WHERE category_id = ' . $this->getParam('id')), false);
    }

    protected function getCategoryId($category_id)
    {
        return $this->_model->getCategoryId($category_id, $this->getParam('language'));
    }

    public function getAllImages()
    {
        return $this->_model->getImages();
    }
}