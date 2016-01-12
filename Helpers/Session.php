<?php
/**
 * Created by PhpStorm.
 * User: nurettin
 * Date: 01.01.2016
 * Time: 09:00
 */

namespace Application\Helper;


class Session
{
    public function __construct()
    {
        $session_id = session_id();
        if (empty($session_id)) {
            session_start();
        }
    }

    /**
     * @param $key
     * @param $value
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @return bool
     */
    public static function isLoggedIn()
    {
        return empty($_SESSION["is_logged_in"]) || !is_bool($_SESSION["is_logged_in"]) ? false : $_SESSION["is_logged_in"];
    }

    /**
     * @return int|null
     */
    public static function getUserId()
    {
        return empty($_SESSION["userid"]) ? null : (int)$_SESSION["userid"];
    }

    /**
     * @return mixed
     */
    public static function getSession()
    {
        return $_SESSION;
    }

    /**
     * @return null
     */
    public static function getCsrfToken()
    {
        return empty($_SESSION["csrf_token"]) ? null : $_SESSION["csrf_token"];
    }

    /**
     * @return null
     */
    public static function getCsrfTokenTime()
    {
        return empty($_SESSION["csrf_token_time"]) ? null : $_SESSION["csrf_token_time"];
    }

    /**
     * @return null
     */
    public static function generateCsrfToken()
    {
        $max_time = 60 * 60; // 1 hour
        $stored_time = self::getCsrfTokenTime();
        $csrf_token  = self::getCsrfToken();
        if($max_time + $stored_time <= time() || empty($csrf_token)){
            $token = md5(uniqid(rand(), true));
            $_SESSION["csrf_token"] = $token;
            $_SESSION["csrf_token_time"] = time();
        }
        return self::getCsrfToken();
    }

    /**
     * @param $username
     */
    public static function create($username)
    {
        session_regenerate_id(true);
        $_SESSION = array();
        setcookie(COOKIE_NAME, $username, time() + (SESSION_COOKIE_EXPIRY));
    }

    public static function destroy()
    {
        session_unset();
        session_destroy();
        setcookie(COOKIE_NAME, '', time() - SESSION_COOKIE_EXPIRY);
    }


}