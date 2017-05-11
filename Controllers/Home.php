<?php
class Home extends BaseController {
    protected $_model;
    protected $_modelAdmin;
    protected $_heleper;
    public function __init() {
        $this->_model = new HomeModel();
        $this->_modelAdmin = new AdminModel();
        $this->_heleper = new HomeHelper();

        parent::__init();
    }
	protected function indexAction() {
        $this->Add('slide', $this->_model->getSlide());

        $about = $this->_model->getContent($this->action);
        $this->Add('homeView',$about);
        $this->ReturnView('', false);
	}
    public function contactSendAction() {
        $flash_message = $this->renderMessage(__('error'), 'danger');
        if(($this->getParam('first_name') != '') && ($this->getParam('last_name') != '') && ($this->getParam('email') != '')) {
            $resp = recaptcha_check_answer ($this->_privatekey,
                $_SERVER["REMOTE_ADDR"],
                $this->getParam("recaptcha_challenge_field"),
                $this->getParam("recaptcha_response_field"));
            if (!$resp->is_valid) {
                $flash_message = $this->renderMessage(__('reCAPTCHA_error'), 'danger') . "$('#recaptcha_widget_div').parents('.form-group').addClass('recaptcha_widget_div_has-error');";
            } else {
                $emailTemplate = dirname(__FILE__) . '/../data/template/contact_mail.txt';
                $message_contact = "<table border='0' style='width: 500px; border: 0'>
                                      <tr>
                                        <td style='width: 100px'>First Name: </td>
                                        <td>%s</td>
                                      </tr>
                                      <tr>
                                        <td style='width: 100px'>Last Name: </td>
                                        <td>%s</td>
                                      </tr>
                                      <tr>
                                        <td style='width: 100px'>E-mail: </td>
                                        <td>%s</td>
                                      </tr>
                                      <tr>
                                        <td style='width: 100px'>Phone: </td>
                                        <td>%s</td>
                                      </tr>
                                      <tr>
                                        <td style='width: 100px'>Message: </td>
                                        <td>%s</td>
                                      </tr>
                                    </table>";

                $message = sprintf($message_contact, $this->getParam('first_name'), $this->getParam('last_name'), $this->getParam('email'), $this->getParam('phone'), $this->getParam('comment'));
                $message = str_replace("%message%", $message, file_get_contents($emailTemplate));
                   $send = $this->send_mail(__('mail_title'),$message);
                if($send['status'] == false){
                    $flash_message = $this->renderMessage(__($send['message']), 'success') . "$('#recaptcha_reload').trigger('click'); $('form').trigger('reset');";
                }
                $flash_message =  $this->renderMessage(__('send_mail'), 'success') . "$('#recaptcha_reload').trigger('click'); $('form').trigger('reset');";

            }
        }
        $this->finish(null, $flash_message);
    }
    protected function contactAction() {
        $contact = sprintf($this->_model->getContent($this->action),__('address'),__(''),__('phone'),__('phone'),__('email'));
        $this->Add('contactView',$contact);
        $this->ReturnView('', false);
    }
    protected function aboutAction() {
        $about = $this->_model->getContent($this->action);
        $this->Add('aboutView',$about);
        $this->ReturnView('', false);
    }
    protected function testAction() {
        echo '<div class="page-header"><h3>dddd</h3></div>';
    }
}