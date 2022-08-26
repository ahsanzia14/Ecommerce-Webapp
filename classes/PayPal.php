<?php

class PayPal
{
    private $_env = 'sandbox';

    private $_url_production = 'https://www.paypal.com/cgi-bin/webscr';
    private $_url_sandbox = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

    private $_url;

    private $_cmd;

    private $_products = array();
    private $_fields = array();

    private $_business = 'example-facilitator@yahoo.com';
    private $_page_style = null;

    private $_url_return;
    private $_cancel_payment;
    private $_url_notify;
    private $_currency_code = 'USD';

    public $_tax_cart = 0;
    public $_tax = 0;

    public $_populate = array();

    private $_ipn_data = array();
    private $_log_file = null;
    private $_ipn_result;


    public function __construct($cmd = '_cart')
    {
        $this->_url = ($this->_env == 'sandbox')? $this->_url_sandbox: $this->_url_production;
        $this->_cmd = $cmd;
        $this->_url_return = SITE_URL . '/?page=return';
        $this->_cancel_payment = SITE_URL . '/?page=cancel';
        $this->_url_notify = SITE_URL . '/?page=ipn';
        $this->_log_file = ROOT_PATH .DS. 'log' .DS. 'ipn.log';
    }

    public function addProduct($number, $name, $price = 0, $quantity = 1)
    {
        switch ($this->_cmd){
            case '_cart':
                $id = count($this->_products) + 1;
                $this->_products[$id]['item_number_'.$id] = $number;
                $this->_products[$id]['item_name_'.$id] = $name;
                $this->_products[$id]['amount_'.$id] = $price;
                $this->_products[$id]['quantity_'.$id] = $quantity;
                break;
            case '_xclick':
                if (!empty($this->_products)){
                    $this->_products[0]['item_number'] = $number;
                    $this->_products[0]['item_name'] = $name;
                    $this->_products[0]['amount'] = $price;
                    $this->_products[0]['quantity'] = $quantity;
                }
                break;
        }
    }

    public function run($trans_id = null)
    {
        if (!empty($trans_id)){
            $this->addField('custom', $trans_id);
        }
        return $this->render();
    }

    private function addField($name = null, $value = null)
    {
        if (!empty($name) && !empty($value)){
            $this->_fields[] = '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
        }
    }

    private function render()
    {
        $out = '<form action="'.$this->_url.'" method="post" id="frm_paypal">';
        $out .= $this->getFields();
        $out .= '<input type="submit" value="Submit" />';
        $out .= '</form>';
        return $out;
    }

    private function getFields()
    {
        $this->processFields();
        if (!empty($this->_fields)){
            return implode('', $this->_fields);
        }
    }

    private function processFields()
    {
        $this->standardFields();
        if (!empty($this->_products)){
            foreach ($this->_products as $product){
                foreach ($product as $key => $value){
                    $this->addField($key, $value);
                }
            }
        }
        $this->prePopulate();
    }

    private function standardFields()
    {
        $this->addField('cmd', $this->_cmd);
        $this->addField('business', $this->_business);
        if (!empty($this->_page_style)){
            $this->addField('page_style', $this->_page_style);
        }
        $this->addField('return', $this->_url_return);
        $this->addField('notify_url', $this->_url_notify);
        $this->addField('cancel_payment', $this->_cancel_payment);
        $this->addField('currency_code', $this->_currency_code);
        $this->addField('rm', 2);

        switch ($this->_cmd){
            case '_cart':
                if ($this->_tax_cart != 0){
                    $this->addField('tax_cart', $this->_tax_cart);
                }
                $this->addField('upload', 1);
                break;
            case '_xclick':
                if ($this->_tax != 0){
                    $this->addField('tax', $this->_tax);
                }
                break;
        }
    }

    private function prePopulate()
    {
        if (!empty($this->_populate)){
            foreach ($this->_populate as $key => $value){
                $this->addField($key, $value);
            }
        }
    }

    public function ipn()
    {
        if ($this->validateIpn()){
            $this->sendCurl();
            
            $orderObj = new Order();

            if (strcmp($this->_ipn_result, 'VERIFIED') == 0){
                // $this->saveLog();
                $orderObj->approveOrder($this->_ipn_data, $this->_ipn_result);

            } elseif (strcmp($this->_ipn_result, 'INVALID') == 0) {
                // $this->saveLog();
                $orderObj->approveOrder($this->_ipn_data, $this->_ipn_result);
            } else {
                $this->_ipn_result = 'NO RESPONSE';
                // $this->saveLog();
                $orderObj->approveOrder($this->_ipn_data, $this->_ipn_result);
            }
        }
    }

    private function validateIpn()
    {
        $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        if (!preg_match('/paypal\.com$/', $hostname)){
            return false;
        }

        $formObj = new Form();
        $this->_ipn_data = $formObj->getPostArray();

        if (
            !empty($this->_ipn_data) &&
            array_key_exists('receiver_email', $this->_ipn_data) &&
            strtolower($this->_ipn_data['receiver_email']) != strtolower($this->_business)
        ){
            return false;
        }

        return true;
    }

    private function sendCurl()
    {
        $response = $this->getReturnParams();
        
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $this->_url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
        // curl_setopt($ch, CURLOPT_HEADER, 0);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //     "Content-Type: application/x-www-form-urlencoded",
        //     "Content-Length: " . strlen($response)
        // ));
        // curl_setopt($ch, CURLOPT_VERBOSE, 1);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        // $this->_ipn_result = curl_exec($ch);
        // curl_close($ch);

        $ch = curl_init($this->_url);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        $this->_ipn_result = curl_exec($ch);
        curl_close($ch);
    }

    private function getReturnParams()
    {
        $out = array('cmd=_notify-validate');
        if (!empty($this->_ipn_data)){
            foreach ($this->_ipn_data as $key => $value){
                $value = (function_exists('get_magic_quotes_gpc'))?
                            urlencode(stripslashes($value)):
                            urlencode($value);
                $out[] = "$key=$value";
            }
        }
        return implode('&', $out);
    }

   private function saveLog()
   {
       $out = array();

       $out[] = "Date: " . Helper::setDate(4);
       $out[] = "Status: $this->_ipn_result";
       $out[] = "IPN Response:\n";

       if (!empty($this->_ipn_data)){
           foreach ($this->_ipn_data as $key => $value){
               $out[] = "$key: $value";
           }
       }

       $out[] = "\n---------------------------\n";

       $log = implode("\n", $out);

       file_put_contents($this->_log_file, $log, FILE_APPEND);
   }

}