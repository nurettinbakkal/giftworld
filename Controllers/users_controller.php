<?php
/**
 * Created by PhpStorm.
 * User: nurettin
 * Date: 01.01.2016
 * Time: 10:38
 */

namespace Application\Controller;

use Application\Helper\Session;
use Framework\Controller;
use Application\Model\User;

class UsersController extends Controller
{
    /**
     * Login
     */
    public function login()
    {
        if ( isset($_POST['username']) && isset($_POST['password']) ) {
            $user = new User();

            $username = $_POST['username'];
            $password = $_POST['password'];

            $result = $user->doLogin($username, $password);

            if ( false === $result ) {
                return call('pages', 'error');
            } else {
                $this->sessionCreate($result['username']);
                Session::set('is_logged_in', true);
                Session::set('userid', (int)$result['userid']);
                Session::set('user', $result['username']);
                Session::set('name', $result['firstname']);
                Session::set('surname', $result['lastname']);
                Session::set('generated_time', time());
                header('location:?controller=pages&action=home');
            }
        } else {
            if (Session::isLoggedIn()) {
                header('location:?controller=pages&action=home');
            } else {
                require_once('../Views/users/login.php');
            }
        }
    }

    /**
     * Logout
     */
    public function logOut()
    {
        $this->sessionDestroy();
        header('location:?controller=pages&action=home');
    }
}