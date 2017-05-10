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

    protected function setSessionAction () {
        $message = '';
        if (($this->getParam('userName') != '' && $this->getParam('userPassword') != '' && ($_SERVER['REQUEST_METHOD'] == 'POST'))) {
            $userName = $this->getParam('userName');
            $userPassword = $this->getParam('userPassword');
            if ($this->_model->checkUser($userName) == 1) {
                if ($this->_model->checkPassword($userName, $userPassword) != false) {
                    $data = $this->_model->getUser($this->_model->checkPassword($userName, $userPassword));
                    $this->_session->__set('user_id', $data[0]['id']);
                    $this->_session->__set('name', $data[0]['name'] . ' ' . $data[0]['surname']);
                    $message = $this->renderMessage(__('login_success'), 'success') . $this->redirect('admin','index');
                } else {
                    $message =  $this->renderMessage(__('login_incorrect'), 'danger');
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
        $this->_baseHelper->redirect('admin', 'login');
    }
}