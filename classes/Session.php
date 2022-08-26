<?php
class Session {

	/**
	 * @param $id
	 * @param int $quantity
     */
	public static function addProduct($id, $quantity = 1)
	{
		$_SESSION['basket'][$id]['quantity'] = $quantity;
	}

	/**
	 * @param $id
	 * @param null $quantity
     */
	public static function removeProduct($id, $quantity = null)
	{
		if ($quantity != null && $quantity < $_SESSION['basket'][$id]['quantity']) {
			$_SESSION['basket'][$id]['quantity'] = $_SESSION['basket'][$id]['quantity'] - $quantity;
		} else {
			$_SESSION['basket'][$id] = null;
			unset($_SESSION['basket'][$id]);
		}
	}

	/**
	 * @param null $name
	 * @return null
     */
	public static function getSession($name = null)
	{
		if (!empty($name)){
			return (isset($_SESSION[$name]))? $_SESSION[$name]: null;
		}
		return null;
	}

	/**
	 * @param null $name
	 * @param null $value
     */
	public static function setSession($name = null, $value = null)
	{
		if (!empty($name) && !empty($value)){
			$_SESSION[$name] = $value;
		}
	}

	/**
	 * @param null $name
     */
	public static function clearSession($name = null)
	{
		if (!empty($name) && isset($_SESSION[$name])){
			self::cleanSession($name);
		} else {
			session_destroy();
		}
	}

	public static function cleanSession($name = null)
	{
		if (isset($_SESSION[$name]) && !empty($name)){
			$_SESSION[$name] = null;
			unset($_SESSION[$name]);
		}
	}
}