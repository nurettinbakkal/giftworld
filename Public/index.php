<?php
/**
 * Created by PhpStorm.
 * User: nurettin
 * Date: 01.01.2016
 * Time: 10:26
 */

if ( isset($_GET['controller']) && isset($_GET['action']) ) {
    $controller = strtolower($_GET['controller']);
    $action     = strtolower($_GET['action']);
} else {
    $controller = 'pages';
    $action     = 'home';
}
session_start();
ob_start();
require_once('../Helpers/Session.php');

if ( $controller == 'gifts' && $action == 'send' ) {
    require_once('../Views/emptylayout.php');
} else {
    require_once('../Views/layout.php');
}