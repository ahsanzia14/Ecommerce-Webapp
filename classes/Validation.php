<?php
class Validation {

	private $_formObj;

	private $_error = array();	//kept field name if error
	public $_error_message = array(
		'first_name' => 'Please provide your First Name.',
		'last_name' => 'Please provide your Last Name.',
		'address' => 'Please provide your Address.',
		'address_1' => 'Please provide your Address 1.',
		'town' => 'Please provide your Town Name.',
		'county' => 'Please provide your County Name.',
		'post_code' => 'Please provide your Post Code.',
		'country' => 'Select your Country form the List.',
		'email' => 'Please provide your Email Address.',
		'duplicate_email' => 'This email is already registered.',
		'login' => 'Please provide valid Email / Password.',
		'password' => 'Please provide your Password.',
		'confirm_password' => 'Please Confirm your Password.',
		'password_mismatch' => 'Password Mismatch.',
		'category' => 'Please Select a Category',
		'name' => 'Please provide Name.',
		'description' => 'Please provide Description.',
		'price' => 'Please provide Price.',
		'telephone' => 'Please provide Telephone #',
		'vat_rate' => 'Please provide VAT.',
		'message' => 'Please send some message or ask question.',
		'subject' => 'Please provide Subject.',
		'qty' => 'Please provide Quantity.',
		'iban' => 'Please provide IBAN(International Bank Account Number).',
		'bank_name' => 'Please provide your Bank Name.',
		'branch' => 'Please provide Branch of Bank.',
		'city' => 'Please provide city.',
		'routing_no' => 'Please provide your Branch Routing No.',
		'swift_bic' => 'Please provide SWIFT / BIC Code.',
		'acc_owner' => 'Please provide Account Owner Name.',
		'acc_no' => 'Please provide Account no.',
		'slogan' => 'Please provide your business statement.'
	);

	public $_expected = array();
	public $_required = array();
	public $_special = array();
	public $_post = array();
	public $_post_remove = array();
	public $_post_format = array();

	/**
	 * Validation constructor.
	 * @param $formObj
     */
	public function __construct($formObj)
	{
		$this->_formObj = $formObj;
	}

	/**
	 * Initialization function
     */
	public function process()
	{
		if ($this->_formObj->isPost() && !empty($this->_required)) {
			$this->_post = $this->_formObj->getPostArray($this->_expected);

	 		if (!empty($this->_post)) {
				foreach ($this->_post as $key => $value) {
					$this->check($key, $value);
				}
			}
		}
	}

	/**
	 * @param $key
	 * @param $value
     */
	public function check($key, $value)
	{
		if (!empty($this->_special) && array_key_exists($key, $this->_special)) {
			$this->checkSpecial($key, $value);
		} else {
			if (in_array($key, $this->_required) && empty($value)) {
				$this->addToErrorArray($key);
			}
		}
	}

	/**
	 * @param $key
	 * @param $value
     */
	public function checkSpecial($key, $value)
	{
		switch ($this->_special[$key]) {
			case 'email':
				if (!$this->isValidEmail($value)) {
					$this->addToErrorArray($key);
				}
				break;
		}
	}

	/**
	 * @param $email
	 * @return bool
     */
	public function isValidEmail($email)
	{
		if (!empty($email)) {
			$result = filter_var($email, FILTER_VALIDATE_EMAIL);
			return $result? true: false;
		} 
		return false;
	}

	/**
	 * @param $key
     */
	public function addToErrorArray($key)
	{
		$this->_error[] = $key;
	}

	/**
	 * @return bool
     */
	public function isValid()
	{
		$this->process();
		if (empty($this->_error) && !empty($this->_post)) {

			if (!empty($this->_post_remove)) {
				foreach ($this->_post_remove as $value) {
					unset($this->_post[$value]);
				}
			}

			if (!empty($this->_post_format)) {
				foreach ($this->_post_format as $key => $value) {
					$this->format($key, $value);
				}
			}
			
			return true;
		}
		return false;
	}

	/**
	 * @param $key
	 * @param $value
     */
	public function format($key, $value)
	{
		switch ($value) {
			case 'password':
				$this->_post[$key] = Login::takeHash($this->_post[$key]);
				break;
		}
	}

	/**
	 * @param $key
	 * @return string
     */
	public function validate($key)
	{
		if (!empty($this->_error) && in_array($key, $this->_error)){
			return $this->wrapWarnMsg($this->_error_message[$key]);
		}
	}

	/**
	 * @param null $msg
	 * @return string
     */
	public function wrapWarnMsg($msg = null){
		if (!empty($msg)){
			return '<span class="warn">' .$msg. '</span>';
		}
	}
	
}