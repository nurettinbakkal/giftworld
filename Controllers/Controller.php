<?php
/**
 * Created by PhpStorm.
 * User: nurettin
 * Date: 01.01.2016
 * Time: 09:18
 */

namespace Framework;

use Application\Helper\Session;

class Controller
{
    public function sessionCreate($username)
    {
        Session::create($username);
    }

    public function sessionDestroy()
    {
        Session::destroy();
    }

    public function checkSession()
    {
        if (!Session::isLoggedIn()) {
            header('location:?controller=pages&action=home');
        }
    }
}