<?php

class Url
{
    public static $_page = 'page';
    public static $_pages_dir = PAGES_DIR;
    public static $_params = array();

    /**
     * @param $key
     * @return null
     */
    public static function getParam($key){
        return (!empty($_GET[$key]))? $_GET[$key]: null;
    }

    /**
     * @return string
     */
    public static function currentPage(){
        return (!empty($_GET[self::$_page]))? $_GET[self::$_page]: 'index';
    }

    /**
     * @return string
     */
    public static function getPage(){
        $page = self::$_pages_dir . DS . self::currentPage() . '.php';
        $error = self::$_pages_dir . DS . 'error.php';
        return file_exists($page)? $page: $error;
    }

    /**
     * populate params array property
     */
    public static function setParams(){
        if (!empty($_GET)){
            foreach ($_GET as $key => $value){
                if (!empty($value)){
                    self::$_params[$key] = $value;
                }
            }
        }
    }

    /**
     * @param null $remove
     * @return string
     */
    public static function getCurrentUrl($remove = null)
    {
        self::setParams();
        $out = array();
        if (!empty($remove)) {
            $remove = (is_array($remove))? $remove: array($remove);

            foreach (self::$_params as $key => $value) {
                if (in_array($key, $remove)) {
                    unset(self::$_params[$key]);
                }
            }
        }
        foreach (self::$_params as $key => $value) {
            $out[] = $key.'='.$value;
        }
        return '?' . implode('&', $out);
    }

    /**
     * @return null|string
     */
    public static function getReferrerUrl()
    {
        $page = self::getParam(Login::$_referrer);
        return (!empty($page))? '/?page='.$page: null;
    }

    Public static function getSearchParam($remove = null)
    {
        self::setParams();
        $out = array();
        if (!empty(self::$_params)){
            foreach (self::$_params as $key => $value){
                if (!empty($remove)){
                    $remove = (is_array($remove))? $remove: array($remove);
                    if (!in_array($key, $remove)){
                        $out[] = '<input type="hidden" name="'.$key.'" value="'.$value.'" />';
                    }
                } else {
                    $out[] = '<input type="hidden" name="'.$key.'" value="'.$value.'" />';
                }
            }
            return implode('', $out);
        }
    }

}