<?php
abstract class BaseController extends BaseModel{
	protected $urlvalues;
	protected $action;
    protected $_params = array();
    public $_session;
    public $_baseHelper;

	public function __construct($action, $urlvalues) {
		$this->action = $action;
		$this->urlvalues = $urlvalues;
        $the_request = array();
        if (isset($_SERVER['REQUEST_METHOD'])) {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $the_request = & $_GET;
                    break;
                case 'POST':
                    $the_request = & $_POST;
                    break;
                default:
            }
        }
        $this->setParams($the_request);
        $this->__init();
        $this->Add('web_title','<img src="/data/images/logo.png"/>');
        $this->Add('top_menu',$this->_model->getTopMenu());
        $this->_session = new Session();
        if (session_status() == PHP_SESSION_NONE) {
            $this->_session->startSession();
        }

        $this->_baseHelper = new BaseHelper();

	}
	public function __init() {
        $this->Add('_publickey',$this->getConfig()['recaptcha.public']);
        $this->Add('_privatekey',$this->getConfig()['recaptcha.private']);
    }
	public function ExecuteAction() {
		return $this->{$this->action}();
	}
	
	protected function ReturnView($viewmodel, $fullview, $fixView = null) {
        if($fixView != null) $this->action = $fixView;
		$viewloc = 'views/' . get_class($this) . '/' . str_replace('Action','',$this->action) . '.phtml';
        if ($fullview) {
            return;
        } else {
            require('views/template/header.phtml'); // is set default header
            require($viewloc); // data from controller action
            require('views/template/footer.phtml'); // is set default footer
        }
	}

    public function setParam($key, $value)
    {
        $key = (string)$key;
        if ((null === $value) && isset($this->_params[$key])) {
            unset($this->_params[$key]);
        } elseif (null !== $value) {
            $this->_params[$key] = $value;
        }
        return $this;
    }

    public function setParams(array $array)
    {
        $this->_params = $this->_params + (array)$array;
        foreach ($this->_params as $key => $value) {
            if (null === $value) {
                unset($this->_params[$key]);
            }
        }
        return $this;
    }

    public function getParam($key, $default = null)
    {
        $key = (string)$key;
        if (isset($this->_params[$key])) {
            return $this->_params[$key];
        }
        return $default;
    }

    public function getParams()
    {
        return $this->_params;
    }
    public function mailClass()
    {
        include(dirname(__FILE__) . "/mailer/class.phpmailer.php");
        $email = new PHPMailer(true);
        $this->_email = $email;
        include(dirname(__FILE__) . "/mailer/setparameters.php");
        return $this->_email;
    }
    public function send_mail($title = 'Default', $message = '', $attachment = null)
    {
        $mail = $this->mailClass();

        $mail->ClearReplyTos();
        $mail->From = "aleksander.sowiak@codeconcept.pl";
        $mail->FromName = $title;

        $arr = $this->getConfig();
        $mail->AddAddress($arr['email.globalAddress'], '');

        if ($attachment != null) {
            $mail->AddAttachment($attachment);
        }
        $mail->IsSMTP();
        $mail->Subject = "" . $title . " - " . date('Y-m-d_H:i:s');
        $mail->Body = $message;
        $mail->Send();
        unset($mail);
    }
    public function renderMessage($message,$status) {
        return  <<<EOF
        $('#body').find('.container').append('<div class="box-message"><div class="alert alert-$status pop-up" role="alert">$message</div></div>');
        setTimeout(function(){
            $('.alert').remove();
        }, 5000);
EOF;
    }
    public function redirect($controller = '', $action = '', $url = '') {
        if($controller != '' && $action != '') {
            return  'window.location="'.createUrl($controller,$action).'";';
        }else if ($url != '') {
            return  'window.location="'.$url.'";';
        }else{
            return  'window.location=window.location.href;';
        }
    }
    public function checkSession($redirect = true)
    {
        if (!$this->_session->__isset("user_id")
            && !$this->_session->__isset('name')
        ) {
            if ($redirect == true) {
                $this->_baseHelper->redirect('admin', 'login');
            }
            return false;
        }
        return true;
    }
    public function finish($msg = null,$extraCommand = null, $type = "success") {
        $result = array();
        $result['cmd'] = 'break';

        if(!is_null($extraCommand)) {
            $result['extraCommand'] = $extraCommand;
        }

        if(!is_null($msg)) {
            $result['msg'] = $msg;
            $result['type'] = $type;
            $result['cmd'] = 'break-with-msg';
        }

        die(json_encode($result));
    }
}
