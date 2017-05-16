<?php

class Admin extends BaseController
{
    protected $_model;
    protected $_heleper;

    public function __init()
    {
        $this->_model = new AdminModel();
        parent::__init();
    }

    protected function indexAction()
    {
        $this->checkSession();
        $content = '';
        switch ($this->getParam('id')) {
            case 'contents' :
                $contentData = array();
                $content = $this->_model->getContents();

                foreach ($content as $key => $val) {
                    $textContent = $this->_model->getDataToEdit($val['controller'], $val['action'], $val['id'], $this->getParam('language'));
                    if (!array_key_exists($val['controller'], $contentData)) {
                        $contentData[] = '<span class="label label-primary">' . $val['controller'] . '</span> <span class="like-link" id="pop-upModal" data-url="' . createUrl('admin', 'add') . '" data-controller="' .
                            $val['controller'] . '" params="dataController:' . $val['controller'] .'"><i class="glyphicon glyphicon-plus-sign"></i> ' . __('add') . '</span>';
                    }
                    $contentData[$val['controller']][] = '<span class="label label-default" data-id="' . $val['id'] . '"> ' .
                        __('menu_' . $val['action']) . '</span>' .
                        ' <span class="like-link edit-document" data-url="' . createUrl('admin', 'edit') . '" data-action="' .
                        $val['action'] . '" data-controller="' .
                        $val['controller'] . '"  data-id="' .
                        $val['id'] . '"><i class="glyphicon glyphicon-edit"></i> ' . __('edit') . '</span>' .
                        ' <p><i>' . $this->_baseHelper->restrictText($textContent, 100, true) . '</i></p>';
                }
                $content = $this->createList($contentData);
                break;
        }
        $this->Add('viewContent', $content);
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
                    $message = $this->renderMessage(__('login_success'), 'success') . $this->redirect('admin', 'index');
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

        $data = $this->_model->getDataToEdit($controller, $action, $id, $lang);
        if ($data != false) {
            $this->Add('dataEdit', $data);
        }
        $this->ReturnView('', false);

    }

    protected function saveAction()
    {
        $message = $this->renderMessage(__('save_error'), 'danger');
        if ($this->getParam("action") != '') {
            $this->_model->{$this->getParam("action") . 'Data'}($this->getParams());
            $message = $this->renderMessage(__('login_incorrect'), 'success');
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

    protected function addAction () {
        $content = $this->_model->getContents();
        $contentData= array();
        foreach ($content as $key => $val) {
//            if (!array_key_exists($val['controller'], $contentData)) {
//                $contentData[] = $val['controller'];
//            }
            $contentData[$val['controller']][] = $val['action'];
        }
        $this->Add('contentAdd',array_unique($contentData[$this->getParam('dataController')]));
        $this->ReturnView('',false);
    }
}