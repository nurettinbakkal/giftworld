<?php
/**
 * Created by PhpStorm.
 * User: nurettin
 * Date: 01.01.2016
 * Time: 10:31
 */

namespace Application\Controller;

class PagesController
{
    public function home()
    {
        require_once('../Views/pages/home.php');
    }

    public function error()
    {
        require_once('../Views/pages/error.php');
    }
}