<?php
abstract class BaseController extends BaseModel{
	protected $urlvalues;
	protected $action;
    protected $_params = array();

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
        $this->Add('web_title','Knopf');
        $this->Add('top_menu',$this->_model->getTopMenu());
	}
	public function __init() {

    }
	public function ExecuteAction() {
		return $this->{$this->action}();
	}
	
	protected function ReturnView($viewmodel, $fullview) {
		$viewloc = 'views/' . get_class($this) . '/' . str_replace('Action','',$this->action) . '.phtml';
		if ($fullview) {
			require('views/maintemplate.phtml');
            return;
		} else {
            require('views/template/header.phtml'); // is set default header
			require($viewloc);  // data from controller action
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
    public function renderMessage($message,$status,$url = '') {
        return <<<EOF
<script>
$('#body').append('<div class="box-message"><div class="alert alert-$status pop-up" role="alert">$message</div></div>');
setTimeout(function(){
//$('.alert').remove();
//if('$url' != '') {
//        window.location="$url";
//    }
}, 5000);
</script>
EOF;

    }
    public function redirect($controller = '', $action = '') {
        header('Location: ' . createUrl($controller,$action));
    }
}
