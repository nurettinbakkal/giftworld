<?php
/**
 * Created by PhpStorm.
 * User: nurettin
 * Date: 01.01.2016
 * Time: 10:30
 */

function call($controller, $action)
{
    require_once('../Controllers/Controller.php');
    require_once('../Controllers/' . $controller . '_controller.php');
    require_once('../Config/DatabaseConfig.php');
    require_once('../Models/Model.php');
    require_once('../Services/Util.php');
    require_once('../Services/GiftRequestService.php');

    switch($controller) {
        case 'pages':
            $controller = new \Application\Controller\PagesController();
            break;
        case 'users':
            require_once('../Models/User.php');
            $controller = new \Application\Controller\UsersController();
            break;
        case 'gifts':
            require_once('../Models/User.php');
            require_once('../Models/Gift.php');
            require_once('../Models/GiftRequest.php');
            $controller = new \Application\Controller\GiftsController();
            break;
    }

    $controller->{ $action }();
}

$controllers = array(
    'pages' => ['home', 'error'],
    'users' => ['home', 'login', 'logout'],
    'gifts' => ['home', 'send', 'listusers', 'accept'],
);

$allows = array(
    'pages' => ['home', 'error'],
    'users' => ['login', 'logout'],
);

if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
        if (in_array($action, $allows[$controller])) {
            call($controller, $action);
        } elseif (\Application\Helper\Session::isLoggedIn()) {
            call($controller, $action);
        } else {
            call('pages', 'home');
        }
    } else {
        call('pages', 'error');
    }
} else {
    call('pages', 'error');
}