<?php
require_once('PHPMailer_v5.2/PHPMailerAutoload.php');
class Email
{
    private $_mailerObj;

    public function __construct()
    {
        $this->_mailerObj = new PHPMailer();

        $this->_mailerObj->isSMTP();
        $this->_mailerObj->SMTPDebug = 0;
        $this->_mailerObj->SMTPAuth = true;
        $this->_mailerObj->SMTPKeepAlive = true;
        $this->_mailerObj->Host = 'smtp.mail.yahoo.com';
        $this->_mailerObj->SMTPSecure = 'tls';
        $this->_mailerObj->Port = 587;
        $this->_mailerObj->Username = 'example@yahoo.com';
        $this->_mailerObj->Password = 'password';
        $this->_mailerObj->setFrom('example@yahoo.com', 'AHSAN ZIA');
        $this->_mailerObj->addReplyTo('example@yahoo.com', 'AHSAN ZIA');
    }

    public function process($case = null, $array = null)
    {
        if (!empty($case)) {

            switch ($case) {
                case 1:
                    $link = '<a href="' . SITE_URL . '/?page=activate&code=' . $array['hash'] . '">';
                    $link .= SITE_URL . '/?page=activate&code=' . $array['hash'];
                    $link .= '</a>';
                    $array['link'] = $link;

                    $this->_mailerObj->Subject = 'Activate Your Account.';
                    $this->_mailerObj->MsgHTML($this->fetchEmail($case, $array));
                    $this->_mailerObj->AddAddress($array['email'], $array['first_name'] . ' ' . $array['last_name']);

                    break;

                case 2:
                    $this->_mailerObj->Subject = 'Email from Website Contact Form';
                    $this->_mailerObj->MsgHTML($this->fetchEmail($case, $array));
                    $this->_mailerObj->AddAddress('example@yahoo.com', $array['name']);

                    break;
            }

            if ($this->_mailerObj->Send()) {
                $this->_mailerObj->ClearAddresses();
                return true;
            } else {
                //                echo json_encode($this->_mailerObj->ErrorInfo);
                //                die;
            }
        }
        return false;
    }

    public function fetchEmail($case = null, $array = null)
    {
        if (!empty($case)) {
            if (!empty($array)) {

                extract($array);

                ob_start();
                require_once(EMAILS_DIR . DS . $case . '.php');
                $out = ob_get_clean();

                //                $this->wrapEmail($out);
                return $out;
            }
        }
    }

    //    public function wrapEmail($content = null)
    //    {
    //        if (!empty($content)){
    //            return $content;
    //        }
    //    }
}
