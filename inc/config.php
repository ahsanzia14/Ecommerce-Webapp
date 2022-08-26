<?php
// checking session if exists
if (!isset($_SESSION)){
    // starting session
    session_start();
}

// Site URL
defined('SITE_URL') || define('SITE_URL', 'http://' . $_SERVER['SERVER_NAME']);

// Directory Separator
defined('DS') || define('DS', DIRECTORY_SEPARATOR);

// Root Path
defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(__FILE__) . DS . '..' . DS));

// Classes Dir
defined('CLASSES_DIR') || define('CLASSES_DIR', 'classes');

// Pages Dir
defined('PAGES_DIR') || define('PAGES_DIR', 'pages');

// Modules Dir
defined('MODULES_DIR') || define('MODULES_DIR', 'modules');

// Inc Dir
defined('INC_DIR') || define('INC_DIR', 'inc');

// Templates Dir
defined('TEMPLATES_DIR') || define('TEMPLATES_DIR', 'templates');

// Catalog Dir
defined('CATALOG_DIR') || define('CATALOG_DIR', ROOT_PATH . DS . 'media' . DS . 'catalog');

// Emails Dir
defined('EMAILS_DIR') || define('EMAILS_DIR', ROOT_PATH . DS . 'emails');

// adding all above defined directories into include path
set_include_path(implode(PATH_SEPARATOR, array(
        realpath(ROOT_PATH . DS . CLASSES_DIR),
        realpath(ROOT_PATH . DS . PAGES_DIR),
        realpath(ROOT_PATH . DS . MODULES_DIR),
        realpath(ROOT_PATH . DS . INC_DIR),
        realpath(ROOT_PATH . DS . TEMPLATES_DIR),
        get_include_path()
)));