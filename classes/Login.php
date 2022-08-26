<?php

class Login
{
    public static $_login_page_front = '/?page=login';
    public static $_dashboard_front = '/?page=orders';
    public static $_login_client = 'cid';
    public static $_client_name = 'cname';

    public static $_login_page_admin = '/admin/';
    public static $_dashboard_admin = '/admin/?page=products';
    public static $_login_admin = 'aid';

    public static $_valid_login = 'valid';
    public static $_referrer = 'refer';


    /**
     * check for restricted area
     */
    public static function restrictUser()
    {
        if (!self::isLoggedIn(self::$_login_client)){
            $url = (Url::currentPage() != 'logout')?
                    self::$_login_page_front .'&'. self::$_referrer .'='. Url::currentPage():
                    self::$_login_page_front;
            Helper::redirect($url);
        }
    }

    /**
     *
     */
    public static function restrictAdmin()
    {
        if (!self::isLoggedIn(self::$_login_admin)){
            Helper::redirect(self::$_login_page_admin);
        }
    }

    /**
     * @param $case
     * @return bool
     */
    public static function isLoggedIn($case = null)
    {
        if (!empty($case)){
            if (isset($_SESSION[self::$_valid_login]) && $_SESSION[self::$_valid_login] == 1){
                return isset($_SESSION[$case])? true: false;
            }
        }
        return false;
    }

    /**
     * @param $id
     * @param null $url
     */
    public static function loginFront($id = null, $url = null)
    {
        if (!empty($id)){
            $url = (!empty($url))? $url: self::$_dashboard_front;
            $_SESSION[self::$_login_client] = $id;
            $_SESSION[self::$_client_name] = self::getUserFullName($id);
            $_SESSION[self::$_valid_login] = 1;
            Helper::redirect($url);
        }
    }

    /**
     * @param null $id
     * @param null $url
     */
    public static function loginAdmin($id = null, $url = null)
    {
        if (!empty($id)){
            $url = (!empty($url))? $url: self::$_dashboard_admin;
            $_SESSION[self::$_login_admin] = $id;
            $_SESSION[self::$_valid_login] = 1;
            Helper::redirect($url);
        }
    }

    /**
     * @param $str
     * @return bool|string
     */
    public static function takeHash($str)
    {
        return password_hash($str, PASSWORD_DEFAULT);
    }

    /**
     * @param $str
     * @param $hash
     * @return bool
     */
    public static function verifyHash($str, $hash)
    {
        return password_verify($str, $hash);
    }

    /**
     * @param null $id
     * @return string
     */
    public static function getUserFullName($id = null)
    {
        if (!empty($id)) {
            $userObj = new User();
            $user = $userObj->getUserById($id);
            if (!empty($user)) {
                return $user['first_name'] .' '. $user['last_name'];
            }
        }
    }

    /**
     * @param null $name
     */
    public static function logout($name = null)
    {
        if (!empty($name) && isset($_SESSION[$name])){
            $_SESSION[$name] = null;
            $_SESSION[Login::$_valid_login] = null;
            unset($_SESSION[$name]);
            unset($_SESSION[Login::$_valid_login]);
        } else {
            session_destroy();
        }
    }

}