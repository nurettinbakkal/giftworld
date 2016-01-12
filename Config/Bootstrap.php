<?php
/**
 * Created by PhpStorm.
 * User: nurettin
 * Date: 01.01.2016
 * Time: 11:27
 */

if ( isset($_SERVER['APPLICATION_ENV']) && $_SERVER['APPLICATION_ENV'] === 'production' ) {
    define('APPLICATION_ENV', 'PRODUCTION');
} else {
    define('APPLICATION_ENV', 'DEVELOPMENT');
}

define('PASSWORD_SALT', 'xOls19xNWO');

define('COOKIE_NAME', 'giftworld_cookie');
define('SESSION_COOKIE_EXPIRY', 3600);