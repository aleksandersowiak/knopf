<?php
class Admin extends BaseController {
    protected $_model;
    protected $_heleper;
    public function __init() {
        $this->_model = new AdminModel();
//        $this->_heleper = new HomeHelper();
        parent::__init();
    }
    protected function indexAction(){
        if(!$this->_session->__isset("user_id")
            && !$this->_session->__isset('name')){
            $this->redirect('admin','login');
        }
        $this->ReturnView('', false);
    }

    protected function loginAction() {
        if($this->_session->__isset("user_id")
            && $this->_session->__isset('name')){
            $this->redirect('admin','index');
        }
        $this->ReturnView('', false);
        if(($this->getParam('userName') != '' && $this->getParam('userPassword') != '' && ($_SERVER['REQUEST_METHOD'] == 'POST'))) {
            $userName = $this->getParam('userName');
            $userPassword = $this->getParam('userPassword');
            if($this->_model->checkUser($userName) == 1) {
                if(count($this->_model->checkPassword($userName, $userPassword)) == 1) {
                    $data = $this->_model->getUser($this->_model->checkPassword($userName, $userPassword));
                    $this->_session->__set('user_id', $data[0]['id']);
                    $this->_session->__set('name',$data[0]['name'] . ' ' . $data[0]['surname']);
                    echo $this->renderMessage(__('login_success'),'success', createUrl('home','index'));
                } else{
                    echo $this->renderMessage(__('password_incorrect'),'danger');
                    return;
                }
            }else{
                echo $this->renderMessage(__('user_not_exists'),'danger');
                return;
            }
        }
    }

    protected function logoutAction(){
        $this->ReturnView('', false, 'index');
        $this->_session->destroy();
        echo $this->renderMessage(__('logout_success'),'success', createUrl('home','index'));
    }
}