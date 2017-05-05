<?php
class Home extends BaseController {
    protected $_model;
    protected $_heleper;
    public function __init() {
        $this->_model = new HomeModel();
        $this->_heleper = new HomeHelper();
        parent::__init();
    }
	protected function indexAction() {
        $this->Add('slide', $this->_model->getSlide());
        $this->ReturnView('', false);
	}

    protected function contactAction() {

        if($this->getParam('sendContact')) {
            $emailTemplate = dirname(__FILE__) . '/../data/template/contact_mail.txt';
            $message = $this->getParam('first_name') .'<br>';
            $message .= $this->getParam('last_name') .'<br>';
            $message .= $this->getParam('email') .'<br>';
            $message .= $this->getParam('phone') .'<br>';
            $message .= $this->getParam('comment') .'<br>';

            $message = str_replace("%message%", $message, file_get_contents($emailTemplate));
            $this->send_mail(__('test_mail_title'),$message);
            $this->Add('flash_message',$this->renderMessage('Mail was sent!', 'success', createUrl('home','contact')));

        }
        $this->ReturnView('', false);
    }
}